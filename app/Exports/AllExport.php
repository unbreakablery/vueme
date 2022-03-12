<?php

namespace App\Exports;

use App\Http\Trails\PayoutTrail;
use App\Models\User;
use App\Models\UserDevice;
use App\Services\WhiteLabel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class AllExport implements FromQuery, WithMapping, WithHeadings, WithEvents
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
            'Credit',
            'Referred by',
            'Profile',
            'Active',
            'Home',
            'Featured',
            'Fraud',
            'Hidden',
            'Test User',
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

        $categories = $creditU = $creditP = "";

        $home = false;

        if ($user->role_id == WhiteLabel::roleId('User')) {

            $role = 'Client';

            $creditU = $user->credits;//$credit['current_balance'];
        } else {
            $role = 'Model';

            $creditP = $credit['earning']-\round($credit['earning'] / 5, 2);

            foreach ($user->categories()->get() as $value) {
                $categories .= $value->name . ' ';
            }

            if ($user->email_validated && $user->account_status == 'ACTIVE' && !$user->test_user && $user->userProfile()->where('haedshot_path', '!=', '')->count()) {
                $home = true;
            }

        }
        $phones = "";
        foreach ($user->user_mobile_nums()->get() as $value) {
            $phones .= $value->number . ' ';
        }

        if ($device = UserDevice::where('user_id', $user->id)->first()) {
            $device = $device->ip;
        }
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
            $user->created_at ? $user->created_at->format('m/d/Y') : '',
            $user->created_at ? $user->created_at->format('g:i A') : '',
            $creditP ? $numberFormatter->format($creditP) : '$00.00',
            $creditU ? $numberFormatter->format($creditU) : '$00.00',
            $user->referred_by,
            $user->profile_percent . '%',
            $user->email_validated ? 'Yes' : 'No',
            $home ? 'Yes' : 'No',
            $user->featured ? 'Yes' : 'No',
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
                $event->sheet->getStyle('A1:V1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                ]);
            },
        ];
    }
}
