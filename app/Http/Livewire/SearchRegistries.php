<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Company;
use App\Registry;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View as IlluminateView;
use Livewire\Component;

use function view;

class SearchRegistries extends Component
{
    public string $search = '';
    public Company $company;

    /**
     * @return Factory|IlluminateView
     */
    public function render()
    {
        $companyId = $this->company->getId();

        $companyRegistries = Registry::search($this->search)->whereHas('companies', static function ($query) use ($companyId): void {
                $query->where('company_id', '=', $companyId);
        })->get();

        return view('livewire.search-registries', ['companyRegistries' => $companyRegistries]);
    }

    public function mount(Company $company): void
    {
        $this->company = $company;
    }
}
