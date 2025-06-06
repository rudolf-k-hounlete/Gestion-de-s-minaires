<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Seminar;
use Carbon\Carbon;

class MarkExpiredSeminars extends Command
{
    protected $signature = 'seminars:mark-expired';
    protected $description = 'Marque comme "expired" les séminaires si : 
1) date préférée passée (pending),
2) pas de résumé 10 jours avant (accepted & summary null),
3) pas publiés 7 jours avant (accepted).';

    public function handle()
    {
        $today = Carbon::today();

        // 1. Séminaires en 'pending' dont la preferred_date est antérieure à aujourd’hui
        $expiredPending = Seminar::where('status', 'pending')
            ->whereNotNull('preferred_date')
            ->whereDate('preferred_date', '<', $today)
            ->get();

        foreach ($expiredPending as $seminar) {
            $seminar->status = 'expired';
            $seminar->save();
            $this->info("Séminaire ID {$seminar->id} expiré (date préférée dépassée).");
        }

        // 2. Séminaires en 'accepted' sans résumé 10 jours avant la date programmée
        $tenDaysFromNow = $today->copy()->addDays(10);
        $expiredNoSummary = Seminar::where('status', 'accepted')
            ->whereNotNull('scheduled_date')
            ->whereNull('summary')                 // pas de résumé soumis
            ->whereDate('scheduled_date', '<', $tenDaysFromNow)
            ->get();

        foreach ($expiredNoSummary as $seminar) {
            $seminar->status = 'expired';
            $seminar->save();
            $this->info("Séminaire ID {$seminar->id} expiré (pas de résumé à J-10).");
        }

        // 3. Séminaires en 'accepted' pas publiés 7 jours avant la date programmée
        $sevenDaysFromNow = $today->copy()->addDays(7);
        $expiredNoPublish = Seminar::where('status', 'accepted')
            ->whereNotNull('scheduled_date')
            ->whereDate('scheduled_date', '<', $sevenDaysFromNow)
            ->get();

        foreach ($expiredNoPublish as $seminar) {
            // Si la même session apparaissait dans $expiredNoSummary, elle est déjà marquée ; on ignore
            if ($seminar->status === 'expired') {
                continue;
            }
            $seminar->status = 'expired';
            $seminar->save();
            $this->info("Séminaire ID {$seminar->id} expiré (accepté non publié J-7).");
        }

        if ($expiredPending->isEmpty() && $expiredNoSummary->isEmpty() && $expiredNoPublish->isEmpty()) {
            $this->info('Aucun séminaire à marquer comme expiré.');
        } else {
            $this->info('Mise à jour des séminaires expirés terminée.');
        }
    }
}
