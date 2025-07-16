<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PasanacoGroupParticipant
 *
 * @property $id
 * @property $pasanaco_group_id
 * @property $participant_id
 * @property $status
 * @property $removal_reason
 * @property $joined_at
 * @property $removed_at
 * @property $created_at
 * @property $updated_at
 *
 * @property Participant $participant
 * @property PasanacoGroup $pasanacoGroup
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class PasanacoGroupParticipant extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['pasanaco_group_id', 'participant_id', 'status', 'removal_reason', 'joined_at', 'removed_at'];


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
    
}
