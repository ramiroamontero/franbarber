<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Log;

class ClientsController extends Controller
{
    public function index()
    {
        return view(view: 'clients.index');
    }


    public function datatable(): JsonResponse
    {
        $clients = Client::all(['name', 'email', 'phone']);
        return DataTables::collection($clients)->toJson();
    }

    public function store(Request $request)
    {
        Log::info('CREATE_CLIENT_IN_PROGRESS');
        try {
            Client::create($request->all());
        } catch (\Throwable $th) {
            //throw $th;
            Log::error('CREATE_CLIENT_ERROR:' . $th->getMessage());
            return response()->json(['message' => $th->getMessage()], status: 500);
        }

        Log::info('CREATE_CLIENT_SUCCESS');
        return response()->json(['message' => 'El cliente fue creado con éxito'], status: 200);
    }
}
