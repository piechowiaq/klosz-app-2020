<?php declare(strict_types = 1);

namespace App\Http\Controllers\User;

use App\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use function collect;
use function compact;
use function now;
use function round;
use function view;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function home(): RedirectResponse
    {
        $user = Auth::user();

        if($user->companies()->count() === 1){

            $company = $user->companies()->first();

            $companyId = $company->id;

            return Redirect::action('User\HomeController@index', $companyId);
        }
        else

 return $user->isSuperAdmin() ? Redirect::action('Admin\AdminController@index') : \view('user.home', \compact('user'));
    }

    public function index(Company $company)
    {
        $companyTrainings = $company->trainings;

        $collection = \collect([]);

        foreach ($companyTrainings as $training) {

            $collection->push( 0 === $training->employees->where('company_id', $companyId)->count() ?0: \round($training->employees()->certified($training, $companyId)->count() / $training->employees->where('company_id', $companyId)->count() * 100));
        }

        $average = \round ($collection->avg());



        $companyRegistries = $company->registries;

        $collection = \collect();

        foreach($company->registries as $registry) {
            foreach($registry->reports->where('company_id', $company->id) as $report) {
                   if($report->expiry_date > \now()){
                $collection->push($report);

            }
}
}

        $validRegistries = $collection->unique('registry_id')->count();

        $registryChartValue= 0 ===$companyRegistries->count()
            ?0
            : \round(
            $validRegistries / $companyRegistries->count()*100,
        );

        return \view(
            'user.dashboard',
            \compact('company', 'companyTrainings' , 'average', 'companyRegistries', 'registryChartValue'),
        );
    }

}
