<?php

namespace Hafael\Abstracts\Models;

use Illuminate\Database\Eloquent\Model;

class BasicExample extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'examples';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'field_1',
        'field_2',
    ];

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