<?php

declare(strict_types=1);

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Registry extends Model
{
    private const ID_COLUMN          = 'id';
    private const NAME_COLUMN        = 'name';
    private const DESCRIPTION_COLUMN = 'description';
    private const VALID_FOR_COLUMN   = 'valid_for';
    private const CREATED_AT_COLUMN  = 'created_at';
    private const UPDATED_AT_COLUMN  = 'updated_at';

    /** @var array|string[] */
    protected $guarded = [];

    public static function getRegistryById(string $id): ?self
    {
        return self::find($id);
    }

    /**
     * @param array|string[] $ids
     *
     * @return Collection|self[]
     */
    public static function getRegistriesById(array $ids): Collection
    {
        return self::whereIn(self::ID_COLUMN, $ids)->get();
    }

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

    public function getValidFor(): int
    {
        return (int) $this->attributes[self::VALID_FOR_COLUMN];
    }

    public function setValidFor(int $validFor): void
    {
        $this->attributes[self::VALID_FOR_COLUMN] = $validFor;
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

    public function path(): string
    {
        return '/admin/registries/' . $this->getID();
    }

    public function userPath(Company $company): string
    {
        return '/' . $company->getId() . '/registries/' . $this->getID();
    }

    public function reports(): Relation
    {
        return $this->hasMany(Report::class);
    }

    /**
     * @return Collection|Report[]
     */
    public function getReports(): Collection
    {
        return $this->reports()->get();
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
}
