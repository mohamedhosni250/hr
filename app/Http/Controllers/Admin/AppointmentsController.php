<?php

namespace App\Http\Controllers\Admin;

use App\Appointment;
use App\Client;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAppointmentRequest;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Service;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class AppointmentsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Appointment::with(['services'])->select(sprintf('%s.*', (new Appointment)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'appointment_show';
                $editGate      = 'appointment_edit';
                $deleteGate    = 'appointment_delete';
                $crudRoutePart = 'appointments';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->addColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->addColumn('status', function ($row) {
                return $row->status ? $row->status : 'Processing';
            });

            $table->addColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });

            $table->editColumn('mobile_number', function ($row) {
                return $row->number ? $row->number : "";
            });
            $table->editColumn('comments', function ($row) {
                return $row->comments ? $row->comments : "";
            });
            $table->editColumn('services', function ($row) {
                $labels = [];

                foreach ($row->services as $service) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $service->name);
                }

                return implode(' ', $labels);
            });

            $table->rawColumns(['actions', 'placeholder', 'services']);

            return $table->make(true);
        }

        return view('admin.appointments.index');
    }

    public function create()
    {
        abort_if(Gate::denies('appointment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');



        $services = Service::all()->pluck('name', 'id');

        return view('admin.appointments.create', compact('services'));
    }

    public function store(StoreAppointmentRequest $request)
    {

        $appointment = Appointment::create($request->all());
        $appointment->services()->sync($request->input('services', []));
        if ($request->hasFile('file_path')) {
            $appointment->update([
                'file_path' => $request->file('file_path')->store('cvs', 'public')
            ]);
        }
        return redirect()->route('admin.appointments.index');
    }

    public function edit(Appointment $appointment)
    {
        abort_if(Gate::denies('appointment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');


        $services = Service::all()->pluck('name', 'id');

        $appointment->load('employee', 'services');

        return view('admin.appointments.edit', compact('services', 'appointment'));
    }

    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        $appointment->update($request->all());
        $appointment->services()->sync($request->input('services', []));

        return redirect()->route('admin.appointments.index');
    }

    public function show(Appointment $appointment)
    {
        abort_if(Gate::denies('appointment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $appointment->load('client', 'employee', 'services');

        return view('admin.appointments.show', compact('appointment'));
    }

    public function destroy(Appointment $appointment)
    {
        abort_if(Gate::denies('appointment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $appointment->delete();

        return back();
    }

    public function massDestroy(MassDestroyAppointmentRequest $request)
    {
        Appointment::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function notify(Request $request)
    {
        # code...

        $validated = $request->validate([
            'name' => 'required|string',
            'number' => 'required',
            'department' => 'required'
        ]);
        $number = $validated['number'];
        $name = $validated['name'];
        $department = $validated['department'];
        $message = "Hello $name We Appreciate your interest in Netarabia and the time you have invested in applying for  $department Opening we ended up moving forward with another candidate but we would like ti thank you for talking to our team and giving us the opporunity to learn about your skill ,HR Manager  " ;
      
        $response  = Http::post('https://smsmisr.com/api/webapi/?username=76ML21BL&password=76ML21&language=1&sender=NetArabia&Mobile=2' . $number . '&message=' . $message);
        if($response->json()['code'] === "1901"){
            return back();
        }
        echo "error happen while sendding ";
      
    }
}
