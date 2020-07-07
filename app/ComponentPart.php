<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use App\WorkPlaceComponentPart;

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

    public function write_off()
    {
        $d = new DateTime();
        $current_date_timestamp = $d->getTimestamp();
        if ($current_date_timestamp - $this->receipt_date > config('app.write_off_time')) {
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

    public function responsible()
    {
        return $this->hasOne('App\Responsibles', 'id', 'responsible_id');
    }

    public function is_attach()
    {
        if (WorkPlaceComponentPart::where([['component_part_id', $this->id], ['attach', 1]])->count()) {
            return true;
        }
        else {
            return false;
        }
    }

    public function is_attach_to_worker()
    {
        $work_place = $this->get_work_place();

        if ($work_place && $work_place->is_attach_to_worker()) {
            return true;
        }
        else return false;
    }

    public function get_work_place()
    {
        $work_place_component_part = WorkPlaceComponentPart::where([['component_part_id', $this->id], ['attach', 1]])->first();
        if ($work_place_component_part) {
            return WorkPlace::find($work_place_component_part->work_place_id);
        }
        else {
            return null;
        }
    }

    public function get_responsible()
    {
        $work_place = $this->get_work_place();
        if ($work_place) {
            return $work_place->get_responsible();
        }
        else {
            return $this->responsible;
        }
    }

    public function get_status()
    {
        $status = 'На складе';

        if ($this->write_off()) {
            $status = 'Списано';
        }

        $work_place = $this->get_work_place();
        
        if ($work_place && $work_place->is_attach_to_worker()) {
            $status = 'Выдано';
        }

        return $status;
    }
}
