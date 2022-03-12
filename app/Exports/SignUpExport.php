<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\User;
use App\Models\UserDevice;
use App\Services\WhiteLabel;
use App\Http\Trails\PayoutTrail;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SignUpExport implements FromArray, WithMapping, WithHeadings, WithEvents
{
    use PayoutTrail;

    private $array = [];

    public function __construct($array)
    {
        $this->array = $array;
    }

    /**
     * @autor Alcides Rodríguez alcidesrh@gmail.com
     * @return array
     */
    public function headings(): array
    {
        return [
            'Date',
            'New Models ',
            'New Clients'
        ];
    }

    /**
     * @autor Alcides Rodríguez alcidesrh@gmail.com
     * @param mixed $user
     * @return array
     */
    public function map($data): array
    {
        $date = explode("-", $data['date']);
        return [
            Carbon::createFromDate($date[0], $date['1'], $date['2'])->format('m/d/yy'),
            isset($data['models']) ? $data['models'] : '0',
            isset($data['users']) ? $data['users'] : '0'
        ];
    }

    /**
     * @autor Alcides Rodríguez alcidesrh@gmail.com
     */
    public function array(): array
    {
        return $this->array;
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
                $event->sheet->getStyle('A1:C1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                ]);
            },
        ];
    }
}
