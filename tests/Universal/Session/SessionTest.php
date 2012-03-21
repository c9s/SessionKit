<?php 

namespace Universal\Session;
use PHPUnit_Framework_TestCase;
use Exception;

class SessionTest extends PHPUnit_Framework_TestCase
{
    function testSession()
    {
        $session = new \SessionKit\Session(array(  
            'state'   => new \SessionKit\State\CookieState,
            'storage' => new \SessionKit\Storage\MemcacheStorage,
        ));
        $counter = $session->get( 'counter' );
        $session->set( 'counter' , ++$counter );
        ok( $session->get( 'counter' ) );
    }

    function testNativeSession()
    {
        @$session = new \SessionKit\Session(array(  
            'state'   => new \SessionKit\State\NativeState,
            'storage' => new \SessionKit\Storage\NativeStorage,
        ));
        $counter = $session->get( 'counter' );
        $session->set( 'counter' , ++$counter );
        $c = $session->get( 'counter' );
        ok( $c );
    }
}

