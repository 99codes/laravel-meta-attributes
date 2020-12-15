<?php

namespace Nncodes\MetaAttributes\Concerns;

use Nncodes\MetaAttributes\Models\MetaAttribute;

trait HasMetaAttributes
{
    public function metaAttributes()
    {
        return $this->morphOne(MetaAttribute::class, 'model');
    }

    public function setMetaAttribute(string $key, $value)
    {
        return $this->metaAttributes()->updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public function getMetaAttribute(string $key)
    {
        return $this->metaAttributes()->firstWhere('key', $key);
    }

    public function hasMetaAttribute(string $key)
    {
        return $this->metaAttributes()->where('key', $key)->count() > 0;
    }

    public function forgetMetaAttribute(string $key)
    {
        return $this->metaAttributes()->where('key', $key)->delete();
    }
}
