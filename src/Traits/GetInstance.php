<?php


namespace App\Traits;


trait GetInstance
{
    public static function getInstance(...$args)
    {
        return new static(...$args);
    }
}
