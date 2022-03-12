<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class MarketingExport implements FromArray, WithMapping, WithHeadings, WithEvents
{
    private $new = null;
    private $aging = null;
    private $date = null;
    private $numberFormatter = null;

    public function __construct($array, $date)
    {
        $this->array = $array;
        $this->date = $date;
        $this->numberFormatter = new \NumberFormatter('en_US', \NumberFormatter::CURRENCY);
    }

    /**
     * @autor Alcides Rodríguez alcidesrh@gmail.com
     * @return array
     */
    public function headings(): array
    {
        $month = $this->date->copy()->startOfYear()->startOfMonth();
        $header = [
            'STATUS',
            'KPI',
        ];

        $monthNumber = \intval($this->date->format('m'));

        for ($i = 0; $i < $monthNumber; $i++) {
            $header[] = $month->format('M');
            $month->addMonth();
        }

        $header[] = 'Grand Total';

        return $header;
    }

    /**
     * @autor Alcides Rodríguez alcidesrh@gmail.com
     * @param mixed $user
     * @return array
     */
    public function map($data): array
    {
        $format = function ($i) {
            if (\is_numeric($i)) {
                return $this->numberFormatter->format($i);
            }

            return $i;
        };
        $rows = $total = [];
        foreach ($data as $type => $values) {

            foreach ($values as $key => $value) {
                if ($key == 'CUSTOMERS') {
                    $rows[] = \array_merge([$type], [$key], \array_map(function($v){return $v == 0 ? "0" : $v;}, \array_merge($value, [\array_sum(\array_slice($value, 0))])));
                } else {
                    $rows[] = \array_merge([''], [$key], \array_map($format, \array_merge($value, [\array_sum(\array_slice($value, 0))])));
                }
            }
        }


        $rows[] = ['MONTHLY TOTALS'];

        $rows[] = \array_merge([''], ['AGING CUSTOMERS'], \array_map(function($v){return $v == 0 ? "0" : $v;}, $data['AGING']['CUSTOMERS']), [\array_sum(\array_map(function($v){return $v == 0 ? "0" : $v;}, $data['AGING']['CUSTOMERS']))]);
        $rows[] = \array_merge([''], ['AGING REVENUE'], \array_map($format, $data['AGING']['REVENUE']), [$format(\array_sum($data['AGING']['REVENUE']))]);
        $rows[] = \array_merge([''], ['AVE AGING VALUE'], \array_map($format, $data["AGING"]["AVE PURCHASE"]), [$format(\array_sum($data['AGING']['AVE PURCHASE']))]);

        $rows[] = \array_merge([''], ['NET NEW CUSTOMERS'], \array_map(function($v){return $v == 0 ? "0" : $v;}, $data['NET NEW']['CUSTOMERS']), [\array_sum(\array_map(function($v){return $v == 0 ? "0" : $v;}, $data['NET NEW']['CUSTOMERS']))]);
        $rows[] = \array_merge([''], ['NET NEW REVENUE'], \array_map($format, $data['NET NEW']['REVENUE']), [$format(\array_sum($data['NET NEW']['REVENUE']))]);
        $rows[] = \array_merge([''], ['AVE NET NEW VALUE'], \array_map($format, $data["NET NEW"]["AVE PURCHASE"]), [$format(\array_sum($data["NET NEW"]["AVE PURCHASE"]))]);

        $sum = function ($array1, $array2) {
            $result = [];

            for ($i = 0; $i < \count($array1); $i++) {
                $result[] = $array1[$i] + $array2[$i];
            }

            return $result;
        };
        $total = $sum($data["NET NEW"]["AVE PURCHASE"], $data["AGING"]["AVE PURCHASE"]);

        $rows[] = \array_merge([''], ['TOTAL REVENUE'], \array_map($format, $total), [$format(\array_sum($total))]);

        return $rows;
    }

    /**
     * @autor Alcides Rodríguez alcidesrh@gmail.com
     * @return \Illuminate\Database\Query\Builder|null
     */
    function array(): array
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
                $event->sheet->getStyle('A1:U1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                ]);
            },
        ];
    }
}
