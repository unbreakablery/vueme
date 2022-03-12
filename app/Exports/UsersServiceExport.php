<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\User;
use App\Models\UserDevice;
use Carbon\CarbonTimeZone;
use App\Http\Trails\ServiceTrail;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersServiceExport implements FromQuery, WithMapping, WithHeadings, WithEvents
{
    use ServiceTrail;

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
            'Username',
            'ID',
            'Full name',
            'Email',
            'Phone',
            'Sign up date',
            'AVG all',
            'AVG video',
            'AVG call',
            'AVG chat',
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

        $phones = "";

        foreach ($user->user_mobile_nums()->get() as $value) {
            $phones .= $value->number . ' ';
        }

        if ($device = UserDevice::where('user_id', $user->id)->first()) {
            $device = $device->ip;
        }
        

        try {
            $date = new Carbon($user->created_at, $profile->timezone);
        } catch (\Exception $e) {
            $date = new Carbon($user->created_at);
        }

        $date->setTimezone('US/Eastern');

        $numberFormatter = new \NumberFormatter( 'en_US', \NumberFormatter::CURRENCY );

    
        $now = Carbon::now();

        $days = $date->diffInDays($now);

        $service = $this->clientService($user, $days);

        return [
            $device,
            $profile->display_name,
            $user->id,
            $profile->name . ' ' . $profile->last_name,
            $user->email,
            $phones,
            $user->created_at ? $date->format('m/d/Y') : '',
            $service['avg_session'],
            $service['avg_video'],
            $service['avg_call'],
            $service['avg_chat'],
            
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
