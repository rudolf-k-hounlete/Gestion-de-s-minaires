{{-- resources/views/seminars/presenter/create.blade.php --}}
@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle demande de séminaire</title>
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
            --shadow-soft: 0 8px 30px rgba(0, 0, 0, 0.08);
            --border-radius: 18px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, var(--soft-lavender) 0%, var(--gentle-mint) 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Nunito', sans-serif;
            padding: 20px;
            color: #4a4a6a;
            line-height: 1.6;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 35px;
            position: relative;
        }

        .header h1 {
            font-size: 2.4rem;
            font-weight: 800;
            color: #3a2e6d;
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }

        .header h1::after {
            content: "";
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: var(--deep-lilac);
            border-radius: 2px;
        }

        .header p {
            color: #6c6c8a;
            font-size: 1.1rem;
            max-width: 90%;
            margin: 0 auto;
            margin-top: 20px;
        }

        .card {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            border-radius: var(--border-radius);
            padding: 40px;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(255, 255, 255, 0.6);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(138, 79, 255, 0.15);
        }

        .form-group {
            margin-bottom: 28px;
            position: relative;
        }

        label {
            display: block;
            margin-bottom: 12px;
            font-weight: 600;
            color: #5a5a7a;
            font-size: 1.05rem;
            display: flex;
            align-items: center;
        }

        label i {
            margin-right: 12px;
            color: var(--deep-lilac);
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
        }

        .required-star {
            color: #ff5a78;
            margin-left: 4px;
        }

        input, textarea {
            width: 100%;
            padding: 16px 20px;
            font-size: 1.05rem;
            border: 2px solid #e0d6ff;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
            color: #4a4a6a;
            font-family: 'Nunito', sans-serif;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: var(--deep-lilac);
            box-shadow: 0 0 0 4px rgba(138, 79, 255, 0.2);
            background: white;
        }

        input::placeholder, textarea::placeholder {
            color: #b8b8d0;
        }

        .form-error {
            color: #ff5a78;
            font-size: 0.95rem;
            margin-top: 8px;
            display: flex;
            align-items: center;
            animation: fadeIn 0.3s ease;
        }

        .form-error i {
            margin-right: 8px;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 30px;
            gap: 15px;
        }

        .btn {
            padding: 16px 35px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-family: 'Nunito', sans-serif;
            border: none;
            text-decoration: none;
        }

        .btn-secondary {
            background: white;
            color: #7a7a9a;
            border: 2px solid #e0d6ff;
        }

        .btn-secondary:hover {
            background: #f9f7ff;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(138, 79, 255, 0.1);
        }

        .btn-secondary i {
            margin-right: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--deep-lilac) 0%, #6c2fff 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(138, 79, 255, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(138, 79, 255, 0.4);
            background: linear-gradient(135deg, #7a5bff 0%, #5c1fff 100%);
        }

        .btn-primary i {
            margin-left: 8px;
        }

        .decoration {
            position: absolute;
            z-index: -1;
        }

        .dec-1 {
            top: 10%;
            left: 5%;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--misty-rose);
            opacity: 0.7;
        }

        .dec-2 {
            bottom: 15%;
            right: 7%;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--light-periwinkle);
            opacity: 0.8;
        }

        .dec-3 {
            top: 30%;
            right: 10%;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--soft-violet);
            opacity: 0.6;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .card {
                padding: 30px;
            }
            
            .form-actions {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            input, textarea {
                padding: 14px 18px;
            }
        }
    </style>
</head>
<body>
    <div class="decoration dec-1"></div>
    <div class="decoration dec-2"></div>
    <div class="decoration dec-3"></div>
    
    <div class="container">
        <div class="header">
            <h1>Nouvelle demande de séminaire</h1>
            <p>Remplissez ce formulaire pour soumettre votre demande de séminaire</p>
        </div>
        
        <div class="card">
            <form method="POST" action="{{ route('seminars.presenter.store') }}">
                @csrf

                <div class="form-group">
                    <label for="theme">
                        <i class="fas fa-lightbulb"></i> Thème <span class="required-star">*</span>
                    </label>
                    <input type="text" name="theme" id="theme" 
                           placeholder="Entrez le thème de votre séminaire"
                           value="{{ old('theme') }}" required>
                    @error('theme')
                        <p class="form-error">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="preferred_date">
                        <i class="fas fa-calendar-alt"></i> Date préférée <span class="required-star">*</span>
                    </label>
                    <input type="date" name="preferred_date" id="preferred_date" 
                           value="{{ old('preferred_date') }}" required>
                    @error('preferred_date')
                        <p class="form-error">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>



                <div class="form-actions">
                    <a href="{{ route('seminars.presenter.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Annuler
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Soumettre la demande <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Animation pour les champs au focus
        document.querySelectorAll('input, textarea').forEach(item => {
            item.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.01)';
            });
            
            item.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });

        // Animation pour les messages d'erreur
        document.querySelectorAll('.form-error').forEach(error => {
            error.style.opacity = '0';
            setTimeout(() => {
                error.style.transition = 'opacity 0.5s ease';
                error.style.opacity = '1';
            }, 100);
        });

        // Pré-sélection de la date du jour pour le champ date
    const today = new Date();
    const minDate = new Date();
    minDate.setDate(today.getDate() + 12);
    
    // Formatage en YYYY-MM-DD
    const minDateString = minDate.toISOString().split('T')[0];
    
    // Application au champ date
    const dateInput = document.getElementById('preferred_date');
    dateInput.min = minDateString;
    
    // Si la valeur actuelle est inférieure à la date minimum, on la remplace
    if (dateInput.value && dateInput.value < minDateString) {
        dateInput.value = minDateString;
    } else if (!dateInput.value) {
        dateInput.value = minDateString;
    }
    </script>
</body>
</html>
@endsection