<?php 
namespace SessionKit;
use ArrayAccess;

/**
 * Session manager class.
 *
 * TODO:
 * - support Session Save Handler 
 */
class Session 
    implements ArrayAccess
{
    private $state;
    private $storage;
    private $saveHandler;


    /**
     * contruct
     *
     * @param array|Container\ObjectContainer $options default option
     *
     * options:
     *   can be ObjectContainer or array.
     *
     *   array:
     *      state: State object.
     *      storage: Storage object.
     *      save_handler: session save handler
     *          once this is enabled, use native session storage for session.
     */
    public function __construct( $options = array() )
    {
        if( is_array( $options ) ) 
        {
            if( isset($options['storage']) ) {
                $this->storage = $options['storage'];
                $this->state = isset($options['state']) 
                    ? $options['state'] 
                    : new State\NativeState;
                                // : new State\Cookie; // or built-in
            }
            elseif( isset($options['save_handler']) ) {
                $this->saveHandler = $options['save_handler'];
                $this->state = new State\NativeState;
                $this->storage = new Storage\NativeStorage;
            }
            else {
                $this->state = new State\NativeState;
                $this->storage = new Storage\NativeStorage;
            }
        }
        elseif ( is_a( '\Container\ObjectContainer', $options ) ) 
        {

            /* use save handler or storage */
            if( $s = $options->storage ) {
                $this->storage = $s;
                $this->state   = $options->state ?: new State\NativeState;
            } elseif( $h = $options->saveHandler ) {
                $this->saveHandler = $h;
                $this->state = new State\NativeState;
                $this->storage = new Storage\NativeStorage;
            } else {
                $this->state = new State\NativeState;
                $this->storage = new Storage\NativeStorage;
            }
        }

        // load session data by session id.
        $this->storage->load( $this->state->getSid() );
    }

    /**
     * @return SessionKit\State
     */
    public function getState()
    {
        return $this->state;
    }


    /**
     * @return SessionKit\Storage
     */
    public function getStorage()
    {
        return $this->storage;
    }


    /**
     * @return SessionKit\SaveHandler
     */
    public function getSaveHandler()
    {
        return $this->saveHandler;
    }





    public function __call($m,$a)
    {
        if( method_exists($this->storage,$m) ) {
            return call_user_func_array( array($this->storage,$m), $a );
        }
        throw new Exception("method $m not found.");
    }
        
    public function __set($name,$value)
    {
        return $this->storage->set( $name, $value );
    }

    public function __get($name)
    {
        return $this->storage->get( $name );
    }

    public function __isset($name)
    {
        return $this->storage->has( $name );
    }


    /**
     * ArrayAccess interface method
     *
     * @param string $name
     * @param string $value
     */
    public function offsetSet($name,$value) 
    {
        return $this->storage->set( $name, $value );
    }

    public function offsetGet($name) 
    {
        return $this->storage->get( $name );
    }

    public function offsetExists($name) 
    {
        return $this->storage->has( $name );
    }

    public function offsetUnset($name) 
    {
        return $this->storage->delete( $name );
    }

}
