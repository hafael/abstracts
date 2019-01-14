<?php

namespace Hafael\Abstracts\Models;

use EloquentFilter\Filterable;
use Hafael\LaraFlake\Traits\LaraFlakeTrait;
use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class Example extends Model
{
    use LaraFlakeTrait,
        Eloquence,
        Filterable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'examples';

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
        'field_1',
        'field_2',
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'field_1' => 'string',
        'field_2' => 'boolean',
    ];

    protected $searchableColumns = [
        'field_1' => 10,
        'field_2' => 5,
    ];


    public function modelFilter()
    {
        return $this->provideFilter(\Hafael\Abstracts\Filters\ExampleFilter::class);
    }

    public function toTransform()
    {
        return [
            'id' => $this->id,
            'field_1' => $this->field_1,
            'field_2' => $this->field_2,
            'related' => $this->related,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

}