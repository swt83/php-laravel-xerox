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

		// if found...
		if ($response)
		{
			// This cached value is HTML only, not a formal
			// response object. So we need to fix it up.

			$response = response($response); // looks like facades dont work in middleware?

			// return
			return $response;
		}

		// build
    	$response = $next($request);

    	// save to cache
	    Xerox::after($request, $response);

		// return
		return $response;
	}

}