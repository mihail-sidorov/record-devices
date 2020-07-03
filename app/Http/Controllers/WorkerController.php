<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Service;
use App\Departments;
use App\Workers;

class WorkerController extends Controller
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
    public function index($tab_name = 'services')
    {
        if (Auth::user()->role === 'worker') {
            $active_tabs = [
                'services' => [],
                'fixed-technique' => [],
            ];

            switch ($tab_name) {
                case 'services':
                    $active_tabs['services'][] = ' active';
                    $active_tabs['services'][] = ' show active';
                    break;
                case 'fixed-technique':
                    $active_tabs['fixed-technique'][] = ' active';
                    $active_tabs['fixed-technique'][] = ' show active';
                    break;
                default:
                    abort(404);
            }

            $services = Auth::user()->services;
            $departments = Departments::all();
            $work_places = Auth::user()->get_work_places();
            $devices = Auth::user()->get_devices();

            return view('worker.index', [
                'active_tabs' => $active_tabs,
                'services' => $services,
                'departments' => $departments,
                'work_places' => $work_places,
                'devices' => $devices,
            ]);
        }
        else {
            abort(403);
        }
    }

    public function addService(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'worker') {
            $this->validate($request, [
                'name' => 'bail|required|max:255',
                'login' => 'bail|required|max:255',
                'password' => 'bail|required|max:255',
            ],
            [
                'name.required' => 'Поле "Наименование" не должно быть пустым',
                'name.max' => 'Количество символов в поле "Наименование" не может превышать 255',
                'login.required' => 'Поле "Логин" не должно быть пустым',
                'login.max' => 'Количество символов в поле "Логин" не может превышать 255',
                'password.required' => 'Поле "Пароль" не должно быть пустым',
                'password.max' => 'Количество символов в поле "Пароль" не может превышать 255',
            ]);

            $service = new Service;

            $service->name = $request->name;
            $service->login = $request->login;
            $service->password = $request->password;
            $service->user_id = Auth::user()->id;

            $service->save();
        }

        return 'OK';
    }

    public function writeEditServiceForm(Request $request)
    {
        if ($request->ajax() && (Auth::user()->role === 'worker' || Auth::user()->role === 'admin')) {
            if (Auth::user()->role === 'worker') {
                $service = Service::where([['id', $request->id], ['user_id', Auth::user()->id]])->first();
            }
            if (Auth::user()->role === 'admin') {
                $service = Service::where('id', $request->id)->first();
            }

            return "{
                \"name\": \"$service->name\",
                \"login\": \"$service->login\",
                \"password\": \"$service->password\"
            }";
        }
    }

    public function editService(Request $request)
    {
        if ($request->ajax() && (Auth::user()->role === 'worker' || Auth::user()->role === 'admin')) {
            $this->validate($request, [
                'name' => 'bail|required|max:255',
                'login' => 'bail|required|max:255',
                'password' => 'bail|required|max:255',
            ],
            [
                'name.required' => 'Поле "Наименование" не должно быть пустым',
                'name.max' => 'Количество символов в поле "Наименование" не может превышать 255',
                'login.required' => 'Поле "Логин" не должно быть пустым',
                'login.max' => 'Количество символов в поле "Логин" не может превышать 255',
                'password.required' => 'Поле "Пароль" не должно быть пустым',
                'password.max' => 'Количество символов в поле "Пароль" не может превышать 255',
            ]);

            if (Auth::user()->role === 'worker') {
                $service = Service::where([['id', $request->id], ['user_id', Auth::user()->id]])->first();
            }
            if (Auth::user()->role === 'admin') {
                $service = Service::where('id', $request->id)->first();
            }

            if ($service) {
                $service->name = $request->name;
                $service->login = $request->login;
                $service->password = $request->password;

                $service->save();
            }
        }

        return 'OK';
    }

    public function delService(Request $request)
    {
        if ($request->ajax() && (Auth::user()->role === 'worker' || Auth::user()->role === 'admin')) {
            if (Auth::user()->role === 'worker') {
                $service = Service::where([['id', $request->id], ['user_id', Auth::user()->id]])->first();
            }
            if (Auth::user()->role === 'admin') {
                $service = Service::where('id', $request->id)->first();
            }

            if ($service) {
                Service::destroy($service->id);
            }
        }
        
        return 'OK';
    }
}
