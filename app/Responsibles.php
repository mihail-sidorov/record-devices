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
        return $this->belongsTo('App\Departments', 'department_id')->withDefault([
            'name' => 'К данному ответственному не прикреплен отдел!',
        ]);
    }
}
