<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Seminar;
use App\Notifications\RequestResumeNotification;
use App\Notifications\NotifySecretaryToPublishNotification;
use App\Notifications\StudentsSeminarPublishedNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use Carbon\Carbon;

class ProcessSeminarNotifications extends Command
{
    protected $signature   = 'seminars:process-notifications';
    protected $description = 'Envoie automatiquement :
    - J-10 : rappel résumé aux présentateurs pour les séminaires accepted sans résumé,
    - J-7 : rappel publication aux secrétaires pour les séminaires accepted avec résumé,
    - Aujourd’hui : notification aux étudiants pour les séminaires passés en published';

    public function handle()
    {
        $this->info('[Start] Traitement des notifications de séminaires');

        $today = Carbon::today();

        // 1. J-10 : séminaires accepted sans résumé (summary_path est null)
        $tenDaysFromNow = $today->copy()->addDays(10)->toDateString();
        $seminarsForResume = Seminar::where('status', 'accepted')
            ->whereNull('summary')
            ->whereDate('scheduled_date', $tenDaysFromNow)
            ->get();

        foreach ($seminarsForResume as $seminar) {
            $seminar->presenter->notify(new RequestResumeNotification($seminar));
            $this->info("→ J-10 : rappel résumé envoyé à {$seminar->presenter->email} pour le séminaire #{$seminar->id}");
        }

        // 2. J-7 : séminaires accepted avec résumé (summary_path non null)
        $sevenDaysFromNow = $today->copy()->addDays(7)->toDateString();
        $seminarsForPublish = Seminar::where('status', 'accepted')
            ->whereNotNull('summary')
            ->whereDate('scheduled_date', $sevenDaysFromNow)
            ->get();

        foreach ($seminarsForPublish as $seminar) {
            // Récupérer tous les secrétaires (role = 'secretary')
            $secretaries = User::where('role', 'secretary')->get();
            Notification::send($secretaries, new NotifySecretaryToPublishNotification($seminar));
            $this->info("→ J-7 : rappel publication envoyé aux secrétaires pour le séminaire #{$seminar->id}");
        }

        // 3. Aujourd’hui : séminaires passés en published → notification étudiants
        $seminarsPublishedToday = Seminar::where('status', 'published')
            ->whereDate('published_at', $today->toDateString())
            ->get();

        foreach ($seminarsPublishedToday as $seminar) {
            // Récupérer tous les étudiants (role = 'student')
            $students = User::where('role', 'student')->get();

            foreach ($students as $student) {
                $student->notify(new StudentsSeminarPublishedNotification($seminar));
            }

            $this->info("→ Notification étudiants envoyée pour le séminaire #{$seminar->id}");
        }

        $this->info('[End] Traitement terminé.');
        return 0;
    }
}
