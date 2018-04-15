<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds. Empty all tables, reset auto increment primary key and insert data set
     *
     * @return void
     */
    public function run()
    {	
    	DB::table('meetings')->delete();
    	DB::statement('ALTER TABLE meetings AUTO_INCREMENT = 1');

        DB::table('meetings')->insert([[
            'location' => 'Brisbane',
            'type' => 'greyhound'
        ], [
            'location' => 'Sydney',
            'type' => 'thoroughbred'
        ], [
            'location' => 'Melbourne',
            'type' => 'harness'
        ], [
            'location' => 'Perth',
            'type' => 'greyhound'
        ], [
            'location' => 'Adelaide',
            'type' => 'thoroughbred'
        ], [
            'location' => 'Alice Springs',
            'type' => 'harness'
        ]]);

        DB::table('competitors')->delete();
        DB::statement('ALTER TABLE competitors AUTO_INCREMENT = 1');

        DB::table('competitors')->insert([[
        	'name' => 'Sunburnt Highway'
        ], [
        	'name' => 'Hectic Bro'
        ], [
        	'name' => 'Coming Of Love'
        ], [
        	'name' => 'Zipping Falcon'
        ], [
        	'name' => 'Phantom Owl'
        ], [
        	'name' => 'Third Vintage'
        ], [
        	'name' => 'Winsome Jesse'
        ], [
        	'name' => 'Zipping Manuela'
        ], [
        	'name' => 'Complete Love'
        ], [
        	'name' => 'Zoomy Maniac'
        ]]);

        $races = [];
        for($i = 1; $i <= 100; $i++) {
        	$races[] = [
        		'meeting_id' => ($i % 6) + 1,
        		'name' => "Race {$i}",
        		'close_time' => Carbon::now()->addMinutes($i)->addSeconds(rand(0, 59))->format('Y-m-d H:i:s')
        	];
        }

        DB::table('races')->delete();
        DB::statement('ALTER TABLE races AUTO_INCREMENT = 1');
        DB::table('races')->insert($races);

        $positions = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        $race_competitors = [];
        for($i = 1; $i <= 100; $i++) {
        	shuffle($positions);

        	for($j = 1; $j <= 10; $j++) {
        		$race_competitors[] = [
        			'race_id' => $i,
        			'competitor_id' => $j,
        			'position' => $positions[$j - 1]
        		];
        	}
        }

        DB::table('race_competitors')->delete();
        DB::statement('ALTER TABLE race_competitors AUTO_INCREMENT = 1');
        DB::table('race_competitors')->insert($race_competitors);
    }
}
