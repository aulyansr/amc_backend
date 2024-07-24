<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateTechniciansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technicians', function (Blueprint $table) {
            $table->id();
			$table->foreignId('technician_level_id')
                ->constrained('technician_levels')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
			$table->string('nik', 30);
			$table->string('fullname', 255);
			$table->string('nickname', 255)->nullable();
			$table->string('no_hp', 30);
			$table->string('gender', 30);
			$table->date('birthdate')->nullable();
			$table->string('avatar')->nullable();
			$table->tinyInteger('is_active')->default(1);
			$table->date('join_date');
			$table->date('leave_date')->nullable();
			$table->string('email');
			$table->string('password');
			$table->text('leave_reason')->nullable();
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
        Schema::dropIfExists('technicians');
    }
}
