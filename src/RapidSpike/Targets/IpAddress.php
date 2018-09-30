<?php

namespace RapidSpike\Targets;

use RapidSpike\Targets\TargetInterface;

/**
 * The purpose of this class is to enable us to easily validate an IP address
 * and use type-hinting to require functions to be passed valid IP addresses.
 *
 * @author James Tyler <james.tyler@rapidspike.com>
 */
class IpAddress implements TargetInterface
{

    const IPV4 = 'ipv4';
    const IPV6 = 'ipv6';

    /**
     * The IP address
     * @var string
     */
    private $ip_address;

    /**
     * The IP address's type (ipv4/6)
     * @var string
     */
    private $type;

    /**
     * Validates a supplied IP address and figures out its type
     *
     * @param string $ip_address
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($ip_address)
    {
        if (filter_var($ip_address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false) {
            $this->type = self::IPV4;
        } else if (filter_var($ip_address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false) {
            $this->type = self::IPV6;
        } else {
            throw new \InvalidArgumentException('Supplied IP address is invalid');
        }

        $this->ip_address = $ip_address;
    }

    /**
     * Required by the interface - this method
     * standardises getting the IP Address
     *
     * @return string
     */
    public function getString()
    {
        return $this->getIpAddress();
    }

    /**
     * Returns the IP address
     *
     * @return string
     */
    public function getIpAddress()
    {
        return $this->ip_address;
    }

    /**
     * Returns the IP address type (ipv4/6)
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

}
