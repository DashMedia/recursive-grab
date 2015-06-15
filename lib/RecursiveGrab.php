<?php

class RecursiveGrab{
	private $resource;
	private $modx;
    public function __construct($modx, $scriptProperties)
    {
    	$this->modx = $modx;
        $this->scriptProperties = $scriptProperties;
    	//get target page id
    	$thisId = $modx->resource->get('id');
    	$pageId = $modx->getOption('id',$scriptProperties,$thisId);
    	//get fallback page id
        $fallbackDoc = $modx->getOption('fallbackId',$scriptProperties,null);
    	//grab modDocument instances
    	$this->resource = $modx->getObject('modDocument',$pageId);
    	$this->fallback = $modx->getObject('modDocument',$fallbackDoc);
    }

    private function recursiveGrab($tvName, $resource){
    	//check if we have a non null resource
    	if(!is_null($resource)){
    		$value = $resource->getTVValue($tvName);
    		if(!is_null($value) && $value !== ""){
    			//value found, return
    			return $value;
    		} else {
    			//no value, try parent
    			$parent = $this->modx->getObject('modResource', $resource->parent);
    			return $this->recursiveGrab($tvName, $parent);
    		}
    	}
    	//don't have a valid resource, return blank
    	return "";
    }

    public function get($tvName){
    	$recursiveValue = $this->recursiveGrab($tvName, $this->resource);
    	if(!empty($recursiveValue) && $recursiveValue !== ""){
    		//found a value
    		return $recursiveValue;
    	}

        if(!is_null($this->fallback)){
            //no value, try fallback
            $fallbackTvName = $this->modx->getOption('fallbackTv',$this->scriptProperties, $tvName);
            $fallbackValue = $this->fallback->getTVValue($fallbackTvName);
            if(!empty($fallbackValue)){
                //found a value
                return $fallbackValue;
            }
        }

        //nothing, return blank
        return "";
    }
}