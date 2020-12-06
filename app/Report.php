<?php

declare(strict_types=1);

namespace App;

use App\Http\Requests\StoreUserReportRequest;
use App\Http\Requests\UpdateUserReportRequest;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

use function date;

class Report extends Model
{
    private const ID_COLUMN                 = 'id';
    private const NAME_COLUMN               = 'report_name';
    private const REPORT_PATH_COLUMN        = 'report_path';
    private const REPORT_DATE_COLUMN        = 'report_date';
    private const REPORT_EXPIRY_DATE_COLUMN = 'expiry_date';
    private const COMPANY_ID_COLUMN         = 'company_id';
    private const REGISTRY_ID_COLUMN        = 'registry_id';
    private const CREATED_AT_COLUMN         = 'created_at';
    private const UPDATED_AT_COLUMN         = 'updated_at';

    /** @var array|string[] */
    protected $guarded = [];

    public static function getReportById(string $id): ?self
    {
        return self::find($id);
    }

    /**
     * @param array|string[] $ids
     *
     * @return Collection|self[]
     */
    public static function getReportsById(array $ids): Collection
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

    /**
     * @param  StoreUserReportRequest|UpdateUserReportRequest $request
     */
    public function setName(Registry $registry, Company $company, $request): void
    {
        $name = $this->getReportDate()->format('Y-m-d') . ' ' . $registry->getName() . ' ' . $company->getId() . '-' . date('is') . '.' . $request->file('file')->getClientOriginalExtension();

        $this->attributes[self::NAME_COLUMN] = $name;
    }

    public function getPath(): string
    {
        return $this->attributes[self::REPORT_PATH_COLUMN];
    }

    public function setPath(string $path): void
    {
        $this->attributes[self::REPORT_PATH_COLUMN] = $path;
    }

    public function getReportDate(): DateTime
    {
        return $this->attributes[self::REPORT_DATE_COLUMN];
    }

    public function setReportDate(DateTime $dateTime): void
    {
        $this->attributes[self::REPORT_DATE_COLUMN] = $dateTime;
    }

    public function getExpiryDate(): DateTime
    {
        return $this->attributes[self::REPORT_EXPIRY_DATE_COLUMN];
    }

    public function setExpiryDate(DateTime $dateTime): void
    {
        $this->attributes[self::REPORT_EXPIRY_DATE_COLUMN] = $dateTime;
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

    public function registry(): Relation
    {
        return $this->belongsTo(Registry::class);
    }

    public function getRegistry(): Collection
    {
        return $this->registry()->get();
    }

    public function setRegistry(Registry $registry): void
    {
        $this->attributes[self::REGISTRY_ID_COLUMN] = $registry->getID();
    }

    public function company(): Relation
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * @return Collection|Company[]
     */
    public function getCompany(): Collection
    {
        return $this->company()->get();
    }

    public function setCompany(Company $company): void
    {
        $this->attributes[self::COMPANY_ID_COLUMN] = $company->getId();
    }

    public function userPath(Company $company): string
    {
        return '/' . $company->getId() . '/reports/' . $this->getID();
    }

    public function calculateExpiryDate(DateTime $reportDate, Registry $registry): DateTime
    {
        $monthsToAdd = $registry->getValidFor();

        return $reportDate->modify('+' . $monthsToAdd . ' month');
    }
}
