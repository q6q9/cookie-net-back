<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $author
 * @property int $to
 * @property string $body
 * @property Carbon $created_at
 *
 */
class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'from',
        'to',
        'body',
    ];
}
