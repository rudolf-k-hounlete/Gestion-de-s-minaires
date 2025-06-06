{{-- resources/views/seminars/presenter/index.blade.php --}}
{{-- resources/views/dashboard.blade.php --}}

@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes demandes de séminaire</title>
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
            max-width: 1000px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
        }

        .header h1 {
            font-size: 2.8rem;
            font-weight: 800;
            color: #3a2e6d;
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }

        .header h1::after {
            content: "";
            position: absolute;
            bottom: -12px;
            left: 50%;
            transform: translateX(-50%);
            width: 120px;
            height: 5px;
            background: #8a4fff;
            border-radius: 3px;
        }

        .header p {
            color: #6c6c8a;
            font-size: 1.2rem;
            max-width: 90%;
            margin: 0 auto;
            margin-top: 25px;
        }

        .card {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            border-radius: var(--border-radius);
            padding: 40px;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(255, 255, 255, 0.6);
            margin-bottom: 40px;
        }

        .actions-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;
            flex-wrap: wrap;
            gap: 20px;
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

        .btn-primary i {
            margin-right: 12px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 5rem;
            color: #d8c0ff;
            margin-bottom: 25px;
            opacity: 0.7;
        }

        .empty-state h2 {
            font-size: 1.8rem;
            color: #5a5a7a;
            margin-bottom: 15px;
        }

        .empty-state p {
            color: #7a7a9a;
            font-size: 1.15rem;
            margin-bottom: 35px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .seminar-list {
            display: grid;
            grid-template-columns: 1fr;
            gap: 25px;
        }

        .seminar-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border-left: 4px solid #8a4fff;
            position: relative;
            overflow: hidden;
        }

        .seminar-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(138, 79, 255, 0.15);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #3a2e6d;
            max-width: 80%;
        }

        .status-badge {
            padding: 6px 15px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending {
            background-color: #fff8e6;
            color: #d97706;
        }

        .status-accepted {
            background-color: #e0f2fe;
            color: #0284c7;
        }

        .status-published {
            background-color: #dcfce7;
            color: #15803d;
        }

        .status-other {
            background-color: #f3f4f6;
            color: #4b5563;
        }

        .card-details {
            display: flex;
            gap: 25px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95rem;
            color: #5a5a7a;
        }

        .detail-item i {
            color: #8a4fff;
            font-size: 1.1rem;
        }

        .summary {
            background: #f9f7ff;
            border-radius: 12px;
            padding: 15px;
            margin: 20px 0;
            font-size: 1rem;
            color: #5c5c77;
            line-height: 1.7;
            border-left: 3px solid #8a4fff;
        }

        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px dashed #e0d6ff;
            flex-wrap: wrap;
            gap: 15px;
        }

        .download-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            background: rgba(138, 79, 255, 0.1);
            color: #8a4fff;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .download-btn:hover {
            background: rgba(138, 79, 255, 0.2);
            transform: translateY(-2px);
        }

        .creation-date {
            font-size: 0.9rem;
            color: #8c8ca7;
            font-style: italic;
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

        .search-input {
            padding: 12px 20px;
            border: 2px solid #e0d6ff;
            border-radius: 14px;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
            min-width: 300px;
        }

        .search-input:focus {
            outline: none;
            border-color: #8a4fff;
            box-shadow: 0 0 0 4px rgba(138, 79, 255, 0.2);
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 2.2rem;
            }
            
            .card {
                padding: 25px;
            }
            
            .actions-bar {
                flex-direction: column;
                align-items: stretch;
            }
            
            .btn {
                width: 100%;
            }
            
            .card-header {
                flex-direction: column;
                gap: 15px;
            }
            
            .card-title {
                max-width: 100%;
            }
            
            .card-footer {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .search-input {
                min-width: 100%;
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
            <h1>Mes demandes de séminaire</h1>
            <p>Retrouvez ici toutes vos demandes de séminaires avec leur statut actuel</p>
        </div>
        
        <div class="card">
            <div class="actions-bar">
                <a href="{{ route('seminars.presenter.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nouvelle demande
                </a>
                <div class="search-filter">
                    <input type="text" placeholder="Rechercher un séminaire..." class="search-input">
                </div>
            </div>
            
            @if($seminars->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-file-alt"></i>
                    <h2>Aucune demande de séminaire</h2>
                    <p>Vous n'avez pas encore créé de demande de séminaire. Commencez dès maintenant en soumettant votre première proposition.</p>
                    <a href="{{ route('seminars.presenter.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Créer une nouvelle demande
                    </a>
                </div>
            @else
                <div class="seminar-list">
                    @foreach($seminars as $seminar)
                        <div class="seminar-card" 
                             data-status="{{ $seminar->status }}"
                             data-theme="{{ strtolower($seminar->theme) }}">
                            <div class="card-header">
                                <h3 class="card-title">{{ $seminar->theme }}</h3>
                                <span class="status-badge status-{{ $seminar->status }}">
                                    {{ ucfirst($seminar->status) }}
                                </span>
                            </div>
                            
                            <div class="card-details">
                                <div class="detail-item">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span>Date demandée: <strong>{{ \Carbon\Carbon::parse($seminar->preferred_date)->format('d/m/Y') }}</strong></span>
                                </div>
                                @if($seminar->status !== 'pending' && $seminar->scheduled_date)
                                    <div class="detail-item">
                                        <i class="fas fa-calendar-check"></i>
                                        <span>Date confirmée: <strong>{{ \Carbon\Carbon::parse($seminar->scheduled_date)->format('d/m/Y') }}</strong></span>
                                    </div>
                                @endif
                            </div>
                            
                            @if($seminar->summary)
                                <div class="summary">
                                    <strong>Résumé:</strong> {{ Str::limit($seminar->summary, 200, '…') }}
                                </div>
                            @endif
                            
                            <div class="card-footer">
                                @if($seminar->presentation_path)
                                    <a href="{{ route('seminars.student.download', $seminar->id) }}" 
                                       class="download-btn">
                                        <i class="fas fa-download"></i> Télécharger la présentation
                                    </a>
                                @endif
                                <div class="creation-date">
                                    Créé le {{ $seminar->created_at->format('d/m/Y à H:i') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <script>
        // Animation pour les cartes au survol
        document.querySelectorAll('.seminar-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px)';
                this.style.boxShadow = '0 15px 35px rgba(138, 79, 255, 0.2)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 5px 20px rgba(0, 0, 0, 0.05)';
            });
        });

        // Fonction de recherche dynamique
        document.querySelector('.search-input').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            document.querySelectorAll('.seminar-card').forEach(card => {
                const theme = card.getAttribute('data-theme');
                const status = card.getAttribute('data-status');
                
                if (theme.includes(searchTerm) || status.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Animation d'apparition progressive des cartes
        document.querySelectorAll('.seminar-card').forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 50);
            }, index * 150);
        });
    </script>
</body>
</html>

@endsection










