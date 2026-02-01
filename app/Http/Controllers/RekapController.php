<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RekapController extends Controller
{
    public function index()
    {
        Cache::put('rekap_user_' . auth()->id(), true, now()->addMinutes(10));

        return view('rekap.index');
    }
}
