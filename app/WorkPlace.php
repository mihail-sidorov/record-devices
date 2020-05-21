<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\WorkPlaceWorker;

class WorkPlace extends Model
{
    /**
     * Таблица, связанная с моделью.
     *
     * @var string
     */
    protected $table = 'work_places';

    /**
     * Определяет необходимость отметок времени для модели.
     *
     * @var bool
     */
    public $timestamps = false;

    public function responsible()
    {
        return $this->hasOne('App\Responsibles', 'id', 'responsible_id');
    }

    public function get_attach_worker()
    {
        $work_place_worker = WorkPlaceWorker::where([
            ['work_place_id', '=', $this->id],
            ['attach', '=', 1],
        ])->first();

        if ($work_place_worker) {
            return Workers::find($work_place_worker->worker_id);
        }
        else {
            return null;
        }
    }

    public function is_attach_to_worker()
    {
        if (WorkPlaceWorker::where([['work_place_id', $this->id], ['attach', 1]])->count()) {
            return true;
        }
        else {
            return false;
        }
    }

    public function get_responsible()
    {
        $attach_worker = $this->get_attach_worker();
        if ($attach_worker) {
            $responsible = $attach_worker->responsible;
            if ($responsible) {
                return $responsible;
            }
        }

        return $this->responsible;
    }

    public function component_parts()
    {
        return $this->belongsToMany('App\ComponentPart', 'work_place_component_part', 'work_place_id', 'component_part_id')->wherePivot('attach', 1);
    }

    public function get_status()
    {
        $status = 'На складе';

        if ($this->is_attach_to_worker()) {
            $status = 'Выдано';
        }

        return $status;
    }
}