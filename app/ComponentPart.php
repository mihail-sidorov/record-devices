<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComponentPart extends Model
{
    /**
     * Таблица, связанная с моделью.
     *
     * @var string
     */
    protected $table = 'component_parts';

    /**
     * Определяет необходимость отметок времени для модели.
     *
     * @var bool
     */
    public $timestamps = false;
}
