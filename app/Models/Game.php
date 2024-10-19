<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'status',
        'team_local_score',
        'team_visitor_score',
        'team_local_id',
        'team_visitor_id',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    /**
     * @return BelongsTo
     */
    public function teamLocal(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_local_id');
    }

    /**
     * @return BelongsTo
     */
    public function teamVisitor(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_visitor_id');
    }
}
