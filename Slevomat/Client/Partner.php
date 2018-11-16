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
 * Partner API Client.
 *
 * Allows a partner to check and apply vouchers.
 */
class Partner
{
    /**
     * Server identifier - slevomat.cz.
     *
     * @var string
     */
    const SERVER_CZ = 'slevomat.cz';

    /**
     * Server identifier - zlavomat.sk.
     *
     * @var string
     */
    const SERVER_SK = 'zlavomat.sk';

    /**
     * API accesspoint URL format.
     *
     * @var string
     */
    protected static $apiUrl = 'https://www.%s/api';

    /**
     * Chosen server.
     *
     * @var string
     */
    private $server;

    /**
     * Partner token.
     *
     * @var string
     */
    private $token;

    /**
     * Creates an instance of the API client.
     *
     * @param mixed $server Chosen server
     * @param mixed $token Partner token
     */
    public function __construct($server, $token)
    {
        $this->checkRequirements();

        if ($server !== self::SERVER_CZ && $server !== self::SERVER_SK) {
            throw new \RuntimeException(sprintf('An invalid server was provided: "%s".',
                $server));
        }

        $this->server = $server;
        $this->token  = $token;
    }

    /**
     * Checks if a voucher is valid.
     *
     * Returns TRUE if the checked voucher exists and can be used, FALSE otherwise.
     *
     * The whole response object will be stored in the second parameter.
     *
     * @param string $code Voucher code
     * @param Slevomat_Client_Response_Abstract $response Response object
     * @return boolean
     */
    public function checkVoucher($code, &$response = null)
    {
        $response = $this->performRequest('vouchercheck',
            array('token' => $this->token, 'code' => $code));

        return $response instanceof Response\Success;
    }

    /**
     * Tries to apply a voucher.
     *
     * Returns TRUE if the voucher was successfully applied, FALSE otherwise.
     *
     * The whole response object will be stored in the second parameter.
     *
     * @param string $code Voucher code
     * @param Slevomat_Client_Response_Abstract $response Response object
     * @return boolean
     */
    public function applyVoucher($code, &$response = null)
    {
        $response = $this->performRequest('voucherapply',
            array('token' => $this->token, 'code' => $code));

        return $response instanceof Response\Success;
    }

    /**
     * Performs the request to the API and returns the result.
     *
     * @param string $action Action name
     * @param array $parameters Additional HTTP parameters
     * @return Slevomat_Client_Response_Abstract
     * @throws \RuntimeException When the request to the API could not be performed
     */
    protected function performRequest($action, array $parameters)
    {
        $request = $this->prepareRequest();

        $requestUrl = $this->prepareRequestUrl($action, $parameters);
        curl_setopt($request, CURLOPT_URL, $requestUrl);

        $responseData = @curl_exec($request);
        if (false === $responseData) {
            throw new \RuntimeException(sprintf('Could not perform a request to "%s": %s.',
                $requestUrl, curl_error($request)));
        }

        return Factory::create($responseData,
                curl_getinfo($request, CURLINFO_HTTP_CODE));
    }

    /**
     * Prepares a cURL resource.
     *
     * @return resource.
     */
    protected function prepareRequest()
    {
        static $request;

        if (!isset($request)) {
            $request = curl_init();

            curl_setopt_array($request,
                array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT => 5,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_MAXREDIRS => 2
            ));

            if (!ini_get('safe_mode') && !ini_get('open_basedir')) {
                curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);
            }
        }

        return $request;
    }

    /**
     * Prepares an API request URL.
     *
     * @param string $action Action name
     * @param array $parameters Additional HTTP parameters
     * @return string
     */
    protected function prepareRequestUrl($action, array $parameters)
    {
        return sprintf(self::$apiUrl, $this->server).'/'.urlencode($action).'?'.http_build_query($parameters);
    }

    /**
     * Checks for requirements.
     *
     * @throws \RuntimeException When a required PHP extension is not present.
     */
    protected function checkRequirements()
    {
        if (version_compare(PHP_VERSION, '5.2', '<')) {
            throw new \RuntimeException('PHP version 5.2 or newer is required.');
        }

        if (!extension_loaded('json')) {
            throw new \RuntimeException('The "json" PHP extension is required.');
        }

        if (!extension_loaded('curl')) {
            throw new \RuntimeException('The "curl" PHP extension is required.');
        }
    }
}
