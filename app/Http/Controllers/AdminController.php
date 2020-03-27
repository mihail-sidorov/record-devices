<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Devices;
use App\Workers;
use App\Providers;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            $devices = Devices::all();
            $workers = Workers::all();
            $providers = Providers::all();

            return view('admin.index', [
                'devices' => $devices,
                'workers' => $workers,
                'providers' => $providers,
            ]);
        }
        else {
            abort(403);
        }
    }

    public function addDevice(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            $this->validate($request, [
                'name' => 'bail|required|max:255',
                'model' => 'bail|required|max:255',
                'serial_number' => 'bail|required|max:255',
                'type_device_id' => 'bail|required',
                'purchase_price' => 'bail|required|max:255',
                'warranty' => 'date',
                'receipt_date' => 'date',
            ]);

            $devices = new Devices;

            date_default_timezone_set('Europe/Moscow');

            $devices->name = $request->name;
            $devices->model = $request->model;
            $devices->serial_number = $request->serial_number;
            $devices->type_device_id = $request->type_device_id;
            $devices->purchase_price = $request->purchase_price;
            $devices->warranty = strtotime($request->warranty);
            $devices->receipt_date = strtotime($request->receipt_date);

            $devices->save();
        }

        return 'OK';
    }

    public function addWorker(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            $this->validate($request, [
                'name' => 'bail|required|max:255',
                'post' => 'bail|required|max:255',
                'department_id' => 'bail|required|max:255',
            ]);

            $workers = new Workers;

            $workers->name = $request->name;
            $workers->post = $request->post;
            $workers->department_id = $request->department_id;

            $workers->save();
        }

        return 'OK';
    }

    public function addProvider(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            $this->validate($request, [
                'name' => 'bail|required|max:255',
            ]);

            $providers = new Providers;

            $providers->name = $request->name;

            $providers->save();
        }

        return 'OK';
    }

    public function editDevice(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            $this->validate($request, [
                'name' => 'bail|required|max:255',
                'model' => 'bail|required|max:255',
                'serial_number' => 'bail|required|max:255',
                'type_device_id' => 'bail|required',
                'purchase_price' => 'bail|required|max:255',
                'warranty' => 'date',
                'receipt_date' => 'date',
            ]);

            $devices = Devices::find($request->id);

            date_default_timezone_set('Europe/Moscow');

            $devices->name = $request->name;
            $devices->model = $request->model;
            $devices->serial_number = $request->serial_number;
            $devices->type_device_id = $request->type_device_id;
            $devices->purchase_price = $request->purchase_price;
            $devices->warranty = strtotime($request->warranty);
            $devices->receipt_date = strtotime($request->receipt_date);

            $devices->save();
        }

        return 'OK';
    }

    public function editWorker(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            $this->validate($request, [
                'name' => 'bail|required|max:255',
                'post' => 'bail|required|max:255',
                'department_id' => 'bail|required|max:255',
            ]);

            $workers = Workers::find($request->id);

            $workers->name = $request->name;
            $workers->post = $request->post;
            $workers->department_id = $request->department_id;

            $workers->save();
        }

        return 'OK';
    }

    public function editProvider(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            $this->validate($request, [
                'name' => 'bail|required|max:255',
            ]);

            $providers = Providers::find($request->id);

            $providers->name = $request->name;

            $providers->save();
        }

        return 'OK';
    }

    public function delDevice(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            Devices::destroy($request->id);
        }
        
        return 'OK';
    }

    public function delWorker(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            Workers::destroy($request->id);
        }
        
        return 'OK';
    }

    public function writeEditDeviceForm(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            $device = Devices::find($request->id);

            return "{
                \"name\": \"$device->name\",
                \"model\": \"$device->model\",
                \"serial_number\": \"$device->serial_number\",
                \"type_device_id\": \"$device->type_device_id\",
                \"receipt_date\": \"$device->receipt_date\",
                \"purchase_price\": \"$device->purchase_price\",
                \"warranty\": \"$device->warranty\"
            }";
        }
    }

    public function writeEditWorkerForm(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            $worker = Workers::find($request->id);

            return "{
                \"name\": \"$worker->name\",
                \"post\": \"$worker->post\",
                \"department_id\": \"$worker->department_id\"
            }";
        }
    }

    public function writeEditProviderForm(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            $provider = Providers::find($request->id);

            return "{
                \"name\": \"$provider->name\"
            }";
        }
    }
}
