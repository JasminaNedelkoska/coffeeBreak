<?php

namespace App\Services;

use App\Models\CoffeeBreakPreference;
use App\Models\StaffMember;
use Carbon\Carbon;

class CoffeeBreakService
{
    public function __construct()
    {
    }

    public function getPreferencesForToday($idUserAuth)
    {
        $user = StaffMember::where('id_user_login', '=', $idUserAuth)->first();

        $result = StaffMember::where('team', '=', $user->team)
            ->whereHas('coffeeBreak', function ($query) {
                $query->whereBetween('requested_date',[Carbon::today(), Carbon::tomorrow()]);
            })
            ->with(['coffeeBreak' => function ($query) {
                $query->whereBetween('requested_date', [Carbon::today(), Carbon::tomorrow()]);
            }])->get();

        return $result;
    }

    public function getPreferenceForUser($staffMemberId, $date, $dateTomorrow)
    {
        $result = StaffMember::with('memberTeam')->where('id', '=', $staffMemberId)
            ->whereHas('coffeeBreak' , function ($query) use ($date,  $dateTomorrow) {
                $query->whereBetween('requested_date', [$date,  $dateTomorrow]);
            })
            ->with(['coffeeBreak' => function ($query) use ($date,  $dateTomorrow) {
                $query->whereBetween('requested_date', [$date,  $dateTomorrow]);
            }])
            ->first();

        return $result;
    }

    public function getJsonForResponse($preferences)
    {
        foreach ($preferences as $preference) {
        $json[]  = self::getAsArray($preference);
        }
        return ["preferences"=>$json];
    }

    public function getHtmlForResponse($preferences)
    {

        $html = "<ul>";
        foreach ($preferences as $preference) {
            $detailsString = self::getDetailsString($preference);
            $html .= "<li>" . $preference->name . " would like a " . $preference->coffeeBreak[0]->sub_type . " ($detailsString)</li>";
        }
        $html .= "</ul>";
        return $html;
    }

    public function getXmlForResponse($preferences)
    {
        $preferencesNode = new \SimpleXMLElement('<?xml version="1.0"?><CoffeeBreakPreferences></CoffeeBreakPreferences>');
        foreach ($preferences as $preference) {
            $preferencesNode->addChild('br', $this->getAsXmlElement($preference));
        }

        return $preferencesNode->asXML();
    }

    public function getAsXmlElement($preference)
    {
        $xml = "<preference type='" . $preference->coffeeBreak[0]->type . "' subtype='" . $preference->coffeeBreak[0]->sub_type . "'>";
        $xml .= "<requestedBy>" . $preference->name . "</requestedBy>";
        $xml .= "<details>" .  self::getDetailsString($preference) . "</details>";
        $xml .= "</preference>";

        return $xml;
    }

    public function getAsArray($preference)
    {
        return [
            "type" => $preference->coffeeBreak[0]->type,
            "subType" => $preference->coffeeBreak[0]->sub_type,
            "requestedBy" => [
                "name" => $preference->name
            ],
            "details" => $preference->coffeeBreak[0]->details
        ];
    }

    public function getDetailsString($preference){
        return implode(
            ",",
            array_map(
                function ($detailKey, $detailValue) {
                    return "$detailKey : $detailValue";
                },
                array_keys($preference->coffeeBreak[0]->details),
                array_values($preference->coffeeBreak[0]->details)
            )
        );
    }
}