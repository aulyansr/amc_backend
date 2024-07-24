<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
			$table->foreignId('branch_id')
                ->constrained('branches')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
            $table->foreignId('shift_id')
                ->constrained('shifts')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
            $table->string('nama');
			$table->integer('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams');
    }
}
