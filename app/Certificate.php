<?php

declare(strict_types=1);

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Certificate extends Model
{
    private const ID_COLUMN               = 'id';
    private const CERTIFICATE_NAME_COLUMN = 'certificate_name';
    private const CERTIFICATE_PATH_COLUMN = 'certificate_path';
    private const TRAINING_DATE_COLUMN    = 'training_date';
    private const EXPIRY_DATE_COLUMN      = 'expiry_date';
    private const TRAINING_ID_COLUMN      = 'training_id';
    private const COMPANY_ID_COLUMN       = 'company_id';
    private const CREATED_AT_COLUMN       = 'created_at';
    private const UPDATED_AT_COLUMN       = 'updated_at';

    /** @var array|string[] */
    protected $guarded = [];

    public static function getCertificateById(string $id): ?self
    {
        return self::find($id);
    }

    /**
     * @param array|string[] $ids
     *
     * @return Collection|self[]
     */
    public static function getCertificatesById(array $ids): Collection
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
        return $this->attributes[self::CERTIFICATE_NAME_COLUMN];
    }

    public function setName(string $name): void
    {
        $this->attributes[self::CERTIFICATE_NAME_COLUMN] = $name;
    }

    public function getPath(): string
    {
        return $this->attributes[self::CERTIFICATE_PATH_COLUMN];
    }

    public function setPath(string $path): void
    {
        $this->attributes[self::CERTIFICATE_PATH_COLUMN] = $path;
    }

    public function getTrainingDate(): DateTime
    {
        return new DateTime($this->attributes[self::TRAINING_DATE_COLUMN]);
    }

    public function setTrainingDate(DateTime $dateTime): void
    {
        $this->attributes[self::TRAINING_DATE_COLUMN] = $dateTime;
    }

    public function getExpiryDate(): DateTime
    {
        return new DateTime($this->attributes[self::EXPIRY_DATE_COLUMN]);
    }

    public function setExpiryDate(DateTime $dateTime): void
    {
        $this->attributes[self::EXPIRY_DATE_COLUMN] = $dateTime;
    }

    public function training(): Relation
    {
        return $this->belongsTo(Training::class);
    }

    /**
     * @return Collection|Training[]
     */
    public function getTraining(): Collection
    {
        return $this->training()->get();
    }

    public function setTraining(Training $training): void
    {
        $this->attributes[self::TRAINING_ID_COLUMN] = $training->getId();
    }

    public function company(): Relation
    {
        return $this->belongsTo(Company::class);
    }

    public function getCompany(): Collection
    {
        return $this->company()->get();
    }

    public function setCompany(Company $company): void
    {
        $this->attributes[self::COMPANY_ID_COLUMN] = $company->getId();
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
        $this->employees()->sync($ids);
    }

    public function path(): string
    {
        return '/admin/certificates/' . $this->getId();
    }

    public function userPath(Company $company, Training $training): string
    {
        return '/' . $company->getId() . '/trainings/' . $training->getId() . '/certificates/' . $this->getId();
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc')->first();
    }
}
