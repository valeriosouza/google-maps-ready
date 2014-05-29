<?php
$options = array();
foreach($this->map['html_options'] as $k => $v) {
	$options[] = $k. ': '. $v;
}
echo implode(', ', $options);
?>
<hr/>
<div class="gmpShortCodePreview">
   <p><b><?php langGmp::_e('Shortcode')?>:</b></p>
   <span>[ready_google_map id='<?php echo $this->map['id'];?>']</span>
</div>