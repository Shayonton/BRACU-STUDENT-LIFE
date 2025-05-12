<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rooms')->insert([
            // Multipurpose Hall (Ground Floor)
            [
                'room_code' => 'GFA01M',
                'floor' => 0,
                'block' => 'A',
                'room_number' => '01',
                'room_type' => 'M',
                'capacity' => 2500,
                'features' => json_encode(['Stage', 'Sound System', 'Projector', 'Lighting', 'Seating']),
                'status' => 'available',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Auditorium (2nd Floor)
            [
                'room_code' => '02AA01A',
                'floor' => 2,
                'block' => 'A',
                'room_number' => '01',
                'room_type' => 'A',
                'capacity' => 500,
                'features' => json_encode(['Stage', 'Sound System', 'Projector', 'Lighting', 'Seating']),
                'status' => 'available',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Clubrooms (6th Floor)
            [
                'room_code' => '06A01C',
                'floor' => 6,
                'block' => 'A',
                'room_number' => '01',
                'room_type' => 'CR',
                'capacity' => 40,
                'features' => json_encode(['Tables', 'Chairs', 'Whiteboard', 'AC']),
                'status' => 'available',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'room_code' => '06B02C',
                'floor' => 6,
                'block' => 'B',
                'room_number' => '02',
                'room_type' => 'CR',
                'capacity' => 35,
                'features' => json_encode(['Tables', 'Chairs', 'Whiteboard', 'AC']),
                'status' => 'available',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'room_code' => '06C03C',
                'floor' => 6,
                'block' => 'C',
                'room_number' => '03',
                'room_type' => 'CR',
                'capacity' => 30,
                'features' => json_encode(['Tables', 'Chairs', 'Whiteboard', 'AC']),
                'status' => 'available',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'room_code' => '06D04C',
                'floor' => 6,
                'block' => 'D',
                'room_number' => '04',
                'room_type' => 'CR',
                'capacity' => 30,
                'features' => json_encode(['Tables', 'Chairs', 'Whiteboard', 'AC']),
                'status' => 'available',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Lecture Theaters (7th Floor)
            [
                'room_code' => '07A01T',
                'floor' => 7,
                'block' => 'A',
                'room_number' => '01',
                'room_type' => 'T',
                'capacity' => 200,
                'features' => json_encode(['Tiered Seating', 'Projector', 'Sound System', 'AC']),
                'status' => 'available',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'room_code' => '07B02T',
                'floor' => 7,
                'block' => 'B',
                'room_number' => '02',
                'room_type' => 'T',
                'capacity' => 200,
                'features' => json_encode(['Tiered Seating', 'Projector', 'Sound System', 'AC']),
                'status' => 'available',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'room_code' => '07C03T',
                'floor' => 7,
                'block' => 'C',
                'room_number' => '03',
                'room_type' => 'T',
                'capacity' => 200,
                'features' => json_encode(['Tiered Seating', 'Projector', 'Sound System', 'AC']),
                'status' => 'available',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'room_code' => '07D04T',
                'floor' => 7,
                'block' => 'D',
                'room_number' => '04',
                'room_type' => 'T',
                'capacity' => 200,
                'features' => json_encode(['Tiered Seating', 'Projector', 'Sound System', 'AC']),
                'status' => 'available',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Lab Room (10th Floor)
            [
                'room_code' => '10B19L',
                'floor' => 10,
                'block' => 'B',
                'room_number' => '19',
                'room_type' => 'L',
                'capacity' => 30,
                'features' => json_encode(['Computers', 'Projector', 'AC', 'Network Access']),
                'status' => 'available',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
} 