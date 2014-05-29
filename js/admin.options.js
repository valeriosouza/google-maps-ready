var gmpAdminFormChanged = []
,	gmpDefaultOpenTab = '';
window.onbeforeunload = function(){
	// If there are at lease one unsaved form - show message for confirnation for page leave
	if(gmpAdminFormChanged.length)
		return 'Some changes were not-saved. Are you sure you want to leave?';
};
jQuery(document).ready(function(){
	jQuery('#gmpAdminOptionsTabs').tabs({
		/*beforeActivate: function( event, ui ) {
		   if(typeof(gmpChangeTab)==typeof(Function)){
			   return gmpChangeTab(event,ui) 
		   }
		}*/
	});
    jQuery('#gmpAdminOptionsTabs li').removeClass('ui-corner-top').addClass('ui-corner-left');
	jQuery('#gmpAdminOptionsTabs li a[href="#gmpAllMaps"]').click(function(){
		gmpOpenMapLists();
	});
	jQuery('#gmpAdminOptionsTabs li a[href="#gmpMarkerList"]').click(function(){
		jQuery('.gmpCancelMarkerEditing').trigger('click');
	});
	jQuery('#gmpAdminOptionsSaveMsg').submit(function(){
		return false;
	});
	/*jQuery('#gmpAdminOptionsForm [name="opt_values[mode]"]').change(function(){
		changeModeOptionGmp( jQuery(this).val(), true );
	});
	changeModeOptionGmp( toeOptionGmp('mode') );*/
	//selectTemplateImageGmp( toeOptionGmp('template') );
	// Remove class is to remove this class from wrapper object
	//jQuery('.gmpAdminTemplateOptRow').not('.gmpAvoidJqueryUiStyle').buttonset().removeClass('ui-buttonset');
	
	/*jQuery('#gmpAdminTemplateOptionsForm').submit(function(){
		jQuery(this).sendFormGmp({
			msgElID: 'gmpAdminTemplateOptionsMsg'
		});
		return false;
	});*/
	/*jQuery('#gmpAdminTemplateOptionsForm [name="opt_values[bg_type]"]').change(function(){
		changeBgTypeOptionGmp();
	});
	changeBgTypeOptionGmp();*/
	
	 jQuery('.gmpOptTip').live('mouseover',function(event){
        if(!jQuery('#gmpOptDescription').attr('toeFixTip')) {
			var pageY = event.pageY - jQuery(window).scrollTop();
			var pageX = event.pageX;
			var tipMsg = jQuery(this).attr('tip');
			var moveToLeft = jQuery(this).hasClass('toeTipToLeft');	// Move message to left of the tip link
			if(typeof(tipMsg) == 'undefined' || tipMsg == '') {
				tipMsg = jQuery(this).attr('title');
			}
			toeOptShowDescriptionGmp( tipMsg, pageX, pageY, moveToLeft );
			jQuery('#gmpOptDescription').attr('toeFixTip', 1);
		}
        return false;
    });
    jQuery('.gmpOptTip').live('mouseout',function(){
		toeOptTimeoutHideDescriptionGmp();
        return false;
    });
	jQuery('#gmpOptDescription').live('mouseover',function(e){
		jQuery(this).attr('toeFixTip', 1);
		return false;
    });
	jQuery('#gmpOptDescription').live('mouseout',function(e){
		toeOptTimeoutHideDescriptionGmp();
		return false;
    });
	// If some changes was made in those forms and they were not saved - show message for confirnation before page reload
	/*var formsPreventLeave = ['gmpAdminTemplateOptionsForm', 'gmpSubAdminOptsForm', 'gmpAdminSocOptionsForm'];
	jQuery('#'+ formsPreventLeave.join(', #')).find('input,select').change(function(){
		var formId = jQuery(this).parents('form:first').attr('id');
		changeAdminFormGmp(formId);
	});
	jQuery('#'+ formsPreventLeave.join(', #')).find('input[type=text],textarea').keyup(function(){
		var formId = jQuery(this).parents('form:first').attr('id');
		changeAdminFormGmp(formId);
	});
	jQuery('#'+ formsPreventLeave.join(', #')).submit(function(){
		if(gmpAdminFormChanged.length) {
			var id = jQuery(this).attr('id');
			for(var i in gmpAdminFormChanged) {
				if(gmpAdminFormChanged[i] == id) {
					gmpAdminFormChanged.pop(i);
				}
			}
		}
	});*/
	if(gmpDefaultOpenTab && gmpDefaultOpenTab != '') {
		// Call after all initialization will compleate
		setTimeout(function(){
			switch(gmpDefaultOpenTab) {
				case 'gmpAddNewMap':
					gmpShowAddMap();
					break;
				case 'gmpMarkerList':
					selectTabMainGmp('gmpMarkerList');
					break;
				case 'gmpMarkerGroups':
					selectTabMainGmp('gmpMarkerGroups');
					break;
				case 'gmpPluginSettings':
					selectTabMainGmp('gmpPluginSettings');
					break;
			}
		}, 500);
		
	}
	
	jQuery('#toeModActivationPopupFormGmp').submit(function(){
		jQuery(this).sendFormGmp({
			msgElID: 'toeModActivationPopupMsgGmp',
			onSuccess: function(res){
				if(res && !res.error) {
					var goto = jQuery('#toeModActivationPopupFormGmp').find('input[name=goto]').val();
					if(goto && goto != '') {
					  toeRedirect(goto);  
					} else
					  toeReload();
				}
			}
		});
		return false;
	});
	jQuery('.toeRemovePlugActivationNoticeGmp').click(function(){
		  jQuery(this).parents('.info_box:first').animateRemove();
		  return false;
	});
	if(window.location && window.location.href && window.location.href.indexOf('plugins.php')) {
		if(GMP_DATA.allCheckRegPlugs && typeof(GMP_DATA.allCheckRegPlugs) == 'object') {
			for(var plugName in GMP_DATA.allCheckRegPlugs) {
				var plugRow = jQuery('#'+ plugName.toLowerCase())
				,	updateMsgRow = plugRow.next('.plugin-update-tr');
				if(plugRow.size() && updateMsgRow.find('.update-message').size()) {
					updateMsgRow.find('.update-message').find('a').each(function(){
						if(jQuery(this).html() == 'update now') {
							jQuery(this).click(function(){
								toeShowModuleActivationPopupGmp( plugName, 'activateUpdate', jQuery(this).attr('href') );
								return false;
							});
						}
					});
				}
			}
		}
	}
});
function toeShowModuleActivationPopupGmp(plugName, action, goto) {
	action = action ? action : 'activatePlugin';
	goto = goto ? goto : '';
	jQuery('#toeModActivationPopupFormGmp').find('input[name=plugName]').val(plugName);
	jQuery('#toeModActivationPopupFormGmp').find('input[name=action]').val(action);
	jQuery('#toeModActivationPopupFormGmp').find('input[name=goto]').val(goto);
	
	tb_show(toeLangGmp('Activate plugin'), '#TB_inline?width=710&height=220&inlineId=toeModActivationPopupShellGmp', false);
	var popupWidth = jQuery('#TB_ajaxContent').width()
	,	docWidth = jQuery(document).width();
	// Here I tried to fix usual wordpress popup displace to right side
	jQuery('#TB_window').css({'left': Math.round((docWidth - popupWidth)/2)+ 'px', 'margin-left': '0'});
}
function changeAdminFormGmp(formId) {
	if(jQuery.inArray(formId, gmpAdminFormChanged) == -1)
		gmpAdminFormChanged.push(formId);
}
function toeShowDialogCustomized(element, options) {
	options = jQuery.extend({
		resizable: false
	,	width: 500
	,	height: 300
	,	closeOnEscape: true
	,	open: function(event, ui) {
			jQuery('.ui-dialog-titlebar').css({
				'background-color': '#222222'
			,	'background-image': 'none'
			,	'border': 'none'
			,	'margin': '0'
			,	'padding': '0'
			,	'border-radius': '0'
			,	'color': '#CFCFCF'
			,	'height': '27px'
			});
			jQuery('.ui-dialog-titlebar-close').css({
				'background': 'url("../wp-includes/js/thickbox/tb-close.png") no-repeat scroll 0 0 transparent'
			,	'border': '0'
			,	'width': '15px'
			,	'height': '15px'
			,	'padding': '0'
			,	'border-radius': '0'
			,	'margin': '-7px 0 0'
			}).html('');
			jQuery('.ui-dialog').css({
				'border-radius': '3px'
			,	'background-color': '#FFFFFF'
			,	'background-image': 'none'
			,	'padding': '1px'
			,	'z-index': '300000'
			});
			jQuery('.ui-dialog-buttonpane').css({
				'background-color': '#FFFFFF'
			});
			jQuery('.ui-dialog-title').css({
				'color': '#CFCFCF'
			,	'font': '12px sans-serif'
			,	'padding': '6px 10px 0'
			});
			if(options.openCallback && typeof(options.openCallback) == 'function') {
				options.openCallback(event, ui);
			}
		}
	}, options);
	return jQuery(element).dialog(options);
}
function selectTabMainGmp(id) {
	/*var index = jQuery('#gmpAdminOptionsTabs a[href="#'+ id+ '"]').parent().index();
	jQuery('#gmpAdminOptionsTabs').tabs('option', 'active', index);*/
	selectTab(id, 'gmpAdminOptionsTabs');
}
function selectTab(id, tabsElementId) {
	var tabsSelector = '#'+ tabsElementId
	,	index = jQuery(tabsSelector+ ' a[href="#'+ id+ '"]').parent().index();
	jQuery(tabsSelector).tabs('option', 'active', index);
}