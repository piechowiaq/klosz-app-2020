<?php

declare(strict_types=1);

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection as SupportCollection;

use function bcrypt;
use function route;

class User extends Authenticatable
{
    use Notifiable;

    private const ID_COLUMN                = 'id';
    private const NAME_COLUMN              = 'name';
    private const SURNAME_COLUMN           = 'surname';
    private const EMAIL_COLUMN             = 'email';
    private const EMAIL_VERIFIED_AT_COLUMN = 'email_verified_at';
    private const PASSWORD_COLUMN          = 'password';
    private const CREATED_AT_COLUMN        = 'created_at';
    private const UPDATED_AT_COLUMN        = 'updated_at';

    /** @var array|string[] */
    protected $guarded = [];

    /** @var array|string[] */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getID(): string
    {
        return (string) $this->attributes[self::ID_COLUMN];
    }

    public function setId(string $id): void
    {
        $this->attributes[self::ID_COLUMN] = $id;
    }

    public function getName(): string
    {
        return (string) $this->attributes[self::NAME_COLUMN];
    }

    public function setName(string $name): void
    {
        $this->attributes[self::NAME_COLUMN] = $name;
    }

    public function getSurname(): string
    {
        return (string) $this->attributes[self::SURNAME_COLUMN];
    }

    public function setSurname(string $surname): void
    {
        $this->attributes[self::SURNAME_COLUMN] = $surname;
    }

    public function getEmail(): string
    {
        return (string) $this->attributes[self::EMAIL_COLUMN];
    }

    public function setEmail(string $email): void
    {
        $this->attributes[self::EMAIL_COLUMN] = $email;
    }

    public function setPassword(string $password): void
    {
        $this->attributes[self::PASSWORD_COLUMN] = bcrypt($password);
    }

    public function getEmailVerifiedAt(): DateTime
    {
        return new DateTime($this->attributes[self::EMAIL_VERIFIED_AT_COLUMN]);
    }

    public function setEmailVerifiedAt(DateTime $dateTime): void
    {
        $this->attributes[self::EMAIL_VERIFIED_AT_COLUMN] = $dateTime;
    }

    public function getCreatedAt(): DateTime
    {
        return new DateTime($this->attributes[self::CREATED_AT_COLUMN]);
    }

    public function setCreatedAtDateTime(DateTime $dateTime): void
    {
        $this->attributes[self::CREATED_AT_COLUMN] = $dateTime;
    }

    public function getUpdatedAt(): DateTime
    {
        return new DateTime($this->attributes[self::UPDATED_AT_COLUMN]);
    }

    public function setUpdatedAtDateTime(DateTime $dateTime): void
    {
        $this->attributes[self::UPDATED_AT_COLUMN] = $dateTime;
    }

    /**
     * @return Collection|self[]
     */
    public static function getAll(): Collection
    {
        return self::all();
    }

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

    /**
     * @param Collection|Role[] $roles
     */
    public function setRoles(Collection $roles): void
    {
        $this->roles()->sync($roles);
    }

    public function companies(): Relation
    {
        return $this->belongsToMany(Company::class);
    }

    /**
     * @return Collection|Company[]
     */
    public function getCompanies(): Collection
    {
        return $this->companies()->get();
    }

    /**
     * @param Collection|Company[] $companies
     */
    public function setCompanies(Collection $companies): void
    {
        $this->companies()->sync($companies);
    }

    public function path(): string
    {
        return route('admin.users.show', ['user' => $this]);
    }

    public function isSuperAdmin(): bool
    {
        return $this->roles()->where('name', 'SuperAdmin')->exists();
    }

    public function isAdmin(): bool
    {
        return $this->roles()->where('name', 'Admin')->exists();
    }

    public function isUser(): bool
    {
        return $this->roles()->where('name', 'User')->exists();
    }

    public function isManager(): bool
    {
        return $this->roles()->where('name', 'Manager')->exists();
    }

    public function getFullNameAttribute(): string
    {
        return $this->getName() . ' ' . $this->getSurname();
    }

    /**
     * @return SupportCollection | Employee[]
     */
    public function getEmployees(): SupportCollection
    {
        return $this->companies()->get()->flatMap(static function (Company $company) {
            return $company->getEmployees();
        });
    }
}
