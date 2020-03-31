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
        return $this->belongsTo('App\Departments', 'department_id')->withDefault([
            'name' => 'К данному сотруднику не прикреплен отдел!',
        ]);
    }
}
