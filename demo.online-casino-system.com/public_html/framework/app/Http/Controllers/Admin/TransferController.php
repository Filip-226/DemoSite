<?php namespace App\Http\Controllers\Admin;

use Auth;
use App\User;
use App\Models\Bank;
use App\Models\Casino;
use App\Models\Company;
use App\Models\Transfer;
use App\Models\Transaction;
use App\Models\Transaction_History;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class TransferController extends BaseController {

	private $paginate = 30;
	private $redirectTo = 'panel.admin.transfer_manage';

	public function __construct()
	{
		$this->middleware('auth');

		if(session()->has('locale')){
			\App::setLocale(\Session::get('locale'));
		}
		else{
			$lang = \Config('app.fallback_locale');
			\App::setLocale($lang);
			\Session::put('locale', $lang);
		}
	}

	public function index()
	{	
		$transfer_list = Transfer::GetTransferList()
						->paginate($this->paginate);
		$transfer_list->setPath('pending');
		$casino_list = Casino::GetAllCasino()->get();

		return view('admin.transfer_list')
				->with('transfer_list', $transfer_list)
				->with('casino_list', $casino_list)
				->with('fullscreen', '0');
	}

	public function view($id) 
	{	
		$transfer = Transfer::GetTransfer($id)->first();

		return \View::make('admin.transfer_details')
				->with('transfer', $transfer)
				->with('fullscreen', '0');
	}

	public function verify($id) 
	{	
		try
		{
			$verify_comment = \Input::get('comment_txt');
			$verify_action = 1;
			if(\Input::has('approve_btn'))
				$verify_action = 1;
			else if(\Input::has('reject_btn'))
				$verify_action = 2;

			$transfer = Transfer::find($id);
			$transfer->comment = $verify_comment;
			$transfer->is_verified = $verify_action;
			$transfer->verified_date = date('Y-m-d H:i:s');
			$transfer->save();

			return \Redirect::route($this->redirectTo)
							->with('message', \Lang::get('transfer.verified_transfer_msg'));
		}
		catch(Exception $e)
		{
			return \Redirect::back()
							->with('error_message', $e->getMessage());
		}
	}
	
	public function history()
	{	
		$transfer_list = Transfer::GetTransferHistoryList()
						->paginate($this->paginate);
		$transfer_list->setPath('pending');
		$casino_list = Casino::GetAllCasino()->get();

		return view('admin.transfer_history_list')
				->with('transfer_list', $transfer_list)
				->with('casino_list', $casino_list)
				->with('fullscreen', '0');
	}
	
	/*public function actions() 
	{
		if(\Input::has('search_btn'))
		{	
			$user_name = \Input::get('username_search_txt');
			$casino_id = \Input::get('casinoname_search_sel');
			$transaction_action = (\Input::get('action_search_sel') == "") ? $transaction_action = array(1, 2) : array((int)\Input::get('action_search_sel'));
			$transaction_amount = (\Input::get('amount_search_txt') == "") ? 1000000000 : \Input::get('amount_search_txt');
			
			$transaction_year = \Input::get('year_search_sel');
			$transaction_month = \Input::get('month_search_sel');
			$is_transactiondate_empty = false;
			$is_transactionmonth_empty = false;
			if($transaction_year == "" && $transaction_month == "")
			{
				$transaction_year = '2000';
				$transaction_month = '01';
				$is_transactiondate_empty = true;
				$is_transactionmonth_empty = true;
			}
			else
			{
				$transaction_year = (\Input::get('year_search_sel') == "") ? date('Y') : \Input::get('year_search_sel');
				$transaction_month = (\Input::get('month_search_sel') == "") ? '01' : \Input::get('month_search_sel');
				$is_transactiondate_empty = false;
				$is_transactionmonth_empty = (\Input::get('month_search_sel') == "") ? true : false;
			}
			$transaction_start_date = $transaction_year.'-'.$transaction_month.'-01 00:00:00';
			$transaction_end_date = $this->get_end_date($transaction_year, $transaction_month, $is_transactiondate_empty, $is_transactionmonth_empty);

			$list_order = \Input::get('list_order_sel');

			$transaction_list = Transaction::SearchTransactionListByDetails($user_name, $casino_id, $transaction_action, $transaction_amount, $transaction_start_date, $transaction_end_date, $list_order)
								->paginate($this->paginate);
			$transaction_list->setPath('actions');
			$casino_list = Casino::GetAllCasino()->get();

			return view('admin.transaction_list')
						->with('transaction_list', $transaction_list)
						->with('casino_list', $casino_list)
						->with('fullscreen', '0');
		}
		else if(\Input::has('approve_btn'))
		{
			$transaction_list = \Input::get('transaction_list');
			$verify_comment = trim(\Input::get('comment_txt'));

			if($transaction_list != null){
				Transaction_History::UpdateVerifiedTransactionHistoryList($transaction_list, 1, $verify_comment);
				Transaction::DeleteTransactionList($transaction_list);

				return \Redirect::route($this->redirectTo)
							->with('message', \Lang::get('transaction.verified_transaction_list_msg'));
			}
		}
		else if(\Input::has('verify_btn'))
		{
			$transaction_list = \Input::get('transaction_list');
			$verify_comment = trim(\Input::get('comment_txt'));

			if($transaction_list != null){
				Transaction_History::UpdateVerifiedTransactionHistoryList($transaction_list, 2, $verify_comment);
				Transaction::DeleteTransactionList($transaction_list);

				return \Redirect::route($this->redirectTo)
							->with('message', \Lang::get('transaction.verified_transaction_list_msg'));
			}
		}
	}

	private function get_end_date($start_year, $start_month, $is_date_empty, $is_month_empty)
	{
		$end_date = "2099-12-31 00:00:00";
		if(!$is_date_empty){
			$end_year = (string)((int)$start_year + 1);
			$end_month = '01';
			if($start_month != '12'){
				$end_year = $start_year;
				$end_month_int = ((int)$start_month) + 1;
				if($is_month_empty)
				{
					$end_month = '12';
				}
				else
				{
					$end_month = (($end_month_int == 10) || ($end_month_int == 11)) ? (string)$end_month_int : '0'.(string)$end_month_int;
				}
			}
			$end_date = $end_year.'-'.$end_month.'-01 00:00:00';
		}

		return $end_date;
	}
	
	public function upload_image($image, $action_name)
	{
		//folder path of the uploaded image
		$destinationPath = public_path() . "/images/upload/transaction/" . date('Y') . "/" . date('m') . "/";

		//create folder if not exists
		if(!file_exists($destinationPath))
			mkdir($destinationPath, 0777, true);
		
		//getting image extension
		$extension = $image->getClientOriginalExtension(); 
	    
	    //renaming image
	    $fileName = Auth::user()->name . "_" . $action_name . "_" . rand(111111,999999) . '.' . $extension;
	    
	    //uploading file to given path
	    $image->move($destinationPath, $fileName); 

		$image_location = date('Y') . "\\" . date('m') . "\\" . $fileName;

		return $image_location;
	}*/

	public function add()
	{	
		$casino_list = Casino::GetAllEnabledCasino()->get();
		//$bank_list = Bank::GetAllBank()->get();
		$user_list = User::GetAllUser()->get();
		$companybank_list = Company::GetAllCompanyBank()->get();

		return view('admin.transaction_create')
				->with('casino_list', $casino_list)
				->with('user_list', $user_list)
				->with('companybank_list', $companybank_list)
				->with('fullscreen', '0');
	}

	public function create(Request $request)
	{
		$action = \Input::get('action_sel');
		$user = \Input::get('user_sel');
		$amount = \Input::get('amount_txt');
		$casino = \Input::get('casino_sel');
		$remark = \Input::get('remark_txt');
		$bank = \Input::get('bank_sel');
		$bank_account = \Input::get('bank_account_txt');
		$bank_fullname = \Input::get('bank_fullname_txt');
		$action_name = ($action == '1') ? "Topup" : "Withdraw" ;

		try
		{
			$transfer = new Transfer;
			$transfer->amount = $amount;
			$transaction->casino_id = $casino;
			$transaction->remark = $remark;
			$transaction->bank_id = $bank;
			$transaction->bank_account = $bank_account;
			$transaction->bank_fullname = $bank_fullname;
			$transaction->user_id = $user;
			$transaction->image_location = $image_location;
			$transaction->is_verified = 0; 
			$transaction->save();


			return \Redirect::route($this->redirectTo)
							->with('message', \Lang::get('transaction.create_success_msg'));
		}
		catch(Exception $e)
		{
			return \Redirect::back()
							->with('error_message', $e->getMessage());
		}
	}
}
