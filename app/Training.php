<?php

declare(strict_types=1);

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Training extends Model
{
//    use Searchable;

    private const ID_COLUMN          = 'id';
    private const NAME_COLUMN        = 'name';
    private const DESCRIPTION_COLUMN = 'description';
    private const VALID_FOR_COLUMN   = 'valid_for';
    private const CREATED_AT_COLUMN  = 'created_at';
    private const UPDATED_AT_COLUMN  = 'updated_at';

    /** @var array|string[] */
    protected $guarded = [];

    public static function getTrainingById(string $id): ?self
    {
        return self::find($id);
    }

    /**
     * @param array|string[] $ids
     *
     * @return Collection|self[]
     */
    public static function getTrainingsById(array $ids): Collection
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

    public function getValidFor(): string
    {
        return (string) $this->attributes[self::VALID_FOR_COLUMN];
    }

    public function setValidFor(string $validFor): void
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

    public function departments(): Relation
    {
        return $this->belongsToMany(Department::class);
    }

    public function getDepartments(): Collection
    {
        return $this->departments()->get();
    }

    /**
     * @param Collection|Department[] $departments
     */
    public function setDepartments($departments): void
    {
        $this->departments()->sync($departments->flatten()->pluck('id'), false);
    }

    public function positions(): Relation
    {
        return $this->belongsToMany(Position::class);
    }

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

    public function employees(): Relation
    {
        return $this->belongsToMany(Employee::class);
    }

    public function getEmployees(): Collection
    {
        return $this->employees()->get();
    }

    /**
     * @param Collection|Employee[] $employees
     */
    public function setEmployees($employees): void
    {
        $this->employees()->sync($employees->flatten()->pluck('id'), false);
    }

    public function certificates(): Relation
    {
        return $this->hasMany(Certificate::class);
    }

    public function getCertificates(): Collection
    {
        return $this->certificates()->get();
    }

    /**
     * @param array|string[] $ids
     */
    public function setCertificates(array $ids): void
    {
        $this->certificates()->sync($ids);
    }

    public function companies(): Relation
    {
        return $this->belongsToMany(Company::class);
    }

    public function getCompanies(): Collection
    {
        return $this->companies()->get();
    }

    /**
     * @param array|string[] $ids
     */
    public function setCompanies(array $ids): void
    {
        $this->companies()->sync($ids);
    }

    public function path(): string
    {
        return '/admin/trainings/' . $this->getId();
    }

    public function userPath(Company $company): string
    {
        return '/' . $company->getId() . '/trainings/' . $this->getId();
    }

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('name', 'like', '%' . $query . '%');
    }

//    public function scopeCertified($query, $training)
//    {
//        return $query->employees()->whereHas('certificates', function($q) use ($training) {
//            $q->where('expiry_date', '>', \Carbon\Carbon::now())
//                ->where('training_id', $training->id);
//        })->get();
//    }
}
