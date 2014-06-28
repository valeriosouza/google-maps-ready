<?php
class marker_groupsModelGmp extends modelGmp {
    public function getMarkerGroups($params = array()){
        return frameGmp::_()->getTable('marker_groups')->get('*', $params);
    }
	public function getListForMarkers($markers) {
		if($markers) {
			$goupIds = array();
			foreach($markers as $m) {
				if((int) $m['marker_group_id'])
					$goupIds[ $m['marker_group_id'] ] = 1;
			}
			if(!empty($goupIds)) {
				$goupIds = array_keys($goupIds);
				return $this->getMarkerGroups(array('additionalCondition' => 'id IN ('. implode(',', $goupIds). ')'));
			}
		}
		return false;
	}
    public function getGroupById($id){
        $group = frameGmp::_()->getTable('marker_groups')->get("*"," `id`='".$id."' ");
        if(!empty($group)){
            return $group[0];
        }
        return $group;
    }
    public function showAllGroups(){
        $groups = $this->getMarkerGroups();
        return $this->getModule()->getView()->showGroupsTab($groups);
    }
    public function saveGroup($params){
        if($params['mode']=="update"){
            unset($params['mode']);
            $id = $params['id'];
            unset($params['id']);
            frameGmp::_()->getModule("promo_ready")->getModel()->saveUsageStat("group.edit");
            return frameGmp::_()->getTable('marker_groups')->update($params," `id`='".$id."'");
        }else{
            unset($params['mode']);      
            frameGmp::_()->getModule("promo_ready")->getModel()->saveUsageStat("group.save");
            return frameGmp::_()->getTable('marker_groups')->insert($params);
        }
    }
    public function removeGroup($groupId){
      return frameGmp::_()->getTable('marker_groups')->delete(" `id`='".$groupId."' ");
    }
}