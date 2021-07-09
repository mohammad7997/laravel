<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;

    protected $fillable=['title','slug'];

    public function threads()
    {
        return $this->hasMeny(Thread::class);
    }
}
