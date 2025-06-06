{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMSP – Tableau de bord</title>

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">

    {{-- Font Awesome CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Tailwind via CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Configuration personnalisée Tailwind --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'soft-lavender': '#f0e6ff', 
                        'gentle-mint': '#e0f7e6',
                        'deep-lilac': '#8a4fff',
                        'misty-rose': '#fce4ec',
                        'soft-violet': '#d8c0ff',
                        'light-periwinkle': '#e6e6ff',
                    }
                }
            }
        }
    </script>

<style>
    :root {
        --soft-lavender: #f0e6ff;
        --gentle-mint: #e0f7e6;
        --deep-lilac: #8a4fff;
        --misty-rose: #fce4ec;
        --soft-violet: #d8c0ff;
        --light-periwinkle: #e6e6ff;
        --dark-purple: #3a2e6d;
        --shadow-soft: 0 8px 30px rgba(0, 0, 0, 0.08);
        --border-radius: 18px;
        --transition: all 0.3s ease;
    }

    body {
        background: linear-gradient(135deg, var(--soft-lavender) 0%, var(--gentle-mint) 100%);
        min-height: 100vh;
        font-family: 'Nunito', sans-serif;
        color: #4a4a6a;
        line-height: 1.6;
        padding: 0;
        margin: 0;
    }

    .container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .profile-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(12px);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-soft);
        border: 1px solid rgba(255, 255, 255, 0.6);
        overflow: hidden;
        transition: var(--transition);
    }

    .profile-card:hover {
        box-shadow: 0 15px 40px rgba(138, 79, 255, 0.15);
        transform: translateY(-5px);
    }

    .profile-header {
        position: relative;
        padding-bottom: 15px;
        margin-bottom: 25px;
    }

    .profile-header::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 80px;
        height: 4px;
        background: var(--deep-lilac);
        border-radius: 2px;
    }

    .profile-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--dark-purple);
        margin-bottom: 5px;
    }

    .input-group {
        position: relative;
        margin-bottom: 25px;
    }

    .input-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--dark-purple);
        font-size: 0.95rem;
    }

    .input-group i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--deep-lilac);
        font-size: 1.1rem;
        width: 20px;
        text-align: center;
    }

    .input-field {
        width: 100%;
        padding: 14px 18px 14px 45px;
        border: 2px solid #e0d6ff;
        border-radius: 14px;
        font-size: 1rem;
        background: white;
        transition: var(--transition);
        outline: none;
        color: var(--dark-purple);
        font-weight: 500;
    }

    .input-field:focus {
        border-color: var(--deep-lilac);
        box-shadow: 0 0 0 3px rgba(138, 79, 255, 0.2);
    }

    .input-field:disabled {
        background: rgba(245, 245, 245, 0.7);
        border-color: rgba(224, 224, 224, 0.7);
        color: #7a7a9a;
        cursor: not-allowed;
    }

    .error-text {
        color: #ef4444;
        font-size: 0.85rem;
        margin-top: 6px;
        display: block;
        padding-left: 5px;
    }

    .save-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 28px;
        background: linear-gradient(135deg, var(--deep-lilac) 0%, #6c2fff 100%);
        border: none;
        border-radius: 14px;
        color: white;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        box-shadow: 0 4px 12px rgba(138, 79, 255, 0.25);
    }

    .save-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(138, 79, 255, 0.35);
    }

    .alert-message {
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

    .decoration {
        position: fixed;
        z-index: -1;
        border-radius: 50%;
        opacity: 0.5;
        pointer-events: none;
    }

    .dec-1 {
        top: 10%;
        left: 5%;
        width: 120px;
        height: 120px;
        background: var(--misty-rose);
        animation: float 15s ease-in-out infinite;
    }

    .dec-2 {
        bottom: 15%;
        right: 7%;
        width: 100px;
        height: 100px;
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

    @media (max-width: 768px) {
        .container {
            padding: 20px 15px;
        }
        
        .profile-card {
            padding: 25px 20px;
        }
        
        .profile-title {
            font-size: 1.5rem;
        }
    }
</style>
</head>
<body>
    {{-- Décorations d'arrière-plan --}}
    <div class="decoration dec-1"></div>
    <div class="decoration dec-2"></div>
    <div class="decoration dec-3"></div>

    <div class="container mx-auto px-4 py-10">
        <div class="profile-card max-w-xl mx-auto p-8">
            <div class="profile-header">
                <h2 class="profile-title">Mon profil</h2>
            </div>

            {{-- Messages flash --}}
            @if(session('success'))
                <div class="alert-message alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert-message alert-error">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            {{-- Formulaire --}}
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf

                {{-- Nom --}}
                <div class="input-group">
                    <label for="name">Nom</label>
                    <div class="relative">
                        <i class="fas fa-user"></i>
                        <input type="text" name="name" id="name"
                               value="{{ old('name', $user->name) }}"
                               class="input-field"
                               required>
                    </div>
                    @error('name')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="input-group">
                    <label for="email">Adresse e-mail</label>
                    <div class="relative">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email"
                               value="{{ $user->email }}"
                               class="input-field"
                               disabled readonly>
                    </div>
                </div>

                {{-- Rôle --}}
                <div class="input-group">
                    <label for="role">Rôle</label>
                    <div class="relative">
                        <i class="fas fa-user-tag"></i>
                        <input type="text" id="role"
                               value="{{ ucfirst($user->role) }}"
                               class="input-field"
                               disabled readonly>
                    </div>
                </div>

                {{-- Mot de passe actuel --}}
                <div class="input-group">
                    <label for="current_password">Mot de passe actuel</label>
                    <div class="relative">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="current_password" id="current_password"
                               class="input-field">
                    </div>
                    @error('current_password')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nouveau mot de passe --}}
                <div class="input-group">
                    <label for="password">Nouveau mot de passe</label>
                    <div class="relative">
                        <i class="fas fa-key"></i>
                        <input type="password" name="password" id="password"
                               class="input-field">
                    </div>
                    @error('password')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirmer mot de passe --}}
                <div class="input-group">
                    <label for="password_confirmation">Confirmer le mot de passe</label>
                    <div class="relative">
                        <i class="fas fa-key"></i>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="input-field">
                    </div>
                </div>

                {{-- Submit button --}}
                <div class="flex justify-end mt-6">
                    <button type="submit" class="save-button">
                        <i class="fas fa-save"></i> Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Animation au survol des champs
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.input-field:not([disabled])');
            
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.parentElement.style.transform = 'scale(1.01)';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.parentElement.style.transform = 'scale(1)';
                });
            });
            
            // Animation du bouton
            const saveButton = document.querySelector('.save-button');
            saveButton.addEventListener('mousedown', () => {
                saveButton.style.transform = 'translateY(1px)';
                saveButton.style.boxShadow = '0 2px 8px rgba(138, 79, 255, 0.25)';
            });
            
            saveButton.addEventListener('mouseup', () => {
                saveButton.style.transform = 'translateY(-3px)';
                saveButton.style.boxShadow = '0 6px 18px rgba(138, 79, 255, 0.35)';
            });
        });
    </script>
</body>
</html>
@endsection