<?php
namespace Givepulse\Controllers;

use Givepulse\Models\Events;

/**
 * Class EventsController
 * @package Givepulse\Controllers
 */
class EventsController
{


    public function index()
    {

    }

    /**
     * @return string
     */
    public function getEvents()
    {
        $events = new Events();
        $queryEvents = $events->get();

        return json_encode($queryEvents);
    }
}
