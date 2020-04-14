<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Responsibles extends Model
{
    /**
     * Таблица, связанная с моделью.
     *
     * @var string
     */
    protected $table = 'responsibles';

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
}
