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
        // Retrieve all records from the ac_customers table
        $customers = DB::table('ac_customers')->get();

        // Loop through each customer and update the next_service field
        foreach ($customers as $customer) {
            // Assuming that 'last_services' is a column in your table
            $lastService = \Carbon\Carbon::parse($customer->last_service);

            // Add 2 months to the last_services date
            $nextService = $lastService->addMonths(2);

            // Update the 'next_service' column in the ac_customers table
            DB::table('ac_customers')
                ->where('id', $customer->id)  // Assuming 'id' is the primary key column
                ->update(['next_service' => $nextService]);
        }
    }

    public function down(): void
    {
        // Rollback logic if needed
    }
};
