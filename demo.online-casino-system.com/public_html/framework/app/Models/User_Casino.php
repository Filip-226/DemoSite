<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class User_Casino extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user_casino';

	protected $primaryKey = 'user_casino_id';

	protected $softDelete = true;
	
	public function scopeGetAllCasino($query)
    {
        return $query->join('casino', 'casino.casino_id', '=', 'user_casino.casino_id')->orderBy('casino.casino_id', 'asc');
    }
	
	public function scopeGetAllUserCasino($query, $user_id)
    {
        return $query->join('casino', 'casino.casino_id', '=', 'user_casino.casino_id')->where('user_id', '=', $user_id);
    }
}
