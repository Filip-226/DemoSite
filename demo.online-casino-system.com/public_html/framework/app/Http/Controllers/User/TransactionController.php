<?php namespace App\Http\Controllers\User;

use Auth;
use App\User;
use App\Models\Bank;
use App\Models\Casino;
use App\Models\User_Casino;
use App\Models\Company;
use App\Models\Transaction;
use App\Models\Transaction_History;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class TransactionController extends BaseController {

	private $paginate = 30;
	private $redirectTo = 'user.transaction_manage';

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
		$transaction_list = Transaction::GetUserTransactionList(Auth::user()->user_id)
										->paginate($this->paginate);
		$transaction_list->setPath('pending');
		$casino_list = Casino::GetAllCasino()->get();

		return view('user.transaction_list')
				->with('transaction_list', $transaction_list)
				->with('casino_list', $casino_list)
				->with('fullscreen', '0');
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
	}

	public function add()
	{	
		//$casino_list = Casino::GetAllEnabledCasino()->get();
		$casino_list = User_Casino::GetAllUserCasino(Auth::user()->user_id)->get();
		$bank_list = Bank::GetAllBank()->get();
		$companybank_list = Company::GetAllCompanyBank()->get();

		return view('user.transaction_create')
				->with('casino_list', $casino_list)
				->with('bank_list', $bank_list)
				->with('companybank_list', $companybank_list)
				->with('fullscreen', '0');
	}

	public function create(Request $request)
	{
		$action = \Input::get('action_sel');
		$amount = \Input::get('amount_txt');
		$casino = \Input::get('casino_sel');
		$casino_no = \Input::get('username_txt');
		$remark = \Input::get('remark_txt');
		$bank = \Input::get('bank_sel');
		$bank_account = \Input::get('bank_account_txt');
		$bank_fullname = \Input::get('bank_fullname_txt');
		$action_name = ($action == '1') ? "Topup" : "Withdraw" ;

		$image = \Input::file('image');

		if($image != null){
			$validator = Validator::make($request->all(), [
	            'image' => 'mimes:jpg,jpe,jpeg,gif,png,svg'
	        ]);

			if ($validator->fails()) {
	            return \Redirect::back()
							->with('error_message', \Lang::get('transaction.upload_image_error_msg'))
	                        ->withInput();
	        }
		}

		$image_location = ($image == null) ? "" : $this->upload_image($image, $action_name);

		try
		{
			$transaction = new Transaction;
			$transaction->action = $action;
			$transaction->amount = $amount;
			$transaction->casino_id = $casino;
			$transaction->casino_no = $casino_no;
			$transaction->remark = $remark;
			$transaction->bank_id = $bank;
			$transaction->bank_account = $bank_account;
			$transaction->bank_fullname = $bank_fullname;
			$transaction->user_id = Auth::user()->user_id;
			$transaction->image_location = $image_location;
			$transaction->is_verified = 0; 
			$transaction->save();

			$transaction_history = new Transaction_History;
			$transaction_history->transaction_id = $transaction->transaction_id;
			$transaction_history->action = $action;
			$transaction_history->amount = $amount;
			$transaction_history->casino_id = $casino;
			$transaction_history->casino_no = $casino_no;
			$transaction_history->remark = $remark;
			$transaction_history->bank_id = $bank;
			$transaction_history->bank_account = $bank_account;
			$transaction_history->bank_fullname = $bank_fullname;
			$transaction_history->user_id = Auth::user()->user_id;
			$transaction_history->image_location = $image_location;
			$transaction_history->is_verified = 0;
			$transaction_history->save();

			return \Redirect::route($this->redirectTo)
							->with('message', \Lang::get('transaction.create_success_msg'));
		}
		catch(Exception $e)
		{
			return \Redirect::back()
							->with('error_message', $e->getMessage());
		}
	}

	public function edit($id) 
	{
		$transaction = Transaction::GetTransaction($id)->first();
		$casino_list = Casino::GetAllEnabledCasino()->get();
		$bank_list = Bank::GetAllBank()->get();
		$companybank_list = Company::GetAllCompanyBank()->get();

		return \View::make('user.transaction_edit')
				->with('transaction', $transaction)
				->with('casino_list', $casino_list)
				->with('bank_list', $bank_list)
				->with('companybank_list', $companybank_list)
				->with('fullscreen', '0');
	}
	
	public function update(Request $request, $id) 
	{
		$action = \Input::get('action_sel');
		$amount = \Input::get('amount_txt');
		$casino = \Input::get('casino_sel');
		$action_name = ($action == '1') ? "Topup" : "Withdraw" ;

		$image = \Input::file('image');

		if($image != null){
			$validator = Validator::make($request->all(), [
	            'image' => 'mimes:jpg,jpe,jpeg,gif,png,svg'
	        ]);

			if ($validator->fails()) {
	            return \Redirect::back()
							->with('error_message', \Lang::get('transaction.upload_image_error_msg'))
	                        ->withInput();
	        }

	        $image_location = $this->upload_image($image, $action_name);
		}	

		try
		{
			$transaction = Transaction::find($id);
			$transaction->action = $action;
			$transaction->amount = $amount;
			$transaction->casino_id = $casino;

			if($image != null)
				$transaction->image_location = $image_location;

			$transaction->is_verified = 0; 
			$transaction->save();

			$transaction_history = Transaction_History::GetTransactionHistoryById($id)->first();
			$transaction_history->action = $action;
			$transaction_history->amount = $amount;
			$transaction_history->casino_id = $casino;

			if($image != null)
				$transaction_history->image_location = $image_location;

			$transaction_history->is_verified = 0;
			$transaction_history->save();
				
			return \Redirect::route($this->redirectTo)
							->with('message', \Lang::get('transaction.update_success_msg'));
		}
		catch(Exception $e)
		{
			return \Redirect::back()
							->with('error_message', $e->getMessage());
		}
	}
	
	public function delete($id) 
	{
		try
		{
			$transaction = Transaction::find($id);
			$transaction->delete();

			$transaction_history = Transaction_History::GetTransactionHistoryById($id)->first();
			$transaction_history->delete();

			return \Redirect::route($this->redirectTo)
							->with('message', \Lang::get('transaction.delete_success_msg'));
		}
		catch(Exception $e)
		{
			return \Redirect::back()
							->with('error_message', $e->getMessage());
		}
	}

	public function actions() 
	{
		if(\Input::has('search_btn'))
		{
			$user_name = \Input::get('username_search_txt');
			$casino_id = \Input::get('casino_search_sel');
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

			$transaction_list = Transaction::SearchUserTransactionListByDetails($user_name, $casino_id, $transaction_action, $transaction_amount, $transaction_start_date, $transaction_end_date, $list_order, Auth::user()->user_id)
								->paginate($this->paginate);
			$transaction_list->setPath('actions');
			$casino_list = Casino::GetAllCasino()->get();

			return view('user.transaction_list')
						->with('transaction_list', $transaction_list)
						->with('casino_list', $casino_list)
						->with('fullscreen', '0');
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

}
