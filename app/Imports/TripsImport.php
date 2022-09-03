<?php

namespace App\Imports;

use App\Models\Coach;
use App\Models\Schedule;
use App\Models\Trip;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class TripsImport implements ToModel, WithBatchInserts, WithHeadingRow, WithValidation
{
    private $service_provider_id;
    public function __construct($service_provider_id)
    {
        $this->service_provider_id = $service_provider_id;
    }
    public function prepareForValidation($data, $index)
    {

        if (isset($data['departure_date'])&&strtotime($data['departure_date']) === false) {
           preg_match_all("/[0-9]+/i", $data['departure_date'],$dateArgs);
           $data['departure_date']=implode('-',$dateArgs[0]);
        }
        return $data;
    }
    public function model(array $row)
    {
        return new Trip([
            'service_provider_id' => $this->service_provider_id,
            'schedule_id' => $row['schedule_id'],
            'coach_id' => $row['coach_id'],
            'departure_date' => $row['departure_date'],
            'price' => $row['price'],
        ]);
    }
    public function batchSize(): int
    {
        return 1000;
    }


    public function rules(): array
    {
        return [

            // Above is alias for as it always validates in batches
            '*.price' => [
                'bail',
                'required',
                'numeric',
                'min:0',
            ],
            '*.schedule_id' => [
                'bail',
                'required',
                function ($attribute, $value, $onFailure) {
                    if (!Schedule::where('id', $value)->where('service_provider_id', $this->service_provider_id)->exists()) {
                        $onFailure('Schedule_ID is not valid');
                    }
                }
            ],
            '*.coach_id' => [
                'bail',
                'required',
                function ($attribute, $value, $onFailure) {
                    if (!Coach::where('id', $value)->where('service_provider_id', $this->service_provider_id)->exists()) {
                        $onFailure('Coach_ID is not valid');
                    }
                }
            ],
            '*.departure_date' => [
                'bail',
                'required',
                'date',
                'after_or_equal:today'
            ]
        ];
    }
}
