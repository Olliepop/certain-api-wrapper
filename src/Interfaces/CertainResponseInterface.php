<?php

namespace Wabel\CertainAPI\Interfaces;

/**
 * Interface CertainResponseInterface
 * 
 * @author rbergina
 */
interface CertainResponseInterface
{
    /**
     * @return mixed
     */
    public function isSuccessFul();

    /**
     * @return mixed
     */
    public function getResults();
    
}