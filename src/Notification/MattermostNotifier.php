<?php
namespace Kackcode\Datasharekeeper\Notification;

use Kackcode\Datasharekeeper\Utilities\GuzzleService;

class MattermostNotifier extends GuzzleService
{
    private $webhook_url;
    private $username;
    private $password;

    public function __construct($webhook_url,$username,$password)
    {
        $this->webhook_url = $webhook_url;
        $this->username = $username;
        $this->password = $password;
    }

    public function send(string $message,$channel,$icon_url): bool
    {
        $payload = [
            'text' => $message,
            'username' => $this->username,
            'channel' => $channel,
            'icon_url' => $icon_url
        ];

        return $this->sendJsonPostRequest($this->webhook_url,$payload);
    }
}
