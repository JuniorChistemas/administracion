<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;

class ServicePDFController extends Controller
{
    public function exportPDF()
    {
        $services = Service::all();
        
        $pdf = Pdf::loadView('pdf.services', compact('services'));

        return $pdf->download('servicios.pdf');
    }
}