<div class="gmpLeftCol">
<?php echo htmlGmp::ajaxfile('logo_image', array(
	'url' => uriGmp::_(array('baseUrl' => admin_url('admin-ajax.php'), 'page' => 'options', 'action' => 'saveLogoImg', 'reqType' => 'ajax')), 
	'buttonName' => 'Select Logo image', 
	'responseType' => 'json',
	'onSubmit' => 'toeOptLogoImgOnSubmitNewFile',
	'onComplete' => 'toeOptLogoImgCompleteSubmitNewFile',
))?>
<div id="gmpOptLogoImgkMsg"></div>
<br />
<img id="gmpOptLogoImgPrev" 
		src="<?php echo $this->optModel->isEmpty('logo_image') 
		? '' 
		: frameGmp::_()->getModule('options')->getLogoImgFullPath()?>" 
style="max-width: 200px;" />
</div>
<div class="gmpRightCol">
    <div class="gmpTip gmpTipArrowLeft nomargin">
        <?php langGmp::_e('Choose your logo, you can use png, jpg or gif image file.')?>
        <span class="gmpTipCorner"></span>
    </div>
    <br />
    <div class="gmpTip gmpTipArrowDown nomargin">
        <?php langGmp::_e('You can use default logo, your own or disable it. To disable logo on Coming Soon page click "Remove image" button bellow.')?>
        <span class="gmpTipCorner"></span>
    </div> <br /> 
    
    <?php echo htmlGmp::button(array('value' => langGmp::_('Remove image'), 'attrs' => 'id="gmpLogoRemove" class="button button-large" style="width:100%;"'))?>
    <?php echo htmlGmp::button(array('value' => langGmp::_('Set default'), 'attrs' => 'id="gmpLogoSetDefault" class="button button-large" style="width:100%;"'))?>
    <div id="gmpAdminOptLogoDefaultMsg"></div>
</div>
<div class="clearfix"></div>