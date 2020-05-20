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
}
