<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Company extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'companyName',
        'companyRegistrationNumber',
        'companyFoundationDate',
        'country',
        'zipCode',
        'city',
        'streetAddress',
        'latitude',
        'lat',
        'long',
        'companyOwner',
        'employees',
        'activity',
        'active',
        'email',
        'password',
    ];

    protected $casts = [
        'companyFoundationDate' => 'date:Y-m-d',
        'lat' => 'decimal:8',
        'long' => 'decimal:8'
    ];

    public function getCompanyByActivityList() :array
    {
        $getCompanyByActivityList = DB::select(DB::raw("select
        IF(activity = 'Building Industry', companyName, NULL) `Building Industry`,
        IF(activity = 'Car', companyName, NULL) `Car`,
        IF(activity = 'Food', companyName, NULL) `Food`,
        IF(activity = 'Growing Plants', companyName, NULL) `Growing Plants`,
        IF(activity = 'IT', companyName, NULL) `IT`
        from companies;"));
        if (!$getCompanyByActivityList) {
            Log::error("Company not found or empty db");
            return [[],418];
        }

        return [$getCompanyByActivityList, 200];
    }
    public function getById($ids) :array
    {
        $company = Company::where('id', 'in', $ids)->get();
        if (!$company) {
            Log::error("Company not found or empty db");
            return [[],418];
        }
        return [$company, 200];
    }
    // https://gist.github.com/archan937/d242e2be4d0e7aea53a6
    public function showCompanyByDates() :array
    {
        $showCompanyByDates = DB::select(DB::raw("select dates, c.company from
        (select adddate('1970-01-01',d4.i*10000 + d3.i*1000 + d2.i*100 + d1.i*10 + d0.i) dates from
         (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) d0,
         (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) d1,
         (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) d2,
         (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) d3,
         (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) d4) v
        left join (select companyFoundationDate, GROUP_CONCAT(companyName) company from companies where companyFoundationDate >= '2001-01-01' group by companyFoundationDate) c
        ON c.companyFoundationDate = dates
        where dates between '2001-01-01' and now();"));
        if (!$showCompanyByDates) {
            Log::error("Company not found or empty db");
            return [[],418];
        }
        usort($showCompanyByDates, function($a, $b) {
            return strtotime($a->dates) - strtotime($b->dates);
        });

        return [$showCompanyByDates, 200];
    }
    public static function create($company) :array
    {
        if (gettype($company) == 'array') {
            $company = (object)$company;
        }

        $newCompany = new Company();
        $newCompany->companyName = $company->companyName;
        $newCompany->companyRegistrationNumber = $company->companyRegistrationNumber;
        $newCompany->companyFoundationDate = $company->companyFoundationDate;
        $newCompany->country = $company->country;
        $newCompany->zipCode = $company->zipCode;
        $newCompany->city = $company->city;
        $newCompany->streetAddress = $company->streetAddress;
        $newCompany->lat = $company->lat;
        $newCompany->long = $company->long;
        $newCompany->companyOwner = $company->companyOwner;
        $newCompany->employees = $company->employees;
        $newCompany->activity = $company->activity;
        $newCompany->active = $company->active;
        $newCompany->email = $company->email;
        $newCompany->password = $company->password;
        try {
            $newCompany->save();
            $status = true;
            $code = 200;
            Log::info("Company save is successful ID: " . $newCompany->id);
        } catch (\Exception $e)
        {
            $status = false;
            $code = 418;
            Log::critical($e);
        }

        return [$status,$code];
    }
}
