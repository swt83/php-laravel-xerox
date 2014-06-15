<?php

namespace Travis;

class Xerox
{
    /**
     * Return a cached copy of the page.
     *
     * @param   object  $request
     * @return  string
     */
    public static function before($request)
    {
        // if NOT get method...
        if (!$request->isMethod('get'))
        {
            // bail
            return null;
        }

        // get url
        $url = \URL::full();

        // determine if cachable, consult config...
        $pass = true;
        foreach (\Config::get('xerox::ignore', array()) as $u)
        {
            if (preg_match('/'.$u.'/i', $url))
            {
                $pass = false;
            }
        }

        // if cachable...
        if ($pass)
        {
            // set hash
            $hash = md5($url);

            // get cache
            $cache = \Cache::get($hash);

            // if found...
            if ($cache)
            {
                // "skip to the end!"
                return $cache;
            }

            // if NOT found...
            else
            {
                // set flag to cache
                $_SERVER['xerox'] = $hash;
            }
        }
    }

    /**
     * Save a cached copy of the page.
     *
     * @param   object  $request
     * @param   object  $response
     * @return  void
     */
    public static function after($request, $response)
    {
        // get hash (meaning, cache this now)
        $hash = isset($_SERVER['xerox']) ? $_SERVER['xerox'] : null;

        // if cachable...
        if ($hash)
        {
            // if not normal response object...
            if (get_class($response) !== 'Illuminate\Http\Response')
            {
                // bail
                return null;
            }

            // if status code not 200...
            $status = $response->headers->get('Status-Code');
            if ($status and $status !== 200)
            {
                // bail
                return null;
            }

            // get html
            $html = $response->getOriginalContent()->render();

            // cache
            \Cache::put($hash, $html, \Config::get('xerox::cooldown', 5));
        }
    }
}