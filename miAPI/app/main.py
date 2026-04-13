from fastapi import FastAPI
from app.data.database import engine, Base

from app.models import user_model, autoparte_model, categoria_model, pedido_model  
from app.routers import usuarios, categorias, autopartes, pedidos

Base.metadata.create_all(bind=engine)

app = FastAPI(title="MACUIN API", description="API REST para MACUIN.", version="1.0.0")

app.include_router(usuarios.router)
app.include_router(categorias.router)
app.include_router(autopartes.router)
app.include_router(pedidos.router)

@app.get("/", tags=["Home"])
async def raiz():
    return {"message": "Bienvenido a MACUIN API.", "docs": "/docs"}
