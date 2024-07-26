<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Lesson extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_id',
        'title',
        'description',
    ];

    /**
     * The course that belong to the lesson.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
    /**
     * The users that belong to the lesson.
     */
    public function userComments(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'comments');
    }

    /**
     * The users that belong to the lesson.
     */
    public function userWatches(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'watches');
    }
}
