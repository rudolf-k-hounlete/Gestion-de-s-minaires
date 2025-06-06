<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddRejectedToStatusEnumInSeminarsTable extends Migration
{
    public function up(): void
    {
        // On modifie l'ENUM existant pour y inclure "rejected"
        DB::statement("
            ALTER TABLE seminars
            MODIFY COLUMN status 
            ENUM('pending', 'accepted', 'rejected', 'published', 'expired', 'completed')
            NOT NULL 
            DEFAULT 'pending'
        ");
    }

    public function down(): void
    {
        // Revenir à l'énum sans "rejected" si l'on annule
        DB::statement("
            ALTER TABLE seminars
            MODIFY COLUMN status 
            ENUM('pending', 'accepted', 'published', 'expired', 'completed')
            NOT NULL 
            DEFAULT 'pending'
        ");
    }
}
