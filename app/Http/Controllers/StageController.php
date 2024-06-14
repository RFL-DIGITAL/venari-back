<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stage;

class StageController extends Controller
{
    
    public function getStages(Request $request) {
        $stages = Stage::where('company_id', $request->get('company_id'))->get();
        if (!collect($stages)->isEmpty()) {
            return $this->successResponse($stages);
        } else {
            return $this->failureResponse($stages);
        }
    }

}
