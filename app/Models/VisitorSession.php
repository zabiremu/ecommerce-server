<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorSession extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'session_id';
    protected $keyType    = 'string';
    public    $incrementing = false;

    protected $fillable = ['session_id', 'ip_address', 'last_seen_at'];

    protected $casts = ['last_seen_at' => 'datetime'];
}
