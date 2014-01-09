<h4 class="gmpTitle"><?php langGmp::_e('Title')?>:</h4>
<?php echo htmlGmp::text('opt_values[msg_title]', array('value' => $this->optModel->get('msg_title')))?>
<div class="gmpLeftCol">
    <?php langGmp::_e('Select color')?>:
    <?php echo htmlGmp::colorpicker('opt_values[msg_title_color]', array('value' => $this->optModel->get('msg_title_color')))?>
</div>
<div class="gmpRightCol">
    <?php langGmp::_e('Select font')?>:
    <?php echo htmlGmp::fontsList('opt_values[msg_title_font]', array('value' => $this->optModel->get('msg_title_font')));?>
</div>
<div class="clearfix"></div>
<div class="clearfix">
	<?php echo htmlGmp::button(array('value' => langGmp::_('Set default'), 'attrs' => 'id="gmpMsgTitleSetDefault"'))?>
	<div id="gmpAdminOptMsgTitleDefaultMsg"></div>
</div>
<div class="clearfix"></div>
<br />
<h4 class="gmpTitle"><?php langGmp::_e('Text')?>:</h4>
<?php echo htmlGmp::textarea('opt_values[msg_text]', array('value' => $this->optModel->get('msg_text')))?>
<div class="gmpLeftCol">
    <?php langGmp::_e('Select color')?>:
    <?php echo htmlGmp::colorpicker('opt_values[msg_text_color]', array('value' => $this->optModel->get('msg_text_color')))?>
</div>
<div class="gmpRightCol">
    <?php langGmp::_e('Select font')?>:
    <?php echo htmlGmp::fontsList('opt_values[msg_text_font]', array('value' => $this->optModel->get('msg_text_font')));?>
</div>
<div class="clearfix"></div>
<div class="clearfix">
	<?php echo htmlGmp::button(array('value' => langGmp::_('Set default'), 'attrs' => 'id="gmpMsgTextSetDefault"'))?>
	<div id="gmpAdminOptMsgTextDefaultMsg"></div>
</div>
<div class="clearfix"></div>