<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\SWAPI;
use App\Character;
use Validator;
use Request;

class CharactersController extends Controller
{
    const MAX_CHARACTERS = 100;
    protected $api;

    public function __construct()
    {
        $this->api = new SWAPI();
    }

    public function all()
    {
        return Character::all();
    }

    public function get(Request $request, string $name)
    {
        $character = Character::where('name', $name)->first();

        if($character){
            return $character;
        }

        abort(404);
    }

    public function refresh()
    {
        $page = 1;

        while(Character::All()->count() <= self::MAX_CHARACTERS){
            try {
                $apiCharacters = $this->api->getCharacters($page);
                $this->addOrUpdateCharacters($apiCharacters);
                $page++;
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }


        return 'refreshed';
    }

    private function addOrUpdateCharacters($characters)
    {
        $updated = [];
        foreach ($characters as $character) {
            $entry = $this->addOrUpdateCharacter($character);
            if($entry){
                $updated[] = $entry;
            }
        }

        return $updated;
    }

    private function addOrUpdateCharacter($character)
    {
        $entry = [
            'name' => $character->name,
            'gender' => $character->gender,
            'culture' => $character->culture,
            'born' => $character->born,
            'died' => $character->died,
        ];

        $validation = Validator::make(
            $entry,
            [
                'name' => ['required'],
                'gender' => ['required'],
            ]
        );

        if (!$validation->fails() ) {
            return Character::updateOrCreate($entry);
        }

        return false;
    }
}
