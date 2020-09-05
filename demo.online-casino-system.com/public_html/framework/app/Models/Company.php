<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Company extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'company';

	protected $primaryKey = 'company_id';

	protected $softDelete = true;

	public function scopeGetAllCompanyBank($query)
    {
        return $query->select('bank.name as bank_name',
        					  'company.*')
        			 ->join('bank', 'company.bank_id', '=', 'bank.bank_id')
        			 ->orderBy('company.company_id', 'asc');
    }

    public function scopeSearchCompanyBankByDetails($query, $bank_name, $bank_account, $bank_fullname)
    {
        return $query->select('bank.name as bank_name',
        					  'company.*')
        			 ->join('bank', 'company.bank_id', '=', 'bank.bank_id')
        			 ->where('bank.name', 'like', '%'.$bank_name.'%')
        			 ->where('company.bank_account', 'like', '%'.$bank_account.'%')
        			 ->where('company.bank_fullname', 'like', '%'.$bank_fullname.'%')
        			 ->orderBy('company_id', 'asc');
    }
}
