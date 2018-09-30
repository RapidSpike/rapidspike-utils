<?php

namespace RapidSpike\Targets;

/**
 * Simple interface for Target types to implement. Basically just ensures
 * that when a target object gets loaded into the TargetGroup class, it has
 * the abilities required of it in the group.
 */
interface TargetInterface
{

    /**
     * Standardised function for getting a target as a string.
     */
    public function getString();
}
