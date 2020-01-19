<?php

namespace App\Http\Controllers;

use App\Models\StaffMember;
use App\Models\Team;
use App\Services\CoffeeBreakService;
use App\Services\Notifications\EmailService;
use App\Services\Notifications\HipChatNotifierService;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Support\Facades\Auth;

class CoffeeBreakController extends Controller
{
    protected $coffeeBreakService;
    protected $emailService;
    protected $hipChatNotifierService;

    public function __construct(CoffeeBreakService $coffeeBreakService,
                                EmailService $emailService,
                                HipChatNotifierService $hipChatNotifierService)
    {
        $this->coffeeBreakService = $coffeeBreakService;
        $this->emailService = $emailService;
        $this->hipChatNotifierService = $hipChatNotifierService;
    }

    public function todayAction($format = "html")
    {
        $idUserAuth = Auth::user()->id;

        $result = $this->coffeeBreakService->getPreferencesForToday($idUserAuth);

        if ($format === "xml") {
            $responseContent = $this->coffeeBreakService->getXmlForResponse($result);
            $contentType = "text/xml";
        } elseif ($format === "json") {
            $responseContent = $this->coffeeBreakService->getJsonForResponse($result);
            $contentType = "application/json";
        } else {
            $responseContent = $this->coffeeBreakService->getHtmlForResponse($result);
            $contentType = "text/html";
        }

        return response($responseContent, 200)->header('Content-Type', $contentType);
    }

    public function notifyStaffMemberAction($staffMemberId)
    {
        $member = $this->coffeeBreakService->getPreferenceForUser($staffMemberId, Carbon::today(), Carbon::tomorrow());
        if (isset($member->memberTeam)) {
            if ($member->memberTeam->has_hip_chat === true) {
                $notificationSent = $this->hipChatNotifierService->notifyStaffMember($member);
            } else {
                $notificationSent = $this->emailService->sendEmailToStaffMember($member);
            }
        } else {
            throw new RuntimeException("Cannot notify - no member");
        }

        return response($notificationSent ? "OK" : "NOT OK", 200);
    }
}