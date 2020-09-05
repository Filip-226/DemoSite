<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Transaction_History extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'transaction_history';

	protected $primaryKey = 'history_id';

	protected $softDelete = true;

	public function scopeGetTransactionHistoryById($query, $transaction_id)
	{
		return $query->where('transaction_id', '=', $transaction_id);
	}

	public function scopeGetTransactionHistoryList($query)
    {
        return $query->select('transaction_history.history_id as history_id'
                                , 'transaction_history.action as action'
        						, 'transaction_history.amount as amount'
                                , 'transaction_history.is_verified as is_verified'
        						, 'transaction_history.created_at as transaction_date'
        						, 'transaction_history.updated_at as verified_date'
						, 'transaction_history.casino_no as casino_no'
        						, 'bank.fullname as bank_name'
        						, 'casino.fullname as casino_name'
        						, 'users.name as user_name')
        			 ->join('bank', 'transaction_history.bank_id', '=', 'bank.bank_id')
        			 ->join('casino', 'transaction_history.casino_id', '=', 'casino.casino_id')
        			 ->join('users', 'transaction_history.user_id', '=', 'users.user_id')
        			 ->whereIn('transaction_history.is_verified', array(1,2))
                     ->orderBy('transaction_history.created_at', 'desc');
    }

    public function scopeGetUserTransactionHistoryList($query, $user_id)
    {
        return $query->select('transaction_history.history_id as history_id'
                                , 'transaction_history.action as action'
                                , 'transaction_history.amount as amount'
                                , 'transaction_history.is_verified as is_verified'
                                , 'transaction_history.created_at as transaction_date'
                                , 'transaction_history.updated_at as verified_date'
                                , 'transaction_history.casino_no as casino_no'
                                , 'bank.fullname as bank_name'
                                , 'casino.fullname as casino_name'
                                , 'users.name as user_name')
                     ->join('bank', 'transaction_history.bank_id', '=', 'bank.bank_id')
                     ->join('casino', 'transaction_history.casino_id', '=', 'casino.casino_id')
                     ->join('users', 'transaction_history.user_id', '=', 'users.user_id')
                     ->whereIn('transaction_history.is_verified', array(1,2))
                     ->where('transaction_history.user_id', '=', $user_id)
                     ->orderBy('transaction_history.created_at', 'desc');
    }

    public function scopeGetTransactionHistory($query, $history_id)
    {
        return $query->select('transaction_history.history_id as history_id'
                                , 'transaction_history.action as action'
                                , 'transaction_history.amount as amount'
                                , 'transaction_history.bank_account as bank_account'
                                , 'transaction_history.bank_fullname as bank_fullname'
                                , 'transaction_history.image_location as image_location'
                                , 'transaction_history.remark as remark'
                                , 'transaction_history.is_verified as is_verified'
                                , 'transaction_history.casino_no as casino_no'
                                , 'transaction_history.comment as comment'
                                , 'transaction_history.created_at as transaction_date'
                                , 'transaction_history.updated_at as verified_date'
                                , 'bank.fullname as bank_name'
                                , 'casino.fullname as casino_name'
                                , 'users.name as user_name'
                                , 'users.email as user_email')
                     ->join('bank', 'transaction_history.bank_id', '=', 'bank.bank_id')
                     ->join('casino', 'transaction_history.casino_id', '=', 'casino.casino_id')
                     ->join('users', 'transaction_history.user_id', '=', 'users.user_id')
                     ->where('transaction_history.history_id', '=', $history_id)
                     ->whereIn('transaction_history.is_verified', array(1,2))
                     ->orderBy('transaction_history.created_at', 'asc');
    }

    public function scopeSearchTransactionHistoryListByDetails($query, $user_name, $casino_id, $status, $transaction_action, $transaction_amount, $transaction_start_date, $transaction_end_date, $verified_start_date, $verified_end_date, $list_order)
    {
        return $query->select('transaction_history.history_id as history_id'
                                , 'transaction_history.action as action'
                                , 'transaction_history.amount as amount'
                                , 'transaction_history.is_verified as is_verified'
                                , 'transaction_history.created_at as transaction_date'
                                , 'transaction_history.updated_at as verified_date'
                                , 'transaction_history.casino_no as casino_no'
                                , 'bank.fullname as bank_name'
                                , 'casino.fullname as casino_name'
                                , 'users.name as user_name')
                     ->join('bank', 'transaction_history.bank_id', '=', 'bank.bank_id')
                     ->join('casino', 'transaction_history.casino_id', '=', 'casino.casino_id')
                     ->join('users', 'transaction_history.user_id', '=', 'users.user_id')
                     ->where('users.name', 'like', '%'.$user_name.'%')
                     ->where('casino.casino_id', 'like', '%'.$casino_id.'%')
                     ->whereIn('transaction_history.action', $transaction_action)
                     ->whereBetween('transaction_history.amount', [0, $transaction_amount])
                     ->whereBetween('transaction_history.created_at', [$transaction_start_date, $transaction_end_date])
                     ->whereBetween('transaction_history.updated_at', [$verified_start_date, $verified_end_date])
                     ->whereIn('transaction_history.is_verified', $status)
                     ->orderBy('transaction_history.created_at', $list_order);
    }

    public function scopeSearchUserTransactionHistoryListByDetails($query, $user_name, $casino_id, $status, $transaction_action, $transaction_amount, $transaction_start_date, $transaction_end_date, $verified_start_date, $verified_end_date, $list_order, $user_id)
    {
        return $query->select('transaction_history.history_id as history_id'
                                , 'transaction_history.action as action'
                                , 'transaction_history.amount as amount'
                                , 'transaction_history.is_verified as is_verified'
                                , 'transaction_history.created_at as transaction_date'
                                , 'transaction_history.updated_at as verified_date'
                                , 'transaction_history.casino_no as casino_no'
                                , 'bank.fullname as bank_name'
                                , 'casino.fullname as casino_name'
                                , 'users.name as user_name')
                     ->join('bank', 'transaction_history.bank_id', '=', 'bank.bank_id')
                     ->join('casino', 'transaction_history.casino_id', '=', 'casino.casino_id')
                     ->join('users', 'transaction_history.user_id', '=', 'users.user_id')
                     ->where('users.name', 'like', '%'.$user_name.'%')
                     ->where('casino.casino_id', 'like', '%'.$casino_id.'%')
                     ->whereIn('transaction_history.action', $transaction_action)
                     ->whereBetween('transaction_history.amount', [0, $transaction_amount])
                     ->whereBetween('transaction_history.created_at', [$transaction_start_date, $transaction_end_date])
                     ->whereBetween('transaction_history.updated_at', [$verified_start_date, $verified_end_date])
                     ->whereIn('transaction_history.is_verified', $status)
                     ->where('transaction_history.user_id', '=', $user_id)
                     ->orderBy('transaction_history.created_at', $list_order);
    }

    public function scopeUpdateVerifiedTransactionHistoryList($query, $transaction_list, $verify_action, $verify_comment)
    {
    	return $query->whereIn('transaction_id', $transaction_list)
    				 ->update(array('is_verified' => $verify_action
                                    , 'comment' => $verify_comment));
    }

    public function scopeGetTransactionAmount($query, $date, $action)
    {
        return $query->where('updated_at', '>=', $date)
                     ->where('is_verified', '=', '1')
                     ->where('action', '=', $action);
    }

    public function scopeGetUserTransactionAmount($query, $date, $action, $user_id)
    {
        return $query->where('updated_at', '>=', $date)
                     ->where('action', '=', $action)
                     ->where('user_id', '=', $user_id);
    }
}
