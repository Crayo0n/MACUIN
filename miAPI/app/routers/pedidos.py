from fastapi import APIRouter, Depends, HTTPException, status
from typing import List
from sqlalchemy.orm import Session, joinedload
from app.data.database import get_db
from app.models.pedido_model import Pedido, DetallePedido, PedidoStatusEnum
from app.models.autoparte_model import Autoparte
from app.schemas.pedido import PedidoCreate, PedidoUpdate, PedidoOut

router = APIRouter(prefix="/v1/pedidos", tags=["Pedidos"])

@router.get("/", response_model=List[PedidoOut])
async def listar_pedidos(usuario_id: int = None, db: Session = Depends(get_db)):
    query = db.query(Pedido).options(
        joinedload(Pedido.detalles).joinedload(DetallePedido.autoparte)
    )
    
    if usuario_id:
        query = query.filter(Pedido.usuario_id == usuario_id)
        
    return query.all()

@router.get("/{id}", response_model=PedidoOut)
async def obtener_pedido(id: int, db: Session = Depends(get_db)):
    pedido = db.query(Pedido).options(
        joinedload(Pedido.detalles).joinedload(DetallePedido.autoparte)
    ).filter(Pedido.id == id).first()
    if not pedido:
        raise HTTPException(status_code=404, detail="Pedido no encontrado")
    return pedido

@router.post("/", response_model=PedidoOut, status_code=status.HTTP_201_CREATED)
async def crear_pedido(data: PedidoCreate, db: Session = Depends(get_db)):
    """Crea un pedido y descuenta automaticamente el stock de cada autoparte."""
    total = 0.0
    detalles_db = []
    for item in data.detalles:
        ap = db.query(Autoparte).filter(Autoparte.id == item.autoparte_id).first()
        if not ap:
            raise HTTPException(status_code=404, detail=f"Autoparte id={item.autoparte_id} no existe")
        if ap.stock_disponible < item.cantidad:
            raise HTTPException(status_code=400, detail=f"Stock insuficiente para '{ap.nombre}' (disponible: {ap.stock_disponible})")
        total += ap.precio * item.cantidad
        detalles_db.append(DetallePedido(autoparte_id=ap.id, cantidad=item.cantidad, precio_unitario=ap.precio))
        ap.stock_disponible -= item.cantidad  # Descontar stock

    nuevo = Pedido(usuario_id=data.usuario_id, direccion_envio=data.direccion_envio, total=round(total,2), detalles=detalles_db)
    db.add(nuevo)
    db.commit()
    db.refresh(nuevo)
    return nuevo

@router.put("/{id}/estatus", response_model=PedidoOut)
async def actualizar_estatus(id: int, data: PedidoUpdate, db: Session = Depends(get_db)):
    pedido = db.query(Pedido).filter(Pedido.id == id).first()
    if not pedido:
        raise HTTPException(status_code=404, detail="Pedido no encontrado")
    if data.estatus:
        pedido.estatus = data.estatus
    if data.direccion_envio:
        pedido.direccion_envio = data.direccion_envio
    db.commit()
    db.refresh(pedido)
    return pedido

@router.delete("/{id}", status_code=status.HTTP_204_NO_CONTENT)
async def cancelar_pedido(id: int, db: Session = Depends(get_db)):
    """Cancela el pedido y RESTAURA el stock de cada autoparte."""
    pedido = db.query(Pedido).filter(Pedido.id == id).first()
    if not pedido:
        raise HTTPException(status_code=404, detail="Pedido no encontrado")
    if pedido.estatus == PedidoStatusEnum.enviado:
        raise HTTPException(status_code=400, detail="No se puede cancelar un pedido ya enviado")
    for detalle in pedido.detalles:
        ap = db.query(Autoparte).filter(Autoparte.id == detalle.autoparte_id).first()
        if ap:
            ap.stock_disponible += detalle.cantidad
    pedido.estatus = PedidoStatusEnum.cancelado
    db.commit()
    return None
