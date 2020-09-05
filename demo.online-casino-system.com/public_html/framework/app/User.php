<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	protected $primaryKey = 'user_id';

	protected $softDelete = true;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password', 'contact_no', 'bank_id', 'bank_account', 'bank_fullname', 'referer_name', 'ip_address', 'code'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];
	
	public function scopeGetAllUser($query)
    {
        return $query->selectRaw('users.*, bank.name as bank_name')->leftJoin('bank', 'bank.bank_id', '=', 'users.bank_id')->orderBy('users.created_at', 'desc');
    }

	public function scopeSearchUserByName($query, $name, $email, $contact, $ipaddress)
    {
        return $query->where('name', 'like', '%'.$name.'%')
        			 ->where('email', 'like', '%'.$email.'%')
        			 ->where('contact_no', 'like', '%'.$contact.'%')
        			 ->where('ip_address', 'like', '%'.$ipaddress.'%')
        			 ->orderBy('name', 'asc');
    }

    public function scopeSearchUserByEmail($query, $email)
    {
        return $query->where('email', '=', $email);
    }

    public function scopeSearchUserByBankAccount($query, $bank_account)
    {
        return $query->where('bank_account', '=', $bank_account);
    }

    public function scopeGetLatestUserList($query)
    {
    	return $query->orderBy('created_at', 'desc')
    				 ->take(10);	
    }
	
    public function scopeGetPendingVerifyUserList($query)
    {
    	return $query->where('is_verified', '=', '0')->orderBy('created_at', 'desc');
    }
}
