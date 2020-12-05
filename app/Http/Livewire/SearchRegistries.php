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
    private string $search = '';
    private Company $company;

    /**
     * @return Factory|IlluminateView
     */
    public function render()
    {
        $companyRegistries = Registry::findByNameAndCompany($this->search, $this->company);

        return view('livewire.search-registries', ['companyRegistries' => $companyRegistries]);
    }

    public function mount(Company $company): void
    {
        $this->company = $company;
    }
}
