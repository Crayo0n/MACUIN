from pydantic import BaseModel, Field

class UsuarioBase(BaseModel):
    # Todo: Definir esquema base
    pass

class UsuarioCreate(UsuarioBase):
    pass

class UsuarioUpdate(BaseModel):
    pass

class Usuario(UsuarioBase):
    id: int

    class Config:
        from_attributes = True
