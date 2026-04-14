from flask import Flask, render_template, request, redirect, url_for, session, flash, jsonify
import requests
import os

app = Flask(__name__)
app.secret_key = os.getenv("SECRET_KEY", "macuin_secret_2026")

API_URL = os.getenv("API_URL", "http://server_api:8080")

def format_date(value):
    if not value:
        return 'Sin fecha'
    try:
        from datetime import datetime
        if isinstance(value, str):
            clean = value[:19]
            dt = datetime.strptime(clean, '%Y-%m-%dT%H:%M:%S')
        else:
            dt = value
        meses = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic']
        return f"{dt.day} {meses[dt.month-1]} {dt.year}, {dt.strftime('%H:%M')}"
    except Exception:
        return str(value)[:16]

app.jinja_env.filters['format_date'] = format_date



@app.route('/')
def inicio():
    if 'usuario' not in session:
        return redirect(url_for('login'))
    return redirect(url_for('catalogo'))

@app.context_processor
def inject_cart_count():
    cart_count = len(session.get('carrito', []))
    return dict(cart_count=cart_count, enumerate=enumerate)


@app.route('/login', methods=['GET', 'POST'])
def login():
    if request.method == 'POST':
        email    = request.form.get('email', '').strip()
        password = request.form.get('password', '').strip()
        
        if not email or not password:
            flash('Por favor ingresa tu email y contraseña.', 'error')
            return render_template('login.html')
            
        try:
            resp = requests.post(f"{API_URL}/v1/usuarios/login", json={"email": email, "password": password}, timeout=5)
            if resp.status_code == 200:
                usuario = resp.json()
                session['usuario'] = usuario
                return redirect(url_for('catalogo'))
            elif resp.status_code == 401:
                flash('Credenciales incorrectas.', 'error')
            elif resp.status_code == 422:
                flash('El formato del email no es válido.', 'error')
            else:
                flash('Error al intentar iniciar sesión. Inténtalo de nuevo.', 'error')
        except requests.exceptions.ConnectionError:
            flash('Error de conexión con el servidor.', 'error')

    return render_template('login.html')

@app.route('/registro', methods=['GET', 'POST'])
def registro():
    if request.method == 'POST':
        nombre   = request.form.get('nombre', '').strip()
        email    = request.form.get('email', '').strip()
        password = request.form.get('password', '').strip()
        
        # Validaciones básicas
        if not nombre or not email or not password or len(password) < 6:
            flash('Completa todos los campos. La contraseña debe tener mínimo 6 caracteres.', 'error')
            return render_template('registro.html')
            
        try:
            payload = {
                "nombre": nombre,
                "email": email,
                "password": password,
                "rol": "cliente" 
            }
            resp = requests.post(f"{API_URL}/v1/usuarios/", json=payload, timeout=5)
            if resp.status_code == 201:
                # Éxito. Iniciar sesión automáticamente
                usuario = resp.json()
                session['usuario'] = usuario
                flash('¡Registro exitoso! Bienvenido.', 'success')
                return redirect(url_for('catalogo'))
            elif resp.status_code == 400:
                flash(resp.json().get('detail', 'El email ya está registrado.'), 'error')
            else:
                flash('Ocurrió un error al intentar registrarte.', 'error')
                
        except requests.exceptions.ConnectionError:
            flash('Error', 'error')

    return render_template('registro.html')


@app.route('/logout')
def logout():
    session.clear()
    return redirect(url_for('login'))


@app.route('/catalogo')
def catalogo():
    autopartes = []
    categorias = []
    try:
        resp = requests.get(f"{API_URL}/v1/autopartes/", timeout=5)
        if resp.status_code == 200:
            autopartes = resp.json()
            
        resp_cat = requests.get(f"{API_URL}/v1/categorias/", timeout=5)
        if resp_cat.status_code == 200:
            categorias = resp_cat.json()
    except requests.exceptions.ConnectionError:
        pass
    return render_template('catalogo.html', autopartes=autopartes, categorias=categorias)


@app.route('/catalogo/producto/<int:id>')
def producto(id):
    autoparte = {}
    try:
        resp = requests.get(f"{API_URL}/v1/autopartes/{id}", timeout=5)
        if resp.status_code == 200:
            autoparte = resp.json()
    except requests.exceptions.ConnectionError:
        pass
    return render_template('productos.html', producto=autoparte)


@app.route('/agregar_carrito', methods=['POST'])
def agregar_carrito():
    if 'usuario' not in session:
        return redirect(url_for('login'))
        
    autoparte_id = int(request.form.get('autoparte_id'))
    nombre = request.form.get('nombre')
    precio = float(request.form.get('precio'))
    sku = request.form.get('sku')
    cantidad_str = request.form.get('cantidad', '1')
    try:
        cantidad = int(cantidad_str) if cantidad_str else 1
    except ValueError:
        cantidad = 1
    stock = int(request.form.get('stock', 9999))

    if 'carrito' not in session:
        session['carrito'] = []

    # Verificar si ya existe el producto para sumar la cantidad
    carrito = session['carrito']
    encontrado = False
    for item in carrito:
        if item['autoparte_id'] == autoparte_id:
            if item['cantidad'] + cantidad > stock:
                flash(f'No hay suficiente stock disponible para {nombre}.', 'error')
                return redirect(url_for('producto', id=autoparte_id))
            item['cantidad'] += cantidad
            encontrado = True
            break
            
    if not encontrado:
        if cantidad > stock:
            flash(f'No hay suficiente stock disponible para {nombre}.', 'error')
            return redirect(url_for('producto', id=autoparte_id))
        carrito.append({
            'autoparte_id': autoparte_id,
            'nombre': nombre,
            'precio': precio,
            'sku': sku,
            'cantidad': cantidad,
            'stock': stock  # Guardamos el stock en la sesión
        })
        
    session.modified = True
    flash(f'{nombre} agregado al carrito!', 'success')
    return redirect(url_for('carrito'))

@app.route('/carrito')
def carrito():
    if 'usuario' not in session:
        return redirect(url_for('login'))
        
    items = session.get('carrito', [])
    total = sum(item['precio'] * item['cantidad'] for item in items)
    return render_template('carrito.html', items=items, total=total)

@app.route('/eliminar_carrito/<int:index>', methods=['POST'])
def eliminar_carrito(index):
    if 'carrito' in session and 0 <= index < len(session['carrito']):
        item = session['carrito'].pop(index)
        session.modified = True
        flash(f"Eliminaste {item['nombre']} del carrito.", "success")
    return redirect(url_for('carrito'))

@app.route('/modificar_carrito/<int:index>', methods=['POST'])
def modificar_carrito(index):
    if 'carrito' in session and 0 <= index < len(session['carrito']):
        cantidad_str = request.form.get('cantidad', '').strip()
        try:
            nueva_cantidad = int(cantidad_str) if cantidad_str else 0
        except ValueError:
            nueva_cantidad = 0

        item = session['carrito'][index]
        stock_limite = item.get('stock', 9999)

        if nueva_cantidad > stock_limite:
            flash(f"No puedes agregar más de {stock_limite} unidades de este producto.", "error")
        elif nueva_cantidad > 0:
            item['cantidad'] = nueva_cantidad
            session.modified = True
            flash("Cantidad actualizada correctamente.", "success")
        else:
            flash("La cantidad debe ser mayor a 0.", "error")
    return redirect(url_for('carrito'))

@app.route('/checkout', methods=['POST'])
def checkout():
    if 'usuario' not in session:
        return redirect(url_for('login'))
        
    carrito_actual = session.get('carrito', [])
    if not carrito_actual:
        flash("Tu carrito está vacío.", "error")
        return redirect(url_for('carrito'))

    # Armar payload para la API
    usuario_id = session['usuario']['id']
    detalles = [{"autoparte_id": item['autoparte_id'], "cantidad": item['cantidad']} for item in carrito_actual]
    
    payload = {
        "usuario_id": usuario_id,
        "direccion_envio": "Recoger en Tienda (Por defecto)",
        "detalles": detalles
    }
    
    try:
        resp = requests.post(f"{API_URL}/v1/pedidos/", json=payload, timeout=8)
        if resp.status_code == 201:
            session.pop('carrito') # Limpiar carrito tras éxito
            flash("¡Pago exitoso! Tu orden ha sido generada.", "success")
            return redirect(url_for('pedidos'))
        else:
            flash(f"Error al generar pedido: {resp.text}", "error")
    except requests.exceptions.ConnectionError:
        flash("No se pudo conectar con el servidor de la API.", "error")
        
    return redirect(url_for('carrito'))


@app.route('/cancelar_pedido/<int:id>', methods=['GET', 'POST'])
def cancelar_pedido(id):
    print(f"DEBUG: Intentando cancelar pedido ID: {id}")
    if 'usuario' not in session:
        print("DEBUG: Usuario no en sesión")
        return redirect(url_for('login'))
        
    try:
        url = f"{API_URL}/v1/pedidos/{id}"
        print(f"DEBUG: Llamando API DELETE {url}")
        resp = requests.delete(url, timeout=5)
        print(f"DEBUG: Respuesta API: {resp.status_code}")
        
        if resp.status_code == 204:
            flash(f"Orden #ORD-{id} cancelada. El inventario fue restaurado.", "success")
        elif resp.status_code == 400:
            error_detail = resp.json().get('detail', 'Error desconocido')
            flash(f"No puedes cancelar esta orden: {error_detail}", "error")
        else:
            flash("Ocurrió un error al intentar cancelar la orden.", "error")
    except requests.exceptions.ConnectionError:
        flash("Error conectando con la API.", "error")
    except Exception as e:
        flash(f"Error: {str(e)}", "error")
        
    return redirect(url_for('pedidos'))

@app.route('/pedidos')
def pedidos():
    mis_pedidos = []
    autopartes_map = {}
    if 'usuario' not in session:
        return redirect(url_for('login'))
        
    try:
        # Obtener pedidos filtrados por el usuario logueado (Seguridad)
        user_id = session['usuario']['id']
        resp = requests.get(f"{API_URL}/v1/pedidos/", params={"usuario_id": user_id}, timeout=5)
        if resp.status_code == 200:
            mis_pedidos = resp.json()
            
        # Obtener nombres de autopartes para el mapeo
        resp_at = requests.get(f"{API_URL}/v1/autopartes/", timeout=5)
        if resp_at.status_code == 200:
            autopartes_map = {item['id']: item['nombre'] for item in resp_at.json()}
            
    except requests.exceptions.ConnectionError:
        pass
        
    return render_template('ordenes.html', pedidos=mis_pedidos, autopartes_map=autopartes_map)


@app.route('/perfil')
def perfil():
    return render_template('registro.html')


if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)
