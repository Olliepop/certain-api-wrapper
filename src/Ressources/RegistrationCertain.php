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
            return $profileCertainResults;
        }
        return null;
    }
    
}