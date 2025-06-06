<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Seminar;
use Carbon\Carbon;

class MarkCompletedSeminars extends Command
{
    protected $signature = 'seminars:mark-completed';
    protected $description = 'Marque les séminaires comme "completed" une fois qu’ils ont eu lieu et que la présentation est disponible';
    protected $commands = [
    \App\Console\Commands\MarkExpiredSeminars::class,
    \App\Console\Commands\ProcessSeminarNotifications::class,
    \App\Console\Commands\MarkCompletedSeminars::class,
];
    public function handle()
    {
        $today = Carbon::today();

        // Séminaires publiés dont la date programmée est antérieure à aujourd’hui
        // et dont le fichier de présentation a été uploadé (presentation_path non nul)
        $toComplete = Seminar::where('status', 'published')
            ->whereNotNull('scheduled_date')
            ->whereDate('scheduled_date', '<', $today)
            ->whereNotNull('presentation_path')
            ->get();

        foreach ($toComplete as $seminar) {
            $seminar->status = 'completed';
            $seminar->save();
            $this->info("Séminaire ID {$seminar->id} marqué comme completed.");
        }

        if ($toComplete->isEmpty()) {
            $this->info('Aucun séminaire à marquer comme completed.');
        } else {
            $this->info('Mise à jour des séminaires completed terminée.');
        }
    }
}
