<?php
class iconsControllerGmp extends controllerGmp {
		
        public function setDefaultIcons(){
            
            $defaultIcons=array('marker.png',
                                'markerA.png',
                                'marker_blue.png',
                                'marker_green.png',
                                'marker_orange.png');
            
            $this->getModel()->setDefaultIcons($defaultIcons);
        }	
	
        public function saveNewIcon(){
            $data= reqGmp::get('post');
            $res = new responseGmp();
            $result=$this->getModel()->saveNewIcon($data);
            if($result){
                $res->addData(array("id"=>$result,'path'=>$data['icon_url']));
            }else{
                outGmp($this->getModel()->getErrors());
            }
            frameGmp::_()->getModule("promo_ready")->getModel()->saveUsageStat("icon.add");            
            return $res->ajaxExec();
        }
        public function downloadIconFromUrl(){
            $data = reqGmp::get('post');
            $res =new responseGmp();
            if(!isset($data['icon_url']) || empty($data['icon_url'])){
                $res->pushError(langGmp::_('Empty url'));
                return $res->ajaxExec();
            }
            $result = $this->getModel()->downloadIconFromUrl($data['icon_url']);
            if($result){
                $res->addData($result);
            }else{
                $res->pushError($this->getModel()->getErrors());
            }
            return $res->ajaxExec();
        }
}