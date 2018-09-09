<?php
namespace Givepulse\Models;

use Givepulse\Helpers\Connection;
use GuzzleHttp\Client as GuzzleClient;

/**
 * Class Events
 * @package Givepulse\Models
 */
class Events
{
    /**
     * @var \PDO
     */
    private $db;

    /**
     * Events constructor.
     */
    function __construct()
    {
        $connect = new Connection();
        $this->db = $connect->open_connection();
    }

    /**
     * @return array
     */
    public function get()
    {
        $address = $this->getLatAndLon($_GET['address']);
        $bounding_distance = 1; //if you put 1 will get roughly 55 miles

        $latMinusBounding = $address->lat - $bounding_distance;
        $latPlusBounding = $address->lat + $bounding_distance;
        $lonMinusBounding = $address->lng - $bounding_distance;
        $lonPlusBounding = $address->lng + $bounding_distance;

        $sql =  "SELECT *
                FROM givepulse_test.events
                WHERE latitude BETWEEN :latitudeMinusBounding AND :latitudePlusBounding 
                AND longitude BETWEEN :longitudeMinusBounding AND :longitudePlusBounding 
                
                ";

        //Query Parameters
        $query_params = array(
            ':latitudeMinusBounding' => $latMinusBounding,
            ':latitudePlusBounding' => $latPlusBounding,
            ':longitudeMinusBounding' => $lonMinusBounding,
            ':longitudePlusBounding' => $lonPlusBounding,
        );

        try {
            // Execute the query to create the user
            $stmt = $this->db->prepare($sql);
            $stmt->execute($query_params);

            $result = $stmt->fetchAll();

            return $result;
        }

        catch(PDOException $ex) {
            die("Failed to run query: " . $ex->getMessage());
        }
    }

    /**
     * @param $address
     * @return mixed
     */
    public function getLatAndLon($address)
    {
        $client = new GuzzleClient();
        $res = $client->request('GET', 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $address);

        $googleApi = json_decode($res->getBody());

        return $googleApi->results[0]->geometry->location;
    }
}
