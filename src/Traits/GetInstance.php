<?php


namespace Inboxino\PhpApi\Traits;


trait GetInstance
{
    public static function getInstance(...$args)
    {
        return new static(...$args);
    }
}
