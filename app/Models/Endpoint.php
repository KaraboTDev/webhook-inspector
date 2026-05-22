<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Endpoint extends Model
{
    protected $fillable = ['name', 'token'];

    public function logs()
    {
        //One Endpoint has many WebhookLogs
        return $this->hasMany(WebhookLog::class);
    }
}