<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', array('as'=>'index','uses'=>'WelcomeController@index'));

Route::get('home', array('as'=>'home','uses'=>'HomeController@index'));

Route::post('check_name', array('as' => 'user.name_check', 'uses' => 'App\AjaxController@check_username'));
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('/language', array('as'=>'change_language','uses'=>'Admin\DashboardController@language'));

//all the url for normal user
Route::group(['prefix' => 'panel'], function () {
	//login, logout and dashboard
    Route::get('/', array('middleware' => 'auth','as'=>'user.dashboard','uses'=>'Admin\DashboardController@index'));
	
	Route::get('account/activation/', array('as' => 'account.activate.index', 'uses' => 'User\MemberController@activateMain'));
	Route::post('account/activation/', array('uses' => 'User\MemberController@activateAction'));
	Route::get('account/activate/{userid}/{code}', array('as' => 'account.activate', 'uses' => 'User\MemberController@getActivate'));

	//personal profile
	Route::get('login-details', array('middleware' => 'auth','as'=>'user.login_details','uses'=>'User\PersonalController@logindetails'));
	Route::post('login-details', array('middleware' => 'auth','uses'=>'User\PersonalController@update_logindetails'));
	Route::get('update-account', array('middleware' => 'auth','as'=>'user.update_account','uses'=>'User\PersonalController@account'));
	Route::post('update-account', array('middleware' => 'auth','as'=>'user.update_account','uses'=>'User\PersonalController@update_account'));

	//Ajax checking personal profile
	Route::post('check_emailaddress', array('middleware' => 'auth', 'as' => 'user.email_check', 'uses' => 'App\AjaxController@check_useremailaddress'));
	Route::post('check_password', array('middleware' => 'auth', 'as' => 'user.password_check', 'uses' => 'App\AjaxController@check_userpassword'));

	//manage transaction
	Route::get('transaction/manage', array('middleware' => 'auth','as'=>'user.transaction_manage','uses'=>'User\TransactionController@index'));
	Route::get('transaction/add', array('middleware' => 'auth','as'=>'user.transaction_add','uses'=>'User\TransactionController@add'));
	Route::post('transaction/add', array('middleware' => 'auth','as'=>'user.transaction_add','uses'=>'User\TransactionController@create'));
	Route::get('transaction/edit/{id}', array('middleware' => 'auth','as'=>'user.transaction_edit','uses'=>'User\TransactionController@edit'));
	Route::post('transaction/edit/{id}', array('middleware' => 'auth','as'=>'user.transaction_edit','uses'=>'User\TransactionController@update'));
	Route::get('transaction/delete/{id}', array('middleware' => 'auth','as'=>'user.transaction_delete','uses'=>'User\TransactionController@delete'));
	Route::get('transaction/actions', array('middleware' => 'auth','as'=>'user.transaction_actions','uses'=>'User\TransactionController@actions'));
	
	//manage transfer
	Route::get('transfer/manage', array('middleware' => 'auth','as'=>'user.transfer_manage','uses'=>'User\TransferController@index'));
	Route::get('transfer/add', array('middleware' => 'auth','as'=>'user.transfer_add','uses'=>'User\TransferController@add'));
	Route::post('transfer/add', array('middleware' => 'auth','as'=>'user.transfer_add','uses'=>'User\TransferController@create'));
	Route::get('transfer/edit/{id}', array('middleware' => 'auth','as'=>'user.transfer_edit','uses'=>'User\TransferController@edit'));
	Route::post('transfer/edit/{id}', array('middleware' => 'auth','as'=>'user.transfer_edit','uses'=>'User\TransferController@update'));
	Route::get('transfer/delete/{id}', array('middleware' => 'auth','as'=>'user.transfer_delete','uses'=>'User\TransferController@delete'));
	Route::get('transfer/actions', array('middleware' => 'auth','as'=>'user.transfer_actions','uses'=>'User\TransferController@actions'));

	//check transaction history
	Route::get('history/manage', array('middleware' => 'auth','as'=>'user.history_manage','uses'=>'User\TransactionHistoryController@index'));
	Route::get('history/view/{id}', array('middleware' => 'auth','as'=>'user.history_view','uses'=>'User\TransactionHistoryController@view'));
	Route::get('history/actions', array('middleware' => 'auth','as'=>'user.history_actions','uses'=>'User\TransactionHistoryController@actions'));

	//manage news
	Route::get('news/manage', array('middleware' => 'auth','as'=>'user.news_manage','uses'=>'User\NewsController@index'));
	Route::get('news/view/{id}', array('middleware' => 'auth','as'=>'user.news_view','uses'=>'User\NewsController@view'));
	Route::get('news/actions', array('middleware' => 'auth','as'=>'user.news_actions','uses'=>'User\NewsController@actions'));
	
	//manage inbox
	Route::get('inbox/manage', array('middleware' => 'auth','as'=>'user.inbox_manage','uses'=>'User\InboxController@index'));
	Route::get('inbox/compose', array('middleware' => 'auth','as'=>'user.inbox_compose','uses'=>'User\InboxController@compose'));
	Route::post('inbox/compose', array('middleware' => 'auth','as'=>'user.inbox_compose','uses'=>'User\InboxController@compose_post'));
	Route::get('inbox/view/{id}/reply', array('middleware' => 'auth','as'=>'user.inbox_reply','uses'=>'User\InboxController@reply'));
	Route::post('inbox/view/{id}/reply', array('middleware' => 'auth','as'=>'user.inbox_reply','uses'=>'User\InboxController@reply_post'));
	Route::get('inbox/view/{id}', array('middleware' => 'auth','as'=>'user.inbox_view','uses'=>'User\InboxController@message'));
	Route::get('inbox/delete/{id}', array('middleware' => 'auth','as'=>'user.inbox_delete','uses'=>'User\InboxController@delete'));
	//Route::get('inbox/actions', array('middleware' => 'auth','as'=>'user.inbox_actions','uses'=>'User\InboxController@actions'));

	//add this middleware to prevent user abuse admin url
	Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'], function()
	{
		//all the url for admin
		Route::group(['prefix' => 'admin'], function () {
			Route::get('notification', array('middleware' => 'auth','as'=>'panel.admin.notification','uses'=>'Admin\AjaxController@notification'));
			//users management
			Route::get('user/manage', array('middleware' => 'auth','as'=>'panel.admin.user_manage','uses'=>'Admin\UserController@index'));
			Route::get('user/add', array('middleware' => 'auth','as'=>'panel.admin.user_add','uses'=>'Admin\UserController@add'));
			Route::post('user/add', array('middleware' => 'auth','as'=>'panel.admin.user_add','uses'=>'Admin\UserController@create'));
			Route::get('user/edit/{id}', array('middleware' => 'auth','as'=>'panel.admin.user_edit','uses'=>'Admin\UserController@edit'));
			Route::post('user/edit/{id}', array('middleware' => 'auth','as'=>'panel.admin.user_edit','uses'=>'Admin\UserController@update'));
			Route::get('user/inbox/{user_id}', array('middleware' => 'auth','as'=>'panel.admin.user_inbox','uses'=>'Admin\InboxController@inbox'));
			Route::get('user/inbox/{user_id}/compose', array('middleware' => 'auth','as'=>'panel.admin.user_inbox_compose','uses'=>'Admin\InboxController@compose'));
			Route::post('user/inbox/{user_id}/compose', array('middleware' => 'auth','as'=>'panel.admin.user_inbox_compose','uses'=>'Admin\InboxController@compose_post'));
			Route::get('user/inbox/{user_id}/msg/{msg_id}', array('middleware' => 'auth','as'=>'panel.admin.user_msg','uses'=>'Admin\InboxController@message'));
			Route::get('user/inbox/{user_id}/msg/{msg_id}/reply', array('middleware' => 'auth','as'=>'panel.admin.user_inbox_reply','uses'=>'Admin\InboxController@reply'));
			Route::post('user/inbox/{user_id}/msg/{msg_id}/reply', array('middleware' => 'auth','as'=>'panel.admin.user_inbox_reply','uses'=>'Admin\InboxController@reply_post'));
			Route::get('news/view/{id}', array('middleware' => 'auth','as'=>'panel.admin.news_view','uses'=>'Admin\NewsController@view'));
			Route::get('user/delete/{id}', array('middleware' => 'auth','as'=>'panel.admin.user_delete','uses'=>'Admin\UserController@delete'));
			Route::get('user/actions', array('middleware' => 'auth','as'=>'panel.admin.user_actions','uses'=>'Admin\UserController@actions'));

			//news management
			Route::get('news/manage', array('middleware' => 'auth','as'=>'panel.admin.news_manage','uses'=>'Admin\NewsController@index'));
			Route::get('news/add', array('middleware' => 'auth','as'=>'panel.admin.news_add','uses'=>'Admin\NewsController@add'));
			Route::post('news/add', array('middleware' => 'auth','as'=>'panel.admin.news_add','uses'=>'Admin\NewsController@create'));
			Route::get('news/edit/{id}', array('middleware' => 'auth','as'=>'panel.admin.news_edit','uses'=>'Admin\NewsController@edit'));
			Route::post('news/edit/{id}', array('middleware' => 'auth','as'=>'panel.admin.news_edit','uses'=>'Admin\NewsController@update'));
			Route::get('news/delete/{id}', array('middleware' => 'auth','as'=>'panel.admin.news_delete','uses'=>'Admin\NewsController@delete'));
			Route::get('news/actions', array('middleware' => 'auth','as'=>'panel.admin.news_actions','uses'=>'Admin\NewsController@actions'));

			/******laravel-filemanager, for ckeditor******/
			//Show LFM
			Route::get('/laravel-filemanager', array('middleware' => 'auth','as'=>'panel.admin.laravel-filemanager.show','uses'=>'File\LfmController@show'));
    		//upload
    		Route::post('/laravel-filemanager/upload', array('middleware' => 'auth','as'=>'panel.admin.laravel-filemanager.upload','uses'=>'File\UploadController@upload'));
    		// list images & files
		    Route::get('/laravel-filemanager/jsonimages', array('middleware' => 'auth','as'=>'panel.admin.laravel-filemanager.json_images', 'uses'=>'File\ItemsController@getImages'));
		    Route::get('/laravel-filemanager/jsonfiles', array('middleware' => 'auth','as'=>'panel.admin.laravel-filemanager.json_files', 'uses'=>'File\ItemsController@getFiles'));
		    // folders
		    Route::get('/laravel-filemanager/newfolder', array('middleware' => 'auth','as'=>'panel.admin.laravel-filemanager.new_folder', 'uses'=>'File\FolderController@getAddfolder'));
		    Route::get('/laravel-filemanager/deletefolder', array('middleware' => 'auth','as'=>'panel.admin.laravel-filemanager.delete_folder', 'uses'=>'File\FolderController@getDeletefolder'));
		    Route::get('/laravel-filemanager/folders', array('middleware' => 'auth','as'=>'panel.admin.laravel-filemanager.folders', 'uses'=>'File\FolderController@getFolders'));
		    // crop
		    Route::get('/laravel-filemanager/crop', array('middleware' => 'auth','as'=>'panel.admin.laravel-filemanager.crop', 'uses'=>'File\CropController@getCrop'));
		    Route::get('/laravel-filemanager/cropimage', array('middleware' => 'auth','as'=>'panel.admin.laravel-filemanager.cropimage', 'uses'=>'File\CropController@getCropimage'));
		    // rename
		    Route::get('/laravel-filemanager/rename', array('middleware' => 'auth','as'=>'panel.admin.laravel-filemanager.rename', 'uses'=>'File\RenameController@getRename'));
		    // scale/resize
		    Route::get('/laravel-filemanager/resize', array('middleware' => 'auth','as'=>'panel.admin.laravel-filemanager.resize', 'uses'=>'File\ResizeController@getResize'));
		    Route::get('/laravel-filemanager/doresize', array('middleware' => 'auth','as'=>'panel.admin.laravel-filemanager.doresize', 'uses'=>'File\ResizeController@performResize'));
		    // download
		    Route::get('/laravel-filemanager/download', array('middleware' => 'auth','as'=>'panel.admin.laravel-filemanager.download', 'uses'=>'File\DownloadController@getDownload'));
		    // delete
		    Route::get('/laravel-filemanager/delete', array('middleware' => 'auth','as'=>'panel.admin.laravel-filemanager.delete', 'uses'=>'File\DeleteController@getDelete'));
    		/******laravel-filemanager, for ckeditor******/

			//banks management
			Route::get('bank/manage', array('middleware' => 'auth','as'=>'panel.admin.bank_manage','uses'=>'Admin\BankController@index'));
			Route::get('bank/add', array('middleware' => 'auth','as'=>'panel.admin.bank_add','uses'=>'Admin\BankController@add'));
			Route::post('bank/add', array('middleware' => 'auth','as'=>'panel.admin.bank_add','uses'=>'Admin\BankController@create'));
			Route::get('bank/edit/{id}', array('middleware' => 'auth','as'=>'panel.admin.bank_edit','uses'=>'Admin\BankController@edit'));
			Route::post('bank/edit/{id}', array('middleware' => 'auth','as'=>'panel.admin.bank_edit','uses'=>'Admin\BankController@update'));
			Route::get('bank/delete/{id}', array('middleware' => 'auth','as'=>'panel.admin.bank_delete','uses'=>'Admin\BankController@delete'));
			Route::get('bank/actions', array('middleware' => 'auth','as'=>'panel.admin.bank_actions','uses'=>'Admin\BankController@actions'));

			//casino management
			Route::get('casino/manage', array('middleware' => 'auth','as'=>'panel.admin.casino_manage','uses'=>'Admin\CasinoController@index'));
			Route::get('casino/add', array('middleware' => 'auth','as'=>'panel.admin.casino_add','uses'=>'Admin\CasinoController@add'));
			Route::post('casino/add', array('middleware' => 'auth','as'=>'panel.admin.casino_add','uses'=>'Admin\CasinoController@create'));
			Route::get('casino/edit/{id}', array('middleware' => 'auth','as'=>'panel.admin.casino_edit','uses'=>'Admin\CasinoController@edit'));
			Route::post('casino/edit/{id}', array('middleware' => 'auth','as'=>'panel.admin.casino_edit','uses'=>'Admin\CasinoController@update'));
			Route::get('casino/delete/{id}', array('middleware' => 'auth','as'=>'panel.admin.casino_delete','uses'=>'Admin\CasinoController@delete'));
			Route::get('casino/actions', array('middleware' => 'auth','as'=>'panel.admin.casino_actions','uses'=>'Admin\CasinoController@actions'));
		
			//transaction management
			Route::get('transaction/add', array('middleware' => 'auth','as'=>'panel.admin.transaction_add','uses'=>'Admin\TransactionController@add'));
			Route::post('transaction/add', array('middleware' => 'auth','as'=>'panel.admin.transaction_add','uses'=>'Admin\TransactionController@create'));
			Route::get('transaction/manage', array('middleware' => 'auth','as'=>'panel.admin.transaction_manage','uses'=>'Admin\TransactionController@index'));
			Route::get('transaction/verify/{id}', array('middleware' => 'auth','as'=>'panel.admin.transaction_verify','uses'=>'Admin\TransactionController@view'));
			Route::post('transaction/verify/{id}', array('middleware' => 'auth','as'=>'panel.admin.transaction_verify','uses'=>'Admin\TransactionController@verify'));
			Route::get('transaction/actions', array('middleware' => 'auth','as'=>'panel.admin.transaction_actions','uses'=>'Admin\TransactionController@actions'));

			Route::get('transfer/manage', array('middleware' => 'auth','as'=>'panel.admin.transfer_manage','uses'=>'Admin\TransferController@index'));
			Route::get('transfer_history/manage', array('middleware' => 'auth','as'=>'panel.admin.transfer_history_manage','uses'=>'Admin\TransferController@history'));
			Route::get('transfer/verify/{id}', array('middleware' => 'auth','as'=>'panel.admin.transfer_verify','uses'=>'Admin\TransferController@view'));
			Route::post('transfer/verify/{id}', array('middleware' => 'auth','as'=>'panel.admin.transfer_verify','uses'=>'Admin\TransferController@verify'));
			
			//transaction history management
			Route::get('history/manage', array('middleware' => 'auth','as'=>'panel.admin.history_manage','uses'=>'Admin\TransactionHistoryController@index'));
			Route::get('history/view/{id}', array('middleware' => 'auth','as'=>'panel.admin.history_view','uses'=>'Admin\TransactionHistoryController@view'));
			Route::get('history/actions', array('middleware' => 'auth','as'=>'panel.admin.history_actions','uses'=>'Admin\TransactionHistoryController@actions'));

			//company bank details management
			Route::get('company/manage', array('middleware' => 'auth','as'=>'panel.admin.company_manage','uses'=>'Admin\CompanyController@index'));
			Route::get('company/add', array('middleware' => 'auth','as'=>'panel.admin.company_add','uses'=>'Admin\CompanyController@add'));
			Route::post('company/add', array('middleware' => 'auth','as'=>'panel.admin.company_add','uses'=>'Admin\CompanyController@create'));
			Route::get('company/edit/{id}', array('middleware' => 'auth','as'=>'panel.admin.company_edit','uses'=>'Admin\CompanyController@edit'));
			Route::post('company/edit/{id}', array('middleware' => 'auth','as'=>'panel.admin.company_edit','uses'=>'Admin\CompanyController@update'));
			Route::get('company/delete/{id}', array('middleware' => 'auth','as'=>'panel.admin.company_delete','uses'=>'Admin\CompanyController@delete'));
			Route::get('company/actions', array('middleware' => 'auth','as'=>'panel.admin.company_actions','uses'=>'Admin\CompanyController@actions'));
			
			Route::get('backup', array('middleware' => 'auth','as'=>'panel.admin.backup','uses'=>'Admin\BackupController@backup'));
			Route::post('backup', array('middleware' => 'auth','as'=>'panel.admin.backup','uses'=>'Admin\BackupController@backup_post'));
			Route::get('restore', array('middleware' => 'auth','as'=>'panel.admin.restore','uses'=>'Admin\BackupController@restore'));
			Route::post('restore', array('middleware' => 'auth','as'=>'panel.admin.restore','uses'=>'Admin\BackupController@restore_post'));
		});
	});
});
