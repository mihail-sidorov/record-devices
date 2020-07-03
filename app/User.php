<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPassword as ResetPasswordNotification;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function services()
    {
        return $this->hasMany('App\Service');
    }

    public function getWorkerId()
    {
        return Workers::where('user_id', $this->id)->value('id');
    }

    public function get_work_places()
    {
        return Workers::find($this->getWorkerId())->work_places;
    }

    public function get_devices()
    {
        return Workers::find($this->getWorkerId())->devices;
    }

    public function get_acts()
    {
        $act_give_ids_form_work_place_worker = WorkPlaceWorker::select('act_give_id')->where([['worker_id', $this->getWorkerId()], ['act_give_id', '<>', null]])->distinct()->pluck('act_give_id');
        $act_give_ids_form_device_worker = DeviceWorker::select('act_give_id')->where([['worker_id', $this->getWorkerId()], ['act_give_id', '<>', null]])->whereNotIn('act_give_id', $act_give_ids_form_work_place_worker)->distinct()->pluck('act_give_id');
        $act_give_ids = $act_give_ids_form_work_place_worker->merge($act_give_ids_form_device_worker );

        $act_return_ids_form_work_place_worker = WorkPlaceWorker::select('act_return_id')->where([['worker_id', $this->getWorkerId()], ['act_return_id', '<>', null]])->distinct()->pluck('act_return_id');
        $act_return_ids_form_device_worker = DeviceWorker::select('act_return_id')->where([['worker_id', $this->getWorkerId()], ['act_return_id', '<>', null]])->whereNotIn('act_return_id', $act_return_ids_form_work_place_worker)->distinct()->pluck('act_return_id');
        $act_return_ids = $act_return_ids_form_work_place_worker->merge($act_return_ids_form_device_worker );
        
        return Act::whereIn('id', $act_give_ids->merge($act_return_ids))->get();
    }
}
