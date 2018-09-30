<?php

namespace RapidSpike\Targets;

/**
 * An object for holding a set of Target object which must implement the
 * TargetInterface interface. This neatly wraps a set of targets and provides
 * standardised functionality to get information about them.
 */
class TargetGroup
{

    /**
     * An array of Target objects
     * @var array
     */
    private $Targets = array();

    /**
     * A count of targets
     * @var int
     */
    private $target_count = 0;
    protected $urlResponse = null;

    /**
     * Sets a target to the class which must use the TargetInterface
     *
     * @param \RapidSpike\MonitorModules\Common\Targets\TargetInterface $Target
     */
    public function setTarget(TargetInterface $Target)
    {
        $this->target_count++;
        $this->Targets[] = $Target;
    }

    /**
     * Return the number of targets
     *
     * @return int
     */
    public function count()
    {
        return (int) $this->target_count;
    }

    /**
     * Returns an array of just the targets
     *
     * @return array
     */
    public function toArray()
    {
        $list = array();

        foreach ($this->Targets as $Target) {
            // getString() is a requirement of the TargetInterface interface
            // so we can reliably assume it is available on the Target object
            if ($this->urlResponse === 'fullUrl') {
                $list[] = $Target->getUrl();
            } else {
                $list[] = $Target->getString();
            }
        }

        return $list;
    }

    /**
     * Uses toArray() to convert the targets into a string
     *
     * @param string $glue
     *
     * @return array
     */
    public function toString($glue = ',')
    {
        return implode($glue, $this->toArray());
    }

    public function setUrlResponse($urlResponse = null)
    {
        $this->urlResponse = $urlResponse;
    }

}
