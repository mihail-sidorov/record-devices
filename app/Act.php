<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\DeviceWorker;
use App\WorkPlaceWorker;
use App\Workers;

class Act extends Model
{
    /**
     * Таблица, связанная с моделью.
     *
     * @var string
     */
    protected $table = 'acts';

    public function get_worker()
    {
        if ($this->type === 'give') {
            $worker_id = DeviceWorker::where('act_give_id', $this->id)->value('worker_id');
            if (!$worker_id) {
                $worker_id = WorkPlaceWorker::where('act_give_id', $this->id)->value('worker_id');
            }
        }

        if ($this->type === 'return') {
            $worker_id = DeviceWorker::where('act_return_id', $this->id)->value('worker_id');
            if (!$worker_id) {
                $worker_id = WorkPlaceWorker::where('act_return_id', $this->id)->value('worker_id');
            }
        }

        return Workers::find($worker_id);
    }

    public function devices()
    {
        if ($this->type === 'give') {
            return $this->belongsToMany('App\Devices', 'device_worker', 'act_give_id', 'device_id');
        }
        else {
            return $this->belongsToMany('App\Devices', 'device_worker', 'act_return_id', 'device_id');
        }
    }

    public function work_places()
    {
        if ($this->type === 'give') {
            return $this->belongsToMany('App\WorkPlace', 'work_place_worker', 'act_give_id', 'work_place_id');
        }
        else {
            return $this->belongsToMany('App\WorkPlace', 'work_place_worker', 'act_return_id', 'work_place_id');
        }
    }
}
