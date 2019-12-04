<?php

namespace KnightAR\Laravel\Config;

use KnightAR\Laravel\Config\Traits\BindsDynamically;

/**
 * RunetimeConfig
 *
 * @property int       $id
 * @property string    $key
 * @property string    $value
 *
 * @method static \Illuminate\Database\Eloquent\Builder|RunetimeConfig newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RunetimeConfig newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RunetimeConfig query()
 * @mixin \Eloquent
 */
class RunetimeConfig extends BaseModel
{
    use BindsDynamically;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['key', 'value'];
}
