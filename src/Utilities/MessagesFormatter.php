<?php

namespace Kackcode\Datasharekeeper\Utilities;

class MessagesFormatter
{
    public static function formatMessages(array $dataMessages): string
    {
        $messages = "<table>";
        foreach ($dataMessages as $key => $value) {
            $messages .= "<tr><td>{$key}</td><td><strong>{$value}</strong></td></tr>";
        }
        $messages .= "</table>";
        return $messages;
    }
}
