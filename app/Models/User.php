<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;

/**
 * User Model
 *
 * Represents the user of the application, handling authentication and authorization.
 * It includes basic user information such as name and email, and utilizes Laravel Sanctum for API token management.
 *
 * @property int $id The model's primary key
 * @property string $name The name of the user
 * @property string $email The email address of the user
 * @property string $password The hashed password for the user account
 * @property Carbon|null $email_verified_at The timestamp when the email was verified
 * @property string|null $remember_token The token for remembering the session
 * @property Carbon|null $created_at The time the record was created
 * @property Carbon|null $updated_at The time the record was last updated
 * @property-read Collection|PersonalAccessToken[] $tokens The API tokens associated with the user
 *
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
