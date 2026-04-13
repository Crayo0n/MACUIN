// Configuración de la API
const API_URL = 'http://localhost:5000/api';

// Estado de la aplicación
let isLoading = false;

// Elementos del DOM
const form = document.getElementById('login-form');
const emailInput = document.getElementById('email');
const passwordInput = document.getElementById('password');
const rememberCheckbox = document.getElementById('remember');
const loginBtn = document.getElementById('login-btn');
const btnText = document.getElementById('btn-text');
const btnSpinner = document.getElementById('btn-spinner');
const alertMessage = document.getElementById('alert-message');

// Mostrar mensaje de alerta
function showAlert(message, type = 'error') {
    alertMessage.textContent = message;
    alertMessage.className = `alert-message alert-${type}`;
    alertMessage.style.display = 'block';
    
    // Auto-ocultar después de 5 segundos
    setTimeout(() => {
        if (alertMessage.style.display !== 'none') {
            alertMessage.style.opacity = '0';
            setTimeout(() => {
                alertMessage.style.display = 'none';
                alertMessage.style.opacity = '1';
            }, 300);
        }
    }, 5000);
}

// Mostrar/ocultar loading
function setLoading(loading) {
    isLoading = loading;
    if (loading) {
        btnText.style.display = 'none';
        btnSpinner.style.display = 'inline-block';
        loginBtn.disabled = true;
        emailInput.disabled = true;
        passwordInput.disabled = true;
    } else {
        btnText.style.display = 'inline';
        btnSpinner.style.display = 'none';
        loginBtn.disabled = false;
        emailInput.disabled = false;
        passwordInput.disabled = false;
    }
}

// Validar formato de email
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// Función principal de login
async function handleLogin(event) {
    event.preventDefault();
    
    // Limpiar alerta anterior
    alertMessage.style.display = 'none';
    
    // Obtener valores
    const email = emailInput.value.trim();
    const password = passwordInput.value;
    const rememberDevice = rememberCheckbox.checked;
    
    // Validaciones
    if (!email || !password) {
        showAlert('❌ Por favor, completa todos los campos');
        emailInput.focus();
        return;
    }
    
    if (!validateEmail(email)) {
        showAlert('❌ Por favor, ingresa un email válido (ejemplo: usuario@macuin.com)');
        emailInput.focus();
        return;
    }
    
    if (password.length < 6) {
        showAlert('❌ La contraseña debe tener al menos 6 caracteres');
        passwordInput.focus();
        return;
    }
    
    // Mostrar loading
    setLoading(true);
    
    try {
        const response = await fetch(`${API_URL}/login`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                email: email,
                password: password,
                remember_device: rememberDevice
            })
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            // Guardar tokens
            localStorage.setItem('access_token', data.data.access_token);
            localStorage.setItem('refresh_token', data.data.refresh_token);
            localStorage.setItem('user', JSON.stringify(data.data.user));
            
            if (rememberDevice) {
                localStorage.setItem('remember_device', 'true');
                localStorage.setItem('saved_email', email);
            } else {
                localStorage.removeItem('remember_device');
                localStorage.removeItem('saved_email');
            }
            
            // Mostrar éxito
            showAlert('✅ ¡Login exitoso! Redirigiendo al dashboard...', 'success');
            
            // Redirigir
            setTimeout(() => {
                window.location.href = 'dashboard.html';
            }, 1000);
            
        } else {
            showAlert(data.message || '❌ Error al iniciar sesión. Verifica tus credenciales.');
        }
        
    } catch (error) {
        console.error('Error:', error);
        showAlert('❌ Error de conexión. ¿El servidor está ejecutándose en http://localhost:5000?');
    } finally {
        setLoading(false);
    }
}

// Toggle mostrar/ocultar contraseña
function togglePassword() {
    const type = passwordInput.type === 'password' ? 'text' : 'password';
    passwordInput.type = type;
    
    // Cambiar ícono opcionalmente (si tienes dos íconos)
    const eyeIcon = document.getElementById('toggle-password');
    if (type === 'text') {
        eyeIcon.style.opacity = '1';
    } else {
        eyeIcon.style.opacity = '0.6';
    }
}

// Verificar sesión existente
async function checkExistingSession() {
    const token = localStorage.getItem('access_token');
    const user = localStorage.getItem('user');
    
    if (token && user) {
        try {
            const response = await fetch(`${API_URL}/verify-token`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });
            
            if (response.ok) {
                // Sesión válida, redirigir
                window.location.href = 'dashboard.html';
            } else {
                // Token inválido, limpiar
                localStorage.clear();
            }
        } catch (error) {
            console.error('Error verificando sesión:', error);
        }
    }
}

// Cargar email guardado
function loadSavedEmail() {
    const savedEmail = localStorage.getItem('saved_email');
    if (savedEmail) {
        emailInput.value = savedEmail;
        rememberCheckbox.checked = true;
    }
}

// Recuperar contraseña
async function handleForgotPassword(e) {
    e.preventDefault();
    const email = emailInput.value.trim();
    
    if (!email || !validateEmail(email)) {
        showAlert('📧 Por favor, ingresa tu email para recuperar la contraseña', 'info');
        emailInput.focus();
        return;
    }
    
    showAlert('🔐 Función de recuperación en desarrollo. Contacta al administrador del sistema.', 'info');
}

// Registrar usuario
function handleRegister() {
    showAlert('📝 Función de registro en desarrollo. Contacta al administrador para crear una cuenta.', 'info');
}

// Event Listeners
form.addEventListener('submit', handleLogin);
document.getElementById('toggle-password').addEventListener('click', togglePassword);
document.getElementById('forgot-password').addEventListener('click', handleForgotPassword);
document.getElementById('register-btn').addEventListener('click', handleRegister);

// Auto-completar credenciales de prueba (solo desarrollo)
if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
    // Opcional: auto-completar para pruebas
    // emailInput.value = 'admin@macuin.com';
    // passwordInput.value = 'Admin123';
}

// Inicializar
loadSavedEmail();
checkExistingSession();