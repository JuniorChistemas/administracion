<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;

class SupplierPDFController extends Controller
{
    public function exportPDF()
    {
        $suppliers = Supplier::all();
        
        $pdf = Pdf::loadView('pdf.suppliers', compact('suppliers'));

        return $pdf->download('proveedores.pdf');
    }
}