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
        // Benutzerinfo aus der Request auslesen
        $userInfo = trim($request->getUri()->getUserInfo());

        // Wenn keine Zugangsdaten übermittelt wurden, ist der Nutzer nicht berechtigt
        if (empty($userInfo)) {
            return false;
        }

        // Die Zugangsdaten kommen im Format Benutzername:Passwort -> Splitten und als variablen zuweisen
        list($username, $password) = explode(':', $userInfo, 2);

        // Benutzername und Passwort überprüfen und ergebnis zurückgeben
        return ($username == $this->username && $password == $this->password);
    }
}
