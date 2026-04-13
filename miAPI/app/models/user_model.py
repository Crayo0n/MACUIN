from sqlalchemy import Column, Integer, String, Float, DateTime, Enum, ForeignKey
from sqlalchemy.orm import relationship
import enum
from datetime import datetime
from app.data.database import Base

class RoleEnum(enum.Enum):
    cliente = "cliente"
    ventas = "ventas"
    almacen = "almacen"
    admin = "admin"

class User(Base):
    __tablename__ = "users"

    id = Column(Integer, primary_key=True, index=True)
    nombre = Column(String, nullable=False)
    email = Column(String, unique=True, index=True, nullable=False)
    password_hash = Column(String, nullable=False)
    rol = Column(Enum(RoleEnum), default=RoleEnum.cliente, nullable=False)
    fecha_creacion = Column(DateTime, default=datetime.utcnow)

    # Relación bidireccional (ver pedido_model.py)
    pedidos = relationship("Pedido", back_populates="usuario")
