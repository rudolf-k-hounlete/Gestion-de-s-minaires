{{-- resources/views/seminars/secretary/showSummary.blade.php --}}
@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résumé du séminaire | IMSP Séminaires</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
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
            background: linear-gradient(135deg, var(--soft-lavender) 0%, var(--gentle-mint) 100%);
            min-height: 100vh;
            color: #4a4a6a;
            line-height: 1.6;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 100px 20px 60px;
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

        .summary-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-radius: var(--border-radius);
            padding: 35px;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(255, 255, 255, 0.6);
            position: relative;
            overflow: hidden;
            border-left: 4px solid var(--deep-lilac);
        }

        .summary-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--deep-lilac);
        }

        .header {
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 20px;
            border-bottom: 2px solid rgba(138, 79, 255, 0.1);
        }

        .header h1 {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--dark-purple);
            position: relative;
            display: inline-block;
            margin-bottom: 15px;
        }

        .header h1::after {
            content: "";
            position: absolute;
            bottom: -12px;
            left: 0;
            width: 120px;
            height: 5px;
            background: var(--deep-lilac);
            border-radius: 3px;
        }

        .seminar-info {
            margin-bottom: 25px;
            padding: 20px;
            background: rgba(240, 230, 255, 0.2);
            border-radius: 14px;
        }

        .seminar-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark-purple);
            margin-bottom: 10px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1rem;
            color: #5a5a7a;
            margin-bottom: 8px;
        }

        .info-item i {
            color: var(--deep-lilac);
            font-size: 1.1rem;
            width: 24px;
            text-align: center;
        }

        .summary-content {
            background: rgba(249, 249, 251, 0.5);
            border-radius: 14px;
            padding: 25px;
            margin-top: 20px;
            border: 1px solid rgba(224, 214, 255, 0.3);
        }

        .summary-text {
            color: #4a4a6a;
            line-height: 1.8;
            font-size: 1.05rem;
            white-space: pre-line;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            font-size: 1rem;
            background: rgba(138, 79, 255, 0.1);
            color: var(--deep-lilac);
            border: none;
            cursor: pointer;
            margin-top: 30px;
        }

        .action-btn:hover {
            background: rgba(138, 79, 255, 0.2);
            transform: translateY(-2px);
        }

        .action-btn i {
            font-size: 1rem;
        }

        @media (max-width: 768px) {
            .container {
                padding: 80px 15px 40px;
            }
            
            .header h1 {
                font-size: 1.8rem;
            }
            
            .summary-card {
                padding: 25px;
            }
        }
    </style>
</head>
<body>
    <!-- Decorations -->
    <div class="decoration dec-1"></div>
    <div class="decoration dec-2"></div>
    <div class="decoration dec-3"></div>

    <div class="container">
        <div class="summary-card">
            <div class="header">
                <h1>Résumé du séminaire</h1>
            </div>

            <div class="seminar-info">
                <h2 class="seminar-title">{{ $seminar->theme }}</h2>
                
                <div class="info-item">
                    <i class="fas fa-calendar-day"></i>
                    <span>Programmée le <strong>{{ \Carbon\Carbon::parse($seminar->scheduled_date)->format('d F Y') }}</strong></span>
                </div>
                
                <div class="info-item">
                    <i class="fas fa-user-tie"></i>
                    <span>Présenté par <strong>{{ $seminar->presenter->name }}</strong> ({{ $seminar->presenter->email }})</span>
                </div>
                
                @if($seminar->status)
                <div class="info-item">
                    <i class="fas fa-tag"></i>
                    <span>Statut: <span class="font-semibold">{{ ucfirst($seminar->status) }}</span></span>
                </div>
                @endif
            </div>

            <div class="summary-content">
                <h3 class="text-lg font-semibold mb-4 text-deep-lilac">Contenu du séminaire</h3>
                <div class="summary-text">
                    {!! nl2br(e($seminar->summary)) !!}
                </div>
            </div>

            <a href="{{ route('seminars.secretary.publish_list') }}"
               class="action-btn">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
        </div>
    </div>
</body>
</html>
@endsection