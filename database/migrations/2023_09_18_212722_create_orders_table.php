<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
			$table->foreignId('branch_id')->nullable()->constrained('branches')
            ->onUpdate('NO ACTION')
            ->onDelete('NO ACTION');
			$table->foreignId('master_address_id')->constrained('master_addresses')
            ->onUpdate('NO ACTION')
            ->onDelete('NO ACTION');
			$table->foreignId('master_customer_id')->constrained('master_customers')
            ->onUpdate('NO ACTION')
            ->onDelete('NO ACTION');
			$table->string('ref_no',255);
			$table->datetime('booked_date');
			$table->unsignedTinyInteger('order_status');
			$table->string('order_method')->nullable();
			$table->datetime('payment_date')->nullable();
			$table->string('payment_type')->nullable();
			$table->string('file_receipt',255)->nullable();
			$table->string('is_confirmed')->nullable();
			$table->integer('total_ac');
			$table->text('reason');
			$table->text('keterangan');
			$table->double('location_range');
			$table->double('total_base_price');
			$table->double('transport_fee');
			$table->double('sub_total');
			$table->double('diskon');
			$table->double('grand_total');
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
        Schema::dropIfExists('orders');
    }
}
