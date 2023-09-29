<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use mysql_xdevapi\Table;

/**
 * @method static where(string $string, string $email)
 * @method static create(array $array)
 */
class User extends Model
{
    use HasFactory;

    protected $fillable = ['userName', 'password', 'email', 'picture'];

    protected $table = 'users';

    public function cards(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Card::class);
    }
}
