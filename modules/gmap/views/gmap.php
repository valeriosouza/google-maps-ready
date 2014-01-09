<?php
class gmapViewGmp extends viewGmp {
    
        public function getAllMaps(){
          
        }
        public function showAllMaps($data,$fromAjax=false){
            $this->assign('mapsArr',$data);  
            $this->assign('fromAjax',$fromAjax);  
            
            frameGmp::_()->addStyle('gmapCss',$this->getModule()->getModPath().'css/map.css');
            return parent::getContent('allMapsContent');
            
       }
        public function drawMap($params){
            $mapObj = frameGmp::_()->getModule('gmap')->getModel()->getMapById($params['id']);
            $this->assign('currentMap', $mapObj);
            if($mapObj['params']['map_display_mode']=='popup'){
                frameGmp::_()->addScript('bpopup',GMP_JS_PATH."/bpopup.js");      
            }

            frameGmp::_()->addScript('map.options',$this->getModule()->getModPath()."js/map.options.js");
                
    
            return parent::getContent('mapPreview');
        }
        public function addNewMapData(){
            $maps  = $this->getModel()->getAllMaps(true);
            
            $marker_opts=  frameGmp::_()->getModule('marker')->getModel()->constructMarkerOptions(); 
            $map_opts = $this->getModel()->constructMapOptions();
           
            $this->assign('mapArr'      , $maps);
            $this->assign('marker_opts' , $marker_opts);
            $this->assign('map_opts'    , $map_opts );
            
            return parent::getContent('newMapData');
        }
        public function editMaps(){
            return parent::getContent('editMaps');            
        }
}