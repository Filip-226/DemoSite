<?php namespace App\Http\Controllers\Admin;

use Auth;
//use App\User;
use App\Models\Inbox;
use Illuminate\Routing\Controller as BaseController;

class InboxController extends BaseController {

	private $paginate = 20;
	//private $redirectTo = 'panel.admin.user_manage';

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

	public function inbox($user_id)
	{	
		$inbox_list = Inbox::GetAllInbox($user_id)
						->paginate($this->paginate);
		//$inbox_list->setPath('manage');

		return view('admin.inbox_list')
				->with('user_id', $user_id)
				->with('inbox_list', $inbox_list)
				->with('fullscreen', '0');
	}
	
	public function compose($user_id) 
	{	

		return \View::make('admin.inbox_compose')
				->with('user_id', $user_id)
				->with('fullscreen', '0');
	}
	
	public function compose_post($user_id) 
	{
		$subject = \Input::get('subject_txt');
		$message = \Input::get('message_txt');


			try
			{
				$inbox = new Inbox;
				$inbox->user_id = $user_id;
				$inbox->inbox_subject = $subject;
				$inbox->inbox_msg = $message;
				$inbox->inbox_type = 2;
				$inbox->inbox_status = 0;
				$inbox->inbox_created_by = Auth::user()->user_id;
				$inbox->save();

				return \Redirect::route('panel.admin.user_inbox', array($user_id))
								->with('message', \Lang::get('inbox.create_success_msg'));
			}
			catch(Exception $e)
			{
				return \Redirect::back()
								->with('error_message', $e->getMessage());
			}
	}
	
	public function reply($user_id, $msg_id) 
	{	
		$subject = Inbox::GetTitle($msg_id)->get();
		
		return \View::make('admin.inbox_reply')
				->with('user_id', $user_id)
				->with('msg_id', $msg_id)
				->with('subject', $subject[0]->inbox_subject)
				->with('fullscreen', '0');
	}
	
	public function reply_post($user_id, $msg_id) 
	{
		$subject = \Input::get('subject_txt');
		$message = \Input::get('message_txt');


			try
			{
				$inbox = new Inbox;
				$inbox->user_id = $user_id;
				$inbox->parent_id = $msg_id;
				$inbox->inbox_subject = $subject;
				$inbox->inbox_msg = $message;
				$inbox->inbox_type = 2;
				$inbox->inbox_status = 0;
				$inbox->inbox_created_by = Auth::user()->user_id;
				$inbox->save();

				return \Redirect::route('panel.admin.user_inbox', array($user_id))
								->with('message', \Lang::get('inbox.create_success_msg'));
			}
			catch(Exception $e)
			{
				return \Redirect::back()
								->with('error_message', $e->getMessage());
			}
	}
	
	public function message($user_id, $msg_id)
	{	
		$subject = Inbox::GetTitle($msg_id)->get();
		$msg_list = Inbox::GetAllMessage($msg_id)
						->paginate($this->paginate);
		//$inbox_list->setPath('manage');

		return view('admin.msg_list')
				->with('user_id', $user_id)
				->with('msg_id', $msg_id)
				->with('subject', $subject[0]->inbox_subject)
				->with('msg_list', $msg_list)
				->with('fullscreen', '0');
	}
}
