<?php namespace App\Http\Controllers\Admin;

use Auth;
//use App\User;
use App\Models\Inbox;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class BackupController extends BaseController {

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

	/*public function inbox($user_id)
	{	
		$inbox_list = Inbox::GetAllInbox($user_id)
						->paginate($this->paginate);
		//$inbox_list->setPath('manage');

		return view('admin.inbox_list')
				->with('user_id', $user_id)
				->with('inbox_list', $inbox_list)
				->with('fullscreen', '0');
	}*/
	
	public function backup() 
	{	

		return \View::make('admin.backup')
				->with('fullscreen', '0');
	}
	
	public function backup_post() 
	{	
		$return = "";
		$tables = array();
		//$result = mysql_query('SHOW TABLES');
		$results = \DB::select('SHOW TABLES');
		foreach($results as $result) {
			$tables[] = $result->Tables_in_zadmin_topup;
		}
		//while($row = mysql_fetch_row($result))
		//{
		//	$tables[] = $row[0];
		//}

		//cycle through
		foreach($tables as $table)
		{
			$result = \DB::select('SELECT * FROM '.$table);
		//echo "<pre>";
		//print_r($result);
		//echo "</pre>";			
			$num_fields = \Schema::getColumnListing($table);
			//echo count($number);
			if(count($result) > 0) {
			//$num_fields = mysql_num_fields($result);
			//if($struc)$return.= 'DROP TABLE '.$table.';';
			//$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
			//if($struc)$return.= "\n\n".$row2[1].";\n\n";
			//$return.= 'DROP TABLE if exists '.$table.';';
			//$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
			//$return.= "\n\n".$row2[1].";\n\n";
//print_r($num_fields);			
			//if($data){
			//for ($i = 0; $i < count($num_fields); $i++) 
			//{
				foreach($result as $row)
				//while($row = mysql_fetch_row($result))
				{
					$return.= 'INSERT INTO `'.$table.'` VALUES(';
					for($j=0; $j< count($num_fields); $j++) 
					{
					//print_r($row->$num_fields[$j]);
						$row->$num_fields[$j] = addslashes($row->$num_fields[$j]);
						//$row->$num_fields[$j] = ereg_replace("\n","\\n",$row->$num_fields[$j]);
						if (isset($row->$num_fields[$j])) {
							if($row->$num_fields[$j] == null)
								$return .= 'null' ;
							else
								$return .= '"' . $row->$num_fields[$j] . '"' ; 
						} else { 
							$return.= '""'; 
						}
						if ($j<(count($num_fields)-1)) { $return.= ','; }
					}
					$return.= ");\n";
				}
			//}
			//}
			}
		}
		$return.="\n\n\n";
		
		//save file
		//header("Content-Type:text/html; charset=utf-8");
		header('Content-Type: application/octet-stream; charset=utf-8;');   
        header('Content-Transfer-Encoding: Binary'); 
        header('Content-disposition: attachment; filename="db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql"');  
        echo $return; exit;
		//header('Content-Type: text/sql');
		//header('Content-Disposition: attachment; filename="db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql"');
		//$handle = fopen('db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql','w+');
		//fwrite($file, "Content-Type: text/xml; charset=utf-8\n")  
		//fwrite($handle, $return);
		//fclose($handle);

		//return \View::make('admin.backup')
		//		->with('message', 'Backup successfully')
		//		->with('fullscreen', '0');
	}
	
	public function restore() 
	{	

		return \View::make('admin.restore')
				->with('fullscreen', '0');
	}
	
	public function restore_post(Request $request) 
	{
		$file = \Input::file('file');

		if($file != null){
			$validator = Validator::make($request->all(), [
	            'text' => 'mimes:sql'
	        ]);

			if ($validator->fails()) {
	            return \Redirect::back()
							->with('error_message', 'Restore fail!')
	                        ->withInput();
	        }
		}

		$file_location = ($file == null) ? "" : $this->upload_file($file);
		//echo $file_location;
		$tables = array();
		$results = \DB::select('SHOW TABLES');
		foreach($results as $result) {
			$tables[] = $result->Tables_in_paneldb;
		}

		//cycle through
		foreach($tables as $table)
		{
			\DB::select('TRUNCATE TABLE `' . $table . '`');
		}

		// Temporary variable, used to store current query
		$templine = '';
		// Read in entire file
		$lines = file($file_location);
		// Loop through each line
		foreach ($lines as $line)
		{
			// Skip it if it's a comment
			if (substr($line, 0, 2) == '--' || $line == '')
				continue;

			// Add this line to the current segment
			$templine .= $line;
			// If it has a semicolon at the end, it's the end of the query
			if (substr(trim($line), -1, 1) == ';')
			{
				// Perform the query
				\DB::statement($templine);
				//mysql_query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
				// Reset temp variable to empty
				$templine = '';
			}
		}
		
		unlink($file_location);
		
		return \View::make('admin.restore')
				->with('message', 'Restore successfully!')
				->with('fullscreen', '0');
	}
	
	public function upload_file($file)
	{
		//folder path of the uploaded image
		$destinationPath = public_path() . "/images/upload/restore";

		//create folder if not exists
		if(!file_exists($destinationPath))
			mkdir($destinationPath, 0777, true);
		
		//getting image extension
		$extension = $file->getClientOriginalExtension(); 
	    
	    //renaming image
	    $fileName = Auth::user()->name . "_" . rand(111111,999999) . '.' . $extension;
	    
	    //uploading file to given path
	    $file->move($destinationPath, $fileName); 

		$image_location = $destinationPath . '/' . $fileName;

		return $image_location;
	}
	
}
