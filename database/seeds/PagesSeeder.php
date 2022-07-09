<?php

use Illuminate\Database\Seeder;
use App\Models\Page;
class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                "page" => "search-window",
                "created_at" => now(),
                "updated_at" => now()],
            [
                "page" => "stock-window",
                "created_at" => now(),
                "updated_at" => now()],
            [
                "page" => "edit-record",
                "created_at" => now(),
                "updated_at" => now()],
            [
                "page" => "upload-request",
                "created_at" => now(),
                "updated_at" => now()],
            [
                "page" => "database",
                "created_at" => now(),
                "updated_at" => now()],
            [
                "page" => "rack-info",
                "created_at" => now(),
                "updated_at" => now()],
            [
                "page" => "settings",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "page" => "users",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "page" => "capacity-reset",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "page" => "location-information",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "page" => "covid-19-questions",
                "created_at" => now(),
                "updated_at" => now()
            ],
        ];

        Page::insert($data);
    }
}
