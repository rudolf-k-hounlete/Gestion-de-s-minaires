{{-- resources/views/seminars/presenter/upload_summary.blade.php --}}
@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploader le résumé – IMSP</title>

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">

    {{-- Font Awesome CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Tailwind CDN --}}
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
            --shadow-soft: 0 8px 30px rgba(0, 0, 0, 0.08);
            --border-radius: 18px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #f0e6ff 0%, #e0f7e6 100%);
            min-height: 100vh;
            font-family: 'Nunito', sans-serif;
            padding: 40px 20px;
            color: #4a4a6a;
            line-height: 1.6;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        .form-card {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            border-radius: var(--border-radius);
            padding: 40px;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(255, 255, 255, 0.6);
        }

        .form-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #3a2e6d;
            margin-bottom: 20px;
            text-align: center;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #4a4a6a;
        }

        input[type="file"] {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e0d6ff;
            border-radius: 14px;
            background-color: #ffffffcc;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #8a4fff;
            box-shadow: 0 0 0 4px rgba(138, 79, 255, 0.2);
        }

        .form-error {
            color: #ef4444;
            font-size: 0.85rem;
            margin-top: 6px;
            display: block;
        }

        .btn {
            padding: 16px 35px;
            font-size: 1.15rem;
            font-weight: 600;
            border-radius: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-family: 'Nunito', sans-serif;
            border: none;
            text-decoration: none;
            text-align: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, #8a4fff 0%, #6c2fff 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(138, 79, 255, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(138, 79, 255, 0.4);
            background: linear-gradient(135deg, #7a5bff 0%, #5c1fff 100%);
        }

        .decoration {
            position: absolute;
            z-index: -1;
            border-radius: 50%;
            opacity: 0.5;
        }

        .dec-1 {
            top: 10%;
            left: 5%;
            width: 100px;
            height: 100px;
            background: #fce4ec;
        }

        .dec-2 {
            bottom: 15%;
            right: 7%;
            width: 80px;
            height: 80px;
            background: #e6e6ff;
        }

        .dec-3 {
            top: 30%;
            right: 10%;
            width: 60px;
            height: 60px;
            background: #d8c0ff;
        }

        @media (max-width: 768px) {
            .form-card {
                padding: 25px;
            }
        }
    </style>
</head>
<body>
    <div class="decoration dec-1"></div>
    <div class="decoration dec-2"></div>
    <div class="decoration dec-3"></div>

    <div class="container">
        <div class="form-card">
            <h1 class="form-title">Uploader le résumé</h1>
            <p class="text-center text-gray-600 mb-6">Séminaire : <strong>{{ $seminar->theme }}</strong></p>

            <form method="POST" action="{{ route('seminars.presenter.upload_summary', $seminar->id) }}" enctype="multipart/form-data">
                @csrf

                {{-- Fichier Résumé --}}
                <div class="form-group">
                    <label for="summary">Fichier résumé (PDF ou Word)</label>
                    <input type="file" id="summary" name="summary" required>
                    @error('summary')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Bouton Soumettre --}}
                <div class="flex justify-center mt-6">
                    <button type="submit" class="btn btn-primary">
                        Télécharger le résumé
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
@endsection