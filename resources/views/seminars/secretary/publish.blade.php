@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publier un séminaire | IMSP Séminaires</title>
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

        .info-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-left: 4px solid var(--deep-lilac);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            margin-bottom: 30px;
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(138, 79, 255, 0.15);
        }

        .detail-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            font-size: 1.05rem;
            color: #5a5a7a;
            margin-bottom: 18px;
            padding-bottom: 18px;
            border-bottom: 1px dashed rgba(138, 79, 255, 0.1);
        }

        .detail-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .detail-item i {
            color: var(--deep-lilac);
            font-size: 1.3rem;
            width: 30px;
            text-align: center;
            margin-top: 3px;
        }

        .detail-content {
            flex: 1;
        }

        .detail-title {
            font-weight: 700;
            color: var(--dark-purple);
            margin-bottom: 5px;
        }

        .detail-value {
            color: #5a5a7a;
            line-height: 1.5;
        }

        .publish-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 15px 30px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 1.1rem;
            text-decoration: none;
            transition: var(--transition);
            background: linear-gradient(135deg, var(--deep-lilac) 0%, #6c2fff 100%);
            color: white;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(138, 79, 255, 0.3);
        }

        .publish-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(138, 79, 255, 0.4);
        }

        .publish-btn:active {
            transform: translateY(1px);
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

        .resume-container {
            background: rgba(249, 249, 251, 0.6);
            border-radius: 14px;
            padding: 20px;
            margin-top: 10px;
            border: 1px solid rgba(138, 79, 255, 0.1);
        }

        .resume-text {
            color: #5a5a7a;
            line-height: 1.7;
            font-size: 1.05rem;
        }

        @media (max-width: 768px) {
            .container {
                padding: 80px 15px 40px;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .info-card {
                padding: 20px;
            }
            
            .detail-item {
                flex-direction: column;
                gap: 8px;
            }
        }
    </style>
</head>
<body>
    <!-- Decorations -->
    <div class="decoration dec-1"></div>
    <div class="decoration dec-2"></div>
    <div class="decoration dec-3"></div>

    <div class="container mx-auto px-4 py-10">
        <div class="header">
            <h1>Publier le séminaire : « {{ $seminar->theme }} »</h1>
        </div>

        <div class="info-card">
            <div class="detail-item">
                <i class="fas fa-user-tie"></i>
                <div class="detail-content">
                    <div class="detail-title">Présentateur</div>
                    <div class="detail-value">{{ $seminar->presenter->name }} ({{ $seminar->presenter->email }})</div>
                </div>
            </div>
            
            <div class="detail-item">
                <i class="fas fa-calendar-day"></i>
                <div class="detail-content">
                    <div class="detail-title">Date programmée</div>
                    <div class="detail-value">{{ $seminar->scheduled_date->translatedFormat('d/m/Y') }}</div>
                </div>
            </div>
            
            <div class="detail-item">
                <i class="fas fa-chalkboard"></i>
                <div class="detail-content">
                    <div class="detail-title">Thème</div>
                    <div class="detail-value">{{ $seminar->theme }}</div>
                </div>
            </div>
            
            <div class="detail-item">
                <i class="fas fa-file-alt"></i>
                <div class="detail-content">
                    <div class="detail-title">Résumé reçu</div>
                    <div class="resume-container">
                        <p class="resume-text">{{ $seminar->resume }}</p>
                    </div>
                </div>
            </div>
        </div>

        <form method="PUT" action="{{ route('seminars.secretary.doPublish', $seminar->id) }}">
            @csrf
            @method('PUT')

            <button type="submit" class="publish-btn">
                <i class="fas fa-upload"></i> Publier ce séminaire
            </button>
        </form>
    </div>

    <script>
        // Animation au survol de la carte
        const infoCard = document.querySelector('.info-card');
        infoCard.addEventListener('mouseenter', function () {
            this.style.transform = 'translateY(-8px)';
            this.style.boxShadow = '0 15px 40px rgba(138, 79, 255, 0.15)';
        });

        infoCard.addEventListener('mouseleave', function () {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'var(--shadow-soft)';
        });
    </script>
</body>
</html>
@endsection
