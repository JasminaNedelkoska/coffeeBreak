<?php


namespace App\Services\Notifications;

use RuntimeException;

class HipChatNotifierService
{
    public function __construct()
    {
    }

    public function notifyStaffMember($staffMember)
    {
        /**
         * Imagine that this function:
         * Sends a notification to the user on Hipchat that their coffee break refreshment today will be $staffMember->coffeeBreak
         * returns true of false status of notification sent
         */

        if (is_null($staffMember->hip_chat_identifier) || $staffMember->hip_chat_identifier==="") {
            throw new RuntimeException("Cannot send notification - no HipChatIdentifier");
        }

        return true;
    }
}