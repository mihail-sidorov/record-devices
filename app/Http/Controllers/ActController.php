<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Act;

class ActController extends Controller
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
    public function index($act_id = null)
    {
        if (Auth::user()->role === 'admin') {
            if (preg_match('/^[1-9][0-9]*$/u', $act_id)) {
                $act = Act::find($act_id);

                if ($act) {
                    return view('act.index', [
                        'act' => $act,
                    ]);
                }
                else {
                    abort(404);
                }
            }
            else {
                abort(404);
            }
        }
        else {
            abort(403);
        }
    }
}