<?php
namespace Wabel\CertainAPI\Ressources;

use Wabel\CertainAPI\Interfaces\CertainRessourceInterface;
use Wabel\CertainAPI\CertainRessourceAbstract;
use Wabel\CertainAPI\Exceptions\RessourceException;
/**
 * ProfileCertain about the Profile entity
 *
 * @author rbergina
 */
class ProfileCertain extends CertainRessourceAbstract implements CertainRessourceInterface
{
    public function getRessourceName(){
        return 'Profile';
    }
    public function getMandatoryFields()
    {
        return array();
    }

    /**
     * Return the Profile object
     * @param string $email
     * @return ProfileObj
     * @throws RessourceException
     */
    public function getProfileByEmail($email)
    {
        $resultCertain =  $this->getProfileCertainReturnByEmail($email);
        if($resultCertain->isSuccessFul()){
            $resultCertainProfile = $resultCertain->getResults();
            if($resultCertainProfile->size == 1){
                return $resultCertainProfile->profiles[0];

            } elseif($resultCertainProfile->size > 1){
                throw new RessourceException('Duplicate entries');
            } else{
                    return $resultCertain;
            }
        } else{
            return null;
        }

    }

    /**
     * Get duplciates cases for a profile by e-mail.
     * @param sting $profilePin
     * @param string $email
     * @return ProfileObject
     */
    public function getDuplicateProfileByEmail($profilePin,$email)
    {
        $resultCertain =  $this->get(null, [
            'email'=> $email
        ]);
        if($resultCertain->isSuccessFul() && $resultCertain->getResults()->size <= 1){
            return null;
        }
        $profilesCertain = $resultCertain->getResults()->profiles;
        $pofileDuplicates = array_map(function($profile) use ($profilePin){
            if($profile->profilePin != $profilePin){
                return $profile;
            }   
        }, $profilesCertain);
        return $pofileDuplicates;

    }

    /**
     * Return with all the result from certain.
     * @param string $email
     * @return ProfileCertain
     */
    public function getProfileCertainReturnByEmail($email)
    {
        return $this->get(null, ['email'=> $email]);
    }


    /**
     * Return with all the result from certain.
     * @return ProfileCertain[]
     */
    public function getProfiles()
    {
        $request=  $this->get();
        if($request->isSuccessFul()){
            $profileCertainResults = $request->getResults();
            return $profileCertainResults->profiles;
        }
        return null;
    }

}