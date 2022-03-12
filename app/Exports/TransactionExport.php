<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\User;
use App\Models\UserDevice;
use App\Services\PayoutUtils;
use App\Services\BillingUtils;
use App\Http\Trails\PayoutTrail;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionExport implements FromQuery, WithMapping, WithHeadings, WithEvents
{
    use PayoutTrail;

    private $query = null;
    private $date = null;

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
            'time',
            'amount',
            'customer_id',
            'status',
            'zip_code'
        ];
    }

    /**
     * @autor Alcides Rodríguez alcidesrh@gmail.com
     * @param mixed $user
     * @return array
     */
    public function map($credit_logs): array
    {

        $numberFormatter = new \NumberFormatter( 'en_US', \NumberFormatter::CURRENCY );

        $user = $credit_logs->user()->first();

        // $cardInfo = BillingUtils::get_user_cards_and_info($user->id, 'CREDIT');

        return [
            $credit_logs->created_at->format('m/d/Y H:i:s'),
            $numberFormatter->format($credit_logs->credits),
            $user->id.' ',
            $user->user_credit_logs()->where('user_credit_log.action', 'BUY_CREDIT')->count() == 1
            ? 'NET NEW' : 'AGING',
            '00000'
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
