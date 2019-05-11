<?php


namespace Matik\Swatchyy\Core;

use ArrayAccess;
use Matik\Swatchyy\Config\Configuration;

class Config implements Configuration, ArrayAccess
{
    /**
     * All of the configuration items.
     *
     * @var array
     */
    protected $items = [];
    /**
     * Create a new configuration repository.
     *
     * @param  array  $items
     *
     * @return void
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public function all()
    {
        return $this->items;
    }

    public function get($key, $default = null)
    {
        if ( ! isset($this->items[$key])) {
            return $default;
        }
        return apply_filters("matik/swatchyy/config/get/{$key}", $this->items[$key]);
    }

    public function set($key, $value = null)
    {
        $keys = is_array($key) ? $key : [$key => $value];
        foreach ($keys as $key => $value) {
            $this->items[$key] = apply_filters("matik/swatchyy/config/set/{$key}", $value);
        }
    }

    public function is_key_valid($key)
    {
        return isset($this->items[$key]);
    }

    public function offsetExists($offset)
    {
        return $this->is_key_valid($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    public function offsetUnset($offset)
    {

        $this->set($offset, null);
    }

}