<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddAdminToRoleEnumInUsersTable extends Migration
{
    public function up(): void
    {
        // On modifie l'énum pour y inclure 'admin' (en conservant l'ordre souhaité)
        DB::statement("
            ALTER TABLE users 
            MODIFY COLUMN role 
            ENUM('admin','secretary','presenter','student') 
            NOT NULL 
            DEFAULT 'student'
        ");
    }

    public function down(): void
    {
        // On retire 'admin' si on roll back
        DB::statement("
            ALTER TABLE users 
            MODIFY COLUMN role 
            ENUM('secretary','presenter','student') 
            NOT NULL 
            DEFAULT 'student'
        ");
    }
}
