<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - RUTVANS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap');
        
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #000;
            font-family: Arial, sans-serif;
        }
        .register-container {
            width: 350px;
            padding: 20px;
            border-radius: 10px;
            background: rgba(255, 102, 0, 0.1);
            box-shadow: 0 0 15px rgba(255, 102, 0, 0.5);
            text-align: center;
            color: white;
        }
        .logo {
            width: 100px;
            margin-bottom: 15px;
            border-radius: 50%;
            border: 4px solid rgba(255, 102, 0, 0.8);
            box-shadow: 0 0 10px rgba(255, 102, 0, 0.8);
        }
        .register-container h2 {
    margin-bottom: 10px;
    font-family: 'Orbitron', sans-serif;
    font-size: 22px;
    font-weight: bold;
    color: white; /* Cambiado a blanco */
    text-shadow: 0 0 5px #ff6600, 0 0 10px #ff6600, 0 0 15px #ff3300; /* Mantiene el borde naranja luminoso */
    padding: 10px;
    display: inline-block;
    animation: glow 1.5s infinite alternate;
}

        @keyframes glow {
            from {
                text-shadow: 0 0 5px #ff6600, 0 0 10px #ff6600, 0 0 15px #ff3300;
            }
            to {
                text-shadow: 0 0 10px #ff9900, 0 0 20px #ff6600, 0 0 30px #ff3300;
            }
        }
        .input-group {
            position: relative;
            margin-bottom: 15px;
        }
        .input-group label {
    display: block;
    text-align: left;
    margin-bottom: 5px;
    font-weight: bold;
    font-family: 'Orbitron', sans-serif;
    font-size: 16px;
    color: white; /* Color del texto en blanco */
    text-shadow: 0 0 5px #ff6600, 0 0 10px #ff6600, 0 0 15px #ff3300; /* Efecto luminoso */
    padding: 5px;
    animation: glow 1.5s infinite alternate;
}

        .input-group input {
            width: 100%;
            padding: 12px 12px 12px 40px;
            border: 2px solid #ff6600;
            border-radius: 5px;
            font-size: 16px;
            background: black;
            color: white;
            outline: none;
            box-sizing: border-box;
        }
        .input-group input:focus {
            border-color: #ff8800;
            box-shadow: 0 0 5px rgba(255, 102, 0, 0.8);
        }
        .input-group .icon-container {
            position: absolute;
            left: 12px;
            top: 71%;
            transform: translateY(-50%);
            color: rgb(248, 244, 242);
            font-size: 16px;
        }
        .register-btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 5px;
            background-color: #ff6600;
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: 0.3s;
        }
        .register-btn:hover {
            background-color: #cc5500;
        }
        .login-link {
            margin-top: 10px;
            font-size: 14px;
        }
        .login-link a {
            color: #ff6600;
            text-decoration: none;
            font-weight: bold;
        }
        .login-link a:hover {
            color: #ff3300;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <img src="{{ asset('asset/LogoRutvans.png') }}" alt="Logo RUTVANS" class="logo">
        <h2>REGÍSTRESE A RUTVANS</h2>
        <p></p>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="input-group">
                <label for="name">Nombre</label>
                <span class="icon-container"><i class="fa-solid fa-user"></i></span>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="input-group">
                <label for="email">Correo Electrónico</label>
                <span class="icon-container"><i class="fa-solid fa-envelope"></i></span>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="password">Contraseña</label>
                <span class="icon-container"><i class="fa-solid fa-lock"></i></span>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
                <label for="password_confirmation">Confirmar Contraseña</label>
                <span class="icon-container"><i class="fa-solid fa-lock"></i></span>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>
            <button type="submit" class="register-btn">Registrarse</button>
        </form>
        <p class="login-link">¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia sesión</a></p>
    </div>
</body>
</html>