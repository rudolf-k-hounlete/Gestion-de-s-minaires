<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récapitulatif Séminaire | IMSP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            padding: 40px 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-soft);
            padding: 40px;
            border: 1px solid rgba(255, 255, 255, 0.6);
            position: relative;
            overflow: hidden;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid rgba(138, 79, 255, 0.2);
            position: relative;
        }

        .header::after {
            content: "";
            position: absolute;
            bottom: -2px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: var(--deep-lilac);
            border-radius: 2px;
        }

        .header h1 {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--dark-purple);
            margin-bottom: 10px;
        }

        .header p {
            color: #6c6c8a;
            font-size: 1.1rem;
        }

        .recap-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            border-left: 4px solid var(--deep-lilac);
        }

        .card-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--dark-purple);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-title i {
            color: var(--deep-lilac);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            padding: 15px;
            border-radius: 14px;
            background: rgba(138, 79, 255, 0.05);
        }

        .info-label {
            font-size: 0.9rem;
            color: #6c6c8a;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-label i {
            color: var(--deep-lilac);
            font-size: 1.1rem;
        }

        .info-value {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark-purple);
            padding-left: 28px;
        }

        .summary-content {
            background: white;
            padding: 25px;
            border-radius: 16px;
            line-height: 1.8;
            color: #5a5a7a;
            font-size: 1.05rem;
            border: 1px solid rgba(224, 214, 255, 0.5);
        }

        .footer {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(224, 214, 255, 0.4);
            color: #7a7a9a;
            font-size: 0.95rem;
        }

        .footer-logo {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--deep-lilac);
            font-weight: 700;
            margin-top: 10px;
            text-decoration: none;
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

        @media (max-width: 768px) {
            .container {
                padding: 30px 20px;
            }
            
            .header h1 {
                font-size: 1.8rem;
            }
            
            .recap-card {
                padding: 20px;
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
            <h1>Récapitulatif du Séminaire</h1>
            <p>Détails complets de la présentation</p>
        </div>

        <div class="recap-card">
            <h2 class="card-title"><i class="fas fa-info-circle"></i> Informations générales</h2>
            
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-book"></i> Thème</span>
                    <div class="info-value">{{ $theme }}</div>
                </div>
                
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-user-tie"></i> Présentateur</span>
                    <div class="info-value">{{ $presenter }}</div>
                </div>
                
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-calendar-day"></i> Date</span>
                    <div class="info-value">{{ $scheduled_date }}</div>
                </div>
                
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-clock"></i> Statut</span>
                    <div class="info-value">Terminé</div>
                </div>
            </div>
        </div>

        <div class="recap-card">
            <h2 class="card-title"><i class="fas fa-file-alt"></i> Résumé du séminaire</h2>
            
            <div class="summary-content">
                {!! nl2br(e($summary)) !!}
            </div>
        </div>

        <div class="footer">
            <p>Document généré le {{ date('d/m/Y à H:i') }}</p>
            <a href="#" class="footer-logo">
                <i class="fas fa-chalkboard-teacher"></i> IMSP Séminaires
            </a>
        </div>
    </div>
</body>
</html>