<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class AdminMiddleware {

	protected $auth;

	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if ($this->auth->check() && (bool)$request->user()->is_verified)
		{
			if (!(bool)$request->user()->is_admin)
	        {
	            return redirect('/panel');
	        }
	    }
	    else
	    {
	    	return redirect('/auth/login');
	    }

		return $next($request);
	}

}
