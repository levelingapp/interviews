<?php
require('../vendor/autoload.php');

use Givepulse\Controllers\EventsController;

if($_GET['controller'] == "events") {
    $eventsController = new EventsController();

    echo $eventsController->getEvents();
}
