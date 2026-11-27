<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Borrowing extends Model
{
    protected $fillable = [
        'user_id',
        'member_id',
        'borrowed_at',
        'due_date',
        'returned_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'borrowed_at' => 'date',
            'due_date'    => 'date',
            'returned_at' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'borrowing_details');
    }
}