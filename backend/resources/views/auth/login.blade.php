<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - RUTVANS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #000;
            font-family: Arial, sans-serif;
        }

        .login-container {
            width: 400px;
            padding: 25px;
            border-radius: 12px;
            background: rgba(255, 102, 0, 0.15);
            box-shadow: 0 0 20px rgba(255, 102, 0, 0.6);
            text-align: center;
            color: white;
            position: relative;
        }

        .logo {
            width: 100px;
            margin-bottom: 15px;
            border-radius: 50%;
            border: 4px solid rgba(255, 102, 0, 0.8);
            box-shadow: 0 0 10px rgba(255, 102, 0, 0.8);
        }

        .login-container h2 {
            margin-bottom: 10px;
            font-family: 'Orbitron', sans-serif;
            font-size: 22px;
            font-weight: bold;
            color: white;
            text-shadow: 0 0 5px #ff6600, 0 0 10px #ff6600, 0 0 15px #ff3300;
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

        .form-group {
            margin-bottom: 15px;
            text-align: left;
            position: relative;
        }

        label {
            font-weight: bold;
            font-family: 'Orbitron', sans-serif;
            font-size: 16px;
            color: white;
            text-shadow: 0 0 5px #ff6600, 0 0 10px #ff6600, 0 0 15px #ff3300;
            padding: 5px;
            animation: glow 1.5s infinite alternate;
            display: block;
            margin-bottom: 5px;
        }

        .input-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-container input {
            width: 100%;
            padding: 12px 12px 12px 40px;
            border: 2px solid #ff6600;
            border-radius: 6px;
            font-size: 16px;
            background: black;
            color: white;
            outline: none;
            transition: 0.3s;
        }

        .input-container input:focus {
            border-color: #ff3300;
            box-shadow: 0 0 8px rgba(255, 102, 0, 0.8);
        }

        .input-container .icon-container {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: white;
            font-size: 16px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .remember-me input {
            margin-right: 5px;
        }

        .login-btn {
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

        .login-btn:hover {
            background-color: #cc5500;
        }

        .register-link {
            margin-top: 10px;
            font-size: 14px;
        }

        .register-link a {
            color: #ff6600;
            text-decoration: none;
            font-weight: bold;
        }

        .register-link a:hover {
            color: #ff3300;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="{{ asset('asset/LogoRutvans.png') }}" alt="Logo RUTVANS" class="logo">
        <h2>ACCEDE A RUTVANS</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <div class="input-container">
                    <span class="icon-container"><i class="fa-solid fa-envelope"></i></span>
                    <input type="email" id="email" name="email" required>
                </div>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <div class="input-container">
                    <span class="icon-container"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" id="password" name="password" required>
                </div>
            </div>
            <div class="remember-me">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Recuérdame</label>
            </div>
            <button type="submit" class="login-btn">Iniciar Sesión</button>
        </form>
        <p class="register-link">¿No tienes una cuenta? <a href="{{ route('register') }}">Regístrate</a></p>
    </div>
</body>
</html>