{{-- resources/views/seminars/student/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Séminaires publiés</h1>

    @if($seminars->isEmpty())
        <p class="text-gray-600">Aucun séminaire publié disponible.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($seminars as $seminar)
                <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $seminar->theme }}</h3>
                        <span class="text-gray-500 text-sm flex items-center">
                            <i class="fas fa-calendar-day mr-1"></i>
                            {{ $seminar->scheduled_date->format('d F Y') }}
                        </span>
                    </div>
                    <p class="text-gray-600 text-sm mb-3">
                        Présentateur : {{ $seminar->presenter->name }}
                    </p>
                    <div class="flex justify-end space-x-4">
                        @if($seminar->presentation_path)
                            <a href="{{ route('seminars.student.download', $seminar->id) }}"
                               class="text-green-600 hover:text-green-800 text-sm font-medium flex items-center">
                                <i class="fas fa-download mr-1"></i> Télécharger la présentation
                            </a>
                        @endif
                        <button onclick="alert('… Afficher plus de détails plus tard …')"
                                class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
                            <i class="fas fa-info-circle mr-1"></i> Détails
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
