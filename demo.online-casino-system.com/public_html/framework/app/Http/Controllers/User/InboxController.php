<?php namespace App\Http\Controllers\User;

use Auth;
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

	public function index()
	{	
		$inbox_list = Inbox::GetAllInbox(Auth::user()->user_id)
						->paginate($this->paginate);
		//$inbox_list->setPath('manage');

		return view('user.inbox_list')
				->with('user_id', Auth::user()->user_id)
				->with('inbox_list', $inbox_list)
				->with('fullscreen', '0');
	}
	
	public function compose() 
	{	

		return \View::make('user.inbox_compose')

				->with('fullscreen', '0');
	}
	
	public function compose_post() 
	{
		$subject = \Input::get('subject_txt');
		$message = \Input::get('message_txt');


			try
			{
				$inbox = new Inbox;
				$inbox->user_id = Auth::user()->user_id;
				$inbox->inbox_subject = $subject;
				$inbox->inbox_msg = $message;
				$inbox->inbox_type = 2;
				$inbox->inbox_status = 0;
				$inbox->inbox_created_by = Auth::user()->user_id;
				$inbox->save();

				return \Redirect::route('user.inbox_manage', array(Auth::user()->user_id))
								->with('message', \Lang::get('inbox.create_success_msg'));
			}
			catch(Exception $e)
			{
				return \Redirect::back()
								->with('error_message', $e->getMessage());
			}
	}
	
	public function reply($id) 
	{	
		$subject = Inbox::GetTitle($id)->get();
		
		return \View::make('user.inbox_reply')
				->with('msg_id', $id)
				->with('subject', $subject[0]->inbox_subject)
				->with('fullscreen', '0');
	}
	
	public function reply_post($id) 
	{
		$subject = \Input::get('subject_txt');
		$message = \Input::get('message_txt');


			try
			{
				$inbox = new Inbox;
				$inbox->user_id = Auth::user()->user_id;
				$inbox->parent_id = $id;
				$inbox->inbox_subject = $subject;
				$inbox->inbox_msg = $message;
				$inbox->inbox_type = 2;
				$inbox->inbox_status = 0;
				$inbox->inbox_created_by = Auth::user()->user_id;
				$inbox->save();

				return \Redirect::route('user.inbox_manage', array(Auth::user()->user_id))
								->with('message', \Lang::get('inbox.create_success_msg'));
			}
			catch(Exception $e)
			{
				return \Redirect::back()
								->with('error_message', $e->getMessage());
			}
	}
	
	public function message($msg_id)
	{	
		$subject = Inbox::GetTitle($msg_id)->get();
		$msg_list = Inbox::GetAllMessage($msg_id)
						->paginate($this->paginate);
		//$inbox_list->setPath('manage');

		return view('user.msg_list')

				->with('msg_id', $msg_id)
				->with('subject', $subject[0]->inbox_subject)
				->with('msg_list', $msg_list)
				->with('fullscreen', '0');
	}
	
	public function delete($msg_id) 
	{
		$inbox = Inbox::find($msg_id);
		$inbox->delete();
		
		$sub_inboxes = Inbox::where('parent_id', '=', $msg_id)->get();
		
		foreach($sub_inboxes as $sub) {
			$subinbox = Inbox::find($sub->inbox_id);
			$subinbox->delete();
		}
		
		return \Redirect::route('user.inbox_manage')
								->with('message', \Lang::get('inbox.delete_success_msg'));	}
}
