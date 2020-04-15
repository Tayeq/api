<?php

namespace App\Services;

use GuzzleHttp\Client;

class SWAPI
{
    protected $url;
    protected $client;
    protected $headers;

    /**
     * SWAPI constructor.
     */
    public function __construct()
    {
        $this->url = 'https://anapioficeandfire.com/api/';
        $this->headers = [
            'content-type' => 'application/json',
        ];
        $this->client = new Client(['base_uri' => $this->url]);
    }

    /**
     * @param string|null $uri
     * @param array $query
     * @return object|null
     */
    private function getResponse(string $uri = null, array $query = [])
    {
        $request = $this->client->request('GET', $uri, ['query' => $query]);

        if ($request->getStatusCode() === 200) {
            $response = $request->getBody();
            return (object)json_decode($response);
        }

        return null;
    }

    /**
     * /people?page=$page
     * @param int $page
     * @return object|null
     */
    public function getCharacters(int $page = 1)
    {
        $query = [];
        $query['page'] = $page;
        return $this->getResponse('characters', $query);
    }
}
