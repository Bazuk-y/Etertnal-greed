<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'JednotliveEtapy::karty'); // Úvodní stránka s kartami
$routes->get('jednotlive_etapy/(:num)', 'JednotliveEtapy::etapy/$1'); // Detail konkrétní etapy podle ID0,

