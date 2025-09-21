<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Scheduled;
use App\Models\Client;
use Illuminate\Http\Request;

use Auth;
use Carbon\Carbon;
use Log;
use Mail;

class AppointmentsController extends Controller
{

    public function index()
    {
        $clients = Client::all(['id', 'name']);
        return view(view: 'appointments.index', data: compact('clients'));
    }

    public function appointments()
    {
        $appointments = Appointment::select('appointments.id', 'start_time as start', 'finish_time as end', 'clients.name as title')
            ->join('clients', 'clients.id', '=', 'appointments.client_id')
            ->where('user_id', Auth::user()->id)
            ->get()->toArray();

        return response()->json($appointments);
    }

    public function store(Request $request)
    {
        Log::info('CREATE_APPOINTMENT_IN_PROGRESS');
        try {
            $date = $request->get('date');
            $start_date = Carbon::parse($date);

            Appointment::create([
                'start_time' => $start_date->toISOString(),
                'finish_time' => $start_date->addMinutes(30)->toISOString(),
                'comments' => $request->get('comments') || null,
                'client_id' => $request->get('clientId'),
                'user_id' => Auth::user()->id
            ]);
            $client = Client::where('id', $request->clientId)->first();

            $scheduledMail = new Scheduled($client->name, Carbon::parse($date)->toDateTimeString());
            $scheduledMail->subject('Turno agendado!');
            $scheduledMail->from(Auth::user()->email);
            Mail::to($client->email)->send($scheduledMail);
        } catch (\Throwable $th) {
            //throw $th;
            Log::error('CREATE_APPOINTMENT_ERROR:' . $th->getMessage());
            return response()->json(['message' => $th->getMessage()], status: 500);
        }

        Log::info('CREATE_APPOINTMENT_SUCCESS');
        return response()->json(['message' => 'El cliente fue creado con éxito'], status: 200);
    }
}
