from flask import Flask, render_template
app = Flask(__name__)


@app.route('/')
def inicio():
    return render_template('inicio.html')


@app.route('/registro')
def registro():
    return render_template('registro.html')

@app.route('/perfil')
def perfil():
    return render_template('perfil.html')


@app.route('/catalogo')
def catalogo():
    return render_template('catalogo.html')

@app.route('/catalogo/producto/<int:id>')
def producto(id):
    return render_template('productos.html', producto_id=id)


@app.route('/carrito')
def carrito():
    return render_template('carrito.html')


@app.route('/pedidos')
def pedidos():
    return render_template('pedidos.html')

if __name__ == '__main__':
    app.run(debug=True)