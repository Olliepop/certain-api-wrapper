<?php
namespace Wabel\CertainAPI\Ressources;

use Wabel\CertainAPI\Interfaces\CertainRessourceInterface;
use Wabel\CertainAPI\CertainRessourceAbstract;

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
}