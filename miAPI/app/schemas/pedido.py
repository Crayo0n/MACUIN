from pydantic import BaseModel, Field
from typing import List, Optional
from datetime import datetime
from app.models.pedido_model import PedidoStatusEnum

from app.schemas.autoparte import AutoparteOut

class DetallePedidoCreate(BaseModel):
    autoparte_id: int
    cantidad: int = Field(..., gt=0)

class DetallePedidoOut(BaseModel):
    id: int
    pedido_id: int
    autoparte_id: int
    cantidad: int
    precio_unitario: float
    autoparte: Optional[AutoparteOut] = None
    class Config:
        from_attributes = True

class PedidoCreate(BaseModel):
    usuario_id: int
    direccion_envio: str
    detalles: List[DetallePedidoCreate]

class PedidoUpdate(BaseModel):
    estatus: Optional[PedidoStatusEnum] = None
    direccion_envio: Optional[str] = None

class PedidoOut(BaseModel):
    id: int
    usuario_id: int
    direccion_envio: str
    estatus: PedidoStatusEnum
    total: float
    documento_pdf: Optional[str] = None
    fecha_creacion: datetime
    detalles: List[DetallePedidoOut] = []
    class Config:
        from_attributes = True
