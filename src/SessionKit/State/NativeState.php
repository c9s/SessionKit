<?php 
namespace SessionKit\State;

class NativeState
{

    function __construct()
    {
        if ( ! isset($_SESSION) ) {
            if ( isset($_REQUEST['session_expiry']) ) {
                session_set_cookie_params(intval($_REQUEST['session_expiry'])); // 1 month
            }
            session_start();
            if ( isset($_REQUEST['session_expiry']) ) {
                setcookie(session_name(),session_id(),time()+ intval($_REQUEST['session_expiry']) );
            }
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

