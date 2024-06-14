<?php

namespace App\Http\Controllers;

use App\Google;
use App\Models\Calendar;
use App\Services\CalendarService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function __construct(protected CalendarService $calendarService) {}

    public function loginWithGoogle(Request $request): JsonResponse
    {
        if ($request->has('code')) {
            return $this->successResponse(
                $this->calendarService->loginWithGoogle($request->user(), $request->get('code'))
            );

        } else {
            return $this->successResponse(
                $this->calendarService->createRedirectUrl()
            );
        }
    }
}
