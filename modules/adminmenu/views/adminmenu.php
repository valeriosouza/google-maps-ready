<?php
class adminmenuViewGmp extends viewGmp {
    protected $_file = '';
    /**
     * Array for standart menu pages
     * @see initMenu method
     */
    protected $_mainSlug = 'ready-google-maps';
    public function init() {
        $this->_file = __FILE__;
		//
        add_action('admin_menu', array($this, 'initMenu'), 9);
        parent::init();
    }
    public function initMenu() {
		$mainSlug = dispatcherGmp::applyFilters('adminMenuMainSlug', $this->_mainSlug);
		$mainMenuPageOptions = array(
			'page_title' => langGmp::_('Ready! Google Maps'), 
			'menu_title' => langGmp::_('Ready! Google Maps'), 
			'capability' => 'manage_options',
			'menu_slug' => $mainSlug,
			'function' => array(frameGmp::_()->getModule('options')->getView(), 'getAdminPage'));
		$mainMenuPageOptions = dispatcherGmp::applyFilters('adminMenuMainOption', $mainMenuPageOptions);
        add_menu_page($mainMenuPageOptions['page_title'], $mainMenuPageOptions['menu_title'], $mainMenuPageOptions['capability'], $mainMenuPageOptions['menu_slug'], $mainMenuPageOptions['function']);
    }
    public function getFile() {
        return $this->_file;
    }
	public function getMainSlug() {
		return $this->_mainSlug;
	}
    /*public function getOptions() {
        return $this->_options;
    }*/
}