<?php

namespace Wabel\CertainAPI\Resources;

use Wabel\CertainAPI\Interfaces\CertainResourceInterface;
use Wabel\CertainAPI\CertainResourceAbstract;

/**
 * Class EventCertain about the Event entity
 *
 * @author rbergina
 */
class EventCertain extends CertainResourceAbstract implements CertainResourceInterface
{

    /**
     * @return string
     */
    public function getResourceName()
    {
        return 'Event';
    }

    /**
     * @return array
     */
    public function getMandatoryFields()
    {
        return ["eventCode", "accountCode", "eventName",
            "eventStatus", "notes", "startDate",
            "endDate", "timezone"];
    }
}