<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('user_type_id')->constrained()->after('id');
            $table->integer('document')->unique()->after('user_type_id');
            $table->renameColumn('name', 'first_name');
            $table->text('last_name');
            $table->date('birthdate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['document', 'last_name', 'birthdate']);
            $table->renameColumn('first_name', 'name');
        });
    }
};
