<?php

namespace Nncodes\MetaAttributes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class MetaAttribute extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'value',
        'type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'model_id',
        'model_type',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::retrieved(function (MetaAttribute $meta) {
            if ($meta->type == 'encrypted') {
                $meta->value = decrypt($meta->value);
            }
        });

        static::saving(function ($meta) {
            if ($meta->type == 'encrypted') {
                $meta->value = encrypt($meta->value);
            }
        });
    }

    public function getValueAttribute($value)
    {
        $this->casts = [
            'value' => $this->type,
        ];

        return $this->castAttribute('value', $value);
    }

    public function setTypeAttribute($value)
    {
        $this->casts = [
            'value' => $value,
        ];

        $this->attributes['type'] = $value;
    }

    /**
     * Related model using MorphTo relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function model(): MorphTo
    {
        return $this->morphTo();
    }
}
