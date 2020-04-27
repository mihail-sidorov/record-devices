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
        if (DeviceComponentPart::where([['component_part_id', $this->id], ['attach', 1]])->count()) {
            return true;
        }
        else {
            return false;
        }
    }

    public function get_device()
    {
        $device_component_part = DeviceComponentPart::where([['component_part_id', $this->id], ['attach', 1]])->first();
        if ($device_component_part) {
            return Devices::find($device_component_part->device_id);
        }
        else {
            return null;
        }
    }

    public function get_responsible()
    {
        $device = $this->get_device();
        if ($device) {
            return $device->get_responsible();
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

        $device = $this->get_device();
        
        if ($device && $device->attach_to_worker()) {
            $status = 'Выдано';
        }

        return $status;
    }
}
