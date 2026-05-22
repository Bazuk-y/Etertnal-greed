<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Karty::index');
$routes->get("jednotlive_Etapy/", "Main::index2");
