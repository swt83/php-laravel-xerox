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

        // set uncachable uris (regex)
        $uncachable = \Config::get('xerox::uncachable', array());

        // get url
        $url = \URL::full();

        // determine cachable...
        $pass = true;
        foreach ($uncachable as $u)
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
                $_SERVER['flatten'] = $hash;
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
        // get status
        $status = $response->headers->get('Status-Code');

        // if status not 200...
        if ($status and $status !== 200)
        {
            // bail
            return null;
        }

        // get hash (meaning, cache this now)
        $hash = isset($_SERVER['flatten']) ? $_SERVER['flatten'] : null;

        // if cachable...
        if ($hash)
        {
            // get html
            $html = $response->getOriginalContent()->render();

            // cache
            \Cache::put($hash, $html, 5);
        }
    }
}