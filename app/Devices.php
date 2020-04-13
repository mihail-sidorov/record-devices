<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Devices extends Model
{
    /**
     * Таблица, связанная с моделью.
     *
     * @var string
     */
    protected $table = 'devices';

    /**
     * Определяет необходимость отметок времени для модели.
     *
     * @var bool
     */
    public $timestamps = false;

    public function device_worker()
    {
        return $this->hasMany('App\DeviceWorker', 'device_id', 'id');
    }
}
