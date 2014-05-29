<?php
class optionsViewGmp extends viewGmp {
	public function getAdminPage() {
		if(!installerGmp::isUsed()){
			frameGmp::_()->getModule('promo_ready')->showWelcomePage();
			return;
		}
		//$presetTemplatesHtml = $this->getPresetTemplates();
		$tabsData = array(/*'gmpAddNewMap'	=> array('title'	=>  'Add New Map',
												   'content' =>  $this->getAddNewMapData()),*/
			'gmpAllMaps'		=> array(
				'title'   => 'All Maps', 
				'content' => frameGmp::_()->getModule('gmap')->getMapsTab()),
			'gmpMarkerList'		=> array(
				'title' => 'Markers',
				'content' => frameGmp::_()->getModule('marker')->getView()->showAllMarkers()),
			'gmpMarkerGroups'	=> array(
				'title'   => 'Marker Groups',
				'content' => $this->getMarkersGroupsTab()),
						/*'gmpEditMaps'		=> array('title' => 'Edit Maps', 
												'content' => $this->getMapsEditTab()),*/
			'gmpPluginSettings'	=>array(
				'title' => 'Plugin Settings',
				'content' => $this->getPluginSettingsTab())						
		);
		$tabsData = dispatcherGmp::applyFilters('adminOptionsTabs', $tabsData);
		
		$indoWindowSize  = utilsGmp::unserialize($this->getModel('options')->get('infowindow_size'));
		$defaultOpenTab = reqGmp::getVar('tab', 'get');

		//$this->assign('presetTemplatesHtml', $presetTemplatesHtml);
		$this->assign('tabsData', $tabsData);
		$this->assign('indoWindowSize', $indoWindowSize);
		$this->assign('defaultOpenTab', $defaultOpenTab);
		parent::display('optionsAdminPage');
	}
	
	public function getPluginSettingsTab() {
		$saveStatistic = $this->getModel('options')->getStatisticStatus();
		$indoWindowSize  = utilsGmp::unserialize($this->getModel('options')->get('infowindow_size'));
		//frameGmp::_()->addScript('import.export.opts', GMP_JS_PATH. 'import.export.opts.js');
		/*$maps = frameGmp::_()->getModule('gmap')->getController()->getAllMaps(false);
		$this->assign("mapsToExport", $maps);*/
		$this->assign('saveStatistic', $saveStatistic);
		$this->assign('indoWindowSize', $indoWindowSize);
		return parent::getContent('settingsTab');
	}
	/*public function getPresetTemplates() {
			return parent::getContent('templatePresetTemplates');
	}*/
	/*public function getAddNewMapData(){
		return frameGmp::_()->getModule('gmap')->getView()->addNewMapData();
	}
	public function getMapsEditTab(){
		return frameGmp::_()->getModule('gmap')->getView()->editMaps(); 
	}*/
	/*public function getMapTemplateTab() {
		$gmapModule = frameGmp::_()->getModule('gmap');
		$gmpAllMaps = $gmapModule->getController()->getAllMaps();
		
		if(!isset($this->optModel)) {
			$this->assign('optModel', $this->getModel());
		}
		return $gmapModule->getView()->showAllMaps($gmpAllMaps);
	}*/
	/*public function getMarkersTab() {
		return  frameGmp::_()->getModule('marker')->getModel()->showAllMarkers();
	}*/
	public function getMarkersGroupsTab(){
		return  frameGmp::_()->getModule('marker_groups')->getModel()->showAllGroups();
	}
	public function displayDeactivatePage(){
		$this->assign('GET', reqGmp::get('get'));
		$this->assign('POST',reqGmp::get('post'));
		$this->assign('REQUEST_METHOD', strtoupper(reqGmp::getVar('REQUEST_METHOD', 'server')));
		$this->assign('REQUEST_URI', basename(reqGmp::getVar('REQUEST_URI', 'server')));
		parent::display('deactivatePage');
	}
}
