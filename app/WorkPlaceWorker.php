<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkPlaceWorker extends Model
{
    /**
     * Таблица, связанная с моделью.
     *
     * @var string
     */
    protected $table = 'work_place_worker';

    /**
     * Определяет необходимость отметок времени для модели.
     *
     * @var bool
     */
    public $timestamps = false;

    public function have_original_give_act()
    {
        if ($this->act_give_id !== null && Act::find($this->act_give_id)->document !== null) {
            return true;
        }
        
        return false;
    }

    public function have_original_return_act()
    {
        if ($this->act_return_id !== null && Act::find($this->act_return_id)->document !== null) {
            return true;
        }
        
        return false;
    }
}
