<?php
/**
 *	Filemanager PHP connector
 *  This file should at least declare auth() function 
 *  and instantiate the Filemanager as '$fm'
 *  
 *  IMPORTANT : by default Read and Write access is granted to everyone
 *  Copy/paste this file to 'user.config.php' file to implement your own auth() function
 *  to grant access to wanted users only
 *
 *	filemanager.php
 *	use for ckeditor filemanager
 *
 *	@license	MIT License
 *  @author		Simon Georget <simon (at) linea21 (dot) com>
 *	@copyright	Authors
 */

// Laravel init
require getcwd() . '/../../../../bootstrap/autoload.php';
$app = require_once getcwd() . '/../../../../bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Http\Kernel');
$response = $kernel->handle(
  $request = Illuminate\Http\Request::capture()
);
$id = $app['encrypter']->decrypt($_COOKIE[$app['config']['session.cookie']]);
$app['session']->driver()->setId($id);
$app['session']->driver()->start();

// Folder path
$folderPath = $app->basePath() . '/public/filemanager/userfiles/'; 

// Check if user in authentified
if(!$app['auth']->check()) 
{
  $laravelAuth = false;
} 
else 
{
  // Check if user has all access
  if($app['auth']->user()->is_admin)
  {
    $laravelAuth = true; 
  } 
  else
  {
  	$laravelAuth = false;
  }
}


/**
 *	Check if user is authorized
 *	
 *
 *	@return boolean true if access granted, false if no access
 */
function auth() {
  // You can insert your own code over here to check if the user is authorized.
  // If you use a session variable, you've got to start the session first (session_start())
  return $GLOBALS['laravelAuth'];
}


// @todo Work on plugins registration
// if (isset($config['plugin']) && !empty($config['plugin'])) {
// 	$pluginPath = 'plugins' . DIRECTORY_SEPARATOR . $config['plugin'] . DIRECTORY_SEPARATOR;
// 	require_once($pluginPath . 'filemanager.' . $config['plugin'] . '.config.php');
// 	require_once($pluginPath . 'filemanager.' . $config['plugin'] . '.class.php');
// 	$className = 'Filemanager'.strtoupper($config['plugin']);
// 	$fm = new $className($config);
// } else {
// 	$fm = new Filemanager($config);
// }


// we instantiate the Filemanager
$fm = new Filemanager();

?>