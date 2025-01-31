<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::with('reservations')->get();
        return view('backend.clients.index', compact('clients'));
    }

    public function reservations()
    {

        return view('backend.clients.reservations');
    }
}
