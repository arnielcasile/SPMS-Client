<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;

class PrintController extends Controller
{
    public function print_irregularity(Request $request)
    {
        // dd(json_decode($request->data));
        $pdf = PDF::loadView('PDF.pdf_irregularity',['data' => json_decode($request->data)])->setPaper('A5', 'landscape');
        $fileName = 'Irregulairty';
        return $pdf->stream();
    }

    public function print_banner(Request $request)
    {
        $pdf = PDF::loadView('PDF.pdf_banner',['raw_data' => json_decode($request->data)])->setPaper('A4', 'landscape');
        $fileName = 'Banner';
        return $pdf->stream();
    }

    public function download_parts_for_dr_making(Request $request)
    {
        $pdf = PDF::loadView('PDF.pdf_dr_making',['raw_data' => json_decode($request->data)])->setPaper('A4', 'portrait');
        return $pdf->download('Delivery Receipt.pdf');
    }

    
}
