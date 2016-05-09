<?php

namespace Wabel\CertainAPI\Interfaces;

/**
 * Interface CertainResourceInterface
 *
 * @author rbergina
 */
interface CertainResourceInterface
{
    /**
     * @return mixed
     */
    public function getResourceName();

    /**
     * @return mixed
     */
    public function getMandatoryFields();
}