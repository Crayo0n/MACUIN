import sys
import os
import random
import hashlib
from datetime import datetime, timedelta
from sqlalchemy.orm import Session

# Add current dir to path to import app
sys.path.append(os.getcwd())

from app.data.database import SessionLocal, engine, Base
from app.models.user_model import User, RoleEnum
from app.models.autoparte_model import Autoparte
from app.models.pedido_model import Pedido, PedidoStatusEnum, DetallePedido
from app.models.categoria_model import Categoria

def hash_password(password: str) -> str:
    return hashlib.sha256(password.encode()).hexdigest()

def seed():
    db = SessionLocal()
    print("Iniciando carga masiva de datos...")

    try:
        # 1. Crear Categorías
        print("Sembrando categorías...")
        cat_nombres = ["Motor", "Frenos", "Suspensión", "Eléctrico", "Accesorios"]
        categorias = []
        for cn in cat_nombres:
            cat = db.query(Categoria).filter(Categoria.nombre == cn).first()
            if not cat:
                cat = Categoria(nombre=cn, descripcion=f"Categoría de {cn.lower()}")
                db.add(cat)
                db.flush()
            categorias.append(cat)

        # 2. Crear Usuarios
        print("Sembrando usuarios (incluyendo Admin)...")
        # Asegurar Admin por defecto
        admin_email = "admin@macuin.com"
        admin = db.query(User).filter(User.email == admin_email).first()
        if not admin:
            admin = User(
                nombre="Admin Macuin",
                email=admin_email,
                password_hash=hash_password("admin123"),
                rol=RoleEnum.admin
            )
            db.add(admin)
            db.flush()

        usuarios = []
        nombres = ["Juan Perez", "Maria Garcia", "Carlos Lopez", "Ana Martinez", "Luis Rodriguez", 
                   "Elena Sanchez", "Roberto Gomez", "Lucia Diaz", "Miguel Torres", "Sofia Ruiz"]
        
        for i, nombre in enumerate(nombres):
            email = f"cliente{i+1}@test.com"
            user = db.query(User).filter(User.email == email).first()
            if not user:
                user = User(
                    nombre=nombre,
                    email=email,
                    password_hash=hash_password("password123"),
                    rol=RoleEnum.cliente
                )
                db.add(user)
                db.flush()
            usuarios.append(user)
        
        # 3. Crear Autopartes realistas
        print("Sembrando catálogo de productos (Iconos estándar)...")
        # (Nombre, Desc, Precio, Stock, Cat_Nombre)
        autopartes_data = [
            ("Frenos de Disco", "Frenos de alto rendimiento cerámicos", 1200.50, 50, "Frenos"),
            ("Batería 12V Pro", "Batería de larga duración 800 CCA", 2500.00, 30, "Eléctrico"),
            ("Amortiguadores", "Kit de 2 amortiguadores gas nitrogeno", 4500.00, 20, "Suspensión"),
            ("Faros LED Premium", "Iluminación intensa blanca 6000K", 850.00, 100, "Eléctrico"),
            ("Filtro de Aceite", "Filtro sintético avanzado alto flujo", 250.00, 200, "Motor"),
            ("Bujías Iridium", "Set de 4 bujías mejor combustión", 600.00, 150, "Motor"),
            ("Radiador Aluminio", "Enfriamiento eficiente para sedán", 3200.00, 15, "Motor"),
            ("Alternador 90A", "Carga estable para motor 4 cil", 1800.00, 25, "Eléctrico"),
            ("Rines de Aleación", "Set de 4 rines deportivos R17", 8500.00, 5, "Accesorios"),
            ("Neumático R15 AllSeason", "Tracción máxima todo clima", 1550.00, 60, "Accesorios")
        ]
        
        autopartes = []
        for i, (nombre, desc, precio, stock, cat_nombre) in enumerate(autopartes_data):
            ap = db.query(Autoparte).filter(Autoparte.nombre == nombre).first()
            cat = next((c for c in categorias if c.nombre == cat_nombre), None)
            
            if not ap:
                ap = Autoparte(
                    nombre=nombre,
                    descripcion=desc,
                    precio=precio,
                    stock_disponible=stock,
                    sku=f"AP-{1000 + i}",
                    marca="Generico",
                    categoria_id=cat.id if cat else None,
                    imagen=None
                )
                db.add(ap)
                db.flush()
            autopartes.append(ap)

        # 4. Generar Órdenes Históricas (Masivo)
        print("Generando 120 pedidos históricos...")
        estados = list(PedidoStatusEnum)
        direcciones = ["Calle Principal 123", "Av. Universidad 456", "Reforma 789", "Insurgentes 101", "Periférico 202"]
        
        total_pedidos = 120
        for _ in range(total_pedidos):
            user = random.choice(usuarios)
            estado = random.choice(estados)
            # Fecha aleatoria en los últimos 6 meses
            dias_atras = random.randint(0, 180)
            fecha = datetime.utcnow() - timedelta(days=dias_atras)
            
            pedido = Pedido(
                usuario_id=user.id,
                estatus=estado,
                direccion_envio=random.choice(direcciones),
                fecha_creacion=fecha,
                total=0 
            )
            db.add(pedido)
            db.flush()
            
            items_count = random.randint(1, 4)
            items_seleccionados = random.sample(autopartes, items_count)
            total_pedido = 0
            
            for item in items_seleccionados:
                cant = random.randint(1, 3)
                detalle = DetallePedido(
                    pedido_id=pedido.id,
                    autoparte_id=item.id,
                    cantidad=cant,
                    precio_unitario=item.precio
                )
                db.add(detalle)
                total_pedido += (item.precio * cant)
            
            pedido.total = total_pedido
        
        db.commit()
        print(f"Éxito total: Se han poblado categorías, usuarios, productos y 120 pedidos.")

    except Exception as e:
        db.rollback()
        print(f"Error fatal durante el sembrado: {e}")
    finally:
        db.close()

if __name__ == "__main__":
    seed()
