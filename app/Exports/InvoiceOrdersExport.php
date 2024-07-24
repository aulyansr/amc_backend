<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class InvoiceOrdersExport implements FromView
{
    public function view(): View
    {
        return view('exports.invoices');
    }
}
