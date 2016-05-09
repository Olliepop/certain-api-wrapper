<?php
namespace Wabel\CertainAPI\Resources;

use Wabel\CertainAPI\Interfaces\CertainResourceInterface;
use Wabel\CertainAPI\CertainResourceAbstract;

/**
 * Class AppointmentsPreferencesCertain about the Preferences entity
 *
 * @author rbergina
 */
class AppointmentsPreferencesCertain extends CertainResourceAbstract implements CertainResourceInterface
{
    /**
     * @return string
     */
    public function getResourceName()
    {
        return 'AppointmentsPreferences';
    }

    /**
     * @return array
     */
    public function getMandatoryFields()
    {
        return ['attendeeTypeCode', 'regCode', 'rank', 'blacklist'];
    }

    /**
     * @param $eventCode
     * @param $regCode
     * @return $this
     */
    public function setResourceCalled($eventCode, $regCode)
    {
        return $this->createResourceCalled([
            'events' => $eventCode,
            'registration' => $regCode,
            'preferences' => ''
        ]);

    }
}