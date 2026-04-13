from sqlalchemy import Column, Integer, String, Float, DateTime, ForeignKey
from sqlalchemy.orm import relationship
from datetime import datetime
from app.data.database import Base

class Autoparte(Base):
    __tablename__ = "autopartes"

    id = Column(Integer, primary_key=True, index=True)
    categoria_id = Column(Integer, ForeignKey("categorias.id"), nullable=True) # Puede ser nullable si no asignan al inicio
    nombre = Column(String, nullable=False, index=True)
    descripcion = Column(String)
    sku = Column(String, unique=True, index=True, nullable=False)
    precio = Column(Float, nullable=False)
    stock_disponible = Column(Integer, default=0, nullable=False)
    fecha_creacion = Column(DateTime, default=datetime.utcnow)

    # Relaciones
    categoria = relationship("Categoria", back_populates="autopartes")

