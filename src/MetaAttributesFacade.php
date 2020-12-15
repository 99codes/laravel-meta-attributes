<?php

namespace Nncodes\MetaAttributes;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Nncodes\MetaAttributes\MetaAttributes
 */
class MetaAttributesFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-meta-attributes';
    }
}
