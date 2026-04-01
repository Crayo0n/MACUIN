from fastapi import FastAPI
from app.routers import *
from app.data.database import engine, Base

# Crear tablas en la BD 
Base.metadata.create_all(bind=engine)

app = FastAPI(
    title="MACUIN API",
    description="API REST para MACUIN.",
    version="1.0.0"
)

app.include_router(usuarios.router)
app.include_router(misc.router)

@app.get("/", tags=["Home"])
async def raíz():
    return {
        "message": "Bienvenido a MACUIN API.",
        "docs": "/docs",
        "redoc": "/redoc"
    }
