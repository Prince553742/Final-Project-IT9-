<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * Note: We use 'name' to match your database schema and ManagerController.
     */
    protected $fillable = [
        'name',
        'description',
        'manager_id',
        'due_date',
    ];

    /**
     * Relationship: A project belongs to a Manager (User).
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * Relationship: A project has many tasks.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'project_id');
    }

    /**
     * Helper to check if the project has any overdue tasks.
     */
    public function hasOverdueTasks(): bool
    {
        return $this->tasks()
            ->where('due_date', '<', now())
            ->whereNotIn('status', ['Completed', 'Cancelled'])
            ->exists();
    }
}