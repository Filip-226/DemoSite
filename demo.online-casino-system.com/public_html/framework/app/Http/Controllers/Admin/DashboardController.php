<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Models\Company;
use App\Models\News;
use App\Models\Transaction;
use App\Models\Transaction_History;
use App\Models\User_Casino;
use App\Http\Requests;
use App\Jobs\ChangeLocale;
use Illuminate\Routing\Controller as BaseController;

class DashboardController extends BaseController {

	public function __construct()
	{
		$this->middleware('auth', ['except' => 'language']);
		
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
		$topup_action = 1;
		$withdraw_action = 2;
		$this_day = date("Y-m-d H:i:s", strtotime("today"));
		$this_week_startday = date("Y-m-d H:i:s", strtotime('last sunday'));
		$this_month_startday = date("Y-m-d H:i:s", strtotime('first day of this month'));
		$this_year_startday = date("Y-m-d H:i:s", strtotime(date('Y-01-01')));

		if(Auth::user()->is_admin)
		{
			//get pending verify user list
			$pending_user_list = User::GetPendingVerifyUserList()->get();
			
			//get pending verify topup
			$pending_topup_list = Transaction::GetPendingTopupList()->get();
			
			//get pending verify withdraw
			$pending_withdraw_list = Transaction::GetPendingWithdrawList()->get();
			
			//get all the transaction amount
			$daily_topup_amount = Transaction_History::GetTransactionAmount($this_day, $topup_action)->sum('amount');
			$weekly_topup_amount = Transaction_History::GetTransactionAmount($this_week_startday, $topup_action)->sum('amount');
			$monthly_topup_amount = Transaction_History::GetTransactionAmount($this_month_startday, $topup_action)->sum('amount');
			$yearly_topup_amount = Transaction_History::GetTransactionAmount($this_year_startday, $topup_action)->sum('amount');

			$daily_withdraw_amount = Transaction_History::GetTransactionAmount($this_day, $withdraw_action)->sum('amount');
			$weekly_withdraw_amount = Transaction_History::GetTransactionAmount($this_week_startday, $withdraw_action)->sum('amount');
			$monthly_withdraw_amount = Transaction_History::GetTransactionAmount($this_month_startday, $withdraw_action)->sum('amount');
			$yearly_withdraw_amount = Transaction_History::GetTransactionAmount($this_year_startday, $withdraw_action)->sum('amount');
		
			//get news list
			$new_news_list = News::GetLatestNewsList()->get();

			//get new user list
			$new_user_list = User::GetLatestUserList()->get();

			return view('admin.dashboard')
					->with('daily_topup_amount', $daily_topup_amount)
					->with('weekly_topup_amount', $weekly_topup_amount)
					->with('monthly_topup_amount', $monthly_topup_amount)
					->with('yearly_topup_amount', $yearly_topup_amount)
					->with('daily_withdraw_amount', $daily_withdraw_amount)
					->with('weekly_withdraw_amount', $weekly_withdraw_amount)
					->with('monthly_withdraw_amount', $monthly_withdraw_amount)
					->with('yearly_withdraw_amount', $yearly_withdraw_amount)
					->with('new_news_list', $new_news_list)
					->with('new_user_list', $new_user_list)
					->with('pending_user_list', $pending_user_list)
					->with('pending_topup_list', $pending_topup_list)
					->with('pending_withdraw_list', $pending_withdraw_list)
					->with('fullscreen', '0');
		}
		else
		{
			//get user transaction amount
			$daily_topup_amount = Transaction_History::GetUserTransactionAmount($this_day, $topup_action, Auth::user()->user_id)->sum('amount');
			$weekly_topup_amount = Transaction_History::GetUserTransactionAmount($this_week_startday, $topup_action, Auth::user()->user_id)->sum('amount');
			$monthly_topup_amount = Transaction_History::GetUserTransactionAmount($this_month_startday, $topup_action, Auth::user()->user_id)->sum('amount');
			$yearly_topup_amount = Transaction_History::GetUserTransactionAmount($this_year_startday, $topup_action, Auth::user()->user_id)->sum('amount');

			$daily_withdraw_amount = Transaction_History::GetUserTransactionAmount($this_day, $withdraw_action, Auth::user()->user_id)->sum('amount');
			$weekly_withdraw_amount = Transaction_History::GetUserTransactionAmount($this_week_startday, $withdraw_action, Auth::user()->user_id)->sum('amount');
			$monthly_withdraw_amount = Transaction_History::GetUserTransactionAmount($this_month_startday, $withdraw_action, Auth::user()->user_id)->sum('amount');
			$yearly_withdraw_amount = Transaction_History::GetUserTransactionAmount($this_year_startday, $withdraw_action, Auth::user()->user_id)->sum('amount');
			
			$casinos = User_Casino::GetAllUserCasino(Auth::user()->user_id)->get();
			
			//get news list
			$new_news_list = News::GetLatestNewsList()->get();

			//get company bank information
			$company_bank_list = Company::GetAllCompanyBank()->get();

			return view('admin.dashboard')
					->with('daily_topup_amount', $daily_topup_amount)
					->with('weekly_topup_amount', $weekly_topup_amount)
					->with('monthly_topup_amount', $monthly_topup_amount)
					->with('yearly_topup_amount', $yearly_topup_amount)
					->with('daily_withdraw_amount', $daily_withdraw_amount)
					->with('weekly_withdraw_amount', $weekly_withdraw_amount)
					->with('monthly_withdraw_amount', $monthly_withdraw_amount)
					->with('yearly_withdraw_amount', $yearly_withdraw_amount)
					->with('casinos', $casinos)
					->with('new_news_list', $new_news_list)
					->with('company_bank_list', $company_bank_list)
					->with('fullscreen', '0');
		}
	}

	public function language()
	{
		if(\Input::get('lang'))
		{
			$lang = \Input::get('lang');
			\Session::put('locale', $lang);
			\App::setLocale($lang);
		}
		
		return redirect()->back();
	}

}
