<?php
namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::truncate();
        $csvData = fopen(base_path('database/csv/testCompanyDB.csv'), 'r');
        $transRow = true;
        while (($data = fgetcsv($csvData, 555, ';')) !== false) {
            if (!$transRow) {
                Company::create([
                    'id' => $data[0],
                    'companyName' => $data[1],
                    'companyRegistrationNumber' => $data[2],
                    'companyFoundationDate' => $data[3],
                    'country' => $data[4],
                    'zipCode' => $data[5],
                    'city' => $data[6],
                    'streetAddress' => $data[7],
                    'lat' =>  $data[8],
                    'long' =>  $data[9],
                    'companyOwner' => $data[10],
                    'employees' => $data[11],
                    'activity' => $data[12],
                    'active' => $data[13] == false ? 0:1,
                    'email' => $data[14],
                    'password' => bcrypt($data[15]),
                ]);
            }
            $transRow = false;
        }
        fclose($csvData);
    }
}
