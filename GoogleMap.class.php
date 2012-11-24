<?php

class GoogleMap {

	var $map_id = 'map';
	
	var $api_key = '';

	var $onload = true;

	var $type_controls = true;

	var $map_type = 'ROADMAP';
	
	var $center_lat = 48.690;
	
	var $center_lon = 9.140;
	
	var $scale_control = true;
		
	var $zoom = 5;

	var $width = null;

	var $height = null;	
	
	 var $sidebar_id = 'sidebar';  
	 
	var $sidebar = true;    
	
	var $lookup_service = 'GOOGLE';
	var $lookup_server = array('GOOGLE' => 'maps.google.com');

	
	
	function myGoogleMapApi($map_id = 'map', $app_id = 'rpgmaps01') {
        $this->map_id = $map_id;
        $this->sidebar_id = 'sidebar_' . $map_id;
        $this->app_id = $app_id;
    }
	
	function setAPIKey($key) {
        $this->api_key = $key;   
    }
	
	
	function setWidth($width) {
        if(!preg_match('!^(\d+)(.*)$!',$width,$_match))
            return false;

        $_width = $_match[1];
        $_type = $_match[2];
        if($_type == '%')
            $this->width = $_width . '%';
        else
            $this->width = $_width . 'px';
        
        return true;
    }
	
	function setHeight($height) {
        if(!preg_match('!^(\d+)(.*)$!',$height,$_match))
            return false;

        $_height = $_match[1];
        $_type = $_match[2];
        if($_type == '%')
            $this->height = $_height . '%';
        else
            $this->height = $_height . 'px';
        
        return true;
    }        
	
	function enableTypeControls() {
        $this->type_controls = true;
    }

	function disableTypeControls() {
        $this->type_controls = false;
    }
		
	function setMapType($type) {
        switch($type) {
            case 'hybrid':
                $this->map_type = 'HYBRID';
                break;
			case 'roadmap':
				$this->map_type = 'ROADMAP ';
				break;		
            case 'satellite':
                $this->map_type = 'SATELLITE';
                break;
            case 'terrain':
            default:
                $this->map_type = 'TERRAIN';
                break;
        }       
    }    
	
	function enableOnLoad() {
        $this->onload = true;
    }
	
	function disableOnLoad() {
        $this->onload = false;
    }
	
	
	
	function setLookupService($service) {
        switch($service) {
            case 'GOOGLE':
			default:
                $this->lookup_service = 'GOOGLE';
                break;
        }       
    }
	
	function printHeaderJS() {
        echo $this->getHeaderJS();   
    }
	
	function getHeaderJS() {
		return sprintf('<script src="https://maps.googleapis.com/maps/api/js?key=%s&sensor=true" type="text/javascript" charset="utf-8"></script>', $this->api_key);
	}    
	
	function printSidebar() {
        echo $this->getSidebar();
    }
	
	function getSidebar() {
        return sprintf('<div id="%s"></div>',$this->sidebar_id) . "\n";
    }   
	
	function printOnLoad() {
        echo $this->getOnLoad();
    }
	
	function getOnLoad() {
        return '<script language="javascript" type="text/javascript" charset="utf-8">window.onload=onLoad;</script>';                       
    }
	
	function initializeMapJS(){
		echo $this->getMapJS();
	}
	function getMapJS(){
		
		$_output = '<script type="text/javascript">
						function initialize() {
							var mapOptions = {
							  center: new google.maps.LatLng('.$this->center_lat.', '.$this->center_lon.'),
							  zoom: '.$this->zoom.',
							  mapTypeId: google.maps.MapTypeId.'.$this->map_type.'
							};
							var map = new google.maps.Map(document.getElementById("'.$this->map_id.'"),
								mapOptions);
						}
						</script>';
		
		return $_output;
	
	}
		
	function printMap() {
        echo $this->getMap();
    }
	
	function getMap() {
        $_output = '<div id="'.$this->map_id.'" style="width:100%; height:100%"></div>';
        return $_output;
    }

	
	
}

?>