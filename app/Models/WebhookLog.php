<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebhookLog extends Model
{
    protected $fillable = [
        'endpoint_id',
        'method',
        'headers',
        'body',
        'content_type'
    ];

    protected $casts = [
        'headers' => 'array'
    ];

    public function endpoint()
    {
        //Each WebhookLog belongs to one Endpoint
        return $this->belongsTo(Endpoint::class);
    }
}