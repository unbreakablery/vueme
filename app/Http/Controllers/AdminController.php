<?php

namespace App\Http\Controllers;

use App\Exports\AllExport;
use App\Exports\MarketingExport;
use App\Exports\PayoutExport;
use App\Exports\PsychicExport;
use App\Exports\PsychicsServiceExport;
use App\Exports\SignUpExport;
use App\Exports\TransactionExport;
use App\Exports\UsersExport;
use App\Exports\UsersServiceExport;
use App\Http\Controllers\Controller;
use App\Http\Trails\SearchUser;
use App\Models\User;
use App\Models\UserCreditLog;
use App\Services\WhiteLabel;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Excel;

class AdminController extends Controller
{
    use SearchUser;

    public function __construct(Guard $auth)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('verifield');
    }

    /**
     * @autor Alcides Rodríguez alcidesrh@gmail.com
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin', ['route' => Route::current()->parameters() ?? null]);
    }

    //change-agency
    public function agency()
    {
        return view('admin', ['route' => Route::current()->parameters() ?? null]);
    }

    /**
     * @autor Alcides Rodríguez alcidesrh@gmail.com
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUsersCvs(Request $request)
    {
        if ($year = $request->get('year')) {

            $result = [];

            if ($month = $request->get('month')) {

                $date = Carbon::createFromDate($year, $month);

                $models = User::selectRaw('date(created_at) as date,count(id) as models')->where('role_id', WhiteLabel::roleId('Model'))->whereBetween('created_at', [$date->copy()->startOfMonth(), $date->copy()->endOfMonth()])
                    ->groupBy('date')->orderBy('date', 'DESC')->get()->toArray();

                $users = User::selectRaw('date(created_at) as date,count(id) as users')->where('role_id', WhiteLabel::roleId('User'))->whereBetween('created_at', [$date->copy()->startOfMonth(), $date->copy()->endOfMonth()])
                    ->groupBy('date')->orderBy('date', 'DESC')->get()->toArray();

                foreach (array_merge($models, $users) as $key => $value) {
                    if (isset($value['models'])) {
                        $result[$value['date']]['models'] = $value['models'];
                    } else {
                        $result[$value['date']]['users'] = $value['users'];
                    }
                    $result[$value['date']]['date'] = $value['date'];
                }

                $name = "Respectfully Signups {$date->format('m')} $year.xlsx";

            } else {

                $date = Carbon::createFromDate($year);

                $models = User::selectRaw('date(created_at) as date,count(id) as models')->where('role_id', WhiteLabel::roleId('Model'))->whereBetween('created_at', [$date->copy()->startOfYear(), $date->copy()->endOfYear()])
                    ->groupBy('date')->orderBy('date', 'DESC')->get()->toArray();

                $users = User::selectRaw('date(created_at) as date,count(id) as users')->where('role_id', WhiteLabel::roleId('User'))->whereBetween('created_at', [$date->copy()->startOfYear(), $date->copy()->endOfYear()])
                    ->groupBy('date')->orderBy('date', 'DESC')->get()->toArray();

                foreach (array_merge($models, $users) as $key => $value) {
                    if (isset($value['models'])) {
                        $result[$value['date']]['models'] = $value['models'];
                    } else {
                        $result[$value['date']]['users'] = $value['users'];
                    }
                    $result[$value['date']]['date'] = $value['date'];
                }

                $name = "Respectfully Signups $year.xlsx";
            }

            return \Maatwebsite\Excel\Facades\Excel::download(new SignUpExport($result), $name, \Maatwebsite\Excel\Excel::XLSX);
        }

        $date = new Carbon();

        if ($request->get('role') == WhiteLabel::roleId('User')) {

            $name = "Respectfully Clients List {$date->format('m-d-Y')}.xlsx";

            return \Maatwebsite\Excel\Facades\Excel::download(new UsersExport($this->searchUsersWithFilter($request, true)->where('email_validated', 1)->where('fraud', 0)->where('test_user', 0)), $name, \Maatwebsite\Excel\Excel::XLSX);

        } else if ($request->get('role') == WhiteLabel::roleId('Model')) {

            $name = "Respectfully Models List {$date->format('m-d-Y')}.xlsx";

            return \Maatwebsite\Excel\Facades\Excel::download(new PsychicExport($this->searchUsersWithFilter($request, true)->where('email_validated', 1)->where('fraud', 0)->where('test_user', 0)), $name, \Maatwebsite\Excel\Excel::XLSX);

        }

        $name = "Respectfully Models List {$date->format('m-d-y')}.xlsx";

        return \Maatwebsite\Excel\Facades\Excel::download(new AllExport($this->searchUsersWithFilter($request, true)->where('email_validated', 1)->where('fraud', 0)->where('test_user', 0)), $name, \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * @autor Alcides Rodríguez alcidesrh@gmail.com
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUsersServiceCvs(Request $request)
    {

        $date = new Carbon();

        if ($request->get('role') == WhiteLabel::roleId('User')) {

            $name = "Respectfully Clients Service List {$date->format('m-d-Y')}.xlsx";

            return \Maatwebsite\Excel\Facades\Excel::download(new UsersServiceExport($this->searchUsersWithFilter($request, true)), $name, \Maatwebsite\Excel\Excel::XLSX);

        } else if ($request->get('role') == WhiteLabel::roleId('Model')) {

            $name = "Respectfully Models List {$date->format('m-d-Y')}.xlsx";

            return \Maatwebsite\Excel\Facades\Excel::download(new PsychicsServiceExport($this->searchUsersWithFilter($request, true)), $name, \Maatwebsite\Excel\Excel::XLSX);

        }
    }

    public function getPayoutCvs(Request $request)
    {
        $date = Carbon::createFromFormat('Y-m-d', $request->get('date'));

        $request->request->add(['role' => WhiteLabel::roleId('Model')]);

        $name = "Respectfully Payout Period {$date->format('m-d-Y')}  to {$date->copy()->add(6, 'days')->format('m-d-Y')}.xlsx";

        return \Maatwebsite\Excel\Facades\Excel::download(new PayoutExport($this->searchUsersWithFilter($request), $date), $name, \Maatwebsite\Excel\Excel::XLSX);

    }

    public function getTransactionCvs(Request $request)
    {

        $request->request->add(['role' => WhiteLabel::roleId('User')]);

        $date = new Carbon();

        $name = $date->format('m.d.Y')." - Respectfully Transactions.xlsx";

        $credit_log = UserCreditLog::select('user_credit_log.*')->join('user', 'user.id', '=', 'user_credit_log.user_id')
            ->where('user.account_status', 'ACTIVE')->where('user.fraud', 0)->where('user.test_user', 0)->where('user.email_validated', 1)
            ->where('user_credit_log.action', 'BUY_CREDIT')->orderBy('user_credit_log.created_at', 'desc');

        return \Maatwebsite\Excel\Facades\Excel::download(new TransactionExport($credit_log), $name, \Maatwebsite\Excel\Excel::XLSX);

    }

    public function getMarketingCvs(Request $request)
    {
        $name = "Respectfully Marketing.xlsx";

        $date = new Carbon;

        $monthNumber = \intval($date->format('m'));

        $month = $date->copy()->startOfYear()->startOfMonth();

        $aging = $new = [];

        $setKeys = function (&$aging, &$new, $index) {
            foreach (['CUSTOMERS', 'TRANSACTIONS', 'REVENUE', 'AVE PURCHASE', 'MIN PURCHASE', 'MED PURCHASE', 'MAX PURCHASE'] as $value) {
                $aging[$index][$value] = 0;
                $new[$index][$value] = 0;
            }

        };

        for ($i = 0; $i < $monthNumber; $i++) {

            $setKeys($aging, $new, $i);

            $contNew = $contAging = 0;
            // User::where('user.account_status', 'ACTIVE')->where('user.fraud', 0)->where('user.test_user', 0)->where('user.email_validated', 1)->where('user.role_id', WhiteLabel::roleId('User'))->get()
            foreach ( 
                UserCreditLog::selectRaw('SUM(user_credit_log.credits) as revenue, COUNT(user_credit_log.id) as transactions')->join('user', 'user.id', '=', 'user_credit_log.user_id')
                ->where('user.account_status', 'ACTIVE')->where('user.fraud', 0)->where('user.test_user', 0)->where('user.email_validated', 1)->where('user.role_id', WhiteLabel::roleId('User'))
                ->whereRaw("(user_credit_log.action = 'BUY_CREDIT')")->whereBetween('user_credit_log.created_at', [$month->copy()->startOfMonth(), $month->copy()->endOfMonth()])->groupBy('user_credit_log.user_id')->get()
                as $transactions) {
                // $transactions = $user->user_credit_logs()->selectRaw('SUM(user_credit_log.credits) as revenue, COUNT(user_credit_log.id) as transactions')->whereRaw("(user_credit_log.action = 'BUY_CREDIT')")->whereBetween('created_at', [$month->copy()->startOfMonth(), $month->copy()->endOfMonth()])->first();
                $revenue = $transactions->revenue;
                $count = $transactions->transactions;
                if ($count) {
                    if ($count == 1) {

                        $contNew++;

                        $new[$i]['REVENUE'] += $revenue;
                        $new[$i]['TRANSACTIONS']++;
                        $new[$i]['CUSTOMERS']++;

                        if ($new[$i]['MIN PURCHASE'] == 0) {
                            $new[$i]['MIN PURCHASE'] = $new[$i]['MAX PURCHASE'] = $new[$i]['MED PURCHASE'] = $revenue;
                        } else if ($new[$i]['MIN PURCHASE'] > $revenue) {
                            $new[$i]['MIN PURCHASE'] = $revenue;
                        } else if ($new[$i]['MAX PURCHASE'] < $revenue) {
                            $new[$i]['MAX PURCHASE'] = $revenue;
                        }

                        $medio = ($new[$i]['MIN PURCHASE'] + $new[$i]['MAX PURCHASE']) / 2;
                        if (\abs($medio - $new[$i]['MED PURCHASE']) > \abs($medio - $revenue)) {
                            $new[$i]['MED PURCHASE'] = $revenue;
                        }
                    } else {

                        $contAging++;

                        $aging[$i]['REVENUE'] += $revenue;
                        $aging[$i]['TRANSACTIONS']++;
                        $aging[$i]['CUSTOMERS']++;

                        if ($aging[$i]['MIN PURCHASE'] == 0) {
                            $aging[$i]['MIN PURCHASE'] = $aging[$i]['MAX PURCHASE'] = $aging[$i]['MED PURCHASE'] = $revenue;
                        } else if ($aging[$i]['MIN PURCHASE'] > $revenue) {
                            $aging[$i]['MIN PURCHASE'] = $revenue;
                        } else if ($aging[$i]['MAX PURCHASE'] < $revenue) {
                            $aging[$i]['MAX PURCHASE'] = $revenue;
                        }

                        $medio = ($aging[$i]['MIN PURCHASE'] + $aging[$i]['MAX PURCHASE']) / 2;
                        if (\abs($medio - $aging[$i]['MED PURCHASE']) > \abs($medio - $revenue)) {
                            $aging[$i]['MED PURCHASE'] = $revenue;
                        }
                    }
                }
            }

            $aging[$i]['AVE PURCHASE'] = $contAging ? \round($aging[$i]['REVENUE'] / $contAging, 2) : 0;

            $new[$i]['AVE PURCHASE'] = $contNew ? \round($new[$i]['REVENUE'] / $contNew, 2) : 0;

            $month->addMonth();
        }

        $data = [];

        foreach (['CUSTOMERS', 'TRANSACTIONS', 'REVENUE', 'AVE PURCHASE', 'MIN PURCHASE', 'MED PURCHASE', 'MAX PURCHASE'] as $value) {
            $data[$value] = [];
        }

        $getData = function ($data, $array) {
            foreach ($array as $value) {
                foreach ($value as $key => $value2) {
                    $data[$key] = \array_merge($data[$key], [$value2]);
                }
            }
            return $data;
        };

        return \Maatwebsite\Excel\Facades\Excel::download(new MarketingExport([['AGING' => $getData($data, $aging), 'NET NEW' => $getData($data, $new)]], $date), $name, \Maatwebsite\Excel\Excel::XLSX);

    }
}
