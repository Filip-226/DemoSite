<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Transaction extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'transaction';

	protected $primaryKey = 'transaction_id';

	protected $softDelete = true;

	public function scopeGetTransactionList($query)
    {
        return $query->select('transaction.transaction_id as transaction_id'
        						, 'transaction.action as action'
        						, 'transaction.amount as amount'
        						, 'transaction.created_at as transaction_date'
        						, 'transaction.casino_no as casino_no'
        						, 'bank.name as bank_name'
        						, 'casino.name as casino_name'
        						, 'users.name as user_name')
        			 ->join('bank', 'transaction.bank_id', '=', 'bank.bank_id')
        			 ->join('casino', 'transaction.casino_id', '=', 'casino.casino_id')
        			 ->join('users', 'transaction.user_id', '=', 'users.user_id')
                     ->orderBy('transaction.created_at', 'desc');
    }
	
	public function scopeGetPendingTopupList($query)
    {
        return $query->select('transaction.transaction_id as transaction_id'
        						, 'transaction.action as action'
        						, 'transaction.amount as amount'
        						, 'transaction.created_at as transaction_date'
        						, 'transaction.casino_no as casino_no'
        						, 'bank.name as bank_name'
        						, 'casino.name as casino_name'
        						, 'users.name as user_name')
        			 ->join('bank', 'transaction.bank_id', '=', 'bank.bank_id')
        			 ->join('casino', 'transaction.casino_id', '=', 'casino.casino_id')
        			 ->join('users', 'transaction.user_id', '=', 'users.user_id')
					 ->where('action', '=', '1')
					 ->where('transaction.is_verified', '=', '0')
                     ->orderBy('transaction.created_at', 'asc');
    }
	
	public function scopeGetPendingWithdrawList($query)
    {
        return $query->select('transaction.transaction_id as transaction_id'
        						, 'transaction.action as action'
        						, 'transaction.amount as amount'
        						, 'transaction.created_at as transaction_date'
        						, 'transaction.casino_no as casino_no'
        						, 'bank.name as bank_name'
        						, 'casino.name as casino_name'
        						, 'users.name as user_name')
        			 ->join('bank', 'transaction.bank_id', '=', 'bank.bank_id')
        			 ->join('casino', 'transaction.casino_id', '=', 'casino.casino_id')
        			 ->join('users', 'transaction.user_id', '=', 'users.user_id')
					 ->where('action', '=', '2')
					 ->where('transaction.is_verified', '=', '0')
                     ->orderBy('transaction.created_at', 'asc');
    }

    public function scopeGetUserTransactionList($query, $user_id)
    {
        return $query->select('transaction.transaction_id as transaction_id'
                                , 'transaction.action as action'
                                , 'transaction.amount as amount'
                                , 'transaction.is_verified as is_verified'
                                , 'transaction.created_at as transaction_date'
                                , 'bank.name as bank_name'
                                , 'casino.name as casino_name'
                                , 'users.name as user_name')
                     ->join('bank', 'transaction.bank_id', '=', 'bank.bank_id')
                     ->join('casino', 'transaction.casino_id', '=', 'casino.casino_id')
                     ->join('users', 'transaction.user_id', '=', 'users.user_id')
                     ->where('transaction.user_id', '=', $user_id)
                     ->orderBy('transaction.created_at', 'asc');
    }

    public function scopeGetTransaction($query, $transaction_id)
    {
        return $query->select('transaction.transaction_id as transaction_id'
        						, 'transaction.action as action'
        						, 'transaction.amount as amount'
                                , 'transaction.bank_account as bank_account'
                                , 'transaction.bank_fullname as bank_fullname'
                                , 'transaction.image_location as image_location'
                                , 'transaction.remark as remark'
        						, 'transaction.created_at as transaction_date'
        						, 'transaction.casino_no as casino_no'
                                , 'transaction.bank_id as bank_id'
                                , 'transaction.casino_id as casino_id'
        						, 'bank.fullname as bank_name'
        						, 'casino.fullname as casino_name'
        						, 'users.name as user_name'
        						, 'users.email as user_email')
        			 ->join('bank', 'transaction.bank_id', '=', 'bank.bank_id')
        			 ->join('casino', 'transaction.casino_id', '=', 'casino.casino_id')
        			 ->join('users', 'transaction.user_id', '=', 'users.user_id')
        			 ->where('transaction.transaction_id', '=', $transaction_id)
                     ->orderBy('transaction.created_at', 'asc');
    }

    public function scopeSearchTransactionListByDetails($query, $user_name, $casino_id, $transaction_action, $transaction_amount, $transaction_start_date, $transaction_end_date, $list_order)
    {
        return $query->select('transaction.transaction_id as transaction_id'
        						, 'transaction.action as action'
        						, 'transaction.amount as amount'
        						, 'transaction.created_at as transaction_date'
        						, 'bank.name as bank_name'
        						, 'casino.name as casino_name'
        						, 'users.name as user_name')
        			 ->join('bank', 'transaction.bank_id', '=', 'bank.bank_id')
        			 ->join('casino', 'transaction.casino_id', '=', 'casino.casino_id')
        			 ->join('users', 'transaction.user_id', '=', 'users.user_id')
        			 ->where('users.name', 'like', '%'.$user_name.'%')
        			 ->where('casino.casino_id', 'like', '%'.$casino_id.'%')
        			 ->whereIn('transaction.action', $transaction_action)
        			 ->whereBetween('transaction.amount', [0, $transaction_amount])
                     ->whereBetween('transaction.created_at', [$transaction_start_date, $transaction_end_date])
                     ->orderBy('transaction.created_at', $list_order);
    }

    public function scopeSearchUserTransactionListByDetails($query, $user_name, $casino_id, $transaction_action, $transaction_amount, $transaction_start_date, $transaction_end_date, $list_order, $user_id)
    {
        return $query->select('transaction.transaction_id as transaction_id'
                                , 'transaction.action as action'
                                , 'transaction.amount as amount'
                                , 'transaction.created_at as transaction_date'
                                , 'bank.name as bank_name'
                                , 'casino.name as casino_name'
                                , 'users.name as user_name')
                     ->join('bank', 'transaction.bank_id', '=', 'bank.bank_id')
                     ->join('casino', 'transaction.casino_id', '=', 'casino.casino_id')
                     ->join('users', 'transaction.user_id', '=', 'users.user_id')
                     ->where('users.name', 'like', '%'.$user_name.'%')
                     ->where('casino.casino_id', 'like', '%'.$casino_id.'%')
                     ->whereIn('transaction.action', $transaction_action)
                     ->whereBetween('transaction.amount', [0, $transaction_amount])
                     ->whereBetween('transaction.created_at', [$transaction_start_date, $transaction_end_date])
                     ->where('transaction.user_id', '=', $user_id)
                     ->orderBy('transaction.created_at', $list_order);
    }

    public function scopeDeleteTransactionList($query, $transaction_list)
    {
    	return $query->whereIn('transaction_id', $transaction_list)
    				 ->delete();
    }

}
