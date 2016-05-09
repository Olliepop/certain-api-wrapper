<?php
namespace Wabel\CertainAPI\Resources;

use Wabel\CertainAPI\Interfaces\CertainResourceInterface;
use Wabel\CertainAPI\CertainResourceAbstract;
use Wabel\CertainAPI\Exceptions\ResourceException;

/**
 * Class ProfileCertain about the Profile entity
 *
 * @author rbergina
 */
class ProfileCertain extends CertainResourceAbstract implements CertainResourceInterface
{
    /**
     * @return string
     */
    public function getResourceName()
    {
        return 'Profile';
    }

    /**
     * @return array
     */
    public function getMandatoryFields()
    {
        return [];
    }

    /**
     * Return the Profile object
     * @param string $email
     * @return ProfileObj
     * @throws ResourceException
     */
    public function getProfileByEmail($email)
    {
        $resultCertain = $this->getProfileCertainReturnByEmail($email);
        if ($resultCertain->isSuccessFul()) {
            $resultCertainProfile = $resultCertain->getResults();
            if ($resultCertainProfile->size == 1) {
                return $resultCertainProfile->profiles[0];

            } elseif ($resultCertainProfile->size > 1) {
                throw new ResourceException('Duplicate entries');
            } else {
                return $resultCertain;
            }
        } else {
            return null;
        }

    }


    /**
     * Return with all the result from certain.
     * @param string $email
     * @return ProfileCertain
     */
    public function getProfileCertainReturnByEmail($email)
    {
        return $this->get(null, ['email' => $email]);
    }


    /**
     * Return with all the result from certain.
     * @return ProfileCertain[]
     */
    public function getProfiles($params = [])
    {
        $request = $this->get(null, $params);
        if ($request->isSuccessFul()) {
            $profileCertainResults = $request->getResults();
            return $profileCertainResults->profiles;
        }
        return null;
    }

}