<?php namespace App\Http\Controllers\User;

use Auth;
use App\User;
use App\Models\Bank;
use App\Models\Casino;
use App\Models\Transaction_History;
use Illuminate\Routing\Controller as BaseController;

class TransactionHistoryController extends BaseController {

	private $paginate = 30;
	private $redirectTo = 'user.history_manage';

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
		$history_list = Transaction_History::GetUserTransactionHistoryList(Auth::user()->user_id)
						->paginate($this->paginate);
		$history_list->setPath('verified');
		$casino_list = Casino::GetAllCasino()->get();

		return view('user.history_list')
				->with('history_list', $history_list)
				->with('casino_list', $casino_list)
				->with('fullscreen', '0');
	}

	public function view($id) 
	{	
		$history = Transaction_History::GetTransactionHistory($id)->first();

		return \View::make('user.history_details')
				->with('history', $history)
				->with('fullscreen', '0');
	}
	
	public function actions()
	{
		if(\Input::has('search_btn'))
		{
			$user_name = \Input::get('username_search_txt');
			$casino_id = \Input::get('casino_search_sel');
			$status = (\Input::get('status_search_sel') == "") ? array(1, 2) : array((int)\Input::get('status_search_sel'));
			$transaction_action = (\Input::get('action_search_sel') == "") ? $transaction_action = array(1, 2) : array((int)\Input::get('action_search_sel'));
			$transaction_amount = (\Input::get('amount_search_txt') == "") ? 1000000000 : \Input::get('amount_search_txt');
				
			$transaction_year = \Input::get('tyear_search_sel');
			$transaction_month = \Input::get('tmonth_search_sel');
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
				$transaction_year = (\Input::get('tyear_search_sel') == "") ? date('Y') : \Input::get('tyear_search_sel');
				$transaction_month = (\Input::get('tmonth_search_sel') == "") ? '01' : \Input::get('tmonth_search_sel');
				$is_transactiondate_empty = false;
				$is_transactionmonth_empty = (\Input::get('tmonth_search_sel') == "") ? true : false;
			}
			$transaction_start_date = $transaction_year.'-'.$transaction_month.'-01 00:00:00';
			$transaction_end_date = $this->get_end_date($transaction_year, $transaction_month, $is_transactiondate_empty, $is_transactionmonth_empty);

			$verified_year = \Input::get('vyear_search_sel');
			$verified_month = \Input::get('vmonth_search_sel');
			$is_verifieddate_empty = false;
			$is_verifiedmonth_empty = false;
			if($verified_year == "" && $verified_month == "")
			{
				$verified_year = '2000';
				$verified_month = '01';
				$is_verifieddate_empty = true;
				$is_verifiedmonth_empty = true;
			}
			else
			{
				$verified_year = (\Input::get('vyear_search_sel') == "") ? date('Y') : \Input::get('vyear_search_sel');
				$verified_month = (\Input::get('vmonth_search_sel') == "") ? '01' : \Input::get('vmonth_search_sel');
				$is_verifieddate_empty = false;
				$is_verifiedmonth_empty = (\Input::get('vmonth_search_sel') == "") ? true : false;
			}
			$verified_start_date = $verified_year.'-'.$verified_month.'-01 00:00:00';
			$verified_end_date = $this->get_end_date($verified_year, $verified_month, $is_verifieddate_empty, $is_verifiedmonth_empty);
			
			$list_order = \Input::get('list_order_sel');

			$history_list = Transaction_History::SearchUserTransactionHistoryListByDetails($user_name
																						, $casino_id
																						, $status
																						, $transaction_action
																						, $transaction_amount
																						, $transaction_start_date
																						, $transaction_end_date
																						, $verified_start_date
																						, $verified_end_date
																						, $list_order
																						, Auth::user()->user_id)
																						->paginate($this->paginate);
																						
			$history_list->setPath('actions');
			$casino_list = Casino::GetAllCasino()->get();

			return view('user.history_list')
						->with('history_list', $history_list)
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
