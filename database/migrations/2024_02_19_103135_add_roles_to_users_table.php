<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class AddRolesToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->after('email')->nullable()->default(false);
            $table->boolean('is_revisor')->after('is_admin')->nullable()->default(false);
            $table->boolean('is_writer')->after('is_revisor')->nullable()->default(false);
        });

        // Creazione dell'utente amministratore
        User::create([
            'name' => 'Admin',
            'email' => 'admin@theaulabpost.it',
            'password' => bcrypt('12345678'),
            'is_admin' => true,
        ]);
    }

    public function down()
    {
        User::where('email', 'admin@theaulabpost.it')->delete();
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_admin', 'is_revisor', 'is_writer');
        });

    }
}
