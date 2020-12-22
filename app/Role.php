<?php

declare(strict_types=1);

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

use function route;

class Role extends Model
{
    private const ID_COLUMN          = 'id';
    private const NAME_COLUMN        = 'name';
    private const DESCRIPTION_COLUMN = 'description';
    private const CREATED_AT_COLUMN  = 'created_at';
    private const UPDATED_AT_COLUMN  = 'updated_at';

    /** @var array|string[] */
    protected $guarded = [];

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

    public function getDescription(): string
    {
        return $this->attributes[self::DESCRIPTION_COLUMN];
    }

    public function setDescription(string $description): void
    {
        $this->attributes[self::DESCRIPTION_COLUMN] = $description;
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

    public function users(): Relation
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users()->get();
    }

    /**
     * @param array|string[] $ids
     */
    public function setUsers(array $ids): void
    {
        $this->users()->sync($ids);
    }

    public function path(): string
    {
        return route('admin.roles.show', ['role' => $this]);
    }
}
