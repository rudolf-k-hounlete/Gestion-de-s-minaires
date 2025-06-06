<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSummaryAndPreferredDateToSeminarsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('seminars', function (Blueprint $table) {
            // Ajouter la colonne 'summary' (texte, nullable)
            $table->text('summary')->nullable()->after('status');
            // Ajouter la colonne 'preferred_date' (date, nullable)
            $table->date('preferred_date')->nullable()->after('summary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('seminars', function (Blueprint $table) {
            $table->dropColumn('summary');
            $table->dropColumn('preferred_date');
        });
    }
}
