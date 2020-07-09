<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\WorkPlaceWorker;

class Workers extends Model
{
    /**
     * Таблица, связанная с моделью.
     *
     * @var string
     */
    protected $table = 'workers';

    /**
     * Определяет необходимость отметок времени для модели.
     *
     * @var bool
     */
    public $timestamps = false;

    public function department()
    {
        return $this->hasOne('App\Departments', 'id', 'department_id');
    }

    public function responsible()
    {
        return $this->hasOne('App\Responsibles', 'department_id', 'department_id');
    }

    public function devices()
    {
        return $this->belongsToMany('App\Devices', 'device_worker', 'worker_id', 'device_id')->wherePivot('attach', 1);
    }

    public function work_places()
    {
        return $this->belongsToMany('App\WorkPlace', 'work_place_worker', 'worker_id', 'work_place_id')->wherePivot('attach', 1);
    }

    public function is_attach_to_work_place()
    {
        if (WorkPlaceWorker::where([['worker_id', $this->id], ['attach', 1]])->count()) {
            return true;
        }
        else {
            return false;
        }
    }

    public function services()
    {
        return $this->hasMany('App\Service', 'user_id', 'user_id');
    }

    public function get_email()
    {
        return User::find($this->user_id)->email;
    }

    public function free_by_acts()
    {
        $devices_workers = DeviceWorker::where('worker_id', $this->id)->get();
        $work_places_workers = WorkPlaceWorker::where('worker_id', $this->id)->get();

        foreach($devices_workers as $device_worker) {
            if (($device_worker->act_give_id !== null || $device_worker->act_return_id !== null) && (!$device_worker->have_original_give_act() || !$device_worker->have_original_return_act())) {
                return false;
            }
        }

        foreach($work_places_workers as $work_place_worker) {
            if (($work_place_worker->act_give_id !== null || $work_place_worker->act_return_id !== null) && (!$work_place_worker->have_original_give_act() || !$work_place_worker->have_original_return_act())) {
                return false;
            }
        }

        return true;
    }
}
