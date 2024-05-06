<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Get the department of the file.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
