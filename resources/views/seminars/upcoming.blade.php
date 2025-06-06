{{-- resources/views/seminars/upcoming.blade.php --}}
@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Séminaires à venir | IMSP Séminaires</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
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

        .seminar-card {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(255, 255, 255, 0.6);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .seminar-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(138, 79, 255, 0.15);
        }

        .status-badge {
            padding: 6px 15px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-accepted {
            background-color: #e0f2fe;
            color: #0284c7;
        }

        .status-published {
            background-color: #dcfce7;
            color: #15803d;
        }

        .empty-state {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            border-radius: var(--border-radius);
            padding: 40px;
            text-align: center;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(255, 255, 255, 0.6);
        }

        .empty-state i {
            font-size: 4rem;
            color: var(--soft-violet);
            opacity: 0.7;
        }

        .empty-state h2 {
            font-size: 1.5rem;
            color: #5a5a7a;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #7a7a9a;
            font-size: 1rem;
            max-width: 500px;
            margin: 0 auto;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .btn-summary {
            background: rgba(138, 79, 255, 0.1);
            color: var(--deep-lilac);
        }

        .btn-summary:hover {
            background: rgba(138, 79, 255, 0.2);
            transform: translateY(-2px);
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

        .detail-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.95rem;
            color: #5a5a7a;
            margin-bottom: 10px;
        }

        .detail-item i {
            color: var(--deep-lilac);
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .card-actions {
            display: flex;
            gap: 12px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .seminar-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--deep-lilac);
        }
    </style>
</head>
<body>
    <!-- Decorations -->
    <div class="decoration dec-1"></div>
    <div class="decoration dec-2"></div>
    <div class="decoration dec-3"></div>

    <div class="container mx-auto px-4 py-10">
        <div class="header mb-8 relative pb-4">
            <h1 class="text-3xl font-bold text-gray-800 relative inline-block">Séminaires à venir</h1>
            <p class="text-gray-600 mt-2">Consultez les séminaires programmés dans les prochains jours.</p>
        </div>

        @if($seminars->isEmpty())
            <div class="empty-state">
                <i class="fas fa-calendar-slash text-5xl text-gray-300 mb-4"></i>
                <h2 class="text-xl font-semibold text-gray-700 mb-2">Aucun séminaire programmé</h2>
                <p class="text-gray-500">Il n’y a aucun séminaire à venir pour le moment.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($seminars as $seminar)
                    <div class="seminar-card" data-theme="{{ strtolower($seminar->theme) }}" data-status="{{ $seminar->status }}">
                        <div class="flex justify-between items-start mb-3">
                            {{-- Statut visuel --}}
                            @if($seminar->status === 'accepted')
                                <span class="status-badge status-accepted">
                                    {{ ucfirst($seminar->status) }}
                                </span>
                            @elseif($seminar->status === 'published')
                                <span class="status-badge status-published">
                                    {{ ucfirst($seminar->status) }}
                                </span>
                            @endif
                            <span class="text-gray-500 text-sm flex items-center">
                                <i class="fas fa-calendar-day mr-1 text-deep-lilac"></i> 
                                {{ \Carbon\Carbon::parse($seminar->scheduled_date)->format('d F Y') }}
                            </span>
                        </div>
                        <h3 class="font-bold text-lg mb-3 text-gray-800">{{ $seminar->theme }}</h3>
                        
                        <div class="card-details mb-4">
                            <div class="detail-item">
                                <i class="fas fa-user-tie"></i>
                                <span>{{ $seminar->presenter->name }}</span>
                            </div>

                        </div>
                        
                        <div class="card-actions">
                            <button class="action-btn btn-summary">
                                <i class="fas fa-file-alt"></i> Voir résumé
                            </button>

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
                this.style.boxShadow = '0 15px 40px rgba(138, 79, 255, 0.15)';
            });

            card.addEventListener('mouseleave', function () {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 8px 30px rgba(0, 0, 0, 0.08)';
            });
        });
    </script>
</body>
</html>
@endsection