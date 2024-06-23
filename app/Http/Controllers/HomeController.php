<?php

namespace App\Http\Controllers;

use App\Services\CalendarService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected CalendarService $calendarService)
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Request $request)
    {
        if ($request->has('code')) {
//            return $this->successResponse(
            $this->calendarService->loginWithGoogle($request->user(), $request->get('code'));
            $tempFile = tempnam(sys_get_temp_dir(), $this->calendarService->downloadICS(1));

            return response()->download($tempFile, 'calendar.ics', ['Content-Type: text/calendar']);
//                $this->calendarService->syncCalendarFromG(1);
//                $this->calendarService->createEvents(
//                    $request->user(),
//                    '13:00',
//                    '22:00',
//                    '60',
//                    '0',
//                    [
//                        '15-06-2024', '16-06-2024'
//                    ],
//                    false
//                );
//            );

        } else {
//            return $this->successResponse(
                return redirect($this->calendarService->createRedirectUrl()['message']);
//            );
        }
//        return view('messages_debug.message', [
//            'chatPreviews' => app('App\Http\Controllers\ChatController')->getChats($request),
//            'messages' => app('App\Http\Controllers\ChatController')->getMessagesByUserID($request, 3),
//        ]);
    }

//    /**
//     * Show the application dashboard.
//     *
//     * @return \Illuminate\Contracts\Support\Renderable
//     */
//    public function index()
//    {
//        return view('home');
//    }
}
