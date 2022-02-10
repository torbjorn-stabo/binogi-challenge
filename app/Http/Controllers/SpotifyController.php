<?php

namespace App\Http\Controllers;

use ErrorException;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Cache;
use stdClass;

class SpotifyController extends Controller
{
    /**
     * {
     *   "access_token": "BQDHetacdjm8scav81PcW4aadoo6NfNO4-zOOO-dswmn5FbLTfj3_mOpo1c6ONfzvH-6ANKZlG7AiIsU4J8"
     *   "token_type": "Bearer"
     *   "expires_in": 3600
     * }
     *
     * @var stdClass
     */
    protected object $token;

    /**
     * Undocumented variable
     *
     * @var GuzzleHttp\ClientInterface
     */
    protected $client;

    public function __construct(ClientInterface $client) {
        $this->client = $client;
    }
    /**
     * Fetch API credentials used for subsequent requests during session
     * Note: This method is called from within this controller to keep the flow outside general. Not all search engines might require API tokens :)
     *
     * @return self
     */
    public function getApiToken() : self {
        if (!empty($this->token)) {
            return $this;
        }
        if (Cache::has('spotifyApiToken')) {
            $this->token = Cache::get('spotifyApiToken');
        }

        $response = $this->client->post(
            'https://accounts.spotify.com/api/token',
            [
                RequestOptions::HEADERS => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Authorization' => 'Basic '.base64_encode(env('SPOTIFY_CLIENT_ID').':'.env('SPOTIFY_CLIENT_SECRET'))
                ],
                RequestOptions::FORM_PARAMS => ['grant_type' => 'client_credentials']
            ]
        );

        $token = json_decode($response->getBody()->getContents());
        if ($token === null) {
            throw new ErrorException('There was an error fetching API credentials');
        }

        Cache::remember('spotifyApiToken', now()->addSeconds($token->expires_in), function() use ($token) {
            return $token;
        });
        $this->token = $token;

        return $this;
    }

    /**
     * Fetch search hits from Spotify API
     *
     * @param string $query
     * @return stdClass
     */
    public function search(string $query) : stdClass {
        $this->getApiToken();

        $response = $this->client->get(
            'https://api.spotify.com/v1/search',
            [
                RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.$this->token->access_token
                ],
                RequestOptions::QUERY => [
                    'type' => 'album,artist,track',
                    'q' => $query
                ]
            ]
        );

        $search_results = json_decode($response->getBody()->getContents());
        if ($search_results === null) {
            throw new ErrorException('There was an error fetching search results');
        }

        return $search_results;
    }
}
