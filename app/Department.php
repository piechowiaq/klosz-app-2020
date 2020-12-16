<?php

declare(strict_types=1);

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Department extends Model
{
    public const ID_COLUMN          = 'id';
    private const NAME_COLUMN       = 'name';
    private const CREATED_AT_COLUMN = 'created_at';
    private const UPDATED_AT_COLUMN = 'updated_at';

    /** @var array|string[] */
    protected $guarded = [];

    public static function getDepartmentById(string $id): ?self
    {
        return self::find($id);
    }

    /**
     * @param array|string[] $ids
     *
     * @return Collection|self[]
     */
    public static function getDepartmentsById(array $ids): Collection
    {
        return self::whereIn(self::ID_COLUMN, $ids)->get();
    }

    public function getId(): string
    {
        return (string) $this->attributes[self::ID_COLUMN];
    }

    public function setId(string $id): void
    {
        $this->attributes[self::ID_COLUMN] = $id;
    }

    public function getName(): string
    {
        return $this->attributes[self::NAME_COLUMN];
    }

    public function setName(string $name): void
    {
        $this->attributes[self::NAME_COLUMN] = $name;
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

    public function employees(): Relation
    {
        return $this->belongsToMany(Employee::class);
    }

    /**
     * @return Collection|Employee[]
     */
    public function getEmployees(): Collection
    {
        return $this->employees()->get();
    }

    /**
     * @param array|string[] $ids
     */
    public function setEmployees(array $ids): void
    {
        $this->employees()->sync($ids, false);
    }

    public function positions(): Relation
    {
        return $this->hasMany(Position::class);
    }

    /**
     * @return Collection|Position[]
     */
    public function getPositions(): Collection
    {
        return $this->positions()->get();
    }

    /**
     * @param array|string[] $ids
     */
    public function setPositions(array $ids): void
    {
        $this->positions()->sync($ids);
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
    public function setCompanies($companies): void
    {
        $this->companies()->sync($companies->flatten()->pluck('id'), false);
    }

    public function trainings(): Relation
    {
        return $this->belongsToMany(Training::class);
    }

    /**
     * @return Collection|Training[]
     */
    public function getTrainings(): Collection
    {
        return $this->trainings()->get();
    }

    /**
     * @param array|string[] $ids
     */
    public function setTrainings(array $ids): void
    {
        $this->trainings()->sync($ids);
    }

    public function path(): string
    {
        return '/admin/departments/' . $this->getId();
    }
}
