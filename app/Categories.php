<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    /**
     * Таблица, связанная с моделью.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * Определяет необходимость отметок времени для модели.
     *
     * @var bool
     */
    public $timestamps = false;

    public function devices()
    {
        return $this->hasMany('App\Devices', 'category_id', 'id');
    }

    public function component_parts()
    {
        return $this->hasMany('App\ComponentPart', 'category_id', 'id');
    }

    public function get_store_count()
    {
        $devices = $this->devices;
        $devices_count = count($devices);
        foreach ($devices as $device) {
            if ($device->write_off()) {
                $devices_count--;
            }
            elseif ($device->attach_to_worker()) {
                $devices_count--;
            }
        }

        return $devices_count;
    }
}
