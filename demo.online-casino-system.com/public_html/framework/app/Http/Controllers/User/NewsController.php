<?php namespace App\Http\Controllers\User;

use Auth;
use App\Models\News;
use Illuminate\Routing\Controller as BaseController;

class NewsController extends BaseController {

	private $paginate = 20;
	private $redirectTo = 'user.news_manage';

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

		return view('user.news_list')
				->with('news_list', $news_list)
				->with('fullscreen', '0');
	}

	public function actions() 
	{
		if(\Input::has('search_btn'))
		{
			$news_list = News::SearchNewsByTitle(\Input::get('newstitle_search_txt'))
								->paginate($this->paginate);
			$news_list->setPath('actions');

			return view('user.news_list')
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
