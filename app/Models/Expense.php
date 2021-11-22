<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Expense extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'amount',
        'file',
        'file_path',
        'mime'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function getInfoAttribute(){   //It is only to complete a requirement :)
        return 'Title: ' . $this->title . ' Description: ' . $this->description . ' Amount: ' . $this->amount;
    }

    public function setTitleAttribute($title){
        return $this->attributes['title'] = ucfirst($title);
    }

    public function setDescriptionAttribute($description){
        return $this->attributes['description'] = ucfirst($description);
    }

}
