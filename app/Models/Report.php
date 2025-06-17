<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'judul',
        'deskripsi',
        'lokasi',
        'fotoBukti',
        'status',
        'category',
        'is_approved_by_admin',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fotoBukti' => 'array',
        'is_approved_by_admin' => 'boolean',
    ];

    /**
     * Mendefinisikan relasi: Setiap Laporan (Report) dimiliki oleh satu User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}