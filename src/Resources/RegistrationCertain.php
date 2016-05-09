<?php
namespace Wabel\CertainAPI\Resources;

use Wabel\CertainAPI\Interfaces\CertainResourceInterface;
use Wabel\CertainAPI\CertainResourceAbstract;

/**
 * RegistrationCertain about the Registration entity
 *
 * @author rbergina
 */
class RegistrationCertain extends CertainResourceAbstract implements CertainResourceInterface
{
    /**
     * @return string
     */
    public function getResourceName()
    {
        return 'Registration';
    }

    /**
     * @return array
     */
    public function getMandatoryFields()
    {
        return ['profile'];
    }

    /**
     * Return with all the result from certain.
     * @return RegistrationCertain[]
     */
    public function getRegistrations($params = [])
    {
        $request = $this->get(null, $params);
        if ($request->isSuccessFul()) {
            $registrationCertainResults = $request->getResults();
            return $registrationCertainResults->registrations;
        }
        return null;
    }

    /**
     * Return with all the result from certain.
     * @return RegistrationCertain[]
     */
    public function getRegistrationsByEventCode($eventCode, $params = [])
    {
        $request = $this->get($eventCode, $params);
        if ($request->isSuccessFul()) {
            $registrationCertainResults = $request->getResults();
            return $registrationCertainResults->registrations;
        }
        return null;
    }

    /**
     * Return with all the result from certain.
     * @param string $eventCode eventCode
     * @param string $email email
     * @param boolean $returnRegCode To say if we want return a boolean or the regCode
     * @param string $orderBySecure in order to get the first registration when we have duplciates
     * @return registrationCode|null|boolean|[registrationCode=> "",attendeeTypeCode=>""]
     */
    public function hasRegistrationsByEventCodeAndEmail($eventCode, $email, $returnRegCode = true, $withAttenteeType = true, $orderBySecure = 'dateModified_asc')
    {
        $request = $this->get($eventCode, [
            'email' => $email,
            'orderBy' => $orderBySecure

        ]);
        if ($request->isSuccessFul()) {
            $registrationCertainResults = $request->getResults();
            if ($registrationCertainResults->size > 0 && $returnRegCode && $withAttenteeType) {
                return [
                    'registrationCode' => $registrationCertainResults->registrations[0]->registrationCode,
                    'attendeeTypeCode' => (isset($registrationCertainResults->registrations[0]->attendeeTypeCode)) ? $registrationCertainResults->registrations[0]->attendeeTypeCode : '',
                ];
            } elseif ($registrationCertainResults->size > 0 && $returnRegCode) {
                return $registrationCertainResults->registrations[0]->registrationCode;
            } elseif ($registrationCertainResults->size > 0 && !$returnRegCode) {
                return true;
            }
        } elseif ($request->isNotFound()) {
            return false;
        }
        return null;
    }

    /**
     * Return with the result from certain.
     * @param string $eventCode
     * @param string $regCode
     * @return RegistrationObj
     */
    public function getRegistrationByEventCodeAnRegCode($eventCode, $regCode)
    {
        $request = $this->get($eventCode . '/' . $regCode);
        if ($request->isSuccessFul()) {
            $registrationCertainResult = $request->getResults();
            return $registrationCertainResult;
        }
        return null;
    }

    /**
     * Update with the result from certain.
     * @param string $eventCode
     * @param string $regCode
     * @return RegistrationObj
     */
    public function updateRegistrationByEventCodeAnRegCode($eventCode, $regCode, $data = [])
    {
        $request = $this->post($data, [], $eventCode . '/' . $regCode);
        if ($request->isSuccessFul()) {
            $registrationCertainResult = $request->getResults();
            return $registrationCertainResult;
        }
        return null;
    }

//    public function substituteRegistration($eventCode,$regCode,$profilePin){
//        return $this->updateRegistrationByEventCodeAnRegCode($eventCode, $regCode, [
//            'profile' => [
//                'pin'=> $profilePin
//            ]
//        ]);
//    }
}