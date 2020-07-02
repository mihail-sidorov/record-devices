<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Departments;
use App\Workers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'bail|required|max:255',
            'post' => 'bail|required|max:255',
            'department_id' => 'required',
            'email' => 'bail|required|string|email|max:255|unique:users',
            'password' => 'bail|required|string|min:8|confirmed',
            'employer_id' => 'required',
            'placement_date' => 'date',
        ],
        [
            'name.required' => 'Поле "ФИО" обязательно для заполнения',
            'name.max' => 'Количество символов в поле "ФИО" не может превышать 255',
            'post.required' => 'Поле "Должность" обязательно для заполнения',
            'post.max' => 'Количество символов в поле "Должность" не может превышать 255',
            'department_id.required' => 'Поле "Отдел" обязательно для заполнения',
            'email.required' => 'Поле "Эл. почта" обязательно для заполнения',
            'email.string' => 'Поле "Эл. почта" должно быть строкой',
            'email.email' => 'Поле "Эл. почта" не валидно',
            'email.max' => 'Количество символов в поле "Эл. почта" не может превышать 255',
            'email.unique' => 'Поле "Эл. почта" с таким именем уже существует',
            'password.required' => 'Поле "Пароль" обязательно для заполнения',
            'password.string' => 'Поле "Пароль" должно быть строкой',
            'password.min' => 'Количество символов в поле "Пароль" не может быть меньше 8',
            'password.confirmed' => 'Поле "Пароль" не совпадает с подтверждением',
            'employer_id.required' => 'Поле "Работодатель" обязательно для заполнения',
            'placement_date.date' => 'Поле "Дата трудоустройства" не является датой',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'worker',
        ]);

        $worker = new Workers;
        $worker->name = $data['name'];
        $worker->post = $data['post'];
        $worker->department_id = $data['department_id'];
        $worker->user_id = $user->id;
        $worker->employer_id = $data['employer_id'];
        $worker->placement_date = strtotime($data['placement_date']);
        $worker->save();

        return $user;
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $departments = Departments::all();

        return view('auth.register', [
            'departments' => $departments,
        ]);
    }
}
