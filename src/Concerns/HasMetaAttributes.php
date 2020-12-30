<?php

namespace Nncodes\MetaAttributes\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Nncodes\MetaAttributes\Models\MetaAttribute;
use Nncodes\MetaAttributes\Support\AttributeCast;

trait HasMetaAttributes
{
    /**
     * Meta attributes morph many relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function metas(): MorphMany
    {
        return $this->morphMany(MetaAttribute::class, 'model');
    }

    /**
     * Set a meta attribute
     *
     * @param string $key
     * @param midex $value
     * @return \Nncodes\MetaAttributes\Support\AttributeCast
     */
    public function setMeta(string $key): AttributeCast
    {
        return AttributeCast::make($this->metas(), $key);
    }

    /**
     * Get a meta attribute
     *
     * @param string $key
     * @return \Nncodes\MetaAttributes\Models\MetaAttribute|null
     */
    public function getMeta(string $key): ?MetaAttribute
    {
        if ($meta = $this->metas()->firstWhere('key', $key)) {
            return $meta;
        }
    }

    /**
    * Get a collection of meta attributes
    *
    * @return object
    */
    public function getMetas(): object
    {
        return (object) $this->metas->pluck('value', 'key')->toArray();
    }

    /**
     * Accessor to a collection of meta attributes
     *
     * @return object
     */
    public function getMetaAttribute(): object
    {
        return $this->getMetas();
    }

    /**
     * Get a meta attribute value
     *
     * @param string $key
     * @param mixed|null $fallback
     * @return mixed
     */
    public function getMetaValue(string $key, $fallback = null)
    {
        if ($meta = $this->metas()->firstWhere('key', $key)) {
            return $meta->value;
        }

        return $fallback;
    }

    /**
     * Check if a meta attribute exists
     *
     * @param string $key
     * @return bool
     */
    public function hasMeta(string $key): bool
    {
        return (bool) $this->metas()->firstWhere('key', $key);
    }
    
    /**
     * Delete a meta attribute
     *
     * @param string $key
     * @return void
     */
    public function forgetMeta(string $key): void
    {
        $this->metas()->where('key', $key)->delete();
    }

    /**
     * Delete all meta attributes
     *
     * @return void
     */
    public function clearMetas(): void
    {
        $this->metas()->delete();
    }
}
