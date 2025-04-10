<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CallRecording;
class ReportController extends Controller
{
    public function index()
    {
        $voicemail_details = CallRecording::All();
        return view('reports.callreport',compact('voicemail_details'));
    }
}
