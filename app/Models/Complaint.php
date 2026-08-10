<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Complaint extends Model
{
    protected $fillable = [
        'complainant_name',
        'phone',
        'location',
        'village',
        'region',
        'department',
        'description',
        'priority',
        'status',
        'created_by',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (! filled($term)) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($term) {
            $q->where('complainant_name', 'like', "%{$term}%")
                ->orWhere('phone', 'like', "%{$term}%");
        });
    }

    public function scopeDateRange(Builder $query, ?string $start, ?string $end): Builder
    {
        if (filled($start)) {
            $query->whereDate('created_at', '>=', $start);
        }

        if (filled($end)) {
            $query->whereDate('created_at', '<=', $end);
        }

        return $query;
    }

    public function priorityLabel(): string
    {
        return config('complaints.priorities.'.$this->priority, $this->priority);
    }

    public function statusLabel(): string
    {
        return config('complaints.statuses.'.$this->status, $this->status);
    }
}
