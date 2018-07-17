<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskAssign extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'task_assigns';

	/**
	 * The database primary key value.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id';

	/**
	 * Attributes that should be mass-assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['task_id', 'user_id'];

	public function task(){
		return $this->belongsTo('App\Task');
	}

	public function user(){
		return $this->belongsTo('App\User');
	}
}
