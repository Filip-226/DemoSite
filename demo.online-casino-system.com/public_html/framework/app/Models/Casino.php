<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Casino extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'casino';

	protected $primaryKey = 'casino_id';

	protected $softDelete = true;

	public function scopeGetAllCasino($query)
    {
        return $query->orderBy('name', 'asc');
    }

    public function scopeGetAllEnabledCasino($query)
    {
        return $query->where('is_enabled', '=', 1)
        			 ->orderBy('name', 'asc');
    }

    public function scopeSearchCasinoByName($query, $name)
    {
        return $query->where('name', 'like', '%'.$name.'%')
        			 ->orderBy('name', 'asc');
    }
}
