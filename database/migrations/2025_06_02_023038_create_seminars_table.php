<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeminarsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seminars', function (Blueprint $table) {
            $table->id();

            // Lien vers l’utilisateur présentateur
            $table->foreignId('presenter_id')->constrained('users')->onDelete('cascade');

            // Thème / titre du séminaire
            $table->string('theme');

            // Statut : pending (en attente), accepted (accepté), published (publié), completed (terminé)
            $table->enum('status', ['pending', 'accepted', 'published', 'completed', 'expired'])->default('pending');

            // Date souhaitée / validée (fixée par la secrétaire)
            $table->date('scheduled_date')->nullable();

            // Lien vers le fichier résumé (10 jours avant)
            $table->string('summary_path')->nullable();
            $table->timestamp('summary_uploaded_at')->nullable();

            // Date de publication (chaque semaine avant) – fixe la visibilité aux étudiants
            $table->timestamp('published_at')->nullable();

            // Lien vers le fichier final de la présentation (une fois terminé)
            $table->string('presentation_path')->nullable();
            $table->timestamp('presentation_uploaded_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seminars');
    }
}
