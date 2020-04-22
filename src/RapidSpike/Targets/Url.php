<?php

namespace RapidSpike\Targets;

use RapidSpike\Targets\TargetInterface,
    RapidSpike\Utils\BasicCurl;

/**
 * This class is designed to validate URLs and give access to each part of them
 * in a uniform way. It also enables us to write functions to alter parts of a
 * URL in which ever way we wish and enables us to type-hint in functions that
 * require a valid URL.
 *
 * @author James Tyler <james.tyler@rapidspike.com>
 */
class Url implements TargetInterface
{

    /**
     * The full URL (validated, parsed and rebuilt)
     * @var string
     */
    private $url;

    /**
     * The URL's parsed parts
     * @var array
     */
    private $arrUrl = array();

    /**
     * Validates a supplied URL, parses it and rebuilds it
     *
     * @param string $url
     * @param bool $filter_validate
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($url, bool $filter_validate = true)
    {
        // Validate URL
        if ($filter_validate === true && filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new \InvalidArgumentException('Invalid URL supplied in ' . __CLASS__);
        }

        // Parse the URL into parts
        $this->arrUrl = parse_url($url);

        // Rebuild from the parts
        $this->_rebuildUrl();
    }

    /**
     * Validate the supplied URL actually exists (this isn't a requirement
     * of the class so its just an optional method to call on the object
     *
     * @return \RapidSpike\MonitorModules\Common\Targets\Url
     *
     * @throws \Exception
     */
    public function validate()
    {
        try {
            $BasicCurl = new BasicCurl($this);
            $BasicCurl->setOption([
                CURLOPT_TIMEOUT => 30,
                CURLOPT_CONNECTTIMEOUT => 30,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS => 5
            ]);

            $BasicCurl->makeRequest();

            // Handle errors if there were any
            if ($BasicCurl->getErrNum() !== false) {
                throw new \Exception($BasicCurl->getErrMsg());
            }

            return $this;
        } catch (\Exception $e) {
            error_log($e->getMessage());
        }
    }

    /**
     * A method to overright the scheme
     *
     * @param string $new_scheme
     */
    public function overrideScheme($new_scheme)
    {
        if ($new_scheme !== $this->arrUrl['scheme']) {
            $this->arrUrl['original_scheme'] = $this->arrUrl['scheme'];
            $this->arrUrl['scheme'] = $new_scheme;

            $this->_rebuildUrl();
        }
    }

    /**
     * Returns a boolean value for if the
     * URL is secure (https) or not (http)
     *
     * @return boolean
     */
    public function isSecure()
    {
        return strtolower($this->getScheme()) === 'https' ? true : false;
    }

    /**
     * Required by the interface - this method
     * standardises getting the URL as a string
     *
     * @return string
     */
    public function getString()
    {
        return $this->getHost();
    }

    /**
     * Return the full URL
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Return just the scheme and host as the domain
     *
     * @return string
     */
    public function getDomain()
    {
        $scheme = !empty($this->arrUrl['scheme']) ? $this->arrUrl['scheme'] . '://' : '';
        $host = !empty($this->arrUrl['host']) ? $this->arrUrl['host'] : '';

        return "{$scheme}{$host}";
    }

    /**
     * Return the scheme
     *
     * @return string
     */
    public function getScheme()
    {
        return isset($this->arrUrl['scheme']) ? $this->arrUrl['scheme'] : null;
    }

    /**
     * Return the host
     *
     * @return string
     */
    public function getHost()
    {
        return isset($this->arrUrl['host']) ? $this->arrUrl['host'] : null;
    }

    /**
     * Return the port
     *
     * @return string
     */
    public function getPort()
    {
        return isset($this->arrUrl['port']) ? $this->arrUrl['port'] : null;
    }

    /**
     * Return the user
     *
     * @return string
     */
    public function getUser()
    {
        return isset($this->arrUrl['user']) ? $this->arrUrl['user'] : null;
    }

    /**
     * Return the pass
     *
     * @return string
     */
    public function getPass()
    {
        return isset($this->arrUrl['pass']) ? $this->arrUrl['pass'] : null;
    }

    /**
     * Return the path
     *
     * @return string
     */
    public function getPath()
    {
        return isset($this->arrUrl['path']) ? $this->arrUrl['path'] : null;
    }

    /**
     * Return the query string
     *
     * @return string
     */
    public function getQuery()
    {
        return isset($this->arrUrl['query']) ? $this->arrUrl['query'] : null;
    }

    /**
     * Return the fragment
     *
     * @return string
     */
    public function getFragment()
    {
        return isset($this->arrUrl['fragment']) ? $this->arrUrl['fragment'] : null;
    }

    /**
     * Rebuild the full URL using the parts from 'parse_url()'
     */
    private function _rebuildUrl()
    {
        $scheme = !empty($this->arrUrl['scheme']) ? $this->arrUrl['scheme'] . '://' : '';
        $host = !empty($this->arrUrl['host']) ? $this->arrUrl['host'] : '';
        $port = !empty($this->arrUrl['port']) ? ':' . $this->arrUrl['port'] : '';
        $user = !empty($this->arrUrl['user']) ? $this->arrUrl['user'] : '';
        $_pass = !empty($this->arrUrl['pass']) ? ':' . $this->arrUrl['pass'] : '';
        $pass = $user || $_pass ? "$_pass" : '';
        $path = !empty($this->arrUrl['path']) ? $this->arrUrl['path'] : '';
        $query = !empty($this->arrUrl['query']) ? '?' . $this->arrUrl['query'] : '';
        $fragment = !empty($this->arrUrl['fragment']) ? '#' . $this->arrUrl['fragment'] : '';

        $this->url = "{$scheme}{$user}{$pass}{$host}{$port}{$path}{$query}{$fragment}";
    }

}
