<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Peserta;

class DaftarController extends Controller
{
    public function index()
    {
        $pembimbingId = Auth::user()->pembimbing->id;
        $pesertas = Peserta::with('user')
            ->where('pembimbing_id', $pembimbingId)
            ->orderBy('asal_sekolah')
            ->paginate(10);
        return view('pembimbing.peserta.index', compact('pesertas'));
    }
}