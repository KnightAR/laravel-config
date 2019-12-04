<?php

namespace KnightAR\Laravel\Config\Models;

use Illuminate\Database\Eloquent\Model;
use KnightAR\Laravel\Config\Traits\BindsDynamically;

/**
 * RunetimeConfig
 *
 * Override this model if you wish to use things like Spiritix/LadaCache or OwenIt/Auditing Packages
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
class RunetimeConfig extends Model
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
