<?php

namespace App\Exports;

use App\Models\User;
use App\Services\PayoutUtils;
use App\Http\Trails\PayoutTrail;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PayoutExport implements FromQuery, WithMapping, WithHeadings, WithEvents
{
    use PayoutTrail;

    private $query = null;
    private $date = null;

    public function __construct($query, $date)
    {
        $this->query = $query;
        $this->date = $date;
    }

    /**
     * @autor Alcides Rodríguez alcidesrh@gmail.com
     * @return array
     */
    public function headings(): array
    {
        return [
            'Period',
            'ID',
            'Model',
            'Full Name',
            'Email',
            'Referred By',
            'Earnings',
            'Payout Due',
            'Paid',
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

        $period = $this->date->format('m/d/Y') . '-' . $this->date->copy()->add(6, 'days')->format('m/d/Y');

        $earnings = \round((float)PayoutUtils::get_current_balance($user, $this->date->copy()),2);
        $due = \round((float)PayoutUtils::get_payouts_to_pay($user, $this->date->copy())->sum('payout'),2);
        
        if($due || $earnings)
         $paid = $due ? 'No' : 'Yes';
         else $paid = '';

        $fmt = numfmt_create('us_US', \NumberFormatter::CURRENCY);
        return [
            $period,
            $user->id,
            $profile->display_name,
            $profile->name . ' ' . $profile->last_name,
            $user->email,
            $user->referred_by,
            numfmt_format_currency($fmt, $earnings, 'USD'),
            numfmt_format_currency($fmt, $due, 'USD'),
            $paid
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
                $event->sheet->getStyle('A1:U1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                ]);
            },
        ];
    }
}
