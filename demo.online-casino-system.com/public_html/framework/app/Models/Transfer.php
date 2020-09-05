<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Transfer extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'transfer';

	protected $primaryKey = 'transfer_id';

	protected $softDelete = true;

	public function scopeGetTransferList($query)
    {
        return $query->select('transfer.transfer_id as transfer_id'
                                , 'transfer.amount as amount'
                                , 'transfer.is_verified as is_verified'
                                , 'transfer.created_at as transfer_date'
                                , 'from.name as from_name'
                                , 'transfer.from_casino_no as from_casino_no'
                                , 'to.name as to_name'
                                , 'transfer.to_casino_no as to_casino_no'
                                , 'users.name as user_name')
                     ->join('casino as from', 'transfer.from_acc', '=', 'from.casino_id')
                     ->join('casino as to', 'transfer.to_acc', '=', 'to.casino_id')
                     ->join('users', 'transfer.user_id', '=', 'users.user_id')
					 ->where('transfer.is_verified', '=', '0')
                     ->orderBy('transfer.created_at', 'asc');
        /*return $query->select('transfer.transfer_id as transaction_id'
        						, 'transaction.action as action'
        						, 'transaction.amount as amount'
        						, 'transaction.created_at as transaction_date'
        						, 'casino.name as casino_name'
        						, 'users.name as user_name')
        			 ->join('casino', 'transaction.casino_id', '=', 'casino.casino_id')
        			 ->join('users', 'transaction.user_id', '=', 'users.user_id')
                     ->orderBy('transaction.created_at', 'asc');*/
    }
	
	public function scopeGetTransferHistoryList($query)
    {
        return $query->select('transfer.transfer_id as transfer_id'
                                , 'transfer.amount as amount'
                                , 'transfer.created_at as transfer_date'
                                , 'from.name as from_name'
                                , 'to.name as to_name'
                                , 'users.name as user_name')
                     ->join('casino as from', 'transfer.from_acc', '=', 'from.casino_id')
                     ->join('casino as to', 'transfer.to_acc', '=', 'to.casino_id')
                     ->join('users', 'transfer.user_id', '=', 'users.user_id')
					 ->where('transfer.is_verified', '!=', '0')
                     ->orderBy('transfer.created_at', 'asc');
        /*return $query->select('transfer.transfer_id as transaction_id'
        						, 'transaction.action as action'
        						, 'transaction.amount as amount'
        						, 'transaction.created_at as transaction_date'
        						, 'casino.name as casino_name'
        						, 'users.name as user_name')
        			 ->join('casino', 'transaction.casino_id', '=', 'casino.casino_id')
        			 ->join('users', 'transaction.user_id', '=', 'users.user_id')
                     ->orderBy('transaction.created_at', 'asc');*/
    }
	
	/*public function scopeGetPendingTopupList($query)
    {
        return $query->select('transfer.transfer_id as transfer_id'
        						, 'transfer.action as action'
        						, 'transfer.amount as amount'
        						, 'transfer.created_at as transfer_date'
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
        						, 'bank.name as bank_name'
        						, 'casino.name as casino_name'
        						, 'users.name as user_name')
        			 ->join('bank', 'transaction.bank_id', '=', 'bank.bank_id')
        			 ->join('casino', 'transaction.casino_id', '=', 'casino.casino_id')
        			 ->join('users', 'transaction.user_id', '=', 'users.user_id')
					 ->where('action', '=', '2')
					 ->where('transaction.is_verified', '=', '0')
                     ->orderBy('transaction.created_at', 'asc');
    }*/

    public function scopeGetUserTransferList($query, $user_id)
    {
        return $query->select('transfer.transfer_id as transfer_id'
                                , 'transfer.amount as amount'
                                , 'transfer.is_verified as is_verified'
                                , 'transfer.created_at as transfer_date'
                                , 'from.name as from_name'
                                , 'to.name as to_name'
                                , 'users.name as user_name')
                     ->join('casino as from', 'transfer.from_acc', '=', 'from.casino_id')
                     ->join('casino as to', 'transfer.to_acc', '=', 'to.casino_id')
                     ->join('users', 'transfer.user_id', '=', 'users.user_id')
                     ->where('transfer.user_id', '=', $user_id)
                     ->orderBy('transfer.created_at', 'asc');
    }

    public function scopeGetTransfer($query, $transfer_id)
    {
        return $query->select('transfer.transfer_id as transfer_id'
                                , 'transfer.amount as amount'
                                , 'transfer.from_acc as from_acc'
                                , 'transfer.to_acc as to_acc'
                                , 'transfer.remark as remark'
                                , 'transfer.created_at as transfer_date'
                                , 'from.name as from_name'
                                , 'transfer.from_casino_no as from_casino_no'
                                , 'to.name as to_name'
                                , 'transfer.to_casino_no as to_casino_no'
                                , 'users.name as user_name')
                     ->join('casino as from', 'transfer.from_acc', '=', 'from.casino_id')
                     ->join('casino as to', 'transfer.to_acc', '=', 'to.casino_id')
                     ->join('users', 'transfer.user_id', '=', 'users.user_id')
        			 ->where('transfer.transfer_id', '=', $transfer_id)
                     ->orderBy('transfer.created_at', 'asc');
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

    public function scopeSearchUserTransferListByDetails($query, $from, $to, $transfer_amount, $transfer_start_date, $transfer_end_date, $list_order, $user_id)
    {
        return $query->select('transfer.transfer_id as transfer_id'
                                , 'transfer.from_acc as from_acc'
                                , 'transfer.to_acc as to_acc'
                                , 'transfer.amount as amount'
                                , 'transfer.remark as remark'
                                , 'transfer.created_at as transfer_date'
                                , 'from.name as from_name'
                                , 'to.name as to_name'
                                , 'users.name as user_name')
                     ->join('casino as from', 'transfer.from_acc', '=', 'from.casino_id')
                     ->join('casino as to', 'transfer.to_acc', '=', 'to.casino_id')
        			 ->join('users', 'transfer.user_id', '=', 'users.user_id')
                     ->where('transfer.from_acc', 'LIKE', '%' . $from . '%')
                     ->where('transfer.to_acc', 'LIKE', '%' . $to . '%')
                     ->whereBetween('transfer.amount', [0, $transfer_amount])
                     ->whereBetween('transfer.created_at', [$transfer_start_date, $transfer_end_date])
                     ->where('transfer.user_id', '=', $user_id)
                     ->orderBy('transfer.created_at', $list_order);
    }

    public function scopeDeleteTransactionList($query, $transaction_list)
    {
    	return $query->whereIn('transaction_id', $transaction_list)
    				 ->delete();
    }

}
