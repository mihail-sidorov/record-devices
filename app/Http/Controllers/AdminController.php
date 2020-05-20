<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Devices;
use App\WorkPlace;
use App\Workers;
use App\Providers;
use App\Responsibles;
use App\Departments;
use App\DeviceWorker;
use App\Categories;
use App\ComponentPart;
use App\DeviceComponentPart;
use App\WorkPlaceComponentPart;
use App\WorkPlaceWorker;

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
                'work-places' => [],
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
                case 'work-places':
                    $active_tabs['work-places'][] = ' active';
                    $active_tabs['work-places'][] = ' show active';
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
            $work_places = WorkPlace::all();
            $component_parts = ComponentPart::all();
            $workers = Workers::all();
            $providers = Providers::all();
            $responsibles = Responsibles::all();
            $departments = Departments::all();
            $categories = Categories::all();

            return view('admin.index', [
                'devices' => $devices,
                'work_places' => $work_places,
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
                'type_device_id' => 'required',
                'purchase_price' => 'required',
                'warranty' => 'date',
                'receipt_date' => 'date',
                'responsible_id' => 'required',
                'provider_id' => 'required',
                'category_id' => 'required',
            ];

            $validate_msgs = [
                'name.required' => 'Поле "Наименование" не должно быть пустым',
                'name.max' => 'Количество символов в поле "Наименование" не может превышать 255',
                'model.required' => 'Поле "Модель" не должно быть пустым',
                'model.max' => 'Количество символов в поле "Модель" не может превышать 255',
                'serial_number.required' => 'Поле "Серийный номер" не должно быть пустым',
                'serial_number.max' => 'Количество символов в поле "Серийный номер" не может превышать 255',
                'type_device_id.required' => 'Поле "Тип" не должно быть пустым',
                'purchase_price.required' => 'Поле "Закупочная цена" не должно быть пустым',
                'warranty.date' => 'Поле "Дата окончания гарантии" не является датой',
                'receipt_date.date' => 'Поле "Дата поступления" не является датой',
                'responsible_id.required' => 'Поле "Ответственный на складе" не должно быть пустым',
                'provider_id.required' => 'Поле "Поставщик" не должно быть пустым',
                'category_id.required' => 'Поле "Категория" не должно быть пустым',
            ];

            if ($request->type_device_id === '2') {
                $validate_arr += ['inventar_number' => 'bail|required|max:255'];
                $validate_msgs += [
                    'inventar_number.required' => 'Поле "Инвентарный номер" не должно быть пустым',
                    'inventar_number.max' => 'Количество символов в поле "Инвентарный номер" не может превышать 255',
                ];
            }
            else {
                $request->inventar_number = '';
            }
            
            $this->validate($request, $validate_arr, $validate_msgs);

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

    public function addWorkPlace(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            $this->validate($request, [
                'name' => 'bail|required|max:255',
                'inventar_number' => 'bail|required|max:255',
                'responsible_id' => 'required',
            ],
            [
                'name.required' => 'Поле "Наименование" обязательно для заполнения',
                'name.max' => 'Количество символов в поле "Наименование" не может превышать 255',
                'inventar_number.required' => 'Поле "Инвентарный номер" обязательно для заполнения',
                'inventar_number.max' => 'Количество символов в поле "Инвентарный номер" не может превышать 255',
                'responsible_id.required' => 'Поле "Ответственный на складе" обязательно для заполнения',
            ]);

            $work_place = new WorkPlace;

            $work_place->name = $request->name;
            $work_place->inventar_number = $request->inventar_number;
            $work_place->responsible_id = $request->responsible_id;

            $work_place->save();
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
                'purchase_price' => 'required',
                'warranty' => 'date',
                'receipt_date' => 'date',
                'responsible_id' => 'required',
                'provider_id' => 'required',
                'category_id' => 'required',
            ],
            [
                'name.required' => 'Поле "Наименование" не должно быть пустым',
                'name.max' => 'Количество символов в поле "Наименование" не может превышать 255',
                'model.required' => 'Поле "Модель" не должно быть пустым',
                'model.max' => 'Количество символов в поле "Модель" не может превышать 255',
                'serial_number.required' => 'Поле "Серийный номер" не должно быть пустым',
                'serial_number.max' => 'Количество символов в поле "Серийный номер" не может превышать 255',
                'purchase_price.required' => 'Поле "Закупочная цена" не должно быть пустым',
                'warranty.date' => 'Поле "Дата окончания гарантии" не является датой',
                'receipt_date.date' => 'Поле "Дата поступления" не является датой',
                'responsible_id.required' => 'Поле "Ответственный на складе" не должно быть пустым',
                'provider_id.required' => 'Поле "Поставщик" не должно быть пустым',
                'category_id.required' => 'Поле "Категория" не должно быть пустым',
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
                'department_id' => 'required',
            ],
            [
                'name.required' => 'Поле "ФИО" обязательно для заполнения',
                'name.max' => 'Количество символов в поле "ФИО" не может превышать 255',
                'post.required' => 'Поле "Должность" обязательно для заполнения',
                'post.max' => 'Количество символов в поле "Должность" не может превышать 255',
                'department_id.required' => 'Поле "Отдел" обязательно для заполнения',
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
            ],
            [
                'name.required' => 'Поле "ФИО" обязательно для заполнения',
                'name.max' => 'Количество символов в поле "ФИО" не может превышать 255',
                'description.required' => 'Поле "Описание" обязательно для заполнения',
                'description.max' => 'Количество символов в поле "Описание" не может превышать 255',
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
                'department_id' => 'required',
            ],
            [
                'name.required' => 'Поле "ФИО" обязательно для заполнения',
                'name.max' => 'Количество символов в поле "ФИО" не может превышать 255',
                'post.required' => 'Поле "Должность" обязательно для заполнения',
                'post.max' => 'Количество символов в поле "Должность" не может превышать 255',
                'department_id.required' => 'Поле "Отдел" обязательно для заполнения',
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
            ],
            [
                'name.required' => 'Поле "Наименование" обязательно для заполнения',
                'name.max' => 'Количество символов в поле "Наименование" не может превышать 255',
                'description.required' => 'Поле "Описание" обязательно для заполнения',
                'description.max' => 'Количество символов в поле "Описание" не может превышать 255',
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
            ],
            [
                'name.required' => 'Поле "Наименование" обязательно для заполнения',
                'name.max' => 'Количество символов в поле "Наименование" не может превышать 255',
                'description.required' => 'Поле "Описание" обязательно для заполнения',
                'description.max' => 'Количество символов в поле "Описание" не может превышать 255',
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
                'worker_id' => 'required',
            ],
            [
                'worker_id.required' => 'Выберите сотрудника из списка',
            ]);

            $device_worker = new DeviceWorker;

            $device_worker->device_id = $request->device_id;
            $device_worker->worker_id = $request->worker_id;

            $device_worker->save();
        }

        return 'OK';
    }

    public function attachWorkerToWorkPlace(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            $this->validate($request, [
                'worker_id' => 'required',
            ],
            [
                'worker_id.required' => 'Выберите сотрудника из списка',
            ]);

            $work_place_worker = WorkPlaceWorker::where([['work_place_id', $request->work_place_id], ['worker_id', $request->worker_id], ['attach', 1]])->first();

            if (!$work_place_worker) {
                $work_place_worker = new WorkPlaceWorker;

                $work_place_worker->work_place_id = $request->work_place_id;
                $work_place_worker->worker_id = $request->worker_id;

                $work_place_worker->save();
            }
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

    public function unattachWorkerFromWorkPlace(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            $work_place_worker = WorkPlaceWorker::where([['work_place_id', $request->work_place_id], ['worker_id', $request->worker_id], ['attach', 1]])->first();
            if ($work_place_worker) {
                $work_place_worker->attach = 0;
                $work_place_worker->save();
            }
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
                'type_device_id' => 'required',
                'purchase_price' => 'required',
                'warranty' => 'date',
                'receipt_date' => 'date',
                'responsible_id' => 'required',
                'provider_id' => 'required',
                'category_id' => 'required',
            ];

            $validate_msgs = [
                'name.required' => 'Поле "Наименование" не должно быть пустым',
                'name.max' => 'Количество символов в поле "Наименование" не может превышать 255',
                'model.required' => 'Поле "Модель" не должно быть пустым',
                'model.max' => 'Количество символов в поле "Модель" не может превышать 255',
                'serial_number.required' => 'Поле "Серийный номер" не должно быть пустым',
                'serial_number.max' => 'Количество символов в поле "Серийный номер" не может превышать 255',
                'type_device_id.required' => 'Поле "Тип" не должно быть пустым',
                'purchase_price.required' => 'Поле "Закупочная цена" не должно быть пустым',
                'warranty.date' => 'Поле "Дата окончания гарантии" не является датой',
                'receipt_date.date' => 'Поле "Дата поступления" не является датой',
                'responsible_id.required' => 'Поле "Ответственный на складе" не должно быть пустым',
                'provider_id.required' => 'Поле "Поставщик" не должно быть пустым',
                'category_id.required' => 'Поле "Категория" не должно быть пустым',
            ];

            if ($request->type_device_id === '2') {
                $validate_arr += ['inventar_number' => 'bail|required|max:255'];
                $validate_msgs += [
                    'inventar_number.required' => 'Поле "Инвентарный номер" не должно быть пустым',
                    'inventar_number.max' => 'Количество символов в поле "Инвентарный номер" не может превышать 255',
                ];
            }
            else {
                $request->inventar_number = '';
            }
            
            $this->validate($request, $validate_arr, $validate_msgs);

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

    public function editWorkPlace(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            $this->validate($request, [
                'name' => 'bail|required|max:255',
                'inventar_number' => 'bail|required|max:255',
                'responsible_id' => 'required',
            ],
            [
                'name.required' => 'Поле "Наименование" обязательно для заполнения',
                'name.max' => 'Количество символов в поле "Наименование" не может превышать 255',
                'inventar_number.required' => 'Поле "Инвентарный номер" обязательно для заполнения',
                'inventar_number.max' => 'Количество символов в поле "Инвентарный номер" не может превышать 255',
                'responsible_id.required' => 'Поле "Ответственный на складе" обязательно для заполнения',
            ]);

            $work_place = WorkPlace::find($request->id);

            $work_place->name = $request->name;
            $work_place->inventar_number = $request->inventar_number;
            $work_place->responsible_id = $request->responsible_id;

            $work_place->save();
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
                'purchase_price' => 'required',
                'warranty' => 'date',
                'receipt_date' => 'date',
                'responsible_id' => 'required',
                'provider_id' => 'required',
                'category_id' => 'required',
            ],
            [
                'name.required' => 'Поле "Наименование" не должно быть пустым',
                'name.max' => 'Количество символов в поле "Наименование" не может превышать 255',
                'model.required' => 'Поле "Модель" не должно быть пустым',
                'model.max' => 'Количество символов в поле "Модель" не может превышать 255',
                'serial_number.required' => 'Поле "Серийный номер" не должно быть пустым',
                'serial_number.max' => 'Количество символов в поле "Серийный номер" не может превышать 255',
                'purchase_price.required' => 'Поле "Закупочная цена" не должно быть пустым',
                'warranty.date' => 'Поле "Дата окончания гарантии" не является датой',
                'receipt_date.date' => 'Поле "Дата поступления" не является датой',
                'responsible_id.required' => 'Поле "Ответственный на складе" не должно быть пустым',
                'provider_id.required' => 'Поле "Поставщик" не должно быть пустым',
                'category_id.required' => 'Поле "Категория" не должно быть пустым',
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
                'department_id' => 'required',
            ],
            [
                'name.required' => 'Поле "ФИО" обязательно для заполнения',
                'name.max' => 'Количество символов в поле "ФИО" не может превышать 255',
                'post.required' => 'Поле "Должность" обязательно для заполнения',
                'post.max' => 'Количество символов в поле "Должность" не может превышать 255',
                'department_id.required' => 'Поле "Отдел" обязательно для заполнения',
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
            ],
            [
                'name.required' => 'Поле "ФИО" обязательно для заполнения',
                'name.max' => 'Количество символов в поле "ФИО" не может превышать 255',
                'description.required' => 'Поле "Описание" обязательно для заполнения',
                'description.max' => 'Количество символов в поле "Описание" не может превышать 255',
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
                'department_id' => 'required',
            ],
            [
                'name.required' => 'Поле "ФИО" обязательно для заполнения',
                'name.max' => 'Количество символов в поле "ФИО" не может превышать 255',
                'post.required' => 'Поле "Должность" обязательно для заполнения',
                'post.max' => 'Количество символов в поле "Должность" не может превышать 255',
                'department_id.required' => 'Поле "Отдел" обязательно для заполнения',
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
            ],
            [
                'name.required' => 'Поле "Наименование" обязательно для заполнения',
                'name.max' => 'Количество символов в поле "Наименование" не может превышать 255',
                'description.required' => 'Поле "Описание" обязательно для заполнения',
                'description.max' => 'Количество символов в поле "Описание" не может превышать 255',
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
            ],
            [
                'name.required' => 'Поле "Наименование" обязательно для заполнения',
                'name.max' => 'Количество символов в поле "Наименование" не может превышать 255',
                'description.required' => 'Поле "Описание" обязательно для заполнения',
                'description.max' => 'Количество символов в поле "Описание" не может превышать 255',
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

    public function delWorkPlace(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            WorkPlace::destroy($request->id);
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

    public function writeEditWorkPlaceForm(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            $work_place = WorkPlace::find($request->id);

            return "{
                \"name\": \"$work_place->name\",
                \"inventar_number\": \"$work_place->inventar_number\",
                \"responsible_id\": \"$work_place->responsible_id\"
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

    public function writeAttachComponentPartsModalWindow(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            $component_part_ids = WorkPlaceComponentPart::where([
                ['work_place_id', '<>', $request->work_place_id],
                ['attach', '=', 1],
            ])
            ->pluck('component_part_id');

            $result_array = [];
            $categories = Categories::join('component_parts', 'categories.id', '=', 'component_parts.category_id')->select('categories.*')->distinct()->get();
            $categories_array = [];
            foreach ($categories as $category) {
                $component_parts = $category->component_parts()->whereNotIn('id', $component_part_ids)->get();
                $component_parts_array = [];
                $checked_array = [];
                foreach ($component_parts as $component_part) {
                    if ($component_part->is_attach()) {
                        $component_parts_array[] = $component_part;
                        $checked_array[] = true;
                    }
                    elseif (!$component_part->write_off()) {
                        $component_parts_array[] = $component_part;
                        $checked_array[] = false;
                    }
                }
                $result_array[] = ['category' => $category, 'component_parts' => $component_parts_array, 'checked' => $checked_array];
            }

            return json_encode($result_array);
        }
    }

    public function attachComponentPartToWorkPlace($work_place_id, $component_part_id, $component_part_check)
    {
        $work_place_component_part = WorkPlaceComponentPart::where([
            ['work_place_id', '=', $work_place_id],
            ['component_part_id', '=', $component_part_id],
            ['attach', '=', 1],
        ])
        ->first();

        if (!$component_part_check) {
            if ($work_place_component_part) {
                $work_place_component_part->attach = 0;
                $work_place_component_part->save();
            }
        }
        else {
            if (!$work_place_component_part) {
                $work_place_component_part = new WorkPlaceComponentPart;
                $work_place_component_part->work_place_id = $work_place_id;
                $work_place_component_part->component_part_id = $component_part_id;
                $work_place_component_part->attach = 1;
                $work_place_component_part->save();
            }
        }
    }

    public function attachComponentPartsToWorkPlace(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            if ($request->component_parts) {
                foreach ($request->component_parts[0] as $index => $component_part_id) {
                    $this->attachComponentPartToWorkPlace($request->work_place_id, $component_part_id, $request->component_parts[1][$index]);
                }

                return '{}';
            }
        }
    }

    public function writeAttachDevicesModalWindow(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            $device_ids = DeviceWorker::where([
                ['worker_id', '<>', $request->worker_id],
                ['attach', '=', 1],
            ])
            ->pluck('device_id');

            $result_array = [];
            $categories = Categories::join('devices', 'categories.id', '=', 'devices.category_id')->select('categories.*')->distinct()->get();
            $categories_array = [];
            foreach ($categories as $category) {
                $devices = $category->devices()->whereNotIn('id', $device_ids)->get();
                $devices_array = [];
                $checked_array = [];
                foreach ($devices as $device) {
                    if ($device->attach_to_worker()) {
                        $devices_array[] = $device;
                        $checked_array[] = true;
                    }
                    elseif (!$device->write_off()) {
                        $devices_array[] = $device;
                        $checked_array[] = false;
                    }
                }
                $result_array[] = ['category' => $category, 'devices' => $devices_array, 'checked' => $checked_array];
            }

            return json_encode($result_array);
        }
    }

    public function attachDeviceToWorker($worker_id, $device_id, $device_check)
    {
        if (!$device_check) {
            $device_worker = DeviceWorker::where([
                ['worker_id', '=', $worker_id],
                ['device_id', '=', $device_id],
                ['attach', '=', 1],
            ])
            ->orderby('id', 'desc')
            ->first();

            if ($device_worker) {
                $device_worker->attach = 0;
                $device_worker->save();
            }
        }
        else {
            $worker = Workers::find($worker_id);
            $device = Devices::find($device_id);
            if ($worker && $device && !$device->write_off() && !$device->attach_to_worker()) {
                $device_worker = new DeviceWorker;
                $device_worker->worker_id = $worker_id;
                $device_worker->device_id = $device_id;
                $device_worker->attach = 1;
                $device_worker->save();
            }
        }
    }

    public function attachDevicesToWorker(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            if ($request->devices) {
                foreach ($request->devices[0] as $index => $device_id) {
                    $this->attachDeviceToWorker($request->worker_id, $device_id, $request->devices[1][$index]);
                }

                return '{}';
            }
        }
    }

    public function getFreeWorkers(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            $worker_ids = WorkPlaceWorker::where([
                ['attach', '=', 1],
            ])
            ->pluck('worker_id');

            $workers = Workers::whereNotIn('id', $worker_ids)->get();

            return json_encode($workers);
        }
    }
}
