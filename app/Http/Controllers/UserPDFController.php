<?php

namespace App\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;

class UserPDFController extends Controller
{
    public function exportPDF()
    {
        $users = User::all();
        
        $pdf = Pdf::loadView('pdf.users', compact('users'));

        return $pdf->download('usuarios.pdf');
    }
}