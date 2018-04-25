<?php

namespace Awj;

use Countable;
use ArrayAccess;

class Collection implements ArrayAccess, Countable
{
    protected $items = [];

    public function __construct($items)
    {
        if (!is_array($items)) {
            $items = [$items];
        }
        $this->items = $items;
    }

    public static function new($items = [])
    {
        return new static($items);
    }

    /**
     * Push item into collection
     *
     * @param mixed $item
     *
     * @return $this
     */
    public function push($item)
    {
        array_push($this->items, $item);

        return $this;
    }

    public function first()
    {
        return reset($this->items);
    }

    public function last()
    {
        return end($this->items);
    }

    public function reverse()
    {
        return Collection::new(array_reverse($this->items));
    }

    public function random()
    {
        return $this->items[array_rand($this->items)];
    }

    public function get($item)
    {
        return $this->items[$item];
    }

    public function pop()
    {
        return array_pop($this->items);
    }

    public function shift()
    {
        return array_shift($this->items);
    }

    public function each($callback)
    {
        array_walk($this->items, $callback);
    }

    public function map($callback)
    {
        return Collection::new(array_map($callback, $this->items));
    }

    public function toArray()
    {
        return $this->items;
    }

    /**
     * Whether a offset exists
     *
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     *
     * @return bool true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     *
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    /**
     * Offset to retrieve
     *
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     *
     * @return mixed Can return all value types.
     *
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }

    /**
     * Offset to set
     *
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     *
     * @return void
     *
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        $this->items[$offset] = $value;
    }

    /**
     * Offset to unset
     *
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     *
     * @return void
     *
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }

    /**
     * Count elements of an object
     *
     * @link http://php.net/manual/en/countable.count.php
     *
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     *
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->items);
    }
}
