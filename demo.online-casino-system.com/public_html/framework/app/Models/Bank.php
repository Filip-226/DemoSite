<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Bank extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'bank';

	protected $primaryKey = 'bank_id';

	protected $softDelete = true;

	public function scopeGetAllBank($query)
    {
        return $query->orderBy('name', 'asc');
    }

    public function scopeSearchBankByName($query, $name)
    {
        return $query->where('name', 'like', '%'.$name.'%')
        			 ->orderBy('name', 'asc');
    }
}
