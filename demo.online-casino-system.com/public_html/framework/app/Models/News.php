<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class News extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'news';

	protected $primaryKey = 'news_id';

	protected $softDelete = true;

	public function scopeGetAllNews($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }

    public function scopeSearchNewsByTitle($query, $title)
    {
        return $query->where('title', 'like', '%'.$title.'%')
        			 ->orderBy('updated_at', 'desc');
    }

    public function scopeGetUserNews($query, $user_id)
    {
        return $query->where('user_id', '=', $user_id)
        			 ->orderBy('updated_at', 'desc');
    }

    public function scopeSearchUserNewsByTitle($query, $title, $user_id)
    {
        return $query->where('title', 'like', '%'.$title.'%')
        			 ->where('user_id', '=', $user_id)
        			 ->orderBy('updated_at', 'desc');
    }

    public function scopeGetLatestNewsList($query)
    {
        return $query->orderBy('created_at', 'desc')
                     ->take(10);    
    }
}
