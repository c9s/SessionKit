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

    public function setCookieParams($seconds)
    {
        session_set_cookie_params($seconds);
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
