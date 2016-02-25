<?php
namespace Wabel\CertainAPI\Ressources;

use Wabel\CertainAPI\Interfaces\CertainRessourceInterface;
use Wabel\CertainAPI\CertainRessourceAbstract;

/**
 * AppointementsPreferencesCertain about the Preferences entity
 *
 * @author rbergina
 */
class AppointementsPreferencesCertain extends CertainRessourceAbstract implements CertainRessourceInterface
{
    public function getRessourceName(){
        return 'AppointementsPreferences';
    }

    public function getMandatoryFields()
    {
        return array('attendeeTypeCode','regCode','rank','blacklist');
    }

    public function setRessourceCalled($eventCode,$regCode){
        return $this->createRessourceCalled([
            'events' => $eventCode,
            'registration' => $regCode,
            'preferences' => ''
        ]);
        
    }
}