<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable();
            $table->foreignId('branch_id')->nullable()->constrained('branches')
            ->onUpdate('NO ACTION')
            ->onDelete('NO ACTION');
			$table->foreignId('master_address_id')->constrained('master_addresses')
            ->onUpdate('NO ACTION')
            ->onDelete('NO ACTION');
			$table->foreignId('master_customer_id')->constrained('master_customers')
            ->onUpdate('NO ACTION')
            ->onDelete('NO ACTION');
            $table->foreignId('subscription_id')->nullable();
            $table->string('order_code')->nullable();
			$table->string('ref_no',255)->nullable();
			$table->datetime('booked_date');
			$table->unsignedTinyInteger('order_status');
			$table->string('order_method')->nullable();
			$table->datetime('payment_date')->nullable();
			$table->string('payment_type')->nullable();
			$table->string('file_receipt',255)->nullable();
			$table->string('is_confirmed')->nullable();
			$table->integer('total_ac');
			$table->text('reason');
			$table->text('keterangan')->nullable();
			$table->double('location_range');
			$table->double('total_base_price');
			$table->double('transport_fee');
			$table->double('sub_total');
			$table->double('diskon');
			$table->double('grand_total');
            $table->tinyInteger('payment_status')->nullable();
            $table->text('payment_details')->nullable();
            $table->date('payment_duedate')->nullable();
            $table->date('revision_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_histories');
    }
};
