from sqlalchemy import Column, Integer, String, Float, DateTime, Enum, ForeignKey
from sqlalchemy.orm import relationship
import enum
from datetime import datetime
from app.data.database import Base

class PedidoStatusEnum(enum.Enum):
    pendiente = "pendiente"
    recibido = "recibido"
    surtido = "surtido"
    enviado = "enviado"
    cancelado = "cancelado"

class Pedido(Base):
    __tablename__ = "pedidos"

    id = Column(Integer, primary_key=True, index=True)
    usuario_id = Column(Integer, ForeignKey("usuarios.id"), nullable=False)
    estatus = Column(Enum(PedidoStatusEnum), default=PedidoStatusEnum.pendiente, nullable=False)
    total = Column(Float, default=0.0)
    direccion_envio = Column(String, nullable=False) # Agregado para envios
    documento_pdf = Column(String, nullable=True)
    fecha_creacion = Column(DateTime, default=datetime.utcnow)

    # Relaciones
    usuario = relationship("User", back_populates="pedidos")
    detalles = relationship("DetallePedido", back_populates="pedido", cascade="all, delete-orphan")


class DetallePedido(Base):
    __tablename__ = "detalles_pedido"

    id = Column(Integer, primary_key=True, index=True)
    pedido_id = Column(Integer, ForeignKey("pedidos.id"), nullable=False)
    autoparte_id = Column(Integer, ForeignKey("autopartes.id"), nullable=False)
    cantidad = Column(Integer, nullable=False, default=1)
    precio_unitario = Column(Float, nullable=False)

    # Relaciones
    pedido = relationship("Pedido", back_populates="detalles")
    autoparte = relationship("Autoparte")
