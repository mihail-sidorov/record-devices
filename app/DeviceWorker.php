<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceWorker extends Model
{
    /**
     * Таблица, связанная с моделью.
     *
     * @var string
     */
    protected $table = 'device_worker';

    /**
     * Определяет необходимость отметок времени для модели.
     *
     * @var bool
     */
    public $timestamps = false;
}
