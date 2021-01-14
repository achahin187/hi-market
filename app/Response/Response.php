<?php


namespace App\Response;


class Response
{
    private $attributes = [];


    public function __get($name)
    {
        if (array_key_exists($name, $this->attributes)) {
            return $this->attributes[$name];
        }
        return null;
    }

    public static function __callStatic($name, $arguments)
    {
        return (new self)->$name(...$arguments);
    }

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public  function create($arr)
    {
        $this->attributes = $arr;
    }

}
