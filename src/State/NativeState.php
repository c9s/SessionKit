<?php 
namespace SessionKit\State;

class NativeState
{

    public function __construct()
    {
        if (!isset($_SESSION)) {
            @session_start();
        }
    }

    /**
     * Call session_set_cookie_params to set the cookie parameters.
     */
    public function setCookieParams(array $config)
    {
        // void session_set_cookie_params ( int $lifetime [, string $path [, string $domain [, bool $secure = false [, bool $httponly = false ]]]] )
        session_set_cookie_params(@$config['expire'], @$config['path'], @$config['domain'], @$config['secure'], @$config['httponly']);
    }

    public function getSid()
    {
        return session_id();
    }

    public function generateSid()
    {
        return session_regenerate_id();
    }
}
