<?php

namespace StringsInfrastructure;

abstract class InfrastructureDriver {

    public function __construct($connectionParameters){

        $this->parseConnectionParameters($connectionParameters);
        $this->connection = $this->getProviderConnection();
    }
    
    abstract protected function parseConnectionParameters($params);
    abstract protected function getProviderConnection();
    
    abstract public function createServer($name,$flavor,$image,$network=false,$wait=false,$waitTimeout=600);
    abstract public function resizeServer($serverID,$flavor,$wait=false,$waitTimeout=600);
    abstract public function confirmResizeServer($serverID,$wait=false,$waitTimeout=600);
    abstract public function revertResizeServer($serverID,$wait=false,$waitTimeout=600);

    abstract public function rebuildServer($serverID,$flavor,$image,$wait=false,$waitTimeout=600);
    abstract public function deleteServer($serverID,$wait=false,$waitTimeout=600);
    abstract public function rebootServer($serverID,$wait=false,$waitTimeout=300);

    abstract public function getServerStatus($serverID);

    abstract public function getServerFlavor($serverID);

    abstract public function getServerPublicIPv4Address($serverID);
    abstract public function getServerPrivateIPv4Address($serverID);

    abstract public function getServerPublicIPv6Address($serverID);
    abstract public function getServerPrivateIPv6Address($serverID);

    abstract public function getServerIPs($serverID);

    abstract public function getServers($filter=array());

    abstract public function getImages();
    abstract public function getFlavors(); 

    abstract public function getImageSchedule($serverID);
    abstract public function createImageSchedule($serverID,$retention);
    abstract public function updateImageSchedule($serverID,$retention);
    abstract public function deleteImageSchedule($serverID);

    public static function validDataStructure($validDataStruc,$compDataStruc){

        if($diff = array_diff_key($validDataStruc,$compDataStruc))
            return false;

        foreach($validDataStruc as $index => $item){
            if(is_array($item) && !self::validDataStructure($item,$compDataStruc[$index]))
                return false;
        }

        return true;
    }
}
