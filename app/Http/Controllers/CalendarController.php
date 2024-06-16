<?php

namespace App\Http\Controllers;

use App\Google;
use App\Models\Calendar;
use App\Services\CalendarService;
use DateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CalendarController extends Controller
{
    public function __construct(protected CalendarService $calendarService)
    {
    }

    public function loginWithGoogle(Request $request): JsonResponse
    {
        if ($request->get('code')) {
            return $this->successResponse(
                $this->calendarService->loginWithGoogle($request->user(), $request->get('code'))
            );

        } else {
            return $this->successResponse(
                $this->calendarService->createRedirectUrl()
            );
        }
    }

    public function createSlots(Request $request): JsonResponse
    {
        return $this->successResponse(
            $this->calendarService->createEvents(
                $request->user(),
                $request->start_time,
                $request->end_time,
                $request->slot_duration,
                $request->break_duration,
                $request->days,
                $request->is_create_meet
            )
        );
    }

    public function getCalendarID(Request $request): JsonResponse
    {
        return $this->successResponse(
            ['calendar_id' => $this->calendarService->getCalendarID($request->user()->id)]
        );
    }

    public function getAvailableSlotsInMonth(Request $request): JsonResponse
    {
        return $this->successResponse(
            $this->calendarService->getAvailableSlotsInMonth(
                $request->accountable_id,
                $request->month
            )
        );
    }

    public function bookSlot(Request $request): JsonResponse
    {
        return $this->successResponse(
            $this->calendarService->bookSlot(
                $request->event_id,
            )
        );
    }

    public function downloadICS(Request $request): StreamedResponse
    {
        return response()->streamDownload(function () use ($request) {
            echo $this->calendarService->downloadICS($request->user->hrable->id);
        }, 'calendar.ics');
    }

}
