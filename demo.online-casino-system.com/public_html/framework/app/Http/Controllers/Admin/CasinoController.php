<?php namespace App\Http\Controllers\Admin;

use Auth;
use App\Models\Casino;
use Illuminate\Routing\Controller as BaseController;

class CasinoController extends BaseController {

	private $paginate = 20;
	private $redirectTo = 'panel.admin.casino_manage';

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
		$casino_list = Casino::GetAllCasino()
							->paginate($this->paginate);
		$casino_list->setPath('manage');

		return view('admin.casino_list')
				->with('casino_list', $casino_list)
				->with('fullscreen', '0');
	}

	public function add() 
	{	
		return \View::make('admin.casino_create')
				->with('fullscreen', '0');
	}

	public function create() 
	{
		$casino_name = \Input::get('name_txt');
		$casino_fullname = \Input::get('fullname_txt');
		$casino_isenabled = (\Input::get('isenabled_chk') == null) ? 0 : 1;

		try
		{
			$casino = new Casino;
			$casino->name = $casino_name;
			$casino->fullname = $casino_fullname;
			$casino->is_enabled = $casino_isenabled;
			$casino->save();

			return \Redirect::route($this->redirectTo)
							->with('message', \Lang::get('casino.create_success_msg'));
		}
		catch(Exception $e)
		{
			return \Redirect::back()
							->with('error_message', $e->getMessage());
		}
	}
	
	public function edit($id) 
	{
		return \View::make('admin.casino_edit')
				->with('casino', Casino::find($id))
				->with('fullscreen', '0');
	}
	
	public function update($id) 
	{
		$casino_name = \Input::get('name_txt');
		$casino_fullname = \Input::get('fullname_txt');
		$casino_isenabled = (\Input::get('isenabled_chk') == null) ? 0 : 1;

		try
		{
			$casino = Casino::find($id);
			$casino->name = $casino_name;
			$casino->fullname = $casino_fullname;
			$casino->is_enabled = $casino_isenabled;
			$casino->save();
				
			return \Redirect::route($this->redirectTo)
							->with('message', \Lang::get('casino.update_success_msg'));
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
			$casino = Casino::find($id);
			$casino->delete();

			return \Redirect::route($this->redirectTo)
							->with('message', \Lang::get('casino.delete_success_msg'));
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
			$casino_list = Casino::SearchCasinoByName(\Input::get('casinoname_search_txt'))
								->paginate($this->paginate);
			$casino_list->setPath('actions');

			return view('admin.casino_list')
						->with('casino_list', $casino_list)
						->with('fullscreen', '0');
		}
	}
}
