<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffWork extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'finish_date',
        'reason',
        'document',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public const optionStatus = ['menunggu', 'diproses', 'ditolak', 'disetujui'];

}
