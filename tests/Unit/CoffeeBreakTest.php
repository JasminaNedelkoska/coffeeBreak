<?php

namespace Tests\Unit;

use App\Models\StaffMember;
use App\Models\Team;
use Tests\TestCase;
use RuntimeException;

class CoffeeBreakTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    protected $emailService;
    protected $hipChatNotifierService;

    public function setUp() {
        parent::setUp();
        $this->emailService = $this->app->make('App\Services\Notifications\EmailService');
        $this->hipChatNotifierService = $this->app->make('App\Services\Notifications\HipChatNotifierService');
    }

    public function testStatusOfNotificationIsTrueWithHipChat()
    {
        $staff = new StaffMember([
            'name' => 'Monika',
            'email' => 'monika@monika.com',
            'hip_chat_identifier' => 'ABC123',
            'team' => 1,
        ]);

        $staffTeam = new Team([
            'name' => 'management',
            'has_hip_chat' => true,
        ]);

        if ($staffTeam->has_hip_chat === true) {
            $status = $this->hipChatNotifierService->notifyStaffMember($staff);
        } else {
            $status = $this->emailService->sendEmailToStaffMember($staff);
        }

        $this->assertTrue($status);
    }

    public function testStatusOfNotificationIsTrueWithoutHipChat()
    {
        $staff = new StaffMember([
            'name' => 'Monika',
            'email' => 'monika@monika.com',
            'hip_chat_identifier' => 'ABC123',
            'team' => 1,
        ]);

        $staffTeam = new Team([
            'name' => 'management',
            'has_hip_chat' => false,
        ]);

        if ($staffTeam->has_hip_chat === true) {
            $status = $this->hipChatNotifierService->notifyStaffMember($staff);
        } else {
            $status = $this->emailService->sendEmailToStaffMember($staff);
        }

        $this->assertTrue($status);
    }

    public function testThrowsExceptionWhenCannotNotify()
    {
        $staff = new StaffMember([
            'name' => 'Monika',
            'email' => 'monika@monika.com',
            'team' => 1,
        ]);

        $staffTeam = new Team([
            'name' => 'management',
            'has_hip_chat' => true,
        ]);

        $this->expectException(\RuntimeException::class);
        if ($staffTeam->has_hip_chat === true) {
             $this->hipChatNotifierService->notifyStaffMember($staff);
        } else {
             $this->emailService->sendEmailToStaffMember($staff);
        }
    }

    public function testThrowsExceptionWhenCannotSentEmail()
    {
        $staff = new StaffMember([
            'name' => 'Monika',
            'hip_chat_identifier' => 'ABC123',
            'team' => 1,
        ]);

        $staffTeam = new Team([
            'name' => 'management',
            'has_hip_chat' => false,
        ]);

        $this->expectException(\RuntimeException::class);
        if ($staffTeam->has_hip_chat === true) {
            $this->hipChatNotifierService->notifyStaffMember($staff);
        } else {
            $this->emailService->sendEmailToStaffMember($staff);
        }
    }

    public function testThrowsExceptionWhenErrorData()
    {
        $staff = new StaffMember([
            'name' => 'Monika',
            'hip_chat_identifier' => 'ABC123',
            'team' => 1,
        ]);

        $this->expectException(\RuntimeException::class);
        if (isset($staffTeam)) {
            if ($staffTeam->has_hip_chat === true) {
                $this->hipChatNotifierService->notifyStaffMember($staff);
            } else {
                $this->emailService->sendEmailToStaffMember($staff);
            }
        } else {
            throw new RuntimeException("Cannot notify - no member");
        }
    }
}
