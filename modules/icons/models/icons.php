<?php
class iconsModelGmp extends modelGmp {
    public static $tableObj;
    function __construct() {
        if(empty(self::$tableObj)){
            self::$tableObj=  frameGmp::_()->getTable("icons");
        }
    }
    public function getIcons(){
        $icons =  frameGmp::_()->getTable('icons')->get('*');
        if( empty($icons) ){
              return $icons ;
        }
        $iconsArr=array();
        foreach($icons as $icon){
            $iconsArr[$icon['id']]=$this->getIconUrl($icon['path']);
        }
        return $iconsArr;
    }
    public function saveNewIcon($params){
       
        if(!isset($params['icon_url'])){
            $this->pushError(langGmp::_("Marker no found"));
            return false;
        }
        $url = $params['icon_url'];
        $exists = self::$tableObj->get("*","`path`='".$url."'");
        if(!empty($exists)){
            return $exists[0]['id'];
        }
        return  self::$tableObj->store(array('path'=>$url));
    }
    public function getIconsPath(){
        return '/ready_google_icons/';
    }
    public function getIconsFullDir(){
        $uplDir = wp_upload_dir();
        $path  = $uplDir['baseurl'].$this->getIconsPath();
        return $path;
    }
    
    public function getIconsFullPath(){
        $uplDir = wp_upload_dir();
        $path = $uplDir['basedir'].$this->getIconsPath();
        return $path;
    }
    public function setDefaultIcons($icons){
        //return;
        $uplDir = wp_upload_dir();
        if(!is_dir($uplDir['basedir'])){
            @mkdir($uplDir['basedir'],0777);
        }
        $icons_upload_path=$uplDir['basedir'].$this->getIconsPath();
        if(!is_dir($icons_upload_path)){
            @mkdir($icons_upload_path,0777);
        }
        foreach($icons as $icon){
           $file = str_replace("\\","/",$this->getModule()->getModDir().'icons_files'.DS.$icon);
           $dest =  str_replace("\\","/",$uplDir['basedir'].$this->getIconsPath().$icon);
           @copy($file,$dest);
           frameGmp::_()->getTable('icons')->insert(array('path'=>$icon));
       }
       update_option("gmp_def_icons_installed",true);
    }
    public function downloadIconFromUrl($url){
        $filename = basename($url);
        if(empty($filename)){
            $this->pushError(langGmp::_('File not found'));
            return false;
        }

        $imageinfo = getimagesize ( $url,$imgProp );

        if(empty($imageinfo)){
            $this->pushError(langGmp::_('Cannot get image'));
            return false;
        }
        $fileExt = str_replace("image/","",$imageinfo['mime']);    
        $filename = utilsGmp::getRandStr(8).".".$fileExt;
        $dest = $this->getIconsFullPath().$filename;
        file_put_contents($dest, fopen($url, 'r')); 
        $newIconId = frameGmp::_()->getTable('icons')->store(array('path'=>$filename),"insert");
        if($newIconId){
           return array('id'=>$newIconId,'path'=>$this->getIconsFullDir().$filename);            
        }else{
            $this->pushError(langGmp::_('cannot insert to table'));
            return false;
        }
    }
    public function getIconFromId($id){
        $res = frameGmp::_()->getTable('icons')->get("*",array('id'=>$id));
        if(empty($res)){
            return $res;
        }
        $icon =$res[0]; 

        $icon['path'] = $this->getIconUrl($icon['path']);
        return $icon;
    }
   function getIconUrl($icon){
     if(!empty($icon)){
         return $this->getIconsFullDir().$icon;
     }
     return $icon;
   } 
}