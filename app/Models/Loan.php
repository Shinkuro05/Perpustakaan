<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'book_id',
        'user_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_dikembalikan',
        'status',
        'denda',
        'catatan',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
        'tanggal_dikembalikan' => 'date',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isOverdue(): bool
    {
        return $this->status === 'dipinjam' && $this->tanggal_kembali < Carbon::today();
    }

    public function calculateFine(): int
    {
        if ($this->tanggal_dikembalikan && $this->tanggal_kembali) {
            $days = $this->tanggal_dikembalikan->diffInDays($this->tanggal_kembali);
            if ($days > 0) {
                return $days * 1000; // Rp 1.000/hari
            }
        }
        return 0;
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'dipinjam' => 'bg-blue-100 text-blue-800',
            'dikembalikan' => 'bg-green-100 text-green-800',
            'terlambat' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
