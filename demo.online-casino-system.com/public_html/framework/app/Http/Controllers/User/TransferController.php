<?php namespace App\Http\Controllers\User;

use Auth;
use App\User;
//use App\Models\Bank;
use App\Models\Casino;
use App\Models\User_Casino;
use App\Models\Transfer;
//use App\Models\Company;
use App\Models\Transaction;
use App\Models\Transaction_History;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class TransferController extends BaseController {

	private $paginate = 30;
	private $redirectTo = 'user.transfer_manage';

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
		$transfer_list = Transfer::GetUserTransferList(Auth::user()->user_id)
										->paginate($this->paginate);
		$transfer_list->setPath('pending');
		$casino_list = Casino::GetAllCasino()->get();

		return view('user.transfer_list')
				->with('transfer_list', $transfer_list)
				->with('casino_list', $casino_list)
				->with('fullscreen', '0');
	}

	public function add()
	{	
		//$casino_list = Casino::GetAllEnabledCasino()->get();
		//$bank_list = Bank::GetAllBank()->get();
		$casino_list = User_Casino::GetAllUserCasino(Auth::user()->user_id)->get();

		return view('user.transfer_create')
				->with('casino_list', $casino_list)
				//->with('bank_list', $bank_list)
				//->with('companybank_list', $companybank_list)
				->with('fullscreen', '0');
	}

	public function create(Request $request)
	{
		$amount = \Input::get('amount_txt');
		$from = \Input::get('from_sel');
		$from_casino_no = \Input::get('from_username_txt');
		$to = \Input::get('to_sel');
		$to_casino_no = \Input::get('to_username_txt');
		$remark = \Input::get('remark_txt');

		try
		{
			$transfer = new Transfer;
			$transfer->amount = $amount;
			$transfer->from_acc = $from;
			$transfer->from_casino_no = $from_casino_no;
			$transfer->to_acc = $to;
			$transfer->to_casino_no = $to_casino_no;
			$transfer->remark = $remark;
			$transfer->user_id = Auth::user()->user_id;
			$transfer->is_verified = 0; 
			$transfer->save();

			return \Redirect::route($this->redirectTo)
							->with('message', \Lang::get('transfer.create_success_msg'));
		}
		catch(Exception $e)
		{
			return \Redirect::back()
							->with('error_message', $e->getMessage());
		}
	}

	public function edit($id) 
	{
		$transfer = Transfer::GetTransfer($id)->first();
		$casino_list = User_Casino::GetAllUserCasino(Auth::user()->user_id)->get();
		//$bank_list = Bank::GetAllBank()->get();
		//$companybank_list = Company::GetAllCompanyBank()->get();

		return \View::make('user.transfer_edit')
				->with('transfer', $transfer)
				->with('casino_list', $casino_list)
				//->with('bank_list', $bank_list)
				//->with('companybank_list', $companybank_list)
				->with('fullscreen', '0');
	}
	
	public function update(Request $request, $id) 
	{
		$from = \Input::get('from_sel');
		$from_casino_no = \Input::get('from_username_txt');
		$to = \Input::get('to_sel');
		$to_casino_no = \Input::get('to_username_txt');
		$amount = \Input::get('amount_txt');
		$remark = \Input::get('remark_txt');
		//$action_name = ($action == '1') ? "Topup" : "Withdraw" ;

		try
		{
			$transfer = Transfer::find($id);
			$transfer->from_acc = $from;
			$transfer->from_casino_no = $from_casino_no;
			$transfer->to_acc = $to;
			$transfer->to_casino_no = $to_casino_no;
			$transfer->amount = $amount;
			$transfer->remark = $remark;
			$transfer->is_verified = 0; 
			$transfer->save();
				
			return \Redirect::route($this->redirectTo)
							->with('message', \Lang::get('transfer.update_success_msg'));
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
			$transfer = Transfer::find($id);
			$transfer->delete();

			return \Redirect::route($this->redirectTo)
							->with('message', \Lang::get('transfer.delete_success_msg'));
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
			//$user_name = \Input::get('username_search_txt');
			$from = \Input::get('from_sel');
			$to = \Input::get('to_sel');
			//$transaction_action = (\Input::get('action_search_sel') == "") ? $transaction_action = array(1, 2) : array((int)\Input::get('action_search_sel'));
			$transfer_amount = (\Input::get('amount_search_txt') == "") ? 1000000000 : \Input::get('amount_search_txt');
			
			$transfer_year = \Input::get('year_search_sel');
			$transfer_month = \Input::get('month_search_sel');
			$is_transferdate_empty = false;
			$is_transfermonth_empty = false;
			if($transfer_year == "" && $transfer_month == "")
			{
				$transfer_year = '2000';
				$transfer_month = '01';
				$is_transferdate_empty = true;
				$is_transfermonth_empty = true;
			}
			else
			{
				$transfer_year = (\Input::get('year_search_sel') == "") ? date('Y') : \Input::get('year_search_sel');
				$transfer_month = (\Input::get('month_search_sel') == "") ? '01' : \Input::get('month_search_sel');
				$is_transferdate_empty = false;
				$is_transfermonth_empty = (\Input::get('month_search_sel') == "") ? true : false;
			}
			$transfer_start_date = $transfer_year.'-'.$transfer_month.'-01 00:00:00';
			$transfer_end_date = $this->get_end_date($transfer_year, $transfer_month, $is_transferdate_empty, $is_transfermonth_empty);
			
			$list_order = \Input::get('list_order_sel');

			$transfer_list = Transfer::SearchUserTransferListByDetails($from, $to, $transfer_amount, $transfer_start_date, $transfer_end_date, $list_order, Auth::user()->user_id)
								->paginate($this->paginate);
			$transfer_list->setPath('actions');
			$casino_list = Casino::GetAllCasino()->get();

			return view('user.transfer_list')
						->with('transfer_list', $transfer_list)
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
