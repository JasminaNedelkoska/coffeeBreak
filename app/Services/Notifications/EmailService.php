<?php


namespace App\Services\Notifications;

use RuntimeException;

class EmailService
{
    public function __construct()
    {
    }

    public function sendEmailToStaffMember($staffMember)
    {
        /**
         * Imagine that this function:
         * Sends a email to the user that their coffee break refreshment today will be $staffMember->coffeeBreak
         * returns true of false status of notification sent
         */

        if (is_null($staffMember->email) || $staffMember->email==="") {
            throw new RuntimeException("Cannot send email - no email address");
        }

        return true;
    }
}