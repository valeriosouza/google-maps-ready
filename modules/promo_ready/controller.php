<?php
class promo_readyControllerGmp extends controllerGmp {
	public function welcomePageSaveInfo() {
		$res = new response();
                
		if($this->getModel()->welcomePageSaveInfo(req::get('post'))) {
			$res->addMessage(lang::_('Information was saved. Thank you!'));
			$originalPage = req::getVar('original_page');
			$returnArr = explode('|', $originalPage);
			$return = $this->getModule()->decodeSlug(str_replace('return=', '', $returnArr[1]));
			$return = admin_url( strpos($return, '?') ? $return : 'admin.php?page='. $return);
			$res->addData('redirect', $return);
			installerGmp::setUsed();
		} else {
			$res->pushError($this->getModel()->getErrors());
		}
		return $res->ajaxExec();
	}
	public function saveUsageStat() {
		$res = new response();
		$code = req::getVar('code');
		if($code)
			$this->getModel()->saveUsageStat($code);
		return $res->ajaxExec();
	}
	public function sendUsageStat() {
		$res = new response();
		$this->getModel()->sendUsageStat();
		$res->addMessage(lang::_('Information was saved. Thank you for your support!'));
		return $res->ajaxExec();
	}
	public function hideUsageStat() {
		$res = new response();
		$this->getModule()->setUserHidedSendStats();
		return $res->ajaxExec();
	}
	/**
	 * @see controller::getPermissions();
	 */
	public function getPermissions() {
		return array(
			GMP_USERLEVELS => array(
				GMP_ADMIN => array('welcomePageSaveInfo', 'saveUsageStat', 'sendUsageStat', 'hideUsageStat')
			),
		);
	}
}