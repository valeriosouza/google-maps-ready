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
		
	//$this->_options = dispatcherGmp::applyFilters('adminMenuOptions', $this->_options);
        add_menu_page(langGmp::_('Ready! Google Maps'),
                      langGmp::_('Ready! Google Maps'), 10,
                      $this->_mainSlug, 
                       array(frameGmp::_()->getModule('options')->getView(), 
                      'getAdminPage')
                    );
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