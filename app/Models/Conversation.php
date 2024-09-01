<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'label',
        'type',
        'last_message_id'
    ];

    public function participants(){
        //role and joined at won't return so use pivot
        return $this->belongsToMany(User::class, 'participants')
            ->withPivot([
                'role', 'joined_at',
            ]);
    }

    public function recipients()
    {
        // all recipients that get all messages in the same conversation
        // recipients is the relation that will fetch all the messages that belongs to the conversation via messages
        return $this->hasManyThrough(
            Recipient::class,
            Message::class,
            'conversation_id', // Foreign key on the messages table
            'message_id', // Foreign key on the recipients table
            'id', // Local key on the users table
            'id' // Local key on the conversations table
        );
    }

    public function messages(){
        //conversation has many messages
        return $this->hasMany(Message::class, 'conversation_id', 'id');
    }

    public function user(){
        //conversation made by only one user
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function lastMessage(){

        return $this->belongsTo(Message::class, 'last_message_id', 'id')
            ->whereNull('deleted_at')
            ->withDefault([
                'body' => 'Message deleted'
            ]);
    }
}
