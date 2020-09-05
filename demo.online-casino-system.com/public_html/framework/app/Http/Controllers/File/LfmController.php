<?php namespace App\Http\Controllers\File;

use Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Intervention\Image\Facades\Image;
use Illuminate\Routing\Controller as BaseController;

/**
 * Class LfmController
 * @package Tsawler\Laravelfilemanager\controllers
 */
class LfmController extends BaseController {

    /**
     * @var
     */
    protected $file_location;

    /**
     * Constructor
     */
    public function __construct()
    {
        if ((Session::has('lfm_type')) && (Session::get('lfm_type') == 'Files'))
        {
            $this->file_location = Config::get('lfm.files_dir');
        } else
        {
            $this->file_location = Config::get('lfm.images_dir');
        }
    }


    /**
     * Show the filemanager
     *
     * @return mixed
     */
    public function show()
    {
        if ((Input::has('type')) && (Input::get('type') == "Files"))
        {
            Session::put('lfm_type', 'Files');
            $this->file_location = Config::get('lfm.files_dir');
        } else
        {
            Session::put('lfm_type', 'Images');
            $this->file_location = Config::get('lfm.images_dir');
        }

        if (Input::has('base'))
        {
            $working_dir = Input::get('base');
            $base = $this->file_location . Input::get('base') . "/";
        } else
        {
            $working_dir = "/";
            $base = $this->file_location;
        }

        return View::make('file.index')
            ->with('base', $base)
            ->with('working_dir', $working_dir);
    }

}
