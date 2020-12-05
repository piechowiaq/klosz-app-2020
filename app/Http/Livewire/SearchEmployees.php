<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Company;
use App\Employee;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View as IlluminateView;
use Livewire\Component;

use function view;

class SearchEmployees extends Component
{
    private string $search = '';
    private Company $company;

    /**
     * @return Factory|IlluminateView
     */
    public function render()
    {
        $employees = Employee::searchByNameAndCompanyAndPaginate($this->search, $this->company, 25);

        return view('livewire.search-employees', ['employees' => $employees]);
    }

    public function mount(Company $company): void
    {
        $this->company = $company;
    }
}
