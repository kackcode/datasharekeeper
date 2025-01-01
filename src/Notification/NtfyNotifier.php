<?php
namespace Kackcode\Datasharekeeper\Notification;

use Kackcode\Datasharekeeper\Utilities\GuzzleService;

class NtfyNotifier extends GuzzleService
{
    private $server_url;
    private $authorization;

    public function __construct($server_url,$authorization)
    {
        $this->server_url = $server_url;
        $this->authorization = $authorization;
    }

    public function send(string $title,$tag,$content,$ttl = 3600): bool
    {
        $headers = [
            'Authorization' => 'Basic ' . $this->authorization,
            'Content-Type' => 'text/plain',
            // "Icon: https://styles.redditmedia.com/t5_32uhe/styles/communityIcon_xnt6chtnr2j21.png",
            'X-Title' => $title,
            'X-Tags' => $tag,
            // 'X-TTL' => 1,
        ];

        return $this->sendPostRequestWithHeader($this->server_url,$headers,$content);
    }

}
