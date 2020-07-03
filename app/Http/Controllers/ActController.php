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

    public function upload(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            $file = $request->file('img');

            $this->validate($request, [
                'img' => 'bail|file|max:3072',
            ],
            [
                'img.file' => 'Загруженный объект должен быть файлом',
                'img.max' => 'Размер загружаемого файла не должен превышать 3Мб',
            ]);

            $path = public_path('uploads' . DIRECTORY_SEPARATOR . 'acts');
            $file_full_name = 'act' . $request->id . '.' . $file->getClientOriginalExtension();
            
            $file->move($path, $file_full_name);

            $act = Act::find($request->id);

            if ($act->document === null) {
                $act->document = $file_full_name;
                $act->save();
            }

            return '{}';
        }
    }

    public function download($act_id = null)
    {
        if ((Auth::user()->role === 'admin') || (Auth::user()->role === 'worker')) {
            if (preg_match('/^[1-9][0-9]*$/u', $act_id)) {
                $act = Act::find($act_id);

                if ($act) {
                    return response()->download(public_path("uploads/acts/$act->document"));
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