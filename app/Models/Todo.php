<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todo extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $appends = ['todo_status'];



    public function getTodoStatusAttribute() {
        if ($this->status == '0') {
            return "Active";
        }
        if ($this->status == '1') {
            return "Completed";
        }
    }


    protected $hidden = [
        'deleted_at',
    ];

}
