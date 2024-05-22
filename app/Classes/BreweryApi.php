<?php

namespace App\Classes;

use Illuminate\Support\Facades\Http;

class BreweryApi 
{
    /**
     * Brewery API base url
     */
    const BASE_URL='https://api.openbrewerydb.org/';
    /**
     * Brewery API version
     */
    const VERSION='v1';

    /**
     * Method that retrieves API base url
     *
     * @return string
     */
    protected static function getBaseUrl(): string
    {
        return self::BASE_URL . self::VERSION;
    }

    /**
     * Get breweries API
     *
     * @param array the associative array of the request.
     *              Should contain the keys 'page' and 'per_page' to work.
     *
     * @return array|null
     */
    public static function getBreweries(array $params = []): array|null
    {
        try {
            $response = Http::get(self::getBaseUrl() . "/breweries", $params);
            return json_decode($response->body(), true);
        } catch (\Exception $e) {
            ErrorHandler::logError(__METHOD__, $e);
            return null;
        }
    }
}