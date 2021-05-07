<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToCaissesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('caisses', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();
            $table->float('montant');
            $table->string('banque');
            $table->boolean('etat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('caisses', function (Blueprint $table) {
            Schema::dropIfExists('caisses');
        });
    }
}
