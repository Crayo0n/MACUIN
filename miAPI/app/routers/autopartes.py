from fastapi import APIRouter, Depends, HTTPException, status
from typing import List
from sqlalchemy.orm import Session
from app.data.database import get_db
from app.models.autoparte_model import Autoparte
from app.schemas.autoparte import AutoparteCreate, AutoparteUpdate, AutoparteOut

router = APIRouter(prefix="/v1/autopartes", tags=["Autopartes"])

@router.get("/", response_model=List[AutoparteOut])
async def listar_autopartes(db: Session = Depends(get_db)):
    return db.query(Autoparte).all()

@router.get("/{id}", response_model=AutoparteOut)
async def obtener_autoparte(id: int, db: Session = Depends(get_db)):
    ap = db.query(Autoparte).filter(Autoparte.id == id).first()
    if not ap:
        raise HTTPException(status_code=404, detail="Autoparte no encontrada")
    return ap

@router.post("/", response_model=AutoparteOut, status_code=status.HTTP_201_CREATED)
async def crear_autoparte(data: AutoparteCreate, db: Session = Depends(get_db)):
    if db.query(Autoparte).filter(Autoparte.sku == data.sku).first():
        raise HTTPException(status_code=400, detail="Ya existe una autoparte con ese SKU")
    nueva = Autoparte(**data.model_dump())
    db.add(nueva)
    db.commit()
    db.refresh(nueva)
    return nueva

@router.put("/{id}", response_model=AutoparteOut)
async def actualizar_autoparte(id: int, data: AutoparteUpdate, db: Session = Depends(get_db)):
    ap = db.query(Autoparte).filter(Autoparte.id == id).first()
    if not ap:
        raise HTTPException(status_code=404, detail="Autoparte no encontrada")
    for campo, valor in data.model_dump(exclude_unset=True).items():
        setattr(ap, campo, valor)
    db.commit()
    db.refresh(ap)
    return ap

@router.delete("/{id}", status_code=status.HTTP_204_NO_CONTENT)
async def eliminar_autoparte(id: int, db: Session = Depends(get_db)):
    ap = db.query(Autoparte).filter(Autoparte.id == id).first()
    if not ap:
        raise HTTPException(status_code=404, detail="Autoparte no encontrada")
    db.delete(ap)
    db.commit()
    return None
