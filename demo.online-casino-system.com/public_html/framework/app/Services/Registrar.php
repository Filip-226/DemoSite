<?php namespace App\Services;

use App\User;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		Validator::extend('accepted_referer_name', function ($attribute, $value, $parameters) {
			if($value != "") {
				
				die("Referer name not exist!");
			}
			//$accepted_emails = [
			//	'email1@example.com',
			//	'email2@example.com'
			//];
			//$is_accepted = in_array($value, $accepted_emails);
			//return $is_accepted;
		});

		return Validator::make($data, [
			'name' => 'required|max:255|unique:users',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed|min:8',
			'contact_no' => 'required',
			'referer_name' => 'exists:users,name'
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
		return User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
			'contact_no' => $data['contact_no'],
			'referer_name' => $data['referer_name'],
			'ip_address' => $_SERVER['REMOTE_ADDR'],
			'code' => $data['code']
			//'bank_id' => $data['bank_id'],
			//'bank_account' => $data['bank_account'],
			//'bank_fullname' => $data['bank_fullname'],
		]);
	}

}
