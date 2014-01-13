<?php
class installerDbUpdaterGmp {
	static public function runUpdate() {
		self::update_044();
	}
	
	public static function update_044(){
		dbGmp::query("Insert into `@__modules` (id, code, active,    
                    type_id, params, has_tab, label, description) VALUES
                  (NULL, 'promo_ready', 1, 1, '', 0, 'Promo Ready', 'Promo Ready')                  
		");
		
	}
		
}