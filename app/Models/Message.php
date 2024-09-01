<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable=[
        'conversation_id',
        'user_id',
        'body',
        'type'
    ];

    protected $casts = [
        'body' => 'json'
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
    public function user()
    {
        // for nullable users use default
        return $this->belongsTo(User::class)->withDefault([
            'name' => __('User')
        ]);
    }
    public function recipients()
    {
        // read_at , SoftDelete relation won't return them so use pivot
        return $this->belongsToMany(User::class, 'recipients')
            ->withPivot([
                'read_at', 'deleted_at',
            ]);
    }

}
