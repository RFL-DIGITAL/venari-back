<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    
    public function show($id) {

        $data = Company::where('id', $id)->get()->load([
            'building.street.city.country'
        ]);
        if (!collect($data)->isEmpty()) {
            return $this->successResponse($data);
        }
        return $this->failureResponse($data["errorMessage"] = 'Index Out Of Range');

    }

}
