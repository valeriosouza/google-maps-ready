<?php
class gmapViewGmp extends viewGmp {
    public static $gmapApiUrl = "https://maps.googleapis.com/maps/api/js?&sensor=false&language=";
    public static $_mapsData;
    
    public function getAllMaps(){
    }
    public function showAllMaps($data,$fromAjax=false){
        $this->assign('mapsArr',$data);  
        $this->assign('fromAjax',$fromAjax);  
        frameGmp::_()->addStyle('gmapCss',$this->getModule()->getModPath().'css/map.css');
		$maps = $this->getModel()->getAllMaps(true);
		frameGmp::_()->addJSVar("mapOptions", "GmpExistsMapsArr", $maps);
		$currentTab = reqGmp::getVar("tab");
		if($currentTab ==NULL){
			if(!empty($data)){
				$currentTab="gmpAllMaps";
			}else{
				$currentTab="gmpAddNewMap";
			}
		}
		$this->assign("currentTab",$currentTab);		
        return parent::getContent('allMapsContent');
   }
   public function addMapData($params){
        if(empty(self::$_mapsData)){
            self::$_mapsData = array();
        }
        self::$_mapsData[] =$params;
   }
   public function drawMap($params){
            $mapObj = frameGmp::_()->getModule('gmap')->getModel()->getMapById($params['id']);
            $shortCodeHtmlParams = array('width','height','align');
            foreach($shortCodeHtmlParams as $code){
                if(isset($params[$code])){
                    $mapObj['html_options'][$code]= $params[$code];
                }
            }
            $shortCodeMapParams = array('map_display_mode','language','type','zoom','enable_zoom',
                                        'enable_mouse_zoom');
            foreach($shortCodeMapParams as $code){
                if(isset($params[$code])){
                    $mapObj['params'][$code]= $params[$code];
                }
            }
            if($mapObj['params']['map_display_mode']=='popup'){
                frameGmp::_()->addScript('bpopup',GMP_JS_PATH."/bpopup.js");      
            }
            frameGmp::_()->addScript("google_maps_api_".$mapObj['params']['language'], self::$gmapApiUrl.$mapObj['params']['language']);
            frameGmp::_()->addStyle("map_params", $this->getModule()->getModPath().'css/map.css');
			if(empty($mapObj['params']['map_display_mode'])){
				$mapObj['params']['map_display_mode']="map";
			}
            $this->addMapData($mapObj);
			
			$indoWindowSize  = utilsGmp::unserialize(frameGmp::_()->getModule("options")->getModel("options")->get("infowindow_size"));
			$this->assign("indoWindowSize",$indoWindowSize);
			
            $this->assign('currentMap', $mapObj);
			$displayType="";
			if(isset($params['display_type'])){
				$displayType=$params['display_type'];
			}
			$this->assign("display_theme", $displayType);
			return parent::getContent("mapPreview");
    }
    public function addNewMapData(){
		$mapFormParams = array("page"=>"AddMap","formId"=>'gmpAddNewMapForm','formName'=>'addNewMap');
		$markerFormParams = array("page"=>"AddMap","formId"=>'gmpAddMarkerToNewForm',
								'formNmae'=>'addMarkerForm');
		$markerForm = frameGmp::_()->getModule('marker')->getController()->getMarkerForm($markerFormParams );
		$mapForm=$this->getMapForm($mapFormParams);
		$this->assign("mapForm",$mapForm);
		$this->assign("markerForm",$markerForm);
		return parent::getContent('addMap');
    }
    public function editMaps(){
		$mapFormParams = array("formId"=>"gmpEditMapForm",'formName'=>"editMap","page"=>"editMap");
		$mapForm = $this->getMapForm($mapFormParams);
		$this->assign("mapForm",$mapForm);
		$markerFormParams = array("page"=>"editMap","formId"=>'gmpAddMarkerToEditMap',
								'formNmae'=>'addMarkerForm');
		$markerForm = frameGmp::_()->getModule('marker')->getController()->getMarkerForm($markerFormParams );
		$this->assign("markerForm",$markerForm);
		return parent::getContent('editMaps');            
    }
    public function addMapDataToJs(){
		frameGmp::_()->addScript('map.options',$this->getModule()->getModPath()."js/map.options.js");
        frameGmp::_()->addJSVar('map.options', 'gmpAllMapsInfo', self::$_mapsData);
    }
	public function getMapForm($params){
		$maps  = $this->getModel()->getAllMaps(true);
		$this->assign('mapArr' , $maps);
		$map_opts   = $this->getModel()->constructMapOptions();
		$this->assign('map_opts'    , $map_opts );
		$this->assign("params", $params);
		return parent::getContent("mapForm");
	}
}