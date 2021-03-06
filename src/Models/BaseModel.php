<?php

namespace Hafael\Abstracts\Models;

use EloquentFilter\Filterable;
use Hafael\LaraFlake\Traits\LaraFlakeTrait;
use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use LaraFlakeTrait,
        Eloquence,
        Filterable,
        SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'table';

    /**
     * Indicates if the IDs are auto-incrementing.
     * @var bool
     */
    public $incrementing = false;

    public $primaryKey = 'id';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //
    ];

    protected $searchableColumns = [
        //
    ];


    public function modelFilter()
    {
        return $this->provideFilter(\Hafael\Abstracts\Filters\ExampleFilter::class);
    }

    public function toTransform()
    {
        return $this->toArray();
    }

}