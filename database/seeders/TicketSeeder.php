<?php

namespace Database\Seeders;

use App\Models\Schedule;
use App\Models\ServiceProvider;
use App\Models\Ticket;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    private $tripsPerBatch;

    public function __construct()
    {
        $this->tripsPerBatch = 100;
    }
    public function run()
    {
        $trips_all = Trip::with(['coach:id,seat_number'])->get()->toArray();

        //Get random trips inserted
        $ticketsInsertedAll = [];
        $tripsInserted = [];
        for ($i = 0; $i < $this->tripsPerBatch; ++$i) {
            $key_rand = array_rand($trips_all);
            $tripsInserted[] = $trips_all[$key_rand];
            unset($trips_all[$key_rand]);
        }
        //Generate random tickets per those trips
        foreach ($tripsInserted as $trip) {
            $schedule = Schedule::get_schedules_list($trip['service_provider_id'], $trip['schedule_id'])[0];
            $ticketsInsertedNum = rand(1, $trip['coach']['seat_number']);
            $positions = range(1, $trip['coach']['seat_number']);
            for ($i = 0; $i < $ticketsInsertedNum; ++$i) {
                $ticket = [];
                $key_rand = array_rand($positions);
                $locations = array_rand($schedule['schedule_detail'], 2);
                sort($locations);
                $ticket = [
                    'seat_position' => $positions[$key_rand],
                    'departure_station_id' => $schedule['schedule_detail'][$locations[0]]['id'],
                    'arrival_station_id' => $schedule['schedule_detail'][$locations[1]]['id'],
                    'trip_id' => $trip['id'],
                    'user_id' => User::orderByRaw('RAND()')->first()->id
                ];
                $ticketsInsertedAll[] = $ticket;
                unset($positions[$key_rand]);
            }
        }
        Ticket::insert($ticketsInsertedAll);

        // dd($schedule,$trip);
    }
}
