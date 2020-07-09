<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Act;
use App\DeviceWorker;
use App\WorkPlaceWorker;

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

    public function createAct(Request $request)
    {
        if ($request->ajax() && Auth::user()->role === 'admin') {
            if ($request->type === '1') {
                $devices_workers = DeviceWorker::where([['worker_id', '=', $request->id], ['act_give_id', '=', null], ['attach', '=', 1]])->get();
                $work_places_workers = WorkPlaceWorker::where([['worker_id', '=', $request->id], ['act_give_id', '=', null], ['attach', '=', 1]])->get();
                $type = 'give';
            }
            else {
                $devices_workers = DeviceWorker::where([['worker_id', '=', $request->id], ['act_give_id', '<>', null], ['act_return_id', '=', null], ['attach', '=', 0]])->get();
                $work_places_workers = WorkPlaceWorker::where([['worker_id', '=', $request->id], ['act_give_id', '<>', null], ['act_return_id', '=', null], ['attach', '=', 0]])->get();
                $type = 'return';
            }

            if (($devices_workers->count() > 0) || ($work_places_workers->count() > 0)) {
                $act = new Act;
                $act->type = $type;
                $act->save();

                foreach($devices_workers as $device_worker) {
                    if ($request->type === '1') {
                        $device_worker->act_give_id = $act->id;
                    }
                    else {
                        $device_worker->act_return_id = $act->id;
                    }
                    $device_worker->save();
                }

                foreach($work_places_workers as $work_place_worker) {
                    if ($request->type === '1') {
                        $work_place_worker->act_give_id = $act->id;
                    }
                    else {
                        $work_place_worker->act_return_id = $act->id;
                    }
                    $work_place_worker->save();
                }
            }
        }

        return 'OK';
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