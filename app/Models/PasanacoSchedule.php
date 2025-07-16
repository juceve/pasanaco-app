<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PasanacoSchedule
 *
 * @property $id
 * @property $pasanaco_group_id
 * @property $participant_id
 * @property $scheduled_date
 * @property $status
 * @property $adjusted
 * @property $adjustment_reason
 * @property $created_at
 * @property $updated_at
 *
 * @property Participant $participant
 * @property PasanacoGroup $pasanacoGroup
 * @property PasanacoScheduleChange[] $pasanacoScheduleChanges
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class PasanacoSchedule extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['pasanaco_group_id', 'participant_id', 'scheduled_date', 'status', 'adjusted', 'adjustment_reason'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function participant()
    {
        return $this->belongsTo(\App\Models\Participant::class, 'participant_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pasanacoGroup()
    {
        return $this->belongsTo(\App\Models\PasanacoGroup::class, 'pasanaco_group_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pasanacoScheduleChanges()
    {
        return $this->hasMany(\App\Models\PasanacoScheduleChange::class, 'id', 'pasanaco_schedule_id');
    }
    
}
