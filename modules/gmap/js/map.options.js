function getInfoWindow(title, content, markerItem, mapParams) {
	if(markerItem && parseInt(markerItem.params.title_is_link) && markerItem.params.marker_title_link) {
		title = '<a href="'+ markerItem.params.marker_title_link+ '" target="_blank" class="gmpInfoWIndowTitleLink">'+ title+ '</a>'
	}

	if(parseInt(markerItem.params.more_info_link) && content && content != '') {
		var previewContent = gmpGetPreviewContent(content)
		,	contentShell = jQuery('<div class="gmpMarkerDescShell"/>')
		,	previewHtmlObj = jQuery('<div />').addClass('gmpPreviewContent').html( previewContent )
		,	fullHtmlObj = jQuery('<div />').addClass('gmpFullContent').html( content )
		,	moreInfoButt = jQuery('<a href="#" onclick="gmpToggleInfowndMoreInfoClickButt(this); return false;"/>').html(toeLangGmp('More Info')).addClass('gmpMarkerMoreInfoButt');
		
		contentShell.append(previewHtmlObj).append(fullHtmlObj).append(moreInfoButt);
		content = contentShell.get(0).outerHTML;
	}
	var text = '<div class="gmpMarkerInfoWindow">';
	text += '<div class="gmpInfoWindowtitle">'+ title;
	text += '</div>';
	text += '<div class="gmpInfoWindowContent">'+ content;
	text += '</div></div>';
	if(typeof(gmpAddMarkerAdditionalLinks) === 'function') {
		text = gmpAddMarkerAdditionalLinks(text, title, content, markerItem, mapParams);
	}
	var infoWindow = new google.maps.InfoWindow({
		content: text
	});
	return infoWindow;
}
function gmpGetPreviewContent(content) {
	var tmpDiv = jQuery('<div />').html(content);
	if(tmpDiv.find('img').size()) {
		return tmpDiv.find('img:first').get(0).outerHTML;
	} else {
		return jQuery('<span />').html(content.substring(0, 30)+ ' ...').get(0).outerHTML;
	}
}
function gmpToggleInfowndMoreInfoClickButt(link) {
	var contentShell = jQuery(link).parents('.gmpMarkerDescShell:first');
	if(contentShell.find('.gmpPreviewContent').is(':visible')) {
		contentShell.find('.gmpPreviewContent').hide(100);
		contentShell.find('.gmpFullContent').show(100);
	} else {
		contentShell.find('.gmpFullContent').hide(100);
		contentShell.find('.gmpPreviewContent').show(100);
	}
}
var gmapPreview = {
	maps: []
,	mapObjects: []
,	mapItemsContainer: {}
,	prepareToDraw: function(mapId) {
	   if(typeof(mapId) == 'undefined'){
		   return false;
	   }
	   var currentMap = gmapPreview.maps[mapId].mapParams;
	   if(currentMap.params.map_display_mode == 'popup') {
			jQuery('#show_map_icon.map_num_'+ mapId).click(function(){
				var map_id = jQuery(this).attr('data_val');
				jQuery('#mapConElem_'+ mapId+ '.display_as_popup').bPopup();
				gmapPreview.drawMap(currentMap);
			});
		} else if(currentMap.params.map_display_mode == 'map') {
			this.drawMap(currentMap);
		}
	}
,	drawMap: function(mapForPreview) {
		if(typeof(mapForPreview) == 'undefined') {
			return false;
		}
		var mapElemId = 'ready_google_map_'+ mapForPreview.id
		,	lat = 44.5234475708		// default coords
		,	lng = 40.1879714881;	// default coords
		if(typeof(mapForPreview.params.map_center) != 'undefined') {
			lat = mapForPreview.params.map_center.coord_y;
			lng = mapForPreview.params.map_center.coord_x;
		} else if(mapForPreview.markers.length > 0) {
			lat = mapForPreview.markers[0].coord_y;
			lng = mapForPreview.markers[0].coord_x;
		}
		
		var mapCenter = new google.maps.LatLng(lat,lng);

		var mapOptions = {
			center: mapCenter
		,	zoom: parseInt(mapForPreview.params.zoom)
		,	scrollwheel: false	//mouse disable
		,	draggable: false	//drag map
		,	zoomControl: Boolean(parseInt(mapForPreview.params.enable_zoom))
		,	disableDoubleClickZoom: true
		};
		if(mapForPreview.params.enable_mouse_zoom == 1) {
			mapOptions.disableDoubleClickZoom = false;
			mapOptions.scrollwheel = true;
			mapOptions.draggable = true;
		}
		
		mapOptions.mapTypeId= google.maps.MapTypeId[mapForPreview.params.type];

		var map = new google.maps.Map(document.getElementById(mapElemId),mapOptions);
		this.maps[mapForPreview.id].mapObject = map;

		if(mapForPreview.markers.length > 0) {
			this.drawMarkers(mapForPreview.markers,mapForPreview.id);	  
		}
		google.maps.event.addListenerOnce(this.maps[mapForPreview.id].mapObject, 'tilesloaded', function(){
			gmpAddLicenzeBlock(mapElemId);
		});	
		delete map;
	}
,	drawMarkers: function(markerList, mapId) {
		for(var i in markerList){
			this.createMarker(markerList[i], mapId);
		}
	}
,	createMarker: function(markerItem, mapId) {
		var iconUrl = GMP_DATA.imgPath+ 'markers/marker_1.png'; // default icon
		if(markerItem.icon_data != undefined && markerItem.icon_data.path != undefined) {
			iconUrl = markerItem.icon_data.path;
		}
		var markerIcon = {
			url: iconUrl
		,	origin: new google.maps.Point(0,0)
		};
		var markerLatLng = new google.maps.LatLng(markerItem.coord_y, markerItem.coord_x)
		,	animType = 2;
		if(markerItem.animation == 1) {
			animType = 1;
		}
		this.maps[mapId].markerArr[markerItem.id] = new google.maps.Marker({
			position: markerLatLng
		,	title: markerItem.title
		,	description: markerItem.description
		,	icon: markerIcon
		,	draggable: false
		,	map: gmapPreview.maps[mapId].mapObject
		,	animation: animType
		,	address: markerItem.address
		,	id: markerItem.id
		});
		/*console.log(markerItem);
		if(parseInt(params.title_is_link) && params.marker_title_link){
			markerItem.titleLink = {
				linkEnabled: false
			};
		}*/
		//console.log(this.maps[mapId].markerArr[markerItem.id]);
		var infoWindow = getInfoWindow(markerItem.title, markerItem.description, markerItem, this.maps[mapId].mapParams);
		google.maps.event.addListener(this.maps[mapId].markerArr[markerItem.id], 'click', function(){
			for(var i in gmapPreview.maps[mapId].infoWindows) {
				gmapPreview.maps[mapId].infoWindows[i].close();
			}
			infoWindow.open(gmapPreview.maps[mapId].mapObject, gmapPreview.maps[mapId].markerArr[markerItem.id]);
			toggleBounce(gmapPreview.maps[mapId].markerArr[markerItem.id], animType);
		});
		this.maps[mapId].infoWindows[markerItem.id] = infoWindow;
	}
};

function closePopup(){
	jQuery('.display_as_popup').bPopup().close();	
}
jQuery(document).ready(function(){
	if(typeof(gmpAllMapsInfo) != 'undefined') {
		for(var i in gmpAllMapsInfo){
			var map_id = gmpAllMapsInfo[i].id;
			gmapPreview.maps[map_id] = {
				mapObject: {}
			,	markerArr: {}
			,	infoWindows: {}
			,	mapParams: gmpAllMapsInfo[i]
			};
			gmapPreview.prepareToDraw(map_id);
		}         
	}
});