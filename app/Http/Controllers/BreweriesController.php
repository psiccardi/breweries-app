<?php

namespace App\Http\Controllers;

use App\Classes\BreweryApi;
use App\Classes\ErrorHandler;
use App\Classes\PunkApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BreweriesController extends Controller
{
    /**
     * This method makes a request to an external service that
     * expose a paginated list of beers.
     * The route that uses this method is protected by the middleware
     * customSanctumAuthentication, that checks the validity of the Bearer token
     * 'page' and 'limit' parameters are mandatory
     *
     * @param Request $request
     *
     *
     */
    public function get(Request $request)
    {
        $validateData = Validator::make($request->all(), [
            "page" => "required|integer",
            "limit" => "required|integer"
        ]);

        if ($validateData->fails()) {
            return ErrorHandler::handleApiBadRequestError(__METHOD__, $validateData->errors()->first());
        }

        try {
            $breweries = BreweryApi::getBreweries([
                "page" => $request->page,
                "per_page" => $request->limit
            ]);
            if (is_null($breweries)) {
                return response()->json(['error' => __("errors.generic_error")]);
            }
            if (empty($breweries)) {
                return response()->json([]);
            }

            if (!empty($breweries["error"])) {
                $statusCode = $breweries["statusCode"] ?? 500;
                $msg = $breweries["message"] ?? "Internal server error";
                return response()->json(['error' => $msg], $statusCode);
            }

            return response()->json($breweries);
        } catch (\Exception $e) {
            return ErrorHandler::handleApiInternalServerError(__METHOD__, $e);
        }
    }
}
