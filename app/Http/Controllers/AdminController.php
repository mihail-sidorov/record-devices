<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            return view('admin.index');
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
                'warranty' => 'bail|required',
                'receipt_date' => 'date',
            ]);

            return 'addDevice';
        }
        else {
            return '403';
        }
    }
}
