<?php if(!empty($this->tplModules)) { ?>
	<ul class="gmpTemplatesList">
	<?php foreach($this->tplModules as $tplMod) { ?>
	<li class="gmpTemplatePrevShell gmpTemplatePrevShell-existing gmpTemplatePrevShell-<?php echo $tplMod->getCode()?>" onclick="return setTemplateOptionGmp('<?php echo $tplMod->getCode()?>');">
		<h2 style="text-align: center; color: #454545"><?php echo $tplMod->getLabel()?></h2><hr />
		<?php echo htmlGmp::img( $tplMod->getPrevImgPath(), false, array('attrs' => 'class="gmpAdminTemplateImgPrev"'));?><hr />
		<input type="submit" onclick="return setTemplateOptionGmp('<?php echo $tplMod->getCode()?>');" class="button button-primary button-large" value="<?php langGmp::_e('Apply')?>">
	</li>
	<?php } ?>
	<?php if(!empty($this->tplModulesPromo)) { ?>
		<?php foreach($this->tplModulesPromo as $tplPromo) { ?>
			<li class="gmpTemplatePrevShell">
				<h2 style="text-align: center; color: #454545"><?php echo $tplPromo['label']?></h2><hr />
				<?php echo htmlGmp::img( $tplPromo['img'], false, array('attrs' => 'class="gmpAdminTemplateImgPrev"'));?><hr />
				<input type="submit" onclick="window.open('<?php echo $tplPromo['link']?>'); return false;" class="button button-primary button-large" value="<?php langGmp::_e('Available in PRO version')?>">
			</li>
		<?php }?>
	<?php }?>
	</ul>
	<div style="clear: both;"></div>
	<div id="gmpAskDefaultModParams" style="display: none;" title="<?php langGmp::_e('Set default template settings?')?>">
		<div><?php langGmp::_e('This template has some default setting. If you want to activate them - just check it')?>:</div>
		<div>
			<?php
				$defOptions = array(
					'background_color' => array('label' => 'Background color', 
						'options' => array('bg_color', 'bg_type')),
					'background_image' => array('label' => 'Background image', 
						'options' => array('bg_image', 'bg_type')),
					'fonts' => array('label' => 'Fonts - types and colors', 
						'options' => array('msg_title_color', 'msg_title_font', 'msg_text_color', 'msg_text_font')),
					'logo' => array('label' => 'Logo image', 
						'options' => array('logo_image'),
						'tip' => 'Be careful: if you already uploaded your logo on server - it will be removed. You will be able then upload it one more time.'),
					'background_slides' => array('label' => 'Background slides',
						'options' => array('slider_images')),
				);
			?>
			<?php foreach($defOptions as $optKey => $optData) { ?>
			<div class="gmpTplDefOptionCheckShell">
				<span class="gmpDefTplOptCheckbox"><?php echo htmlGmp::checkbox($optKey, array('value' => implode(',', $optData['options'])))?></span> - <?php langGmp::_e($optData['label'])?>
				<?php if(isset($optData['tip'])) { ?>
				<br /><i style="font-size: 12px;"><b><?php langGmp::_e($optData['tip'])?></b></i>
				<?php }?>
			</div>
			<?php }?>
		</div>
	</div>
<?php } else { ?>
	<?php langGmp::_e('No template modules were found'); ?>
<?php }?>