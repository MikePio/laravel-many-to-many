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
        Schema::table('projects', function (Blueprint $table) {
          //* necessario per creare il campo user_id nella tabella projects per creare un collegamento one-to-many con gli user
          $table->unsignedBigInteger('user_id')->nullable()->after('id');

          $table->foreign('user_id')
              ->references('id')
              ->on('users')
              ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {

          $table->dropForeign(['user_id']);
          $table->dropColumn('user_id');

        });
    }
};
