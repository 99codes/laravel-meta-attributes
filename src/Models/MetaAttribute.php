<?php

namespace Nncodes\MetaAttributes\Models;

use Illuminate\Database\Eloquent\Model;

class MetaAttribute extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['key', 'value'];

    public function model()
    {
        return $this->morphTo();
    }
}
