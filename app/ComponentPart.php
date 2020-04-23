<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use App\DeviceComponentPart;

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

    public function warranty_off()
    {
        $d = new DateTime();
        $current_date_timestamp = $d->getTimestamp();
        if ($this->warranty - $current_date_timestamp <= 0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function provider()
    {
        return $this->hasOne('App\Providers', 'id', 'provider_id');
    }

    public function category()
    {
        return $this->hasOne('App\Categories', 'id', 'category_id');
    }

    public function is_attach()
    {
        if (DeviceComponentPart::where([['component_part_id', $this->id], ['attach', 1]])->count()) {
            return true;
        }
        else {
            return false;
        }
    }
}
