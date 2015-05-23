<?php

namespace Travis\Xerox;

use Travis\Xerox;

class Middleware {

	/**
	 * Return a cached or calculated response.
	 *
	 * @param	object	$request
	 * @param	object	$next
	 * @return	object
	 */
	public function handle($request, $next)
	{
		// load from cache
		$response = Xerox::before($request);

		// if not found...
		if (!$response)
		{
			// build
	    	$resonse = $next($request);

	    	// save to cache
		    Xerox::after($request, $response);
		}

		// return
		return $response;
	}

}