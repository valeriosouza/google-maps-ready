<?php
class tableIconsGmp extends tableGmp{
    public function __construct() {

        $this->_table = '@__icons';
        $this->_id = 'id';
        $this->_alias = 'gmp_icons';
        $this->_addField('id', 'int', 'int', '11', langGmp::_('Icon ID'))
                ->_addField('path', 'varchar', 'varchar', '255', langGmp::_('File Path'));
    }
}

