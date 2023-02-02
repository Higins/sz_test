<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Log;

class CompanyController extends Controller
{

    private $model;

    public function __construct(Company $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $companies = Company::orderBy("id","desc")->get();
        return response()->json($companies, 200);
    }

    public function activity()
    {
        list($data,$status) = $this->model->getCompanyByActivityList();
        return response()->json($data, $status);
    }


    public function create(Request $request)
    {
        list($status,$code) = $this->model->create($request->company);
        return response()->json([ 'status' => $status], $code);
    }
    public function getCompanyByCreatedDate()
    {
        list($data,$code) = $this->model->showCompanyByDates();
        return response()->json([ 'data' => $data], $code);
    }

    public function getCompanyByID($id)
    {
        list($data,$code) = $this->model->getById($id);
        return response()->json([ 'data' => $data], $code);
    }


    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\company  $company
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
        ]);

        $company->fill($request->post())->save();
        return response()->json([ 'data' => 'Company Has Been updated successfully'], 200);
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Company  $company
    * @return \Illuminate\Http\Response
    */
    public function destroy(Company $company)
    {
        $company->delete();
        return response()->json([ 'data' => 'Company has been deleted successfully'], 200);
    }
}
