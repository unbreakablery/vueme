<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\User;
use App\Models\UserDevice;
use Carbon\CarbonTimeZone;
use App\Http\Trails\PayoutTrail;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromQuery, WithMapping, WithHeadings, WithEvents
{
    use PayoutTrail;

    private $query = null;

    public function __construct($query)
    {
        $this->query = $query;
    }

    /**
     * @autor Alcides Rodríguez alcidesrh@gmail.com
     * @return array
     */
    public function headings(): array
    {
        return [
            'Ip',
            'Role',
            'Username',
            'ID',
            'Full name',
            'Email',
            'Phone',
            'Gender',
            'Location',
            'Specialties',
            'Sign up date',
            'Sign up time',
            'Credits',
            'Referred by',
            'Profile',
            'Active',
            'Fraud',
            'Hidden',
            'Test User'
        ];
    }

    /**
     * @autor Alcides Rodríguez alcidesrh@gmail.com
     * @param mixed $user
     * @return array
     */
    public function map($user): array
    {
        $profile = $user->userProfile()->first();        

        $categories = "";

        $role = 'Client';

        // $credit = $this->payout($user, true);

        // $credit = $credit['current_balance'];

        $phones = "";

        foreach ($user->user_mobile_nums()->get() as $value) {
            $phones .= $value->number . ' ';
        }

        if ($device = UserDevice::where('user_id', $user->id)->first()) {
            $device = $device->ip;
        }

        // $tz = null;
        // try {
        //     $tz = new CarbonTimeZone($profile->timezone);
        // } catch (\Exception $e) {
        // }

        try {
            $date = new Carbon($user->created_at, $profile->timezone);
        } catch (\Exception $e) {
            $date = new Carbon($user->created_at);
        }

        $date->setTimezone('US/Eastern');

        $numberFormatter = new \NumberFormatter( 'en_US', \NumberFormatter::CURRENCY );
        return [
            $device,
            $role,
            $profile->display_name,
            $user->id,
            $profile->name . ' ' . $profile->last_name,
            $user->email,
            $phones,
            $profile->gender,
            $profile->city . ' ' . $profile->state,
            $categories,
            $user->created_at ? $date->format('m/d/Y') : '',
            $user->created_at ? $date->format('g:i A') .'  EST' : '',
            $user->credits ? $numberFormatter->format($user->credits) : '$00.00',
            $user->referred_by,
            $user->profile_percent . '%',
            $user->email_validated ? 'Yes' : 'No',
            $user->fraud ? 'Yes' : 'No',
            $user->account_status == 'INACTIVE' ? 'Yes' : 'No',
            $user->test_user ? 'Yes' : 'No',
        ];
    }

    /**
     * @autor Alcides Rodríguez alcidesrh@gmail.com
     * @return \Illuminate\Database\Query\Builder|null
     */
    public function query()
    {
        return $this->query;
    }

    /**
     * No work with csv
     * @autor Alcides Rodríguez alcidesrh@gmail.com
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:S1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                ]);
            },
        ];
    }
}
