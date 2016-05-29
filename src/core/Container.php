<?php
/**
 * P8P Framework - https://github.com/hpolaert/p8p
 *
 * @link      https://github.com/hpolaert/p8p
 * @copyright Copyright (c) 2016 Hugues Polaert
 * @license   https://github.com/hpolaert/p8p/LICENCE.md (MIT)
 */
namespace P8P\Core;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Interop\Container\Exception\NotFoundException;


/**
 * Container
 *
 * Simple dependency injection container
 * Implements Interop Container interface
 */

class Container implements ContainerInterface  {

    /**
     * @var array $keys Store containers services and parameters
     */
    protected $keys = [];

    /**
     * @var array $shared Store shared services
     */
    protected $shared = [];

    /**
     * @var bool $singletonActive Default
     */
    protected $singletonActive = false;

    /**
     * Magic setter for service registration
     *
     * @param String      $key        Service ID
     * @param String      $call       Callable or parameter
     * @param bool|false  $share      Shared Instance
     */
    public function __set($key, $call, $share = false) {
        if($call instanceof Closure and
            // If singleton pattern...
            ($share === true || $this->singletonActive == true)){
                $this->shared[$key] = $call();
        }
        // Else store the property / callable
        $this->keys[$key] = $call;
    }

    /**
     * Return a property/callable method
     *
     * @param $key  String  Service ID
     * @return mixed
     */
    public function __get($key) {
        // Lookup for singleton instanciation
        if(array_key_exists($key, $this->shared)){
            $instance = $this->keys[$key];
            return $instance;
        } elseif(array_key_exists($key, $this->keys)){
            // Else default instanciation
            $key = $this->keys[$key]($this);
            return $key;
        } else {
            // throw not found
        }
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
     * It does however mean that `get($id)` will not throw a `NotFoundException`.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return string
     */

    public function has($id) : bool {
        if(array_key_exists($id, $this->keys)
            || array_key_exists($id, $this->shared)) {
            return true;
        }
        return false;
    }

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @throws NotFoundException  No entry was found for this identifier.
     * @throws ContainerException Error while retrieving the entry.
     *
     * @return mixed Entry.
     */
    public function get($id){
        return $this->$id;
    }

    /**
     * @param boolean $singletonActive
     */
    public function setSingletonActive($singletonActive)
    {
        $this->singletonActive = $singletonActive;
    }
}