<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use HasFactory;

    protected $fillable = ['message', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public static function add($fields)
    {
        $bid = new static;
        $bid->fill($fields);
        $bid->save();

        return $bid;
    }

    public function resolved($comment)
    {
        $this->comment = $comment;
        $this->status = 'resolved';
        $this->save();
    }
}
