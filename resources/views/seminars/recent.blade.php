{{-- resources/views/seminars/recent.blade.php --}}
@extends('layouts.app')
@section('content')

<<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Présentations récentes | IMSP Séminaires</title>
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
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            position: relative;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 2.2rem;
            font-weight: 800;
            color: #3a2e6d;
            margin-bottom: 8px;
            position: relative;
            display: inline-block;
        }

        .header h1::after {
            content: "";
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 100px;
            height: 4px;
            background: var(--deep-lilac);
            border-radius: 2px;
        }

        .header p {
            color: #6c6c8a;
            font-size: 1.1rem;
        }

        .section-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(255, 255, 255, 0.6);
            padding: 30px;
            transition: var(--transition);
            margin-bottom: 30px;
        }

        .section-card:hover {
            box-shadow: 0 15px 40px rgba(138, 79, 255, 0.15);
            transform: translateY(-5px);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .section-title {
            font-size: 1.6rem;
            font-weight: 700;
            color: #3a2e6d;
            position: relative;
            padding-left: 15px;
        }

        .section-title::before {
            content: "";
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 6px;
            height: 80%;
            background: var(--deep-lilac);
            border-radius: 3px;
        }

        .view-all {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: rgba(138, 79, 255, 0.1);
            color: var(--deep-lilac);
            border-radius: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
        }

        .view-all:hover {
            background: rgba(138, 79, 255, 0.2);
            transform: translateY(-3px);
        }

        .empty-state {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-soft);
            padding: 40px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.6);
        }

        .empty-state i {
            font-size: 4rem;
            color: var(--soft-violet);
            opacity: 0.7;
            margin-bottom: 20px;
        }

        .empty-state h2 {
            font-size: 1.5rem;
            color: #5a5a7a;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .empty-state p {
            color: #7a7a9a;
            font-size: 1rem;
            max-width: 500px;
            margin: 0 auto;
        }

        .recent-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        .recent-table thead {
            background: rgba(138, 79, 255, 0.1);
        }

        .recent-table th {
            padding: 18px 20px;
            text-align: left;
            font-weight: 700;
            color: #3a2e6d;
            font-size: 1.05rem;
        }

        .recent-table tbody tr {
            transition: var(--transition);
        }

        .recent-table tbody tr:hover {
            background: rgba(138, 79, 255, 0.05);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .recent-table td {
            padding: 15px 20px;
            border-bottom: 1px solid rgba(224, 214, 255, 0.5);
            color: #5a5a7a;
        }

        .presenter-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .presenter-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: var(--deep-lilac);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .presenter-name {
            font-weight: 600;
            color: #3a2e6d;
            font-size: 1.05rem;
        }

        .presenter-department {
            font-size: 0.9rem;
            color: #7a7a9a;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.95rem;
            color: #5a5a7a;
        }

        .detail-item i {
            color: var(--deep-lilac);
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .table-actions {
            display: flex;
            gap: 15px;
        }

        .table-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            font-size: 0.95rem;
        }

        .table-recap {
            background: rgba(138, 79, 255, 0.1);
            color: var(--deep-lilac);
        }

        .table-recap:hover {
            background: rgba(138, 79, 255, 0.2);
            transform: translateY(-3px);
        }

        .decoration {
            position: fixed;
            z-index: -1;
            border-radius: 50%;
            opacity: 0.5;
            pointer-events: none;
            filter: blur(8px);
        }

        .dec-1 {
            top: 10%;
            left: 5%;
            width: 140px;
            height: 140px;
            background: var(--misty-rose);
            animation: float 15s ease-in-out infinite;
        }

        .dec-2 {
            bottom: 15%;
            right: 7%;
            width: 110px;
            height: 110px;
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
            .section-card {
                padding: 20px;
            }
            
            .recent-table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
            
            .section-title {
                font-size: 1.4rem;
            }
            
            .view-all {
                padding: 8px 15px;
            }
            
            .table-action {
                padding: 8px 12px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <!-- Decorations -->
    <div class="decoration dec-1"></div>
    <div class="decoration dec-2"></div>
    <div class="decoration dec-3"></div>

    <div class="container mx-auto px-4 py-8">
        <div class="header">
            <h1>Présentations récentes</h1>
            <p>Derniers fichiers uploadés par les présentateurs.</p>
        </div>

        @if($presentations->isEmpty())
            <div class="empty-state">
                <i class="fas fa-folder-open"></i>
                <h2>Aucune présentation disponible</h2>
                <p>Il n’y a aucune présentation téléchargée pour le moment.</p>
            </div>
        @else
            <div class="section-card">
                <div class="section-header">
                    <h2 class="section-title">Présentations téléchargeables</h2>

                </div>

                <div class="overflow-x-auto">
                    <table class="recent-table">
                        <thead>
                            <tr>
                                <th scope="col">
                                    Titre
                                </th>
                                <th scope="col">
                                    Présentateur
                                </th>
                                <th scope="col">
                                    Date d’upload
                                </th>
                                <th scope="col">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($presentations as $seminar)
                                <tr class="presentation-file">
                                    <td>
                                        <div class="font-bold text-gray-800 text-lg">{{ $seminar->theme }}</div>
                                    </td>
                                    <td>
                                        <div class="presenter-info">
                                            <div class="presenter-avatar">
                                                {{ substr($seminar->presenter->name, 0, 2) }}
                                            </div>
                                            <div>
                                                <div class="presenter-name">{{ $seminar->presenter->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="detail-item">
                                            <i class="fas fa-calendar-day"></i>
                                            <span>{{ $seminar->scheduled_date ? \Carbon\Carbon::parse($seminar->scheduled_date)->format('d F Y') : '-' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="table-actions">
                                            <a href="{{ route('seminars.recap', $seminar->id) }}" class="table-action table-recap">
                                                <i class="fas fa-file-pdf"></i> PDF Récap
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

    <script>
        // Animation au survol des lignes du tableau
        document.querySelectorAll('.recent-table tbody tr').forEach(row => {
            row.addEventListener('mouseenter', function () {
                this.style.transform = 'scale(1.02)';
            });

            row.addEventListener('mouseleave', function () {
                this.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>
@endsection