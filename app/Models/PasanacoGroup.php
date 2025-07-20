<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PasanacoGroup
 *
 * @property $id
 * @property $name
 * @property $start_date
 * @property $frequency
 * @property $custom_days_interval
 * @property $day_of_week
 * @property $day_of_month
 * @property $amount_per_participant
 * @property $status
 * @property $progress_percent
 * @property $settings
 * @property $created_at
 * @property $updated_at
 *
 * @property PasanacoGroupParticipant[] $pasanacoGroupParticipants
 * @property PasanacoSchedule[] $pasanacoSchedules
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class PasanacoGroup extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'start_date', 'frequency', 'custom_days_interval', 'day_of_week', 'day_of_month', 'amount_per_participant', 'status', 'progress_percent', 'settings'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pasanacoGroupParticipants()
    {
        return $this->hasMany(\App\Models\PasanacoGroupParticipant::class, 'id', 'pasanaco_group_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pasanacoSchedules()
    {
        return $this->hasMany(\App\Models\PasanacoSchedule::class, 'id', 'pasanaco_group_id');
    }
    
    public function pasanacoGroupDates()
    {
        return $this->hasMany(\App\Models\PasanacoGroupDate::class, 'pasanaco_group_id', 'id');
    }
    
}
