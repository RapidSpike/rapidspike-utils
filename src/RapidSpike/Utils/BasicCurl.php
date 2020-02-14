<?php

namespace RapidSpike\Utils;

use RapidSpike\Targets\Url;

/**
 * Some basic cURL-based functionality for the \Spiders\Website\PageScanner
 * and \Spiders\Website\Validator classes. Used to store common cURL code
 * including
 */
class BasicCurl
{

    const BLOCKED_OPTIONS = [CURLOPT_SSL_VERIFYPEER, CURLOPT_RETURNTRANSFER, CURLOPT_USERAGENT];

    /**
     * The URL object for the website we're interacting with
     * @var RapidSpike\MonitorModules\Common\Targets\Url
     */
    private $Url;

    /**
     * cURL handler object
     * @var cURL resource handle
     */
    private $CurlHandler;

    /**
     * The website's HTML
     * @var string
     */
    private $html = null;

    /**
     * An array of info returned by cURL
     * @var array
     */
    private $arrCurlInfo = array();

    /**
     * Stores cURL's error number if there was a problem
     * @var mixed
     */
    private $err_num = false;

    /**
     * Array of  options to use
     * @var array
     */
    private $arrCurlOptions = array();

    /**
     * Array of  error codes mapped to user-friendly messages
     * @var array
     */
    private $arrCurlErrCodes = array(
        1 => 'unsupported protocol', // CURLE_UNSUPPORTED_PROTOCOL
        2 => 'initialisation failed', // CURLE_FAILED_INIT
        3 => 'bad URL format', // CURLE_URL_MALFORMAT
        4 => 'bad URL user format', // CURLE_URL_MALFORMAT_USER
        5 => 'couldn\'t resolve proxy', // CURLE_COULDNT_RESOLVE_PROXY
        6 => 'couldn\'t resolve host', // CURLE_COULDNT_RESOLVE_HOST
        7 => 'couldn\'t connect to host', // CURLE_COULDNT_CONNECT
        9 => 'remote access denied', // CURLE_REMOTE_ACCESS_DENIED
        22 => 'HTTP returned errors', // CURLE_HTTP_RETURNED_ERROR
        26 => 'read error', // CURLE_READ_ERROR
        27 => 'out of memory', // CURLE_OUT_OF_MEMORY
        28 => 'operation timed out', // CURLE_OPERATION_TIMEDOUT
        35 => 'SSL connect error', // CURLE_SSL_CONNECT_ERROR
        36 => 'bad download', // CURLE_BAD_DOWNLOAD_RESUME
        37 => 'file couldn\'t read file', // CURLE_FILE_COULDNT_READ_FILE
        41 => 'function not found', // CURLE_FUNCTION_NOT_FOUND
        42 => 'aborted by callback', // CURLE_ABORTED_BY_CALLBACK
        43 => 'bad function argument', // CURLE_BAD_FUNCTION_ARGUMENT
        45 => 'interface failed', // CURLE_INTERFACE_FAILED
        47 => 'too many redirects', // CURLE_TOO_MANY_REDIRECTS
        51 => 'peer failed verification', // CURLE_PEER_FAILED_VERIFICATION
        52 => 'nothing returned', // CURLE_GOT_NOTHING
        53 => 'SSL engine not found', // CURLE_SSL_ENGINE_NOTFOUND
        54 => 'SSL engine set failed', // CURLE_SSL_ENGINE_SETFAILED
        55 => 'send error', // CURLE_SEND_ERROR
        58 => 'SSL certification problem', // CURLE_SSL_CERTPROBLEM
        59 => 'SSL cipher problem', // CURLE_SSL_CIPHER
        60 => 'SSL CA certification problem', // CURLE_SSL_CACERT
        61 => 'bad content encoding', // CURLE_BAD_CONTENT_ENCODING
        63 => 'filesize exceeded', // CURLE_FILESIZE_EXCEEDED
        64 => 'SSL failed', // CURLE_USE_SSL_FAILED
        65 => 'send fail', // CURLE_SEND_FAIL_REWIND
        66 => 'SSL engine initialisation failed', // CURLE_SSL_ENGINE_INITFAILED
        73 => 'remote file exists', // CURLE_REMOTE_FILE_EXISTS
        77 => 'bad SSL CA certification file', // CURLE_SSL_CACERT_BADFILE
        78 => 'remote file not found', // CURLE_REMOTE_FILE_NOT_FOUND
        80 => 'SSL shutdown failed', // CURLE_SSL_SHUTDOWN_FAILED
        82 => 'bad SSL CRL file', // CURLE_SSL_CRL_BADFILE
        83 => 'SSL issuer error', // CURLE_SSL_ISSUER_ERROR
        88 => 'chunk failed', // CURLE_CHUNK_FAILED
    );

    /**
     * Sets up the basic cURL options and allows you to instantiate the
     * class with options too. Also sets the URL object to the class.
     *
     * @param \RapidSpike\MonitorModules\Common\Targets\Url $Url
     */
    public function __construct(Url $Url)
    {
        $this->Url = $Url;

        // Set defaults
        $this->arrCurlOptions = array(
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_HEADER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_USERAGENT => 'RapidSpike Uptime Monitor Bot v0.1.0 - http://www.rapidspike.com/',
            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
            CURLOPT_COOKIEJAR => tempnam(sys_get_temp_dir(), "/cookie_{$Url->getHost()}.txt")
        );
    }

    /**
     * Setup and make the cUrl request.
     */
    public function makeRequest()
    {
        $this->CurlHandler = curl_init();
        curl_setopt($this->CurlHandler, CURLOPT_URL, $this->Url->getUrl());
        curl_setopt_array($this->CurlHandler, $this->arrCurlOptions);

        $this->html = curl_exec($this->CurlHandler);
        $this->arrCurlInfo = curl_getinfo($this->CurlHandler);
        $this->err_num = curl_errno($this->CurlHandler);
    }

    /**
     * Sets a cURL option (or multiple).
     *
     * @param array $arrOptions
     */
    public function setOption(array $arrOptions)
    {
        foreach ($arrOptions as $key => $val) {
            if (isset($this->arrCurlOptions[$key]) && !in_array($key, self::BLOCKED_OPTIONS)) {
                $this->arrCurlOptions[$key] = $val;
            }
        }
    }

    /**
     * Gets the response HTML.
     *
     * @return string
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * Returns the error number if there was one, false if there wasn't
     *
     * @return mixed
     */
    public function getErrNum()
    {
        return !empty($this->err_num) ? $this->err_num : false;
    }

    /**
     * Build and return an error message based on error number
     *
     * @return string
     */
    public function getErrMsg()
    {
        $message = 'We encountered an error when validating the submitted website domain';
        $message .= (isset($this->arrCurlErrCodes[$this->err_num])) ? " ({$this->arrCurlErrCodes[$this->err_num]})" : '';
        error_log("The domain was {$this->arrCurlInfo['url']}");
        return $message;
    }

    /**
     * Gets a piece of the  info array
     *
     * @param mixed $requested_info
     *
     * @return mixed
     *
     * @throws \APIException\InternalServerError
     */
    public function getCurlInfo($requested_info = false)
    {
        if ($requested_info !== false && !isset($this->arrCurlInfo[$requested_info])) {
            throw new \APIException\InternalServerError('Uh oh, a problem has occurred! Please contact support@rapidspike.com', 'BC-GCI-0001');
        } else {
            return $this->arrCurlInfo;
        }

        return $this->arrCurlInfo;
    }

}
