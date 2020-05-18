<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Service;

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
            ];

            switch ($tab_name) {
                case 'services':
                    $active_tabs['services'][] = ' active';
                    $active_tabs['services'][] = ' show active';
                    break;
                default:
                    abort(404);
            }

            $services = Service::all();

            return view('worker.index', [
                'active_tabs' => $active_tabs,
                'services' => $services,
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

            $service->save();
        }

        return 'OK';
    }

    public function writeEditServiceForm(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'worker') {
            $service = Service::find($request->id);

            return "{
                \"name\": \"$service->name\",
                \"login\": \"$service->login\",
                \"password\": \"$service->password\"
            }";
        }
    }

    public function editService(Request $request)
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

            $service = Service::find($request->id);

            $service->name = $request->name;
            $service->login = $request->login;
            $service->password = $request->password;

            $service->save();
        }

        return 'OK';
    }
}
