<?php

namespace Nncodes\MetaAttributes\Support;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Nncodes\MetaAttributes\Models\MetaAttribute;

class AttributeCast
{
    /**
     * Meta attribute key
     *
     * @var string
     */
    protected string $key;

    /**
     * MorphMany relation
     *
     * @var \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    protected $relationship;

    /**
     * Create a new instance
     *
     * @param \Illuminate\Database\Eloquent\Relations\MorphMany $relationship
     * @param string $key
     */
    public function __construct(MorphMany $relationship, string $key)
    {
        $this->relationship = $relationship;
        $this->key = $key;
    }

    /**
     * Build a new instance
     *
     * @param \Illuminate\Database\Eloquent\Relations\MorphMany $relationship
     * @param string $key
     * @return self
     */
    public static function make(MorphMany $relationship, string $key): self
    {
        return new static($relationship, $key);
    }

    /**
     * Store the value and cast
     *
     * @param string $type
     * @param mixed $value
     * @return \Nncodes\MetaAttributes\Models\MetaAttribute
     */
    protected function storeCastingAs(string $type, $value): MetaAttribute
    {
        if ($meta = $this->relationship->firstWhere('key', $this->key)) {
            $meta->fill([
                'type' => $type,
                'value' => $value,
            ])->save();

            return $meta;
        }

        return $this->relationship->create([
            'key' => $this->key,
            'type' => $type,
            'value' => $value,
        ]);
    }

    /**
     * Create a meta attribute casting the value as array
     *
     * @param array $value
     * @return \Nncodes\MetaAttributes\Models\MetaAttribute
     */
    public function asArray(array $value): MetaAttribute
    {
        return $this->storeCastingAs('array', $value);
    }

    /**
     * Create a meta attribute casting the value as boolean
     *
     * @param mixed $value
     * @return \Nncodes\MetaAttributes\Models\MetaAttribute
     */
    public function asBoolean($value): MetaAttribute
    {
        return $this->storeCastingAs('boolean', $value);
    }

    /**
     * Create a meta attribute casting the value as collection
     *
     * @param mixed $value
     * @return \Nncodes\MetaAttributes\Models\MetaAttribute
     */
    public function asCollection($value): MetaAttribute
    {
        return $this->storeCastingAs('collection', $value);
    }

    /**
    * Create a meta attribute casting the value as date
    *
    * @param string @format
    * @param mixed $value
    * @return \Nncodes\MetaAttributes\Models\MetaAttribute
    */
    public function asDate($value, $format = 'Y-m-d'): MetaAttribute
    {
        $value = $value instanceof \Carbon\Carbon ? $value->format($format) : $value;

        return $this->storeCastingAs('date:' . $format, $value);
    }

    /**
     * Create a meta attribute casting the value as datetime
     *
     * @param string @format
     * @param mixed $value
     * @return \Nncodes\MetaAttributes\Models\MetaAttribute
     */
    public function asDatetime($value, $format = 'Y-m-d H:i:s'): MetaAttribute
    {
        $value = $value instanceof \Carbon\Carbon ? $value->format($format) : $value;

        return $this->storeCastingAs('datetime:' . $format, $value);
    }

    /**
     * Create a meta attribute casting the value as decimal
     *
     * @param mixed $value
     * @param int $digits
     * @return \Nncodes\MetaAttributes\Models\MetaAttribute
     */
    public function asDecimal($value, int $digits = 2): MetaAttribute
    {
        return $this->storeCastingAs('decimal:' . $digits, $value);
    }

    /**
     * Create a meta attribute casting the value as double
     *
     * @param mixed $value
     * @return \Nncodes\MetaAttributes\Models\MetaAttribute
     */
    public function asDouble($value): MetaAttribute
    {
        return $this->storeCastingAs('double', $value);
    }

    /**
     * Create a meta attribute casting the value as encrypted
     *
     * @param mixed $value
     * @return \Nncodes\MetaAttributes\Models\MetaAttribute
     */
    public function asEncrypted($value): MetaAttribute
    {
        return $this->storeCastingAs('encrypted', $value);
    }

    /**
     * Create a meta attribute casting the value as float
     *
     * @param mixed $value
     * @return \Nncodes\MetaAttributes\Models\MetaAttribute
     */
    public function asFloat($value): MetaAttribute
    {
        return $this->storeCastingAs('float', $value);
    }

    /**
     * Create a meta attribute casting the value as integer
     *
     * @param mixed $value
     * @return \Nncodes\MetaAttributes\Models\MetaAttribute
     */
    public function asInteger($value): MetaAttribute
    {
        return $this->storeCastingAs('integer', $value);
    }

    /**
     * Create a meta attribute casting the value as object
     *
     * @param mixed $value
     * @return \Nncodes\MetaAttributes\Models\MetaAttribute
     */
    public function asObject($value): MetaAttribute
    {
        return $this->storeCastingAs('object', $value);
    }

    /**
     * Create a meta attribute casting the value as real
     *
     * @param mixed $value
     * @return \Nncodes\MetaAttributes\Models\MetaAttribute
     */
    public function asReal($value): MetaAttribute
    {
        return $this->storeCastingAs('real', $value);
    }

    /**
     * Create a meta attribute casting the value as string
     *
     * @param mixed $value
     * @return \Nncodes\MetaAttributes\Models\MetaAttribute
     */
    public function asString($value): MetaAttribute
    {
        return $this->storeCastingAs('string', $value);
    }

    /**
     * Create a meta attribute casting the value as timestamp
     *
     * @param mixed $value
     * @return \Nncodes\MetaAttributes\Models\MetaAttribute
     */
    public function asTimestamp($value): MetaAttribute
    {
        return $this->storeCastingAs('timestamp', $value);
    }

    /**
     * Create a meta attribute casting the value using autodiscover
     *
     * @param mixed $value
     * @return \Nncodes\MetaAttributes\Models\MetaAttribute
     */
    public function value($value): MetaAttribute
    {
        if (is_string($value) && $timestamp = strtotime($value)) {
            $value = Carbon::createFromTimestamp($timestamp);
        }
        
        if ($value instanceof \Carbon\Carbon) {
            if ($value->hour || $value->minute || $value->second) {
                return $this->asDatetime($value);
            }

            return $this->asDate($value);
        }

        if ($value instanceof Collection) {
            return $this->asCollection($value);
        }

        $primitiveTypes = ['boolean', 'integer', 'double', 'string', 'object', 'array'];

        if (! in_array($type = gettype($value), $primitiveTypes)) {
            $type = 'string';
        }

        return $this->storeCastingAs($type, $value);
    }
}
