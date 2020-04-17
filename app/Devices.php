<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;

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

    public function responsible()
    {
        return $this->hasOne('App\Responsibles', 'id', 'responsible_id');
    }

    public function provider()
    {
        return $this->hasOne('App\Providers', 'id', 'provider_id');
    }

    public function category()
    {
        return $this->hasOne('App\Categories', 'id', 'category_id');
    }

    public function write_off()
    {
        $current_date = new DateTime();
        $current_date_timestamp = $current_date->getTimestamp();
        if ($current_date_timestamp - $this->receipt_date > 864000) {
            return true;
        }
        else {
            return false;
        }
    }

    public function attach_to_worker()
    {
        if ($this->device_worker()->orderby('id', 'desc')->first()->attach) {
            return true;
        }
    }
}
