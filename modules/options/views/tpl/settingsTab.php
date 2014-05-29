<div class="clearfix"></div>
<div class="gmpPluginSettingsFormContainer">
	<h2><?php langGmp::_e('Plugin Settings');?></h2>
	<form id="gmpPluginSettingsForm">
		<div class="gmpFormRow">
			<?php echo htmlGmp::checkboxHiddenVal('send_statistic', array(
				'attrs' => 'class="statistic"',
				'checked' => (bool)$this->saveStatistic))	
			?>
			<label for="gmpNewMap_title" class="gmpFormLabel">
				<?php langGmp::_e('Send anonym statistic?')?>
			</label>
		</div>
		<hr />
		<div class="gmp-control-group">
			<label><?php langGmp::_e('Marker Description window size')?></label>
			<div class="controls">
				<div class="gmpInfoWindowSize gmpInfoWindowSize-width">
					<label for="gmpInfoWindowSize_width"><?php langGmp::_e('Width');?></label>
					<div class="gmpSizePoint">Px</div>
					<input type="text" name="infoWindowSize[width]" class="input-mini" id="gmpInfoWindowSize_width" required="required" value="<?php echo $this->indoWindowSize['width'];?>">
				</div>
				<div class="gmpInfoWindowSize gmpInfoWindowSize-height">
					<label for="gmpInfoWindowSize_height"><?php langGmp::_e('Height');?></label>
					<div class="gmpSizePoint">Px</div>
					<input type="text" name="infoWindowSize[height]" class="input-mini" id="gmpInfoWindowSize_height" required="required" value="<?php echo $this->indoWindowSize['height'];?>">
				</div>
			</div>
		</div>
		<hr />
		<div class="controls">
			<?php
				echo htmlGmp::hidden('mod', array('value' => 'options'));
				echo htmlGmp::hidden('action', array('value' => 'updatePluginSettings'));
				echo htmlGmp::hidden('reqType', array('value' => 'ajax'));
			?>
			<div id="gmpPluginOptsMsg"></div>
			<input type="submit" class="btn btn-success" value="<?php langGmp::_e('Save')?>" />
		</div>
	</form>
</div>
<?php /*?>
<div class="importExportFormContainer">
	<h2><?php langGmp::_e("Import/Export Maps,Markers,Groups");?></h2>
	<form id='ImportExportForm'>
		<div class='gmpFormRow'>
			<label for='gmpActionMode'><?php langGmp::_e("Select Mode");?></label>
			<?php
				echo htmlGmp::selectbox("gmpActionMode", 
						array("attrs"=>" id='gmpActionMode' class='gmpImportExportMode gmpHintElem'",
								"options"=>array(
											"import"=>langGmp::_("Import"),
											"export"=>langGmp::_("Export"),
									),
									"hint"=>langGmp::_("Select Action"),
									"value"=>"export"
							));
			?>
				
		</div>
		<hr/>
		<div class='gmpFormRow gmpExportOpts gmpImpExpOpts' style='display:block';>
			<div class="existsMApsListToExport">
				<label for='gmpExportMapsOpts_check'><?php langGmp::_e("Select Maps To Export");?></label>
				<?php
				$iter=0;
					if(!empty($this->mapsToExport)){
						foreach($this->mapsToExport as $map){
							?>
							<div class="exportMapItm">
								<div class='gmpFormRow'>
									<label for='map_<?php echo $map['id']?>'><?php echo $map['title'];?></label>
								<?php
								echo htmlGmp::checkbox("map[".$iter."]",
										array("attrs"=>" class='mapItm gmpHintElem' id='map_".$map['id']."'",
												"value"=>$map['id'],
												"hint"=>langGmp::_("Check To Export"),
												"checked"=>1
											))
								?>
								</div>	
							</div>	
								<?php
						$iter++;
						}

					}
				?>
			</div>
				
			<hr/>
			
			<div class='gmpFormRow'>
				<button type='submit' class='btn btn-success' >
					<span class='gmpIcon gmpIconExport' ></span>
					<?php langGmp::_e("Export");?>
				</button>
				
			</div>
			<div id='gmpRes_export'></div>
		</div>	
		<div class='gmpFormRow gmpImportOpts gmpImpExpOpts'>
			
			<div class='gmpFormRow gmpImportBtnCon'>
				<?php
//					echo htmlGmp::ajaxfile("BackupFileCsv",
//								array("attrs"=>" id='importFile' ",
//									"btn_class"=>'btn btn-success',
//									"buttonName"=>"<span class='gmpIcon gmpIconImport'></span>Select File And Import",
//									"onSubmit"=>"StartImportFileUpload",
//									"onComplete"=>"EndImportFileUpload",
//									"url"=>uriGmp::_(
//											array('baseUrl' => admin_url('admin-ajax.php'),
//												'page' => 'options',
//												'action' => 'importData',
//												'reqType' => 'ajax'))));
				?>
			</div>
			<div id='gmpRes_import'></div>
		</div>
		
		<?php
			echo htmlGmp::hidden("mod", array("value"=>"options"));
			echo htmlGmp::hidden("action", array("value"=>"exportData"));
			echo htmlGmp::hidden("reqType", array("value"=>"ajax"));
			echo htmlGmp::hidden("pl", array("value"=>"gmp"));
		?>		
		<div id='gmpImpExpOptsLoader'></div>
	</form>	
</div>
<?php */?>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('.gmpInfoWindowSize input').keyup(function(e){
		if(e.keyCode == 0) {
			return;
		}
		var val = jQuery(this).val();
		if(val == ''){
			return false;
		}
		var res= parseInt(val);
		if(isNaN(res)) {
			res = 100;
		}
		jQuery(this).val(res);
	});
	jQuery('#gmpPluginSettingsForm').submit(function(){
		jQuery(this).sendFormGmp({
			msgElID: 'gmpPluginOptsMsg'
		,	onSuccess: function(res){
				return false;
			}
		});
		return false;
	});
});
</script>		