<?php

namespace App\Http\Controllers;

use App\Models\Seminar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Mail\SeminarNotification;
use App\Mail\SeminarPublished;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use PDF;

class SeminarController extends Controller
{


     public function accept(Request $request, Seminar $seminar)
    {
        // Valider la date programmée
        $request->validate([
            'scheduled_date' => ['required', 'date', 'after:today'],
        ]);

        // Mettre à jour le séminaire
        $seminar->status = 'accepted';
        $seminar->scheduled_date = $request->input('scheduled_date');
        $seminar->save();

        return redirect()->route('seminars.secretary.index')
                         ->with('success', 'La demande a été acceptée.');
    }

    public function reject(Seminar $seminar)
    {
        // Mettre à jour le statut en “refused” (ou “rejected” selon ta convention)
        $seminar->status = 'rejected';
        $seminar->save();

        return redirect()->route('seminars.secretary.index')
                         ->with('success', 'La demande a été refusée.');
    }

    public function showToPublish()
    {
        $today   = Carbon::today();
        $threshold = $today->copy()->addDays(7);
        $seminars = Seminar::where('status', 'accepted')
            ->whereDate('scheduled_date', '<=', $threshold)
            ->with('presenter')
            ->orderBy('scheduled_date', 'asc')
            ->get();

        return view('seminars.secretary.publish_list', compact('seminars'));
    }

    public function showUploadPresentation($id)
    {
        $seminar = Seminar::findOrFail($id);

        // Autoriser uniquement le présentateur une fois que la date passée ou le secrétaire s’il souhaite uploader
        if (! (Auth::id() === $seminar->presenter_id && $seminar->status === 'published' && Carbon::today()->gte($seminar->scheduled_date))
              && Auth::user()->role !== 'secretary') {
            abort(403);
        }

        return view('seminars.upload_presentation', compact('seminar'));
    }

    public function uploadPresentation(Request $request, $id)
    {
        $seminar = Seminar::findOrFail($id);

        if (! (Auth::id() === $seminar->presenter_id && $seminar->status === 'published' && Carbon::today()->gte($seminar->scheduled_date))
              && Auth::user()->role !== 'secretary') {
            abort(403);
        }

        $request->validate([
            'presentation' => 'required|mimes:pdf,ppt,pptx|max:5120',
        ]);

        $path = $request->file('presentation')->store('public/presentations');
        $seminar->presentation_path = str_replace('public/', 'storage/', $path);
        $seminar->presentation_uploaded_at = now();
        // Marquer comme 'completed'
        $seminar->status = 'completed';
        $seminar->save();

        return redirect()->route('dashboard')->with('success', 'Fichier de la présentation téléchargé et séminaire marqué comme terminé.');
    }

    public function upcoming()
    {
        $today = Carbon::today();
        // On récupère tous les séminaires dont la date programmée est aujourd'hui ou dans le futur,
        // et dont le statut est "accepted" ou "published" (au choix).
        $seminars = Seminar::where('status', 'published')
            ->whereDate('scheduled_date', '>=', $today)
            ->orderBy('scheduled_date', 'asc')
            ->get();

        return view('seminars.upcoming', compact('seminars'));
    }

    public function recent()
    {
        // On récupère tous les séminaires qui ont un fichier de présentation uploadé (status completed)
        // Triés par date d'upload décroissante.
        $presentations = Seminar::where('status', 'completed')
            ->orderBy('scheduled_date', 'desc')
            ->get();

        return view('seminars.recent', compact('presentations'));
    }

    public function presenterIndex()
    {
        // 1. Vérification du rôle en dur (pas de middleware)
        if (Auth::user()->role !== 'presenter') {
            abort(403); // Renvoie une 403 Forbidden si ce n’est pas “presenter”
        }

        // 2. Si on est bien “presenter”, on récupère les séminaires correspondants
        $userId = Auth::id();
        $seminars = Seminar::where('presenter_id', $userId)
                           ->orderBy('created_at', 'desc')
                           ->get();

        return view('seminars.presenter.index', compact('seminars'));
    }

     public function presenterCreate()
    {
        if (Auth::user()->role !== 'presenter') {
            abort(403);
        }
        return view('seminars.presenter.create');
    }

   public function presenterStore(Request $request)
    {
        if (Auth::user()->role !== 'presenter') {
            abort(403);
        }

        $data = $request->validate([
            'theme'          => 'required|string|max:255',
            'preferred_date' => 'required|date|after_or_equal:today',
            'summary'        => 'nullable|string|max:1000',
        ]);

        Seminar::create([
            'theme'             => $data['theme'],
            'presenter_id'      => Auth::id(),
            'status'            => 'pending',
            'preferred_date'    => $data['preferred_date'],
            'summary'           => $data['summary'] ?? null,
            'scheduled_date'    => null,
            'presentation_path' => null,
        ]);

        return redirect()->route('seminars.presenter.index')
                         ->with('success', 'Votre demande a bien été enregistrée.');
    }

    /**
     * (Exemple) Affiche la page d’upload de résumé.
     */
    public function showUploadSummary($id)
    {
        if (Auth::user()->role !== 'presenter') {
            abort(403);
        }

        // … logique d’affichage …
        return view('seminars.presenter.upload_summary', compact('id'));
    }

    public function uploadSummary(Request $request, $id)
    {
        if (Auth::user()->role !== 'presenter') {
            abort(403);
        }
        // … traitement du fichier …
    }

    // app/Http/Controllers/SeminarController.php
    public function showSummary(Seminar $seminar)
    {
        return view('seminars.secretary.showSummary', compact('seminar'));
    }


    // -------------------------------
    // MÉTHODES POUR LE SECRÉTAIRE
    // -------------------------------

    /**
     * Liste des demandes en attente (status = pending).
     */
    public function secretaryIndex()
    {
        if (Auth::user()->role !== 'secretary') {
            abort(403);
        }

        $seminars = Seminar::where('status', 'pending')
                        ->orderBy('created_at', 'asc')
                        ->paginate(10); // par exemple 10 demandes par page


        return view('seminars.secretary.index', compact('seminars'));
    }

    public function publishList()
    {
        // Récupère tous les séminaires dont le statut n'est ni 'pending' ni 'published'
        $seminars = Seminar::whereNotIn('status', ['pending', 'published', 'rejected', 'expired', 'completed'])
                        ->orderBy('scheduled_date', 'asc')
                        ->get();

        return view('seminars.secretary.publish_list', compact('seminars'));
    }


    public function studentIndex()
    {
        if (Auth::user()->role !== 'student') {
            abort(403);
        }

        $seminars = Seminar::whereIn('status', ['published', 'completed'])
                        ->orderBy('scheduled_date', 'asc')
                        ->get();

        return view('seminars.student.index', compact('seminars'));
    }

    public function downloadPresentation(Seminar $seminar)
    {
        if (! $seminar->presentation_path) {
            abort(404, 'Aucune présentation disponible pour ce séminaire.');
        }

        $path = $seminar->presentation_path;

        if (! Storage::exists($path)) {
            abort(404, 'Le fichier de présentation est introuvable.');
        }

        return Storage::download($path, 'presentation-' . $seminar->id . '.pdf');
    }

    public function downloadRecap(Seminar $seminar)
    {
        // Préparation des données pour la vue PDF
        $data = [
            'theme'          => $seminar->theme,
            'presenter'      => $seminar->presenter->name,
            'scheduled_date' => $seminar->scheduled_date
                                  ? $seminar->scheduled_date->format('d/m/Y')
                                  : 'À définir',
            'summary'        => $seminar->summary ?? 'Aucun résumé disponible.',
        ];

        // Générer le PDF via la vue Blade dédiée (resources/views/seminars/pdf/recap.blade.php)
        $pdf = PDF::loadView('seminars.pdf.recap', $data);

        // Nom du fichier à télécharger
        $filename = 'recap-seminar-' . $seminar->id . '.pdf';

        return $pdf->download($filename);
    }

    public function showUploadResumeForm(Seminar $seminar)
    {
        // Vérifier que l’utilisateur est bien le présentateur
        if (Auth::id() !== $seminar->presenter_id) {
            abort(403);
        }

        return view('seminars.presenter.upload-resume', compact('seminar'));
    }

    public function submitResume(Request $request, Seminar $seminar)
    {
        if (Auth::id() !== $seminar->presenter_id) {
            abort(403);
        }

        $data = $request->validate([
            'resume' => 'required|string|min:20',
        ]);

        // Met à jour le résumé et le statut
        $seminar->resume = $data['resume'];
        $seminar->status = 'resume_sent';
        $seminar->save();

        return redirect()->route('dashboard')
                         ->with('success', 'Votre résumé a bien été soumis. Le secrétaire en sera informé automatiquement.');
    }

    public function publish(Seminar $seminar)
    {
        // Vérifier que l’utilisateur a le rôle 'secretary'
        if (!Auth::user()->hasRole('secretary')) {
            abort(403);
        }

        // Vérifier qu’il s’agit bien d’un séminaire en statut 'ready_to_publish'
        if ($seminar->status !== 'ready_to_publish') {
            return redirect()->back()->with('error', 'Ce séminaire n’est pas prêt à être publié.');
        }

        return view('seminars.secretary.publish', compact('seminar'));
    }

    public function doPublish(Request $request, Seminar $seminar)
    {
        if (Auth::user()->role !== 'secretary') {
            abort(403);
        }
        if ($seminar->status !== 'accepted') {
            return redirect()->back()->with('error', 'Ce séminaire n’est pas prêt à être publié.');
        }

        // Mettre à jour le statut et la date de publication
        $seminar->status       = 'published';
        $seminar->published_at = now();
        $seminar->save();

        // Notifier tous les étudiants (on suppose qu’on a un scope ou un rôle 'student')
        $students = User::where('role', 'student')->get();
        foreach ($students as $student) {
            $student->notify(new \App\Notifications\StudentsSeminarPublishedNotification($seminar));
        }

        return redirect()->route('dashboard')
                         ->with('success', 'Le séminaire a été publié avec succès et les étudiants ont été avertis.');
    }

    public function expired()
{
    $today = Carbon::today();

    $seminars = Seminar::where('status', 'expired')
        ->orderBy('scheduled_date', 'desc')
        ->with('presenter') // si vous avez une relation définie
        ->get();

    return view('seminars.secretary.expired', compact('seminars'));
}
    /**
     * Affiche la liste des séminaires pour lesquels le résumé n'est pas encore soumis
     * et le séminaire n'est pas expiré.
     */
    public function showSubmitSummaryList()
    {
        $today = Carbon::today()->toDateString();

        $seminars = Seminar::where('presenter_id', Auth::id())
            ->whereNull('summary')          // résumé pas encore soumis
            ->where('status', 'accepted')   // validé par la secrétaire
            ->where('status', '!=', 'expired') // pas expiré
            ->orderBy('scheduled_date', 'asc')
            ->get();

        return view('seminars.presenter.submit_summary', compact('seminars', 'today'));
    }

    /**
     * Traite l’upload du résumé pour un séminaire donné.
     */
    public function submitSummary(Request $request, Seminar $seminar)
    {
        // Vérifie que l’utilisateur est bien le présentateur de ce séminaire
        if ($seminar->presenter_id !== Auth::id()) {
            abort(403);
        }

        // Vérifie que le séminaire est toujours dans l’état "accepted" et pas expiré
        if ($seminar->status !== 'accepted' || $seminar->status === 'expired') {
            return redirect()
                ->back()
                ->with('error', 'Vous ne pouvez pas soumettre un résumé pour ce séminaire.');
        }

        // Vérifie que l’on est bien J-10 avant la date programmée
        $today = Carbon::today();
        $allowedDate = Carbon::parse($seminar->scheduled_date)->subDays(10)->toDateString();
        if ($today->toDateString() !== $allowedDate) {
            return redirect()
                ->back()
                ->with('error', "Vous ne pouvez soumettre le résumé que le $allowedDate.");
        }

        // Validation du contenu du résumé (texte)
        $data = $request->validate([
            'summary' => 'required|string|min:20',
        ]);

        // Enregistrement du résumé dans la base (champ 'summary')
        $seminar->summary = $data['summary'];
        $seminar->save();

        return redirect()
            ->route('seminars.presenter.submitSummaryList')
            ->with('success', 'Votre résumé a bien été soumis.');
    }

}
