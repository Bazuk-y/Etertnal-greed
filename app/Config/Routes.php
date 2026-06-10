<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'JednotliveEtapy::karty'); 
$routes->get('jednotlive_etapy/(:num)', 'JednotliveEtapy::etapy/$1'); 

// Routy pro správu výsledků (Zobrazení, Uložení, Soft-Smazání)
$routes->get('vysledky/editovat/(:num)', 'JednotliveEtapy::editovatVysledek/$1');
$routes->post('vysledky/ulozit/(:num)', 'JednotliveEtapy::ulozitVysledek/$1');
$routes->get('vysledky/smazat/(:num)', 'JednotliveEtapy::smazatVysledek/$1');