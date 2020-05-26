<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $fillable = [
        'date',
        'name',
    ];

/*$response = Http::post('http://test.com/users', [
'name' => 'Steve',
'role' => 'Network Administrator',
]);*/


}
