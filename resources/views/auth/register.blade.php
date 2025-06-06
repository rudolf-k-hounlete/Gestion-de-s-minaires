{{-- resources/views/auth/register.blade.php --}}
@extends('layouts.guest')
@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription | IMSP Séminaires</title>
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
            --dark-purple: #3a2e6d;
            --shadow-soft: 0 5px 20px rgba(0, 0, 0, 0.08);
            --border-radius: 16px;
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
            padding: 15px;
            position: relative;
            overflow: hidden;
        }

        .decoration {
            position: fixed;
            z-index: 1;
            border-radius: 50%;
            opacity: 0.4;
            pointer-events: none;
            filter: blur(8px);
        }

        .dec-1 {
            top: 10%;
            left: 5%;
            width: 140px;
            height: 140px;
            background: var(--misty-rose);
            animation: float 15s ease-in-out infinite;
        }

        .dec-2 {
            bottom: 15%;
            right: 7%;
            width: 110px;
            height: 110px;
            background: var(--light-periwinkle);
            animation: float 12s ease-in-out infinite reverse;
        }

        .dec-3 {
            top: 30%;
            right: 10%;
            width: 80px;
            height: 80px;
            background: var(--soft-violet);
            animation: float 10s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translate(0, 0); }
            50% { transform: translate(8px, 8px); }
            100% { transform: translate(0, 0); }
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            background: rgba(255, 255, 255, 0.97);
            backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-soft);
            padding: 30px;
            position: relative;
            z-index: 10;
            border: 1px solid rgba(255, 255, 255, 0.7);
            transition: var(--transition);
        }

        .login-container:hover {
            box-shadow: 0 8px 25px rgba(138, 79, 255, 0.15);
        }

        .login-header {
            text-align: center;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 15px;
        }

        .login-header::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: var(--deep-lilac);
            border-radius: 2px;
        }

        .login-header h1 {
            font-size: 26px;
            font-weight: 700;
            color: var(--dark-purple);
            margin-bottom: 5px;
        }

        .login-header p {
            color: #6c6c8a;
            font-size: 15px;
        }

        .input-group {
            position: relative;
            margin-bottom: 18px;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--dark-purple);
            font-weight: 600;
            font-size: 14px;
        }

        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--deep-lilac);
            font-size: 16px;
            width: 20px;
            text-align: center;
        }

        .input-group input, .input-group select {
            width: 100%;
            padding: 14px 18px 14px 45px;
            border: 2px solid #e0d6ff;
            border-radius: 14px;
            font-size: 15px;
            background: white;
            transition: var(--transition);
            outline: none;
            color: var(--dark-purple);
            font-weight: 500;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        .input-group select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath fill='%238a4fff' d='M5 6L0 0h10L5 6z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 10px;
            padding-right: 35px;
        }

        .input-group input:focus, .input-group select:focus {
            border-color: var(--deep-lilac);
            box-shadow: 0 0 0 3px rgba(138, 79, 255, 0.2);
        }

        .input-group input::placeholder {
            color: #bbb;
        }

        .error {
            color: #ef4444;
            font-size: 0.85rem;
            margin-top: 6px;
            display: block;
            padding-left: 5px;
        }

        .login-button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--deep-lilac) 0%, #6c2fff 100%);
            border: none;
            border-radius: 14px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 12px rgba(138, 79, 255, 0.25);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-top: 10px;
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(138, 79, 255, 0.35);
        }

        .signup-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #6c6c8a;
            padding-top: 15px;
            border-top: 1px solid rgba(224, 214, 255, 0.4);
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
            padding: 12px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            text-align: center;
            font-size: 14px;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.15);
            color: #15803d;
            border: 1px solid rgba(34, 197, 94, 0.25);
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 25px 20px;
            }
            
            .login-header h1 {
                font-size: 24px;
            }
            
            .input-group input, .input-group select {
                padding: 13px 16px 13px 42px;
                font-size: 14px;
            }
            
            .login-button {
                padding: 13px;
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Decorations -->
    <div class="decoration dec-1"></div>
    <div class="decoration dec-2"></div>
    <div class="decoration dec-3"></div>

    <div class="login-container">
        <div class="login-header">
            <h1>Inscription</h1>
            <p>Créez un compte pour commencer</p>
        </div>

        <!-- Message de statut dynamique -->
        @if(session('status'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('status') }}
            </div>
        @endif

        <!-- Formulaire dynamique -->
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Nom complet -->
            <div class="input-group">
                <label for="name">Nom complet</label>
                <i class="fas fa-user"></i>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Votre nom complet"
                    required
                    autofocus
                >
                @error('name')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Adresse email -->
            <div class="input-group">
                <label for="email">Adresse email</label>
                <i class="fas fa-envelope"></i>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Votre adresse email"
                    required
                >
                @error('email')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Rôle -->
            <div class="input-group" style="display: none;">
                <label for="role">Vous êtes</label>
                <i class="fas fa-user-tag"></i>
                <select
                    id="role"
                    name="role"
                    required
                >
                    <option value="" disabled>— Sélectionnez votre rôle —</option>
                    <option value="student" selected>Étudiant</option>
                </select>
                @error('role')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Mot de passe -->
            <div class="input-group">
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
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirmation du mot de passe -->
            <div class="input-group">
                <label for="password_confirmation">Confirmation</label>
                <i class="fas fa-lock"></i>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Confirmez votre mot de passe"
                    required
                >
            </div>

            <!-- Bouton d'inscription -->
            <button type="submit" class="login-button">
                <i class="fas fa-user-plus"></i> S’inscrire
            </button>

            <!-- Lien vers connexion -->
            <div class="signup-link">
                Vous avez déjà un compte ? <a href="{{ route('login') }}">Connectez-vous</a>
            </div>
        </form>
    </div>

    <script>
        // Animation au survol des champs
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.input-group input, .input-group select');
            
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.01)';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });
            
            // Animation du bouton
            const loginButton = document.querySelector('.login-button');
            loginButton.addEventListener('mousedown', () => {
                loginButton.style.transform = 'translateY(1px)';
                loginButton.style.boxShadow = '0 2px 8px rgba(138, 79, 255, 0.25)';
            });
            
            loginButton.addEventListener('mouseup', () => {
                loginButton.style.transform = 'translateY(-2px)';
                loginButton.style.boxShadow = '0 6px 18px rgba(138, 79, 255, 0.35)';
            });
        });
    </script>
</body>
</html>
@endsection