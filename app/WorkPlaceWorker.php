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
}
