@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Séminaires expirés | IMSP Séminaires</title>
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
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 100px 20px 60px;
        }

        .header {
            margin-bottom: 40px;
            position: relative;
            padding-bottom: 20px;
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--dark-purple);
            position: relative;
            display: inline-block;
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

        .header p {
            color: #6c6c8a;
            font-size: 1.1rem;
            margin-top: 15px;
        }

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
            border-left: 4px solid #ef4444;
        }

        .seminar-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(239, 68, 68, 0.15);
        }

        .seminar-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: #ef4444;
        }

        .status-badge {
            padding: 6px 15px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background-color: #fee2e2;
            color: #b91c1c;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.95rem;
            color: #5a5a7a;
            margin-bottom: 10px;
        }

        .detail-item i {
            color: #ef4444;
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            font-size: 0.95rem;
            background: rgba(138, 79, 255, 0.1);
            color: var(--deep-lilac);
            border: none;
            cursor: pointer;
        }

        .action-btn:hover {
            background: rgba(138, 79, 255, 0.2);
            transform: translateY(-2px);
        }

        .empty-state {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            border-radius: var(--border-radius);
            padding: 60px 40px;
            text-align: center;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(255, 255, 255, 0.6);
        }

        .empty-state i {
            font-size: 4rem;
            color: var(--soft-violet);
            opacity: 0.7;
            margin-bottom: 20px;
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

        .seminar-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
        }

        .seminar-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .seminar-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--dark-purple);
            max-width: 80%;
        }

        .seminar-date {
            color: #7a7a9a;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .seminar-date i {
            color: #ef4444;
        }

        .presenter-info {
            font-size: 0.95rem;
            margin-bottom: 15px;
            color: #5a5a7a;
        }

        .presenter-info strong {
            color: var(--dark-purple);
        }

        .card-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 80px 15px 40px;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .seminar-grid {
                grid-template-columns: 1fr;
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
        <div class="header">
            <h1>Séminaires expirés</h1>
            <p>Séminaires dont la date de présentation est dépassée</p>
        </div>

        @if($seminars->isEmpty())
            <div class="empty-state">
                <i class="fas fa-calendar-times"></i>
                <h2>Aucun séminaire expiré</h2>
                <p>Tous les séminaires programmés sont à venir ou en cours de planification.</p>
            </div>
        @else
            <div class="seminar-grid">
                @foreach($seminars as $seminar)
                    <div class="seminar-card">
                        <div class="seminar-header">
                            <h3 class="seminar-title">{{ $seminar->theme }}</h3>
                            <span class="status-badge">
                                <i class="fas fa-clock"></i> Expiré
                            </span>
                        </div>
                        
                        <div class="seminar-date">
                            <i class="fas fa-calendar-day"></i>
                            {{ \Carbon\Carbon::parse($seminar->scheduled_date)->format('d F Y') }}
                        </div>
                        
                        <div class="presenter-info">
                            <div class="detail-item">
                                <i class="fas fa-user-tie"></i>
                                <span><strong>{{ $seminar->presenter->name }}</strong> ({{ $seminar->presenter->email }})</span>
                            </div>
                        </div>
                        
                        <div class="card-actions">
                            <a href="{{ route('seminars.secretary.showSummary', $seminar->id) }}"
                               class="action-btn">
                                <i class="fas fa-file-alt"></i> Voir le résumé
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script>
        // Animation au survol des cartes
        document.querySelectorAll('.seminar-card').forEach(card => {
            card.addEventListener('mouseenter', function () {
                this.style.transform = 'translateY(-8px)';
                this.style.boxShadow = '0 15px 40px rgba(239, 68, 68, 0.15)';
            });

            card.addEventListener('mouseleave', function () {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = 'var(--shadow-soft)';
            });
        });
    </script>
</body>
</html>
@endsection
