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

class PsychicExport implements FromQuery, WithMapping, WithHeadings, WithEvents
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
            'IP',
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
            'Total Net',
            'Referred by',
            'Profile',
            'Active',
            'Home',
            'Featured',
            'Fraud',
            'Hidden',
            'Test User',
            'Social Link #1',
            'Social Link #2'
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

        $credit = $this->payout($user, true);

        $role = 'Model';

        $credit = $credit['earning'];

        $categories = "";

        foreach ($user->categories()->get() as $value) {
            $categories .= $value->name . ' ';
        }

        $phones = "";

        foreach ($user->user_mobile_nums()->get() as $value) {
            $phones .= $value->number . ' ';
        }

        if ($device = UserDevice::where('user_id', $user->id)->first()) {
            $device = $device->ip;
        }

        $home = false;

        if ($user->email_validated && $user->account_status == 'ACTIVE' && !$user->test_user && $user->userProfile()->where('haedshot_path', '!=', '')->count()) {
            $home = true;
        }

        $numberFormatter = new \NumberFormatter('en_US', \NumberFormatter::CURRENCY);

        try {
            $date = new Carbon($user->created_at, $profile->timezone);
        } catch (\Exception $e) {
            $date = new Carbon($user->created_at);
        }

        // $tz = null;
        // try {
        //     $tz = new CarbonTimeZone($profile->timezone);
        // } catch (\Exception $e) {
        // }

        $date->setTimezone('US/Eastern');

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
            $user->created_at ? $date->format('g:i A') . '  EST': '',
            $credit ? $numberFormatter->format($credit) : '$00.00',
            $user->referred_by,
            $user->profile_percent . '%',
            $user->email_validated ? 'Yes' : 'No',
            $home ? 'Yes' : 'No',
            $user->featured ? 'Yes' : 'No',
            $user->fraud ? 'Yes' : 'No',
            $user->account_status == 'INACTIVE' ? 'Yes' : 'No',
            $user->test_user ? 'Yes' : 'No',
            $profile->social_link_one ?  $profile->social_link_one : '',
            $profile->social_link_two ?  $profile->social_link_two : ''
            
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
                $event->sheet->getStyle('A1:W1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                ]);
            },
        ];
    }
}
