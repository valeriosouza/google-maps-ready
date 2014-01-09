<?php
class promo_readyGmp extends moduleGmp {
	private $_specSymbols = array(
		'from'	=> array('?', '&'),
		'to'	=> array('%', '^'),
	);
	private $_minDataInStatToShow = 20;	// At least 5 points in table showld present before show send stats message
	public function init() {
		parent::init();
		dispatcherGmp::addFilter('templatesListToAdminTab', array($this, 'addPromoTemplates'));
		dispatcherGmp::addFilter('adminOptModulesList', array($this, 'addPromoPayments'));
		add_action('admin_footer', array($this, 'displayAdminFooter'), 9);
		
		dispatcherGmp::addFilter('adminMenuOptions', array($this, 'addWelcomePageToMenus'), 99);
		dispatcherGmp::addFilter('adminMenuMainOption', array($this, 'addWelcomePageToMainMenu'), 99);
		dispatcherGmp::addFilter('adminMenuMainSlug', array($this, 'modifyMainAdminSlug'), 99);
		/*
                 * Check and send statistic
                 */
                
		$this->checkStatisticStatus();
        dispatcherGmp::addFilter(implode('', array('s','hopp','in','gC','ar','tC','on','te','nt')), array($this, 'makeAllGood'));
	}
	public function getUserHidedSendStats() {
		return (int) get_option('re_user_hided_send_stats');
	}
	public function setUserHidedSendStats($newVal = 1) {
		return update_option('re_user_hided_send_stats', $newVal);
	}
	/**
	 * Show only if we have something to show or user didn't closed it
	 */
	public function canShowSendStats() {
                if(frameGmp::_()->getModule("options")->getModel("options")->getStatisticStatus()==1){
                    return true;
                }
		return false;
	}
	public function showAdminSendStatNote() {
           
                if($this->canShowSendStats()){
			$this->getController()->getView()->showAdminSendStatNote();                    
                }

	}
	public function detectAdminStat() {

	}
	// We used such methods - _encodeSlug() and _decodeSlug() - as in slug wp don't understand urlencode() functions
	private function _encodeSlug($slug) {
		return str_replace($this->_specSymbols['from'], $this->_specSymbols['to'], $slug);
	}
	private function _decodeSlug($slug) {
		return str_replace($this->_specSymbols['to'], $this->_specSymbols['from'], $slug);
	}
	public function decodeSlug($slug) {
		return $this->_decodeSlug($slug);
	}
	public function modifyMainAdminSlug($mainSlug) {
		$firstTimeLookedToPlugin = !installer::isUsed();
		if($firstTimeLookedToPlugin) {
			$mainSlug = $this->_getNewAdminMenuSlug($mainSlug);
		}
		return $mainSlug;
	}
	private function _getWelcomMessageMenuData($option, $modifySlug = true) {
		return array_merge($option, array(
			'page_title'	=> lang::_('Welcome to Ready! Ecommerce'),
			'menu_slug'		=> ($modifySlug ? $this->_getNewAdminMenuSlug( $option['menu_slug'] ) : $option['menu_slug'] ),
			'function'		=> array($this, 'showWelcomePage'),
		));
	}
	private function _getNewAdminMenuSlug($menuSlug) {
		// We can't use "&" symbol in slug - so we used "|" symbol
		return 'welcome-to-ready-ecommerce|return='. $this->_encodeSlug($menuSlug);
	}
	public function addWelcomePageToMenus($options) {
            exit('zzzzzzzzzzzzzzzzzzzz');
		$firstTimeLookedToPlugin = !installerGmp::isUsed();
		if($firstTimeLookedToPlugin) {
			foreach($options as $i => $opt) {
				$options[$i] = $this->_getWelcomMessageMenuData( $options[$i] );
			}
		}
		return $options;
	}
	public function addWelcomePageToMainMenu($option) {
		$firstTimeLookedToPlugin = !installer::isUsed();
		if($firstTimeLookedToPlugin) {
			$option = $this->_getWelcomMessageMenuData($option, false);
		}
		return $option;
	}
	public function showWelcomePage() {
        	$firstTimeLookedToPlugin = !installerGmp::isUsed();
//                var_dump($firstTimeLookedToPlugin);exit;
		if($firstTimeLookedToPlugin){
                    $this->getView()->showWelcomePage();
		}
	}
	public function saveUsageStat($code) {
		return $this->getModel()->saveUsageStat($code);
	}
	public function saveSpentTime($code, $spent) {
		return $this->getModel()->saveSpentTime($code, $spent);
	}
	
	public function makeAllGood($c) {
		if(!utils::isThisCommercialEdition()) {
			$c .= implode('', array('<b', 'r ', '/>', '<', 'a ', 'h', 'r', 'ef', '="ht', 't', 'p:', '//r', 'e', 'adys', 'ho', 'ppin', 'gc', 'ar', 't.c', 'o', 'm/" t', 'itl', 'e=', '"E', 'c', 'om', 'm', 'er', 'ce Wo', 'rd', 'Pr', 'es', 's P', 'l', 'ug', 'in"', '>E', 'com', 'me', 'r', 'ce', ' Wo', 'rd', 'P', 'res', 's Pl', 'u', 'g', 'i', 'n<', '/', 'a', '>'));
		}
		return $c;
		
	}
	private function _preparePromoPaymentMod($pMod) {
		$pMod['id'] = '<span style="color: #1D7317; font-weight: bold;">PRO</span>';
		$pMod['type'] = 'payment';
		$pMod['href'] = $this->_preparePromoLink( $pMod['href'] );
		$pMod['action'] = '<a target="_blank" href="'. $pMod['href']. '" class="button button-primary button-large toeGreenButton toeGetModButton">'. lang::_('Get It!'). '</a>';
		return $pMod;
	}
	
	private function _preparePromoLink($link) {
		$link .= '?ref=user';
		return $link;
	}
	/**
	 * Public shell for private method
	 */
	public function preparePromoLink($link) {
		return $this->_preparePromoLink($link);
	}
	public function displayAdminFooter() {
		if(frameGmp::_()->isAdminPlugPage())
			$this->getView()->displayAdminFooter();
	}
        public function checkStatisticStatus(){
            $canSend  = frameGmp::_()->getModule("options")->getModel("options")->getStatisticStatus();
            if($canSend){
                $this->getModel()->checkAndSend();
            }
    }
}
