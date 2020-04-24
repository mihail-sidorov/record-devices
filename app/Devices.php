<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use App\Workers;

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
        $d = new DateTime();
        $current_date_timestamp = $d->getTimestamp();
        if ($current_date_timestamp - $this->receipt_date > config('app.write_off_time')) {
            return true;
        }
        else {
            return false;
        }
    }

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

    public function attach_to_worker()
    {
        $device_worker = $this->device_worker()->orderby('id', 'desc')->first();
        if ($device_worker && $device_worker->attach) {
            return true;
        }

        return false;
    }

    public function get_attach_worker()
    {
        $device_worker = $this->device_worker()->orderby('id', 'desc')->first();
        if ($device_worker && $device_worker->attach) {
            return Workers::find($device_worker->worker_id);
        }

        return null;
    }

    public function get_responsible()
    {
        $attach_worker = $this->get_attach_worker();
        if ($attach_worker) {
            $responsible = $attach_worker->responsible;
            if ($responsible) {
                return $responsible;
            }
        }

        return $this->responsible;
    }

    public function get_status()
    {
        $status = 'На складе';

        if ($this->write_off()) {
            $status = 'Списано';
        }

        if ($this->attach_to_worker()) {
            $status = 'Выдано';
        }

        return $status;
    }

    public function component_parts()
    {
        return $this->belongsToMany('App\ComponentPart', 'device_component_part', 'device_id', 'component_part_id')->wherePivot('attach', 1);
    }
}
