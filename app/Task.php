<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tasks';

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
	protected $fillable = ['name', 'description', 'status', 'user_id'];

	public function assigns(){
		return $this->hasMany('App\TaskAssign');
	}
	public function user(){
		return $this->belongsTo('App\User');
	}
}
