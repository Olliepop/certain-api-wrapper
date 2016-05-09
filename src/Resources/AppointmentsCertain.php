<?php
namespace Wabel\CertainAPI\Resources;

use Wabel\CertainAPI\Interfaces\CertainResourceInterface;
use Wabel\CertainAPI\CertainResourceAbstract;

/**
 * Class AppointmentsCertain about the Appointments entity
 *
 * @author rbergina
 */
class AppointmentsCertain extends CertainResourceAbstract implements CertainResourceInterface
{
    /**
     * @return string
     */
    public function getResourceName()
    {
        return 'Appointments';
    }

    /**
     * @return array
     */
    public function getMandatoryFields()
    {
        return [];
    }
}