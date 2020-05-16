<?php

namespace App\Http\Livewire;

use App\Employee;
use Livewire\Component;

class SearchEmployees extends Component
{

    public $search = '';

    public $company;

    public function render()
    {
        $employees = Employee::search(
            $this->search
        )->where('company_id', $this->company->id)->paginate(25);

        return view('livewire.search-employees', compact('employees'));
    }

    public function mount($company)
    {
        $this->company = $company;

    }
}
