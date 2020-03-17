<?php

namespace Billbee\CustomShopApiExample\Security;

use Billbee\CustomShopApi\Security\AuthenticatorInterface;
use Psr\Http\Message\RequestInterface;

class BasicAuthAuthenticator implements AuthenticatorInterface
{
    /** @var string */
    private $username;

    /** @var string */
    private $password;

    /**
     * BasicAuthAuthenticator constructor.
     * @param string $username The BasicAuth username
     * @param string $password The BasicAuth password
     */
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function isAuthorized(RequestInterface $request)
    {
        $userInfo = trim($request->getUri()->getUserInfo());
        if (empty($userInfo)) {
            return false;
        }

        list($username, $password) = explode(':', $userInfo, 2);
        if ($username != $this->username && $password != $this->password) {
            return false;
        }

        return true;
    }
}
