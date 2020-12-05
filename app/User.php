<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use function bcrypt;

class User extends Authenticatable
{
    use Notifiable;

    private const ID_COLUMN       = 'id';
    private const NAME_COLUMN     = 'name';
    private const SURNAME_COLUMN  = 'surname';
    private const EMAIL_COLUMN    = 'email';
    private const PASSWORD_COLUMN = 'password';

    /** @var array|string[] */
    protected $guarded = [];

    /** @var array|string[] */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /** @var array|string[] */
    protected $casts = ['email_verified_at' => 'datetime'];

    /**
     * The role associated with the user.
     */
    public function roles(): Relation
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    /**
     * @return Collection|Role[]
     */
    public function getRoles(): Collection
    {
        return $this->roles()->get();
    }

    public function companies(): Relation
    {
        return $this->belongsToMany(Company::class)->withTimestamps();
    }

    /**
     * @return Collection|Company[]
     */
    public function getCompanies(): Collection
    {
        return $this->companies()->get();
    }

    public function path(): string
    {
        return "/admin/users/{$this->getId()}";
    }

    public function isSuperAdmin(): bool
    {
        return $this->roles()->where('name', 'SuperAdmin')->exists();
    }

    public function getId(): string
    {
        return (string) $this->attributes[self::ID_COLUMN];
    }

    public function getName(): string
    {
        return $this->attributes[self::NAME_COLUMN];
    }

    public function setName(string $name): void
    {
        $this->attributes[self::NAME_COLUMN] = $name;
    }

    public function getSurname(): string
    {
        return $this->attributes[self::SURNAME_COLUMN];
    }

    public function setSurname(string $surname): void
    {
        $this->attributes[self::SURNAME_COLUMN] = $surname;
    }

    public function getEmail(): string
    {
        return $this->attributes[self::EMAIL_COLUMN];
    }

    public function setEmail(string $email): void
    {
        $this->attributes[self::EMAIL_COLUMN] = $email;
    }

    public function setPassword(string $password): void
    {
        $this->attributes[self::PASSWORD_COLUMN] = bcrypt($password);
    }

    /**
     * @return mixed
     */
    public function getFullNameAttribute()
    {
        return $this->getName() . ' ' . $this->getSurname();
    }
}
