<?php
/**
 * Slevomat.cz/Zľavomat.sk Partner API Client.
 *
 * @copyright Copyright (c) 2012 Slevomat.cz, s.r.o.
 * @version 1.0.1
 * @apiVersion 1.0.1
 * @link http://www.slevomat.cz/pro-partnery/voucher-api
 * @link http://www.zlavomat.sk/pre-partnerov/voucher-api
 */

namespace Slevomat\Client;

/**
 * Response object factory.
 *
 * Creates an appropriate (success, failure) response object from the response string.
 */
class Factory
{

    /**
     * Creates an API response object from the raw response data.
     *
     * @param string $responseData Response data
     * @param integer $httpCode Response HTTP status code
     * @return Slevomat_Client_Response_Abstract
     * @throws \RuntimeException If the reponse data could not be parsed as a JSON definition
     * @throws \RuntimeException If the reponse data have an invalid structure
     */
    public static function create($responseData, $httpCode)
    {
        $parsedResponse = json_decode($responseData, true);
        if (null === $parsedResponse) {
            throw new \RuntimeException(sprintf('Could not parse the JSON response from the API "%s".',
                $responseData),
            function_exists('json_last_error') ? json_last_error() : 0);
        }

        if (!isset($parsedResponse['result'], $parsedResponse['data'],
                $parsedResponse['error']) || !is_bool($parsedResponse['result'])) {
            throw new \RuntimeException('The response has an invalid structure.');
        }

        if ($parsedResponse['result']) {
            if (!is_array($parsedResponse['data'])) {
                throw new \RuntimeException('The response has an invalid structure. The "data" part has to be an array.');
            }
        } else {
            if (!isset($parsedResponse['error']['code'],
                    $parsedResponse['error']['message'])) {
                throw new \RuntimeException('The response has an invalid structure. The returned error has to have both the code and the message.');
            }
        }

        return $parsedResponse['result'] ? new Response\Success($parsedResponse,
            $httpCode) : new Response\Failure($parsedResponse, $httpCode);
    }
}
