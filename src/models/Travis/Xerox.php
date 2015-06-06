<?php

namespace Travis;

class Xerox {

    /**
     * Return a cached copy of the page.
     *
     * @param   object  $request
     * @return  string
     */
    public static function before($request)
    {
        // if not activated...
        if (!\Config::get('xerox.is_active'))
        {
            // bail
            return null;
        }

        // if NOT get method...
        if (!$request->isMethod('get'))
        {
            // bail
            return null;
        }

        // get uri
        $uri = \Request::path();

        // determine if cachable, consult config...
        foreach (\Config::get('xerox.ignore', array()) as $u)
        {
            // if caught...
            if (preg_match('/'.$u.'/i', $uri))
            {
                // bail
                return false;
            }
        }

        // return from cache
        return \Cache::get(static::hash());
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
        // if not normal response object...
        if (get_class($response) !== 'Illuminate\Http\Response')
        {
            // bail
            return null;
        }

        // It looks like any non-200 response doesn't flow through
        // the middleware.  So this check is unnecessary, but I will
        // leave it commented out in case I need it again someday.

        /*
        // if status code not 200...
        $status = $response->headers->get('Status-Code');
        if ($status and $status !== 200)
        {
            // bail
            return null;
        }
        */

        // get html
        $html = $response->getOriginalContent();

        // if response object...
        if (is_object($html))
        {
            // render
            $html = $html->render();

            // Presumtively, if $html is not an object, it is already
            // a string that can be returned directly.
        }

        // get cooldown
        $cooldown = \Config::get('xerox.cooldown', 5);

        // cache
        \Cache::put(static::hash(), $html, $cooldown);
    }

    protected static function hash()
    {
        // get url
        $url = \URL::full();

        // return
        return 'xerox_'.md5($url);
    }

}