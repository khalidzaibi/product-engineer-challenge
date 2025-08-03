<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'created_by',
    ];

    /**
     * The users that belong to the team.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    /**
     * Get the user that created the team.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
