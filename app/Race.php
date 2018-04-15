<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
	protected $table = 'races';

	protected $fillable = ['meeting_id', 'name', 'close_time'];

	public function getDates()
	{
	    return ['close_time'];
	}

	public function meeting()
    {
        return $this->belongsTo('App\Meeting', 'meeting_id', 'id');
    }

    public function competitors()
    {
        return $this->belongsToMany('App\Competitor', 'race_competitors', 'race_id', 'competitor_id')->withPivot('position');
    }
}
