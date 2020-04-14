<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
