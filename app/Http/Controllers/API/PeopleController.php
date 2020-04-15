<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\SWAPI;
use App\People;

class PeopleController extends Controller
{
    protected $swapi;

    public function __construct()
    {
        $this->swapi = new SWAPI();
    }

    public function all()
    {
        return People::all();
    }

    public function getByName(string $name){
        return People::where('name', $name)->first();
    }

    public function refresh()
    {
        $page = 1;

        try{
            $apiPeoples = $this->swapi->getCharacters($page);
            dd($apiPeoples);
        }catch(Exception $e){
            return $e->getMessage();
        }






//        $flight = App\Flight::updateOrCreate(
//            ['departure' => 'Oakland', 'destination' => 'San Diego'],
//            ['price' => 99, 'discounted' => 1]
//        );

        return 'refresh';
    }
}
