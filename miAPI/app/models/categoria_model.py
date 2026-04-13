from sqlalchemy import Column, Integer, String, DateTime
from datetime import datetime
from app.data.database import Base
from sqlalchemy.orm import relationship

class Categoria(Base):
    __tablename__ = "categorias"

    id = Column(Integer, primary_key=True, index=True)
    nombre = Column(String, unique=True, nullable=False, index=True)
    descripcion = Column(String)
    fecha_creacion = Column(DateTime, default=datetime.utcnow)

    # Relación bidireccional
    autopartes = relationship("Autoparte", back_populates="categoria")
