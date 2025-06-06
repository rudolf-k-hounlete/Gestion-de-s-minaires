{{-- resources/views/seminars/presenter/submit_summary.blade.php --}}
@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="fr" x-data="{ sidebarOpen: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMSP – Soumission de résumé</title>
    
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    {{-- Font Awesome CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://unpkg.com/alpinejs" defer></script>
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
                        'soft-gray': '#f9f9fb',
                        'dark-purple': '#3a2e6d',
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
            --shadow-soft: 0 8px 30px rgba(0, 0, 0, 0.08);
            --border-radius: 18px;
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: linear-gradient(135deg, var(--soft-lavender) 0%, var(--gentle-mint) 100%);
            min-height: 100vh;
            font-family: 'Nunito', sans-serif;
            color: #4a4a6a;
            line-height: 1.6;
        }
        
        /* Decorations */
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
        }
        
        .dec-2 {
            bottom: 15%;
            right: 7%;
            width: 100px;
            height: 100px;
            background: var(--light-periwinkle);
        }
        
        .dec-3 {
            top: 30%;
            right: 10%;
            width: 80px;
            height: 80px;
            background: var(--soft-violet);
        }
        
        .dec-4 {
            top: 60%;
            left: 8%;
            width: 60px;
            height: 60px;
            background: var(--misty-rose);
        }
        
        /* Container principal */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 100px 20px 40px;
        }
        
        /* Titre de page */
        .page-header {
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 20px;
        }
        
        .page-header h1 {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--dark-purple);
            position: relative;
            display: inline-block;
        }
        
        .page-header h1::after {
            content: "";
            position: absolute;
            bottom: -12px;
            left: 0;
            width: 120px;
            height: 5px;
            background: var(--deep-lilac);
            border-radius: 3px;
        }
        
        /* Messages flash */
        .alert {
            padding: 15px 20px;
            border-radius: 14px;
            margin-bottom: 30px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: var(--shadow-soft);
            border: 1px solid transparent;
        }
        
        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            color: #b91c1c;
            border-color: rgba(239, 68, 68, 0.3);
        }
        
        .alert-success {
            background: rgba(34, 197, 94, 0.15);
            color: #15803d;
            border-color: rgba(34, 197, 94, 0.3);
        }
        
        /* État vide */
        .empty-state {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            border-radius: var(--border-radius);
            padding: 50px 30px;
            text-align: center;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(255, 255, 255, 0.6);
            max-width: 600px;
            margin: 0 auto;
        }
        
        .empty-state i {
            font-size: 5rem;
            color: var(--soft-violet);
            margin-bottom: 20px;
            opacity: 0.7;
        }
        
        .empty-state h2 {
            font-size: 1.8rem;
            color: #5a5a7a;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        .empty-state p {
            color: #7a7a9a;
            font-size: 1.1rem;
            max-width: 500px;
            margin: 0 auto;
        }
        
        /* Grille de séminaires */
        .seminars-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 25px;
        }
        
        /* Carte de séminaire */
        .seminar-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(255, 255, 255, 0.6);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            border-left: 4px solid var(--deep-lilac);
        }
        
        .seminar-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(138, 79, 255, 0.15);
        }
        
        .seminar-info {
            margin-bottom: 20px;
        }
        
        .seminar-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--dark-purple);
            margin-bottom: 10px;
        }
        
        .seminar-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 5px;
        }
        
        .meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95rem;
            color: #5a5a7a;
        }
        
        .meta-item i {
            color: var(--deep-lilac);
            width: 20px;
            text-align: center;
        }
        
        .seminar-status {
            padding: 6px 15px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 700;
            display: inline-block;
            background-color: #e0f2fe;
            color: #0284c7;
        }
        
        .seminar-date {
            font-size: 0.9rem;
            color: #7a7a9a;
        }
        
        /* Formulaire de résumé */
        .summary-form {
            background: rgba(249, 249, 251, 0.7);
            border-radius: 14px;
            padding: 20px;
            margin-top: 15px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--dark-purple);
            font-weight: 600;
            font-size: 0.95rem;
        }
        
        .form-control {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #e0d6ff;
            border-radius: 14px;
            font-size: 1rem;
            background: white;
            transition: var(--transition);
            outline: none;
            color: var(--dark-purple);
            font-weight: 500;
            resize: vertical;
            min-height: 120px;
        }
        
        .form-control:focus {
            border-color: var(--deep-lilac);
            box-shadow: 0 0 0 3px rgba(138, 79, 255, 0.2);
        }
        
        .form-control::placeholder {
            color: #bbb;
        }
        
        .error-message {
            color: #ef4444;
            font-size: 0.85rem;
            margin-top: 6px;
            display: block;
            padding-left: 5px;
        }
        
        /* Boutons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 25px;
            border-radius: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            font-size: 0.95rem;
            border: none;
            cursor: pointer;
            justify-content: center;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--deep-lilac) 0%, #6c2fff 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(138, 79, 255, 0.25);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(138, 79, 255, 0.35);
        }
        
        .btn-disabled {
            background: rgba(156, 163, 175, 0.3);
            color: #6b7280;
            cursor: not-allowed;
        }
        
        .btn-disabled:hover {
            transform: none;
            box-shadow: none;
        }
        
        /* Responsive */
        @media (min-width: 768px) {
            .seminar-card {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
            }
            
            .seminar-info {
                flex: 1;
                margin-bottom: 0;
                padding-right: 20px;
            }
            
            .summary-form {
                width: 45%;
                min-width: 350px;
                margin-top: 0;
            }
        }
        
        @media (max-width: 767px) {
            .container {
                padding: 80px 15px 30px;
            }
            
            .page-header h1 {
                font-size: 1.8rem;
            }
            
            .empty-state {
                padding: 30px 20px;
            }
            
            .empty-state i {
                font-size: 4rem;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Decorations -->
    <div class="decoration dec-1"></div>
    <div class="decoration dec-2"></div>
    <div class="decoration dec-3"></div>
    <div class="decoration dec-4"></div>

    <div class="container">
        <div class="page-header">
            <h1>Soumission de résumé</h1>
        </div>

        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($seminars->isEmpty()))
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h2>Aucun séminaire disponible</h2>
                <p>Soit vous n’avez pas de séminaire programmé, soit tous vos résumés ont été soumis.</p>
            </div>
        @else
            <div class="seminars-grid">
                @foreach($seminars as $seminar)
                    @php
                        $scheduledDate = \Carbon\Carbon::parse($seminar->scheduled_date);
                        $allowedDate   = $scheduledDate->copy()->subDays(10)->toDateString();
                        $todayDate     = $today;
                    @endphp

                    <div class="seminar-card">
                        <div class="seminar-info">
                            <h3 class="seminar-title">{{ $seminar->theme }}</h3>
                            
                            <div class="seminar-meta">
                                <div class="meta-item">
                                    <i class="fas fa-calendar-day"></i>
                                    <span>Date programmée : <strong>{{ $scheduledDate->format('d/m/Y') }}</strong></span>
                                </div>
                                
                                <div class="meta-item">
                                    <i class="fas fa-clock"></i>
                                    <span>Soumission possible le : <strong>{{ \Carbon\Carbon::parse($allowedDate)->format('d/m/Y') }}</strong></span>
                                </div>
                            </div>
                            
                            <div class="seminar-status">Accepté</div>
                            
                            <div class="seminar-date">
                                Soumis le {{ $seminar->created_at->format('d/m/Y à H:i') }}
                            </div>
                        </div>

                        <div class="summary-form">
                            @if($todayDate === $allowedDate)
                                {{-- Formulaire de soumission du résumé --}}
                                <form method="POST" action="{{ route('seminars.presenter.submitSummary', $seminar->id) }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="summary-{{ $seminar->id }}">Résumé</label>
                                        <textarea name="summary"
                                                id="summary-{{ $seminar->id }}"
                                                class="form-control"
                                                placeholder="Rédigez ici votre résumé..."
                                                required>{{ old('summary') }}</textarea>
                                        @error('summary'))
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <button type="submit"
                                            class="btn btn-primary w-full">
                                        <i class="fas fa-paper-plane"></i> Soumettre le résumé
                                    </button>
                                </form>
                            @elseif($todayDate < $allowedDate)
                                <div class="text-center py-4">
                                    <div class="mb-3">
                                        <i class="fas fa-clock text-3xl text-yellow-500"></i>
                                    </div>
                                    <p class="mb-4 text-gray-600">
                                        La soumission sera disponible le<br>
                                        <strong>{{ \Carbon\Carbon::parse($allowedDate)->format('d/m/Y') }}</strong>
                                    </p>
                                    <button class="btn btn-disabled w-full">
                                        <i class="fas fa-lock"></i> Soumission bientôt disponible
                                    </button>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <div class="mb-3">
                                        <i class="fas fa-exclamation-triangle text-3xl text-red-500"></i>
                                    </div>
                                    <p class="mb-4 text-gray-600">
                                        La date limite de soumission est dépassée
                                    </p>
                                    <button class="btn btn-disabled w-full">
                                        <i class="fas fa-ban"></i> Soumission fermée
                                    </button>
                                </div>
                            @endif
                        </div>
                        
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script>
        // Animation au survol des cartes
        document.addEventListener('DOMContentLoaded', () => {
            const cards = document.querySelectorAll('.seminar-card');
            
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px)';
                    this.style.boxShadow = '0 15px 40px rgba(138, 79, 255, 0.15)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '0 8px 30px rgba(0, 0, 0, 0.08)';
                });
            });
        });
    </script>
</body>
</html>
@endsection
