{{-- resources/views/seminars/secretary/index.blade.php --}}
@extends('layouts.app')
@section('content')

<div class="container mx-auto px-4 py-10">
    <div class="header mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Demandes de séminaires en attente</h1>
        <p class="text-gray-600 mt-2">Consultez et gérez les demandes soumises par les présentateurs.</p>
    </div>

    {{-- Messages flash --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-md shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($seminars->isEmpty())
        <div class="empty-state">
            <i class="fas fa-inbox text-5xl text-gray-300 mb-4"></i>
            <h2 class="text-xl font-semibold text-gray-700 mb-2">Aucune demande en attente</h2>
            <p class="text-gray-500">Il n’y a aucune demande à traiter pour le moment.</p>
        </div>
    @else
        <div class="seminars-grid">
            @foreach($seminars as $seminar)
                <div class="seminar-card" data-theme="{{ strtolower($seminar->theme) }}">
                    <div class="card-header">
                        <h3 class="card-title">{{ $seminar->theme }}</h3>
                        <span class="status-badge status-pending">
                            En attente
                        </span>
                    </div>
                        <div class="card-details">
                            <div class="detail-item">
                                <i class="fas fa-user-tie"></i>
                                <span>Dr. {{ $seminar->presenter->name }}</span>
                            </div>

                            <div class="detail-item">
                                <i class="fas fa-calendar-plus"></i>
                                <span>Soumis le {{ $seminar->created_at->format('d/m/Y') }}</span>
                            </div>

                            {{-- Nouveau : Date préférée --}}
                            <div class="detail-item">
                                <i class="fas fa-calendar-day text-deep-lilac"></i>
                                <span>Date préférée : <strong>{{ \Carbon\Carbon::parse($seminar->preferred_date)->format('d/m/Y') }}</strong></span>
                            </div>
                        </div>
                    <div class="card-actions">
                        <button data-open-modal="modal-accept-{{ $seminar->id }}"
                                class="action-btn btn-accept">
                            <i class="fas fa-check-circle"></i> Accepter
                        </button>
                        <button data-open-modal="modal-reject-{{ $seminar->id }}"
                                class="action-btn btn-reject">
                            <i class="fas fa-times-circle"></i> Refuser
                        </button>
                    </div>
                </div>

                {{-- Modal d'acceptation --}}
<div id="modal-accept-{{ $seminar->id }}" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Accepter la demande</h3>
            <button class="close-modal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <p>Souhaitez-vous accepter cette demande ?</p>
            <form method="POST" action="{{ route('seminars.secretary.accept', $seminar->id) }}">
                @csrf
                <div class="mt-6 mb-4">
                    <label for="scheduled_date_{{ $seminar->id }}" class="block text-sm font-medium text-gray-700 mb-2">Date programmée</label>
                    <input type="date"
                           name="scheduled_date"
                           id="scheduled_date_{{ $seminar->id }}"
                           required
                           value="{{ old('scheduled_date', $seminar->preferred_date ?? '') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    @error('scheduled_date')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel">
                        Annuler
                    </button>
                    <button type="submit"
                            class="btn-confirm">
                        Confirmer l'acceptation
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

                {{-- Modal de refus --}}
                <div id="modal-reject-{{ $seminar->id }}" class="modal-overlay">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Refuser la demande</h3>
                            <button class="close-modal">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="mb-6">Êtes-vous sûr(e) de vouloir refuser cette demande de séminaire ?</p>
                            <form method="POST" action="{{ route('seminars.secretary.reject', $seminar->id) }}">
                                @csrf
                                <div class="modal-footer">
                                    <button type="button" class="btn-cancel">
                                        Annuler
                                    </button>
                                    <button type="submit"
                                            class="btn-reject-confirm">
                                        Confirmer le refus
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

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
    }

        .text-deep-lilac {
        color: #8a4fff;
    }

    .detail-item i {
        width: 20px;
        text-align: center;
        color: #8c8ca7;
    }


    .container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .header h1 {
        position: relative;
        padding-bottom: 15px;
    }

    .header h1::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 80px;
        height: 4px;
        background: var(--deep-lilac);
        border-radius: 2px;
    }

    .seminars-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 25px;
    }

    .seminar-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(12px);
        border-radius: var(--border-radius);
        padding: 25px;
        box-shadow: var(--shadow-soft);
        border-left: 4px solid var(--deep-lilac);
        transition: all 0.3s ease;
    }

    .seminar-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(138, 79, 255, 0.15);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
    }

    .card-title {
        font-size: 1.3rem;
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
        border: none;
        cursor: pointer;
    }

    .btn-accept {
        background: rgba(34, 197, 94, 0.1);
        color: #22c55e;
    }

    .btn-accept:hover {
        background: rgba(34, 197, 94, 0.2);
        transform: translateY(-2px);
    }

    .btn-reject {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    .btn-reject:hover {
        background: rgba(239, 68, 68, 0.2);
        transform: translateY(-2px);
    }

    .empty-state {
        text-align: center;
        padding: 60px 40px;
        background: rgba(255, 255, 255, 0.95);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-soft);
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
        max-width: 500px;
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
        font-size: 1.5rem;
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

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        margin-top: 30px;
        gap: 15px;
    }

    .btn-cancel, .btn-confirm, .btn-reject-confirm {
        padding: 12px 25px;
        border-radius: 14px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-cancel {
        background: rgba(156, 163, 175, 0.1);
        color: #4b5563;
    }

    .btn-cancel:hover {
        background: rgba(156, 163, 175, 0.2);
        transform: translateY(-2px);
    }

    .btn-confirm {
        background: rgba(34, 197, 94, 0.1);
        color: #22c55e;
    }

    .btn-confirm:hover {
        background: rgba(34, 197, 94, 0.2);
        transform: translateY(-2px);
    }

    .btn-reject-confirm {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    .btn-reject-confirm:hover {
        background: rgba(239, 68, 68, 0.2);
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
</style>


<!-- Decorations -->
<div class="decoration dec-1"></div>
<div class="decoration dec-2"></div>
<div class="decoration dec-3"></div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Calculer la date min (aujourd'hui + 12 jours)
        const today = new Date();
        const minDate = new Date(today);
        minDate.setDate(today.getDate() + 12);
        
        // Formater en YYYY-MM-DD
        const year = minDate.getFullYear();
        const month = String(minDate.getMonth() + 1).padStart(2, '0');
        const day = String(minDate.getDate()).padStart(2, '0');
        const minDateString = `${year}-${month}-${day}`;
        
        // Appliquer la restriction à TOUS les champs de date programmée
        document.querySelectorAll('input[type="date"][name="scheduled_date"]').forEach(dateInput => {
            dateInput.min = minDateString;
            
            // Corriger la valeur si nécessaire
            if (dateInput.value && dateInput.value < minDateString) {
                dateInput.value = minDateString;
            } else if (!dateInput.value) {
                dateInput.value = minDateString;
            }
        });

        // Gestion des modaux
        document.querySelectorAll('[data-open-modal]').forEach(button => {
            button.addEventListener('click', () => {
                const modalId = button.getAttribute('data-open-modal');
                document.getElementById(modalId).classList.add('active');
            });
        });

        document.querySelectorAll('.close-modal, .btn-cancel').forEach(btn => {
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
                this.style.boxShadow = 'var(--shadow-soft)';
            });
        });
    });
</script>
@endpush
@endsection