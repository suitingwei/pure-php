<?php

namespace Arrayable\Src;

class Collection implements \Countable, \ArrayAccess, \Iterator
{
    private $data = null;
    private $arrayPosition = 0;

    public function __construct($arrayable = [])
    {
        $this->data = $arrayable;
    }

    /**
     *
     * @param $arrayable
     * @return Collection
     */
    public static function create($arrayable)
    {
        return new self($arrayable);
    }

    /**
     * @param $begin
     * @param $end
     * @return Collection
     */
    public static function range($begin, $end)
    {
        if ($begin >= $end) {
            return new self;
        }

        return new self(range($begin, $end));
    }

    /**
     * @param callable $callback
     * @return Collection
     */
    public function map(callable $callback)
    {
        $data = array_map($callback, $this->data);

        return new self($data);
    }

    public function __toString()
    {
        return json_encode($this->data);
    }

    /**
     * @param callable|null $callback
     * @return Collection
     */
    public function filter(callable $callback = null)
    {
        if (is_null($callback)) {
            $data = array_filter($this->data);
        } else {
            $data = array_filter($this->data, $callback, ARRAY_FILTER_USE_BOTH);
        }

        return new self($data);
    }

    /**
     * Return all items.
     * @return array
     */
    public function all()
    {
        return $this->data;
    }

    /**
     * @param null $key
     * @return float|int
     */
    public function average($key = null)
    {
        if (is_null($key)) {
            return array_sum($this->data) / count($this->data);
        }

        $columnArray = array_column($this->data, $key);

        return array_sum($columnArray) / count($columnArray);
    }

    /**
     * Taken only these keys' values.
     * @param $keys
     * @return Collection
     * @internal param $key
     */
    public function only($keys = null)
    {
        if (is_null($keys)) {
            return $this;
        }

        $keys = is_array($keys) ? $keys : func_get_args();

        $data = array_intersect_key($this->data, array_flip($keys));

        return new self($data);
    }

    /**
     * Split the whole array into pieces.
     * @param $size
     * @return Collection
     */
    public function chunk($size)
    {
        $result = [];
        foreach (array_chunk($this->data, $size) as $part) {
            $result [] = new self($part);
        }

        return new self($result);
    }

    /**
     * Get the values except these keys.
     * @param null $keys
     * @return Collection
     */
    public function except($keys = null)
    {
        $keys = is_array($keys) ? $keys : func_get_args();

        $data = array_diff_key($this->data, array_flip($keys));

        return new self($data);
    }

    /**
     * Count elements of an object
     * @return  int
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * Whether a offset exists
     * @return  boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    /**
     * Offset to retrieve
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    /**
     * Offset to set
     */
    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    /**
     * Offset to unset
     */
    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->data[$this->arrayPosition];
    }

    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        $this->arrayPosition++;
    }

    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->arrayPosition;
    }

    /**
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return isset($this->data[$this->arrayPosition]);
    }

    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->arrayPosition = 0;
    }

    public function collapse()
    {
        $result = [];
        foreach ($this->data as $value) {
            if ($value instanceof Collection) {
                $value = $value->all();
            }
            $result = array_merge($result, $value);
        }

        return new self($result);
    }

    /**
     * Combine the data with the values.
     * @param $values
     * @return Collection
     */
    public function combine($values)
    {
        $values = is_array($values) ? $values : func_get_args();

        $valuesCount = count($values);

        if ($valuesCount < ($count = $this->count())) {
            $values = array_pad($values, $count, null);
        }

        $data = array_combine(array_keys($this->data), $values);

        return new self($data);
    }

    /**
     * Determines whether the items contains a specific key.
     * @param $key
     * @return bool
     */
    public function contains($key)
    {
        return array_key_exists($key, array_keys($this->data));
    }

    /**
     * Get values which the key not in array.
     * @param $string
     * @param $array
     * @return Collection
     */
    public function whereNotIn($string, $array)
    {
        $data = $this->filter(function ($value) use ($string, $array) {
            return !in_array($value[$string], $array);
        });

        return new self($data);
    }

    /**
     * Unique the items.
     * @param null $key
     * @return Collection
     */
    public function unique($key = null)
    {
        if (is_null($key)) {
            return new self(array_unique($this->data));
        }
        $exists = [];

    }
}