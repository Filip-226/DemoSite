<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Inbox extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user_inbox';

	protected $primaryKey = 'inbox_id';

	protected $softDelete = true;
	
	public function scopeGetAllInbox($query, $user_id)
    {
        return $query->where('user_id', '=', $user_id)->whereNull('parent_id')->orderBy('created_at', 'asc');
    }

	public function scopeGetTitle($query, $msg_id)
    {
        return $query->where('inbox_id', '=', $msg_id);
    }
	
	public function scopeGetAllMessage($query, $msg_id)
    {
        return $query->join('users', 'users.user_id', '=', 'user_inbox.inbox_created_by')->where('inbox_id', '=', $msg_id)->orwhere('parent_id', '=', $msg_id)->orderBy('user_inbox.created_at', 'desc');
    }
}
