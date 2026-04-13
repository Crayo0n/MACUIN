from fastapi import APIRouter, Depends, HTTPException, status
from typing import List
from sqlalchemy.orm import Session
from app.data.database import get_db
from app.models.categoria_model import Categoria
from app.schemas.categoria import CategoriaCreate, CategoriaUpdate, CategoriaOut

router = APIRouter(prefix="/v1/categorias", tags=["Categorias"])

@router.get("/", response_model=List[CategoriaOut])
async def listar_categorias(db: Session = Depends(get_db)):
    return db.query(Categoria).all()

@router.get("/{id}", response_model=CategoriaOut)
async def obtener_categoria(id: int, db: Session = Depends(get_db)):
    cat = db.query(Categoria).filter(Categoria.id == id).first()
    if not cat:
        raise HTTPException(status_code=404, detail="Categoria no encontrada")
    return cat

@router.post("/", response_model=CategoriaOut, status_code=status.HTTP_201_CREATED)
async def crear_categoria(data: CategoriaCreate, db: Session = Depends(get_db)):
    if db.query(Categoria).filter(Categoria.nombre == data.nombre).first():
        raise HTTPException(status_code=400, detail="Ya existe una categoria con ese nombre")
    nueva = Categoria(**data.model_dump())
    db.add(nueva)
    db.commit()
    db.refresh(nueva)
    return nueva

@router.put("/{id}", response_model=CategoriaOut)
async def actualizar_categoria(id: int, data: CategoriaUpdate, db: Session = Depends(get_db)):
    cat = db.query(Categoria).filter(Categoria.id == id).first()
    if not cat:
        raise HTTPException(status_code=404, detail="Categoria no encontrada")
    for campo, valor in data.model_dump(exclude_unset=True).items():
        setattr(cat, campo, valor)
    db.commit()
    db.refresh(cat)
    return cat

@router.delete("/{id}", status_code=status.HTTP_204_NO_CONTENT)
async def eliminar_categoria(id: int, db: Session = Depends(get_db)):
    cat = db.query(Categoria).filter(Categoria.id == id).first()
    if not cat:
        raise HTTPException(status_code=404, detail="Categoria no encontrada")
    db.delete(cat)
    db.commit()
    return None
