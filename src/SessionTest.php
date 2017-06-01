<?php 

namespace SessionKit;

use PHPUnit\Framework\TestCase;
use Exception;

class SessionTest extends TestCase
{
    /**
     * @require extension memcache
     */
    function testMemcacheSession()
    {
        $session = new Session([
            'state'   => new State\CookieState,
            'storage' => new Storage\MemcacheStorage,
        ]);
        $counter = $session->get( 'counter' );
        $session->set('counter' , ++$counter);
        $this->assertNotNull(1, $session->get( 'counter' ));
    }

    function testNativeSession()
    {
        @$session = new Session([
            'state'   => new State\NativeState,
            'storage' => new Storage\NativeStorage,
        ]);
        $counter = $session->get( 'counter' );
        $session->set( 'counter' , ++$counter );
        $c = $session->get( 'counter' );
        $this->assertNotNull($c);
    }
}

