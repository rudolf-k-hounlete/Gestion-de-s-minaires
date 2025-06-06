<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Enregistre les commandes personnalisées
     */
    protected $commands = [
        \App\Console\Commands\MarkExpiredSeminars::class,
    ];

    /**
     * Planifie les tâches automatisées
     */
    protected function schedule(Schedule $schedule)
    {
        // Exécuter chaque jour à 01:00 (heure serveur) la commande de notification
        $schedule->command('seminars:process-notifications')
                 ->dailyAt('00:00')
                 ->withoutOverlapping();

        // Exécuter chaque jour la commande de marquage des séminaires expirés
        $schedule->command('seminars:mark-expired')
                 ->dailyAt('00:00')
                 ->withoutOverlapping();
        
        // Exécuter chaque jour la commande de marquage des séminaires complétés
        $schedule->command('seminars:mark-completed')
                 ->dailyAt('23:59')
                 ->withoutOverlapping();
    }

    // ...
}
