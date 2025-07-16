<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PasanacoScheduleChange
 *
 * @property $id
 * @property $pasanaco_schedule_id
 * @property $action
 * @property $details
 * @property $changed_at
 *
 * @property PasanacoSchedule $pasanacoSchedule
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class PasanacoScheduleChange extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['pasanaco_schedule_id', 'action', 'details', 'changed_at'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pasanacoSchedule()
    {
        return $this->belongsTo(\App\Models\PasanacoSchedule::class, 'pasanaco_schedule_id', 'id');
    }
    
}
