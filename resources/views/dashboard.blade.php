{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')
@section('content')

<div class="container mx-auto px-4 py-10">
    <div class="header mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Tableau de bord</h1>
        <p class="text-gray-600 mt-2">Vue d'ensemble de vos activités et séminaires</p>
    </div>

    {{-- Messages flash --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-md shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Stats rapides --}}
<div class="stats-grid">
    {{-- Séminaires programmés --}}
    <div class="stat-card">
        <div class="stat-info">
            <h3 class="stat-value">{{ $countScheduled }}</h3>
            <p>Séminaires programmés</p>
        </div>
        <div class="stat-icon icon-blue">
            <i class="fas fa-calendar-alt"></i>
        </div>
    </div>

    {{-- Séminaires en attente --}}
    <div class="stat-card">
        <div class="stat-info">
            <h3 class="stat-value">{{ $countPending }}</h3>
            <p>Séminaires en attente</p>
        </div>
        <div class="stat-icon icon-yellow">
            <i class="fas fa-clock"></i>
        </div>
    </div>

    {{-- Présentations disponibles --}}
    <div class="stat-card">
        <div class="stat-info">
            <h3 class="stat-value">{{$countAvailablePresentations}}</h3>
            <p>Présentations disponibles</p>
        </div>
        <div class="stat-icon icon-green">
            <i class="fas fa-file-pdf"></i>
        </div>
    </div>

    {{-- Présentations publiées --}}
    <div class="stat-card">
        <div class="stat-info">
            <h3 class="stat-value">{{$publishedCount}}</h3>
            <p>Présentations publiées</p>
        </div>
        <div class="stat-icon icon-green">
            <i class="fas fa-globe"></i> {{-- Icône modifiée --}}
        </div>
    </div>

    {{-- Séminaires passés --}}
    <div class="stat-card">
        <div class="stat-info">
            <h3 class="stat-value">{{$completedCount}}</h3>
            <p>Séminaires passés</p> {{-- Texte modifié pour cohérence --}}
        </div>
        <div class="stat-icon icon-green">
            <i class="fas fa-history"></i> {{-- Icône modifiée --}}
        </div>
    </div>
</div>

    {{-- Séminaires à venir --}}
    <div class="section-card">
        <div class="section-header">
            <h2 class="section-title">Séminaires à venir</h2>
            <a href="{{ route('seminars.upcoming') }}" class="view-all">
                Voir tout <i class="fas fa-chevron-right"></i>
            </a>
        </div>

        @if($upcomingSeminars->isEmpty())
            <div class="empty-state">
                <i class="fas fa-calendar-slash text-5xl text-gray-300 mb-4"></i>
                <p>Aucun séminaire programmé.</p>
            </div>
        @else
            <div class="seminars-grid">
                @foreach($upcomingSeminars as $seminar)
                    <div class="seminar-card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $seminar->theme }}</h3>
                            <span class="status-badge status-{{ $seminar->status }}">
                                {{ ucfirst($seminar->status) }}
                            </span>
                        </div>
                        <div class="card-details">
                            <div class="detail-item">
                                <i class="fas fa-user-tie"></i>
                                <span>{{ $seminar->presenter->name }}</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-calendar-alt"></i>
                                <span>{{ \Carbon\Carbon::parse($seminar->scheduled_date)->format('d F Y') }}</span>
                            </div>
                        </div>
                        <div class="card-actions">
                            <button class="action-btn btn-summary" data-modal="modal-{{ $seminar->id }}">
                                <i class="fas fa-file-alt"></i> Voir résumé
                            </button>

                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Présentations récentes --}}
    <div class="section-card">
        <div class="section-header">
            <h2 class="section-title">Présentations passées</h2>
            <a href="{{ route('seminars.recent') }}" class="view-all">
                Voir tout <i class="fas fa-chevron-right"></i>
            </a>
        </div>

        @if($recentPresentations->isEmpty())
            <div class="empty-state">
                <i class="fas fa-folder-open text-5xl text-gray-300 mb-4"></i>
                <p>Aucune présentation disponible.</p>
            </div>
        @else
            <table class="recent-table">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Présentateur</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentPresentations as $seminar)
                        <tr class="presentation-file hover:bg-gray-50 transition duration-150">
                            <td>
                                <div class="text-lg font-bold">{{ $seminar->theme }}</div>
                                <div class="text-sm text-gray-500">{{ Str::limit($seminar->summary, 50, '…') }}</div>
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
        @endif
    </div>
</div>

{{-- Modals dynamiques --}}

@foreach($upcomingSeminars as $seminar)
    @if($seminar->summary)
        <div id="modal-{{ $seminar->id }}" class="modal-overlay">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Résumé – {{ $seminar->theme }}</h3>
                    <button class="close-modal">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{!! nl2br(e($seminar->summary)) !!}</p>
                </div>
                <div class="modal-footer">
                    <button class="btn-close">Fermer</button>
                </div>
            </div>
        </div>
    @endif
@endforeach

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

    body {
        background: linear-gradient(135deg, var(--soft-lavender) 0%, var(--gentle-mint) 100%);
        min-height: 100vh;
        font-family: 'Nunito', sans-serif;
        color: #4a4a6a;
        line-height: 1.6;
    }

    .container {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
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
            left: 50%;
            transform: translateX(-50%);
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

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(12px);
        border-radius: var(--border-radius);
        padding: 20px;
        box-shadow: var(--shadow-soft);
        border: 1px solid rgba(255, 255, 255, 0.6);
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(138, 79, 255, 0.15);
    }

    .stat-info h3 {
        font-size: 1.8rem;
        font-weight: 700;
        color: #3a2e6d;
        margin-bottom: 5px;
    }

    .stat-info p {
        color: #6c6c8a;
        font-size: 1.05rem;
    }

    .stat-icon {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
    }

    .icon-blue {
        background: rgba(59, 130, 246, 0.15);
        color: #3b82f6;
    }

    .icon-yellow {
        background: rgba(234, 179, 8, 0.15);
        color: #eab308;
    }

    .icon-green {
        background: rgba(34, 197, 94, 0.15);
        color: #22c55e;
    }

    .section-card {
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(12px);
        border-radius: var(--border-radius);
        padding: 35px;
        box-shadow: var(--shadow-soft);
        border: 1px solid rgba(255, 255, 255, 0.6);
        margin-bottom: 40px;
        transition: all 0.3s ease;
    }

    .section-card:hover {
        box-shadow: 0 15px 40px rgba(138, 79, 255, 0.15);
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .section-title {
        font-size: 1.8rem;
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
        transition: all 0.3s ease;
    }

    .view-all:hover {
        background: rgba(138, 79, 255, 0.2);
        transform: translateY(-3px);
    }

    .seminars-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 15px;
    }

    .seminar-card {
        background: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        border-left: 4px solid var(--deep-lilac);
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
        font-size: 1.4rem;
        font-weight: 700;
        color: #3a2e6d;
        max-width: 80%;
    }

    .status-badge {
        padding: 6px 15px;
        border-radius: 50px;
        font-size: 0.85rem;
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

    .card-details {
        margin-bottom: 15px;
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

    .btn-pdf {
        background: rgba(34, 197, 94, 0.1);
        color: #22c55e;
    }

    .btn-pdf:hover {
        background: rgba(34, 197, 94, 0.2);
        transform: translateY(-2px);
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
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--deep-lilac);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
    }

    .presenter-name {
        font-weight: 600;
        color: #3a2e6d;
    }

    .presenter-department {
        font-size: 0.9rem;
        color: #7a7a9a;
    }

    .table-actions {
        display: flex;
        gap: 15px;
    }

    .table-action {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 8px 15px;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .table-download {
        background: rgba(138, 79, 255, 0.1);
        color: var(--deep-lilac);
    }

    .table-download:hover {
        background: rgba(138, 79, 255, 0.2);
    }

    .table-recap {
        background: rgba(34, 197, 94, 0.1);
        color: #22c55e;
    }

    .table-recap:hover {
        background: rgba(34, 197, 94, 0.2);
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        background: rgba(255, 255, 255, 0.6);
        border-radius: 16px;
    }

    .empty-state i {
        font-size: 4rem;
        color: #d8c0ff;
        margin-bottom: 20px;
        opacity: 0.7;
    }

    .empty-state p {
        color: #7a7a9a;
        font-size: 1.15rem;
        max-width: 500px;
        margin: 0 auto;
    }

    .decoration {
        position: fixed;
        z-index: -1;
        border-radius: 50%;
        opacity: 0.5;
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
        top: 50%;
        left: 5%;
        width: 60px;
        height: 60px;
        background: var(--misty-rose);
    }

    {{-- Modals --}}
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .modal-content {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(15px);
        border-radius: var(--border-radius);
        padding: 35px;
        width: 90%;
        max-width: 600px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        transform: translateY(20px);
        transition: all 0.4s ease;
    }

    .modal-overlay.active .modal-content {
        transform: translateY(0);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .modal-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #3a2e6d;
    }

    .close-modal {
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #8c8ca7;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .close-modal:hover {
        color: #ff5a78;
        transform: rotate(90deg);
    }

    .modal-body {
        font-size: 1.05rem;
        line-height: 1.8;
        color: #5a5a7a;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        margin-top: 30px;
    }

    .btn-close {
        padding: 12px 25px;
        background: rgba(138, 79, 255, 0.1);
        color: var(--deep-lilac);
        border-radius: 14px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-close:hover {
        background: rgba(138, 79, 255, 0.2);
        transform: translateY(-2px);
    }
    
</style>

<script>
    // Gestion des modaux
    document.querySelectorAll('[data-modal]').forEach(button => {
        button.addEventListener('click', () => {
            const modalId = button.getAttribute('data-modal');
            document.getElementById(modalId).classList.add('active');
        });
    });

    document.querySelectorAll('.close-modal, .btn-close').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.modal-overlay').forEach(modal => {
                modal.classList.remove('active');
            });
        });
    });

    document.querySelectorAll('.modal-overlay').forEach(modal => {
        modal.addEventListener('click', e => {
            if (e.target === modal) {
                modal.classList.remove('active');
            }
        });
    });

    // Animation au survol des cartes
    document.querySelectorAll('.seminar-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
            this.style.boxShadow = '0 15px 35px rgba(138, 79, 255, 0.15)';
        });
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 5px 20px rgba(0, 0, 0, 0.05)';
        });
    });

    // Animation des lignes du tableau
    document.querySelectorAll('.recent-table tbody tr').forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.02)';
        });
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
</script>

@endsection