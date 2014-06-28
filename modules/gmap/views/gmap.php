<?php
class gmapViewGmp extends viewGmp {
	private $_gmapApiUrl = "https://maps.googleapis.com/maps/api/js?&sensor=false&language=";
	public static $_mapsData;
	private $_displayColumns = array();

	public function getApiUrl() {
		return $this->_gmapApiUrl;
	}
	public function getMapsTab() {
		$this->assign('allMaps', $this->showAllMaps());
		$this->assign('editMap', $this->editMaps());
		return parent::getContent('mapsTab');
	}
	public function showAllMaps($fromAjax = false) {
		$this->assign('displayColumns', $this->getDisplayColumns());
		frameGmp::_()->addStyle('gmapCss', $this->getModule()->getModPath().'css/map.css');
		$maps = $this->getModel()->getAllMaps(true);
		frameGmp::_()->addJSVar('mapOptions', 'GmpExistsMapsArr', $maps);
		$this->assign('fromAjax', $fromAjax);
		$this->assign('mapsArr', $maps);
		/*$currentTab = reqGmp::getVar('tab');
		if($currentTab == NULL){
			if(!empty($data)){
				$currentTab = 'gmpAllMaps';
			} else {
				$currentTab = 'gmpAddNewMap';
			}
		}
		$this->assign('currentTab', $currentTab);	*/	
		return parent::getContent('allMapsContent');
	}
	public function addMapData($params){
		if(empty(self::$_mapsData)) {
			self::$_mapsData = array();
		}
		self::$_mapsData[] = $params;
	}
	public function drawMap($params){
		$ajaxurl = admin_url('admin-ajax.php');
		if(frameGmp::_()->getModule('options')->get('ssl_on_ajax')) {
			$ajaxurl = uriGmp::makeHttps($ajaxurl);
		}
		$jsData = array(
		   'siteUrl'					=> GMP_SITE_URL,
		   'imgPath'					=> GMP_IMG_PATH,
		   'loader'						=> GMP_LOADER_IMG, 
		   'close'						=> GMP_IMG_PATH. 'cross.gif', 
		   'ajaxurl'					=> $ajaxurl,
		   'animationSpeed'				=> frameGmp::_()->getModule('options')->get('js_animation_speed'),
		   'siteLang'					=> langGmp::getData(),
		   'options'					=> frameGmp::_()->getModule('options')->getAllowedPublicOptions(),
		   'GMP_CODE'					=> GMP_CODE,
		   'ball_loader'				=> GMP_IMG_PATH. 'ajax-loader-ball.gif',
		   'ok_icon'					=> GMP_IMG_PATH. 'ok-icon.png',
		);
		frameGmp::_()->addScript('coreGmp', GMP_JS_PATH. 'core.js');

		$jsData = dispatcherGmp::applyFilters('jsInitVariables', $jsData);
		frameGmp::_()->addJSVar('coreGmp', 'GMP_DATA', $jsData);
		frameGmp::_()->addScript('jquery', '', array('jquery'));
		$mapObj = frameGmp::_()->getModule('gmap')->getModel()->getMapById($params['id']);
		$shortCodeHtmlParams = array('width', 'height', 'align');
		foreach($shortCodeHtmlParams as $code) {
			if(isset($params[$code])){
				$mapObj['html_options'][$code] = $params[$code];
			}
		}
		$shortCodeMapParams = array('map_display_mode', 'language', 'type', 'zoom', 'enable_zoom', 'enable_mouse_zoom');
		foreach($shortCodeMapParams as $code){
			if(isset($params[$code])) {
				$mapObj['params'][$code] = $params[$code];
			}
		}
		if($mapObj['params']['map_display_mode'] == 'popup') {
			frameGmp::_()->addScript('bpopup', GMP_JS_PATH. '/bpopup.js');      
		}
		frameGmp::_()->addScript('google_maps_api_'. $mapObj['params']['language'], $this->getApiUrl(). $mapObj['params']['language']);
		frameGmp::_()->addScript('map.options', $this->getModule()->getModPath(). 'js/map.options.js', array('jquery'));
		
		frameGmp::_()->addStyle('map_params', $this->getModule()->getModPath(). 'css/map.css');
		
		frameGmp::_()->getModule('marker')->connectAssets();
		if(empty($mapObj['params']['map_display_mode'])){
			$mapObj['params']['map_display_mode'] = 'map';
		}
		$this->addMapData($mapObj);

		$indoWindowSize = utilsGmp::unserialize(frameGmp::_()->getModule('options')->getModel('options')->get('infowindow_size'));
		$this->assign('indoWindowSize', $indoWindowSize);
		$this->assign('currentMap', $mapObj);
		$markersDisplayType = '';
		if(isset($params['display_type'])) {
			$markersDisplayType = $params['display_type'];
		} else if(isset($params['markers_list_type'])) {
			$markersDisplayType = $params['markers_list_type'];
		} else if(isset($mapObj['params']['markers_list_type']) && !empty($mapObj['params']['markers_list_type'])) {
			$markersDisplayType = $mapObj['params']['markers_list_type'];
		}
		$this->assign('markersDisplayType', $markersDisplayType);
		// This will require only in PRO, but we will make it here - to avoid code doubling
		$this->assign('mapCategories', frameGmp::_()->getModule('marker_groups')->getModel()->getListForMarkers(isset($mapObj['markers']) ? $mapObj['markers'] : false));
		return parent::getContent('mapPreview');
	}
	/*public function addNewMapData(){
		$mapFormParams = array('page' => 'AddMap', 'formId' => 'gmpAddNewMapForm', 'formName' => 'addNewMap');
		$markerFormParams = array('page' => 'AddMap', 'formId' => 'gmpAddMarkerToNewForm', 'formNmae'=>'addMarkerForm');
		$markerForm = frameGmp::_()->getModule('marker')->getController()->getMarkerForm($markerFormParams );
		$mapForm=$this->getMapForm($mapFormParams);
		$this->assign('mapForm', $mapForm);
		$this->assign('markerForm', $markerForm);
		return parent::getContent('addMap');
	}*/
	public function editMaps(){
		$mapFormParams = array('formId' => 'gmpEditMapForm', 'formName' => 'editMap', 'page' => 'editMap');
		$mapForm = $this->getMapForm($mapFormParams);
		$this->assign('mapForm', $mapForm);
		$markerFormParams = array('page' => 'editMap', 'formId' => 'gmpAddMarkerToEditMap', 'formNmae' => 'addMarkerForm');
		$markerForm = frameGmp::_()->getModule('marker')->getController()->getMarkerForm($markerFormParams);
		$this->assign('markerForm', $markerForm);
		return parent::getContent('editMaps');
	}
	public function addMapDataToJs(){
		frameGmp::_()->addJSVar('map.options', 'gmpAllMapsInfo', self::$_mapsData);
	}
	public function getMapForm($params){
		$maps  = $this->getModel()->getAllMaps(true);
		$this->assign('mapArr', $maps);
		$map_opts = $this->getModel()->constructMapOptions();
		$this->assign('map_opts', $map_opts );
		$this->assign('params', $params);
		return parent::getContent('mapForm');
	}
	public function getDisplayColumns() {
		if(empty($this->_displayColumns)) {
			$this->_displayColumns = array(
				'id'				=> array('label' => __('ID'), 'db' => 'id'),
				'title'				=> array('label' => __('Title'), 'db' => 'title'),
				'description'		=> array('label' => __('Description'), 'db' => 'description'),
				'list_html_options'	=> array('label' => __('Html options'), 'db' => 'html_options'),
				'list_markers'		=> array('label' => __('Markers'), 'db' => 'markers'),
				'operations'		=> array('label' => __('Operations'), 'db' => 'operations'),
			);
		}
		return $this->_displayColumns;
	}
	public function getListHtmlOptions($map) {
		$this->assign('generatedShortcode', $this->getModule()->generateShortcode($map));
		$this->assign('map', $map);
		return parent::getContent('mapListHtmlOptions');
	}
	public function getListMarkers($map) {
		$this->assign('map', $map);
		return parent::getContent('mapListMarkers');
	}
	public function getListOperations($map) {
		$this->assign('map', $map);
		return parent::getContent('mapListOperations');
	}
}