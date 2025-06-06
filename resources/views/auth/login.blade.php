{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.guest')
@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion | IMSP Séminaires</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --soft-lavender: #f0e6ff;
            --gentle-mint: #e0f7e6;
            --deep-lilac: #8a4fff;
            --misty-rose: #fce4ec;
            --soft-violet: #d8c0ff;
            --light-periwinkle: #e6e6ff;
            --soft-gray: #f9f9fb;
            --dark-purple: #3a2e6d;
            --shadow-soft: 0 8px 30px rgba(0, 0, 0, 0.08);
            --border-radius: 18px;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Nunito', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, var(--soft-lavender) 0%, var(--gentle-mint) 100%);
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        .decoration {
            position: fixed;
            z-index: 1;
            border-radius: 50%;
            opacity: 0.5;
            pointer-events: none;
            filter: blur(10px);
        }

        .dec-1 {
            top: 10%;
            left: 5%;
            width: 200px;
            height: 200px;
            background: var(--misty-rose);
            animation: float 15s ease-in-out infinite;
        }

        .dec-2 {
            bottom: 15%;
            right: 7%;
            width: 150px;
            height: 150px;
            background: var(--light-periwinkle);
            animation: float 12s ease-in-out infinite reverse;
        }

        .dec-3 {
            top: 30%;
            right: 10%;
            width: 100px;
            height: 100px;
            background: var(--soft-violet);
            animation: float 10s ease-in-out infinite;
        }

        .dec-4 {
            top: 60%;
            left: 8%;
            width: 80px;
            height: 80px;
            background: var(--misty-rose);
            animation: float 8s ease-in-out infinite reverse;
        }

        @keyframes float {
            0% { transform: translate(0, 0); }
            50% { transform: translate(10px, 10px); }
            100% { transform: translate(0, 0); }
        }

        .login-container {
            width: 100%;
            max-width: 450px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-soft);
            padding: 40px 35px;
            position: relative;
            z-index: 10;
            border: 1px solid rgba(255, 255, 255, 0.6);
            transform: translateY(0);
            transition: var(--transition);
        }

        .login-container:hover {
            box-shadow: 0 15px 40px rgba(138, 79, 255, 0.15);
            transform: translateY(-5px);
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 20px;
        }

        .login-header::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: var(--deep-lilac);
            border-radius: 2px;
        }

        .login-header h1 {
            font-size: 32px;
            font-weight: 800;
            color: var(--dark-purple);
            margin-bottom: 8px;
        }

        .login-header p {
            color: #6c6c8a;
            font-size: 16px;
        }

        .input-group {
            position: relative;
            margin-bottom: 25px;
        }

        .input-group label {
            display: block;
            margin-bottom: 10px;
            color: var(--dark-purple);
            font-weight: 600;
            font-size: 15px;
        }

        .input-group i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--deep-lilac);
            font-size: 18px;
            width: 24px;
            text-align: center;
        }

        .input-group input {
            width: 100%;
            padding: 16px 20px 16px 55px;
            border: 2px solid #e0d6ff;
            border-radius: 14px;
            font-size: 16px;
            background: white;
            transition: var(--transition);
            outline: none;
            color: var(--dark-purple);
            font-weight: 500;
        }

        .input-group input:focus {
            border-color: var(--deep-lilac);
            box-shadow: 0 0 0 4px rgba(138, 79, 255, 0.2);
        }

        .input-group input::placeholder {
            color: #bbb;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .remember-me {
            display: flex;
            align-items: center;
        }

        .remember-me input {
            margin-right: 8px;
            cursor: pointer;
            width: 18px;
            height: 18px;
            accent-color: var(--deep-lilac);
        }

        .forgot-password {
            color: var(--deep-lilac);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }

        .forgot-password:hover {
            color: #6c2fff;
            text-decoration: underline;
        }

        .login-button {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--deep-lilac) 0%, #6c2fff 100%);
            border: none;
            border-radius: 14px;
            color: white;
            font-size: 17px;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(138, 79, 255, 0.3);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .login-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(138, 79, 255, 0.4);
        }

        .signup-link {
            text-align: center;
            margin-top: 25px;
            font-size: 15px;
            color: #6c6c8a;
            padding-top: 20px;
            border-top: 1px solid rgba(224, 214, 255, 0.5);
        }

        .signup-link a {
            color: var(--deep-lilac);
            text-decoration: none;
            font-weight: 700;
            transition: var(--transition);
        }

        .signup-link a:hover {
            color: #6c2fff;
            text-decoration: underline;
        }

        .alert {
            padding: 15px;
            border-radius: 14px;
            margin-bottom: 25px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.15);
            color: #15803d;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            color: #b91c1c;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        @media (max-width: 500px) {
            .login-container {
                padding: 30px 25px;
            }
            
            .login-header h1 {
                font-size: 28px;
            }
            
            .remember-forgot {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
            
            .input-group input {
                padding: 14px 18px 14px 50px;
            }
        }
    </style>
</head>
<body>
    <!-- Decorations -->
    <div class="decoration dec-1"></div>
    <div class="decoration dec-2"></div>
    <div class="decoration dec-3"></div>
    <div class="decoration dec-4"></div>

    <div class="login-container">
        <div class="login-header">
            <h1>Connexion</h1>
            <p>Entrez vos identifiants pour accéder au système</p>
        </div>



<form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- Email -->
    <div class="input-group">
        <label for="email">Adresse email</label>
        <i class="fas fa-envelope"></i>
        <input
            type="email"
            id="email"
            name="email"
            placeholder="votre.email@imsp-edu.org"
            value="{{ old('email') }}"
            required
            autofocus
        >
        @error('email')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Password -->
    <div class="input-group mt-4">
        <label for="password">Mot de passe</label>
        <i class="fas fa-lock"></i>
        <input
            type="password"
            id="password"
            name="password"
            placeholder="Votre mot de passe"
            required
        >
        @error('password')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Si tu veux afficher une erreur générique (exemple : “Identifiants incorrects”) -->
    @if(session('error'))
        <div class="mt-4 text-red-600 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <!-- Login button -->
    <div class="mt-6">
        <button type="submit" class="login-button">
            <i class="fas fa-sign-in-alt"></i> Connexion
        </button>
    </div>
</form>


        <!-- Signup link -->
        <div class="signup-link">
            Nouveau sur IMSP Séminaires ? <a href="{{ route('register') }}">Créer un compte</a>
        </div>
    </div>

    <script>
        // Animation au survol des champs
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.input-group input');
            
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });
            
            // Animation du bouton
            const loginButton = document.querySelector('.login-button');
            loginButton.addEventListener('mousedown', () => {
                loginButton.style.transform = 'translateY(1px)';
                loginButton.style.boxShadow = '0 2px 10px rgba(138, 79, 255, 0.3)';
            });
            
            loginButton.addEventListener('mouseup', () => {
                loginButton.style.transform = 'translateY(-3px)';
                loginButton.style.boxShadow = '0 8px 25px rgba(138, 79, 255, 0.4)';
            });
        });
    </script>
</body>
</html>
@endsection