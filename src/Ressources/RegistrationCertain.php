<?php
namespace Wabel\CertainAPI\Ressources;

use Wabel\CertainAPI\Interfaces\CertainRessourceInterface;
use Wabel\CertainAPI\CertainRessourceAbstract;

/**
 * RegistrationCertain about the Registration entity
 *
 * @author rbergina
 */
class RegistrationCertain extends CertainRessourceAbstract implements CertainRessourceInterface
{
    public function getRessourceName(){
        return 'Registration';
    }
    public function getMandatoryFields()
    {
        return array('profile');
    }

    /**
     * Return with all the result from certain.
     * @return RegistrationCertain[]
     */
    public function getRegistrations()
    {
        $request=  $this->get();
        if($request->isSuccessFul()){
            $registrationCertainResults = $request->getResults();
            return $registrationCertainResults->registrations;
        }
        return null;
    }
    
    /**
     * Return with all the result from certain.
     * @return RegistrationCertain[]
     */
    public function getRegistrationsByEventCode($eventCode)
    {
        $request=  $this->get($eventCode);
        if($request->isSuccessFul()){
            $registrationCertainResults = $request->getResults();
            return $registrationCertainResults->registrations;
        }
        return null;
    }
    
    
}