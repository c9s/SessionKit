<?php 
namespace SessionKit\State;

class NativeState
{

    function __construct()
    {
        if ( ! isset($_SESSION) ) {
            if ( isset($_REQUEST['session_expiry']) ) {
                session_set_cookie_params($_REQUEST['session_expiry']); // 1 month
            }
            session_start();
        }
    }

    function getSid()
    {
        return session_id();
    }

    function generateSid()
    {
        return session_regenerate_id();
    }


}

