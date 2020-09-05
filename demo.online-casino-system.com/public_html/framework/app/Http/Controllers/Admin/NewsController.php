<?php namespace App\Http\Controllers\Admin;

use Auth;
use App\Models\News;
use Illuminate\Routing\Controller as BaseController;

class NewsController extends BaseController {

	private $paginate = 20;
	private $redirectTo = 'panel.admin.news_manage';

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
		$news_list = News::GetAllNews()
						->paginate($this->paginate);
		$news_list->setPath('manage');

		return view('admin.news_list')
				->with('news_list', $news_list)
				->with('fullscreen', '0');
	}

	public function add() 
	{	
		return \View::make('admin.news_create')
				->with('fullscreen', '0');
	}

	public function create() 
	{
		$news_title = \Input::get('title_txt');
		$news_content = \Input::get('content_txt');

		try
		{
			$news = new News;
			$news->title = $news_title;
			$news->content = $news_content;
			$news->user_id = Auth::user()->user_id;
			$news->save();

			return \Redirect::route($this->redirectTo)
							->with('message', \Lang::get('news.create_success_msg'));
		}
		catch(Exception $e)
		{
			return \Redirect::back()
							->with('error_message', $e->getMessage());
		}
	}
	
	public function edit($id) 
	{
		return \View::make('admin.news_edit')
				->with('news', News::find($id))
				->with('fullscreen', '0');
	}
	
	public function update($id) 
	{
		$news_title = \Input::get('title_txt');
		$news_content = \Input::get('content_txt');

		try
		{
			$news = News::find($id);
			$news->title = $news_title;
			$news->content = $news_content;
			$news->save();
				
			return \Redirect::route($this->redirectTo)
							->with('message', \Lang::get('news.update_success_msg'));
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
			$news = News::find($id);
			$news->delete();

			return \Redirect::route($this->redirectTo)
							->with('message', \Lang::get('news.delete_success_msg'));
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
			$news_list = News::SearchNewsByTitle(\Input::get('newstitle_search_txt'))
								->paginate($this->paginate);
			$news_list->setPath('actions');

			return view('admin.news_list')
						->with('news_list', $news_list)
						->with('fullscreen', '0');
		}
	}

	public function view($id)
	{
		$news = News::find($id);

		return view('user.news_view')
						->with('news', $news)
						->with('fullscreen', '0');
	}
}
