<?php
require_once __DIR__ . '/vendor/autoload.php';

use Billbee\CustomShopApi\Http\Request;
use Billbee\CustomShopApi\Http\RequestHandlerPool;
use Billbee\CustomShopApi\Security\KeyAuthenticator;
use Billbee\CustomShopApiExample\Repository\OrderRepository;
use Billbee\CustomShopApiExample\Security\BasicAuthAuthenticator;

// Keine Authentifizierung
$authenticator = null;

// Authentifizierung per Schlüssel
// $authenticator = new KeyAuthenticator('MySecretKey');

// Authentifizierung mit BasicAuth (Benutzername Passwort)
// $authenticator = new BasicAuthAuthenticator($user = 'admin_user', $pass = 'admin_password');

$handler = new RequestHandlerPool($authenticator, [
    new OrderRepository(),
]);

// Im nächsten Schritt erzeugen wir aus der aktuellen HTTP-Anfrage ein Request Objekt
// und lassen dieses vom RequestHandlerPool verarbeiten
$request = Request::createFromGlobals();
$response = $handler->handle($request);

// Zuletzt wird die Response an den client gesendet
$response->send();
