<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seminar;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Affiche le tableau de bord avec les statistiques et les dernières activités.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Récupère la date d'aujourd'hui pour les comparaisons
        $today = Carbon::today()->toDateString();

        // Séminaires programmés : status accepted ou published + date >= aujourd’hui
        $countScheduled = Seminar::whereIn('status', ['accepted', 'published'])
            ->whereDate('scheduled_date', '>=', $today)
            ->count();

        // Séminaires en attente : status = pending
        $countPending = Seminar::where('status', 'pending')->count();

        // Présentations disponibles : fichier uploadé
        $countAvailablePresentations = Seminar::whereNotNull('presentation_path')->count();

        // Prochains séminaires (3 premiers) : triés par date
        $upcomingSeminars = Seminar::with('presenter')
            ->whereIn('status', ['published'])
            ->whereDate('scheduled_date', '>=', $today)
            ->orderBy('scheduled_date', 'asc')
            ->take(4)
            ->get();

        $publishedCount = Seminar::where('status', 'published')->count();
        $completedCount = Seminar::where('status', 'completed')->count();
        


        // Dernières présentations téléchargées (3 dernières)
        $recentPresentations = Seminar::with('presenter')
            ->where('status', 'completed')
            ->orderBy('scheduled_date', 'desc')
            ->take(4)
            ->get();

        return view('dashboard', compact(
            'countScheduled',
            'countPending',
            'countAvailablePresentations',
            'upcomingSeminars',
            'recentPresentations',
            'publishedCount',
            'completedCount'
        ));
    }
}