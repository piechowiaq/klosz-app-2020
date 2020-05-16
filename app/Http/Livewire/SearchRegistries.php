<?php

namespace App\Http\Livewire;


use App\Registry;
use Livewire\Component;

class SearchRegistries extends Component
{
    public $search = '';
    public $company;

    public function render()
    {
        $companyId = $this->company->id;

        $companyRegistries= Registry::search($this->search)->whereHas('companies', function($query) use ($companyId){
                $query->where('company_id', '=', $companyId);
            })->get();

        return view('livewire.search-registries',compact('companyRegistries'));
    }

    public function mount($company)
    {
        $this->company = $company;

    }


}
