from pydantic import BaseModel, Field
from typing import Optional
from datetime import datetime

class AutoparteBase(BaseModel):
    categoria_id: Optional[int] = None
    nombre: str = Field(..., max_length=150)
    descripcion: Optional[str] = None
    sku: str = Field(..., max_length=50)
    marca: Optional[str] = None
    precio: float = Field(..., ge=0)
    stock_disponible: int = Field(default=0, ge=0)
    imagen: Optional[str] = None

class AutoparteCreate(AutoparteBase):
    pass

class AutoparteUpdate(BaseModel):
    categoria_id: Optional[int] = None
    nombre: Optional[str] = None
    descripcion: Optional[str] = None
    sku: Optional[str] = None
    precio: Optional[float] = Field(None, ge=0)
    stock_disponible: Optional[int] = Field(None, ge=0)
    imagen: Optional[str] = None

class AutoparteOut(AutoparteBase):
    id: int
    fecha_creacion: datetime
    class Config:
        from_attributes = True
