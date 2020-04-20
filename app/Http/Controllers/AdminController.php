<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Devices;
use App\Workers;
use App\Providers;
use App\Responsibles;
use App\Departments;
use App\DeviceWorker;
use App\Categories;
use App\ComponentPart;

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
    public function index($tab_name = 'devices')
    {
        if (Auth::user()->role === 'admin') {
            $active_tabs = [
                'devices' => [],
                'component_parts' => [],
                'workers' => [],
                'providers'=> [],
                'responsibles' => [],
                'departments' => [],
                'categories' => [],
            ];

            switch ($tab_name) {
                case 'devices':
                    $active_tabs['devices'][] = ' active';
                    $active_tabs['devices'][] = ' show active';
                    break;
                case 'component_parts':
                    $active_tabs['component_parts'][] = ' active';
                    $active_tabs['component_parts'][] = ' show active';
                    break;
                case 'workers':
                    $active_tabs['workers'][] = ' active';
                    $active_tabs['workers'][] = ' show active';
                    break;
                case 'providers':
                    $active_tabs['providers'][] = ' active';
                    $active_tabs['providers'][] = ' show active';
                    break;
                case 'responsibles':
                    $active_tabs['responsibles'][] = ' active';
                    $active_tabs['responsibles'][] = ' show active';
                    break;
                case 'departments':
                    $active_tabs['departments'][] = ' active';
                    $active_tabs['departments'][] = ' show active';
                    break;
                case 'categories':
                    $active_tabs['categories'][] = ' active';
                    $active_tabs['categories'][] = ' show active';
                    break;
                default:
                    abort(404);
            }

            $devices = Devices::all();
            $component_parts = ComponentPart::all();
            $workers = Workers::all();
            $providers = Providers::all();
            $responsibles = Responsibles::all();
            $departments = Departments::all();
            $categories = Categories::all();

            return view('admin.index', [
                'devices' => $devices,
                'component_parts' => $component_parts,
                'workers' => $workers,
                'providers' => $providers,
                'responsibles' => $responsibles,
                'departments' => $departments,
                'categories' => $categories,
                'active_tabs' => $active_tabs,
            ]);
        }
        else {
            abort(403);
        }
    }

    public function addDevice(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            $validate_arr = [
                'name' => 'bail|required|max:255',
                'model' => 'bail|required|max:255',
                'serial_number' => 'bail|required|max:255',
                'type_device_id' => 'bail|required',
                'purchase_price' => 'bail|required|max:255',
                'warranty' => 'date',
                'receipt_date' => 'date',
                'responsible_id' => 'bail|required|max:255',
                'provider_id' => 'bail|required|max:255',
                'category_id' => 'bail|required|max:255',
            ];

            if ($request->type_device_id === '2') {
                $validate_arr += ['inventar_number' => 'bail|required|max:255'];
            }
            else {
                $request->inventar_number = '';
            }
            
            $this->validate($request, $validate_arr);

            $devices = new Devices;

            $devices->name = $request->name;
            $devices->model = $request->model;
            $devices->serial_number = $request->serial_number;
            $devices->inventar_number = $request->inventar_number;
            $devices->type_device_id = $request->type_device_id;
            $devices->purchase_price = $request->purchase_price;
            $devices->warranty = strtotime($request->warranty);
            $devices->receipt_date = strtotime($request->receipt_date);
            $devices->responsible_id = $request->responsible_id;
            $devices->provider_id = $request->provider_id;
            $devices->category_id = $request->category_id;

            $devices->save();
        }

        return 'OK';
    }

    public function addComponentPart(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            $this->validate($request, [
                'name' => 'bail|required|max:255',
                'model' => 'bail|required|max:255',
                'serial_number' => 'bail|required|max:255',
                'purchase_price' => 'bail|required|max:255',
                'warranty' => 'date',
                'receipt_date' => 'date',
                'responsible_id' => 'bail|required|max:255',
                'provider_id' => 'bail|required|max:255',
                'category_id' => 'bail|required|max:255',
            ]);

            $component_part = new ComponentPart;

            $component_part->name = $request->name;
            $component_part->model = $request->model;
            $component_part->serial_number = $request->serial_number;
            $component_part->purchase_price = $request->purchase_price;
            $component_part->warranty = strtotime($request->warranty);
            $component_part->receipt_date = strtotime($request->receipt_date);
            $component_part->responsible_id = $request->responsible_id;
            $component_part->provider_id = $request->provider_id;
            $component_part->category_id = $request->category_id;

            $component_part->save();
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
                'description' => 'bail|required|max:255',
            ]);

            $providers = new Providers;

            $providers->name = $request->name;
            $providers->description = $request->description;

            $providers->save();
        }

        return 'OK';
    }

    public function addResponsible(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            $this->validate($request, [
                'name' => 'bail|required|max:255',
                'post' => 'bail|required|max:255',
                'department_id' => 'bail|required|max:255',
            ]);

            $responsibles = new Responsibles;

            $responsibles->name = $request->name;
            $responsibles->post = $request->post;
            $responsibles->department_id = $request->department_id;

            $responsibles->save();
        }

        return 'OK';
    }

    public function addDepartment(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            $this->validate($request, [
                'name' => 'bail|required|max:255',
                'description' => 'bail|required|max:255',
            ]);

            $departments = new Departments;

            $departments->name = $request->name;
            $departments->description = $request->description;

            $departments->save();
        }

        return 'OK';
    }

    public function addCategory(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            $this->validate($request, [
                'name' => 'bail|required|max:255',
                'description' => 'bail|required|max:255',
            ]);

            $categories = new Categories;

            $categories->name = $request->name;
            $categories->description = $request->description;

            $categories->save();
        }

        return 'OK';
    }

    public function attachWorker(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            $this->validate($request, [
                'worker_id' => 'bail|required|max:255',
            ]);

            $device_worker = new DeviceWorker;

            $device_worker->device_id = $request->device_id;
            $device_worker->worker_id = $request->worker_id;

            $device_worker->save();
        }

        return 'OK';
    }

    public function unattachWorker(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            $device_worker = DeviceWorker::where('device_id', $request->device_id)->orderby('id', 'desc')->first();
            $device_worker->attach = 0;
            $device_worker->save();
        }

        return 'OK';
    }

    public function editDevice(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            $validate_arr = [
                'name' => 'bail|required|max:255',
                'model' => 'bail|required|max:255',
                'serial_number' => 'bail|required|max:255',
                'type_device_id' => 'bail|required',
                'purchase_price' => 'bail|required|max:255',
                'warranty' => 'date',
                'receipt_date' => 'date',
                'responsible_id' => 'bail|required|max:255',
                'provider_id' => 'bail|required|max:255',
                'category_id' => 'bail|required|max:255',
            ];

            if ($request->type_device_id === '2') {
                $validate_arr += ['inventar_number' => 'bail|required|max:255'];
            }
            else {
                $request->inventar_number = '';
            }
            
            $this->validate($request, $validate_arr);

            $devices = Devices::find($request->id);

            $devices->name = $request->name;
            $devices->model = $request->model;
            $devices->serial_number = $request->serial_number;
            $devices->inventar_number = $request->inventar_number;
            $devices->type_device_id = $request->type_device_id;
            $devices->purchase_price = $request->purchase_price;
            $devices->warranty = strtotime($request->warranty);
            $devices->receipt_date = strtotime($request->receipt_date);
            $devices->responsible_id = $request->responsible_id;
            $devices->provider_id = $request->provider_id;
            $devices->category_id = $request->category_id;

            $devices->save();
        }

        return 'OK';
    }

    public function editComponentPart(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            $this->validate($request, [
                'name' => 'bail|required|max:255',
                'model' => 'bail|required|max:255',
                'serial_number' => 'bail|required|max:255',
                'purchase_price' => 'bail|required|max:255',
                'warranty' => 'date',
                'receipt_date' => 'date',
                'responsible_id' => 'bail|required|max:255',
                'provider_id' => 'bail|required|max:255',
                'category_id' => 'bail|required|max:255',
            ]);

            $component_part = ComponentPart::find($request->id);

            $component_part->name = $request->name;
            $component_part->model = $request->model;
            $component_part->serial_number = $request->serial_number;
            $component_part->purchase_price = $request->purchase_price;
            $component_part->warranty = strtotime($request->warranty);
            $component_part->receipt_date = strtotime($request->receipt_date);
            $component_part->responsible_id = $request->responsible_id;
            $component_part->provider_id = $request->provider_id;
            $component_part->category_id = $request->category_id;

            $component_part->save();
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
                'description' => 'bail|required|max:255',
            ]);

            $providers = Providers::find($request->id);

            $providers->name = $request->name;
            $providers->description = $request->description;

            $providers->save();
        }

        return 'OK';
    }

    public function editResponsible(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            $this->validate($request, [
                'name' => 'bail|required|max:255',
                'post' => 'bail|required|max:255',
                'department_id' => 'bail|required|max:255',
            ]);

            $responsibles = Responsibles::find($request->id);

            $responsibles->name = $request->name;
            $responsibles->post = $request->post;
            $responsibles->department_id = $request->department_id;

            $responsibles->save();
        }

        return 'OK';
    }

    public function editDepartment(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            $this->validate($request, [
                'name' => 'bail|required|max:255',
                'description' => 'bail|required|max:255',
            ]);

            $departments = Departments::find($request->id);

            $departments->name = $request->name;
            $departments->description = $request->description;

            $departments->save();
        }

        return 'OK';
    }

    public function editCategory(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            $this->validate($request, [
                'name' => 'bail|required|max:255',
                'description' => 'bail|required|max:255',
            ]);

            $categories = Categories::find($request->id);

            $categories->name = $request->name;
            $categories->description = $request->description;

            $categories->save();
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

    public function delComponentPart(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            ComponentPart::destroy($request->id);
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

    public function delProvider(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            Providers::destroy($request->id);
        }
        
        return 'OK';
    }

    public function delResponsible(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            Responsibles::destroy($request->id);
        }
        
        return 'OK';
    }

    public function delDepartment(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            Departments::destroy($request->id);
        }
        
        return 'OK';
    }

    public function delCategory(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            Categories::destroy($request->id);
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
                \"inventar_number\": \"$device->inventar_number\",
                \"type_device_id\": \"$device->type_device_id\",
                \"receipt_date\": \"$device->receipt_date\",
                \"purchase_price\": \"$device->purchase_price\",
                \"warranty\": \"$device->warranty\",
                \"responsible_id\": \"$device->responsible_id\",
                \"provider_id\": \"$device->provider_id\",
                \"category_id\": \"$device->category_id\"
            }";
        }
    }

    public function writeEditComponentPartForm(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            $component_part = ComponentPart::find($request->id);

            return "{
                \"name\": \"$component_part->name\",
                \"model\": \"$component_part->model\",
                \"serial_number\": \"$component_part->serial_number\",
                \"receipt_date\": \"$component_part->receipt_date\",
                \"purchase_price\": \"$component_part->purchase_price\",
                \"warranty\": \"$component_part->warranty\",
                \"responsible_id\": \"$component_part->responsible_id\",
                \"provider_id\": \"$component_part->provider_id\",
                \"category_id\": \"$component_part->category_id\"
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

            $description = $provider->description;
            $description = str_replace("\r\n", '***', $description);
            $description = str_replace("\r", '**', $description);
            $description = str_replace("\n", '*', $description);

            return "{
                \"name\": \"$provider->name\",
                \"description\": \"$description\"
            }";
        }
    }

    public function writeEditResponsibleForm(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            $responsible = Responsibles::find($request->id);

            return "{
                \"name\": \"$responsible->name\",
                \"post\": \"$responsible->post\",
                \"department_id\": \"$responsible->department_id\"
            }";
        }
    }

    public function writeEditDepartmentForm(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            $department = Departments::find($request->id);

            $description = $department->description;
            $description = str_replace("\r\n", '***', $description);
            $description = str_replace("\r", '**', $description);
            $description = str_replace("\n", '*', $description);

            return "{
                \"name\": \"$department->name\",
                \"description\": \"$description\"
            }";
        }
    }

    public function writeEditCategoryForm(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            $category = Categories::find($request->id);

            $description = $category->description;
            $description = str_replace("\r\n", '***', $description);
            $description = str_replace("\r", '**', $description);
            $description = str_replace("\n", '*', $description);

            return "{
                \"name\": \"$category->name\",
                \"description\": \"$description\"
            }";
        }
    }
}
