<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::with('reservations')->get();
        return view('admin.clients.index', compact('clients'));
    }
}
