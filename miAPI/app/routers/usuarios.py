from fastapi import APIRouter, Depends, HTTPException, status
from typing import List
from sqlalchemy.orm import Session
from app.data.database import get_db

from app.schemas.usuario import Usuario, UsuarioCreate, UsuarioUpdate, UsuarioLogin
from app.models.user_model import User, RoleEnum
# asumiendo que verificar_credenciales existe o es opcional temporalmente
# from app.security.auth import verificar_credenciales

# Para hashear contraseñas (simulado o usando passlib si lo configuran, usaremos base por simplicidad)
import hashlib

router = APIRouter(
    prefix="/v1/usuarios",
    tags=["Usuarios"],
)

def hash_password(password: str) -> str:
    return hashlib.sha256(password.encode()).hexdigest()

@router.get("/", response_model=List[Usuario])
async def obtener_usuarios(db: Session = Depends(get_db)):
    usuarios = db.query(User).all()
    return usuarios

@router.get("/{id}", response_model=Usuario)
async def obtener_usuario(id: int, db: Session = Depends(get_db)):
    usuario = db.query(User).filter(User.id == id).first()
    if not usuario:
        raise HTTPException(status_code=404, detail="Usuario no encontrado")
    return usuario

@router.post("/login", response_model=Usuario)
async def login_api(data: UsuarioLogin, db: Session = Depends(get_db)):
    """Valida credenciales y devuelve el usuario si son correctas (Login Seguro)"""
    usuario = db.query(User).filter(User.email == data.email).first()
    if not usuario:
        raise HTTPException(status_code=401, detail="Credenciales incorrectas")
        
    hash_enviado = hash_password(data.password)
    # Por seguridad no devolvemos el password_hash en el json
    if usuario.password_hash != hash_enviado:
        raise HTTPException(status_code=401, detail="Credenciales incorrectas")
        
    return usuario

@router.post("/", response_model=Usuario, status_code=status.HTTP_201_CREATED)
async def crear_usuario(user_in: UsuarioCreate, db: Session = Depends(get_db)):
    # Check if email exists
    exist = db.query(User).filter(User.email == user_in.email).first()
    if exist:
        raise HTTPException(status_code=400, detail="El email ya está registrado")
    
    nuevo_usuario = User(
        nombre=user_in.nombre,
        email=user_in.email,
        password_hash=hash_password(user_in.password),
        rol=user_in.rol
    )
    db.add(nuevo_usuario)
    db.commit()
    db.refresh(nuevo_usuario)
    return nuevo_usuario

@router.put("/{id}", response_model=Usuario)
async def actualizar_usuario(id: int, user_update: UsuarioUpdate, db: Session = Depends(get_db)):
    # Remover validacion current_user temporalmente para poder probar la API
    usuario = db.query(User).filter(User.id == id).first()
    if not usuario:
        raise HTTPException(status_code=404, detail="Usuario no encontrado")
    
    if user_update.nombre:
        usuario.nombre = user_update.nombre
    if user_update.email:
        usuario.email = user_update.email
    if user_update.rol:
        usuario.rol = user_update.rol
    if user_update.password:
        usuario.password_hash = hash_password(user_update.password)
        
    db.commit()
    db.refresh(usuario)
    return usuario

@router.delete("/{id}", status_code=status.HTTP_204_NO_CONTENT)
async def eliminar_usuario(id: int, db: Session = Depends(get_db)):
    usuario = db.query(User).filter(User.id == id).first()
    if not usuario:
        raise HTTPException(status_code=404, detail="Usuario no encontrado")
    
    db.delete(usuario)
    db.commit()
    return None
