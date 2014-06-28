var gmpGeocoder;
function gmpGetGeocoder() {
	if(!gmpGeocoder) {
		gmpGeocoder = new google.maps.Geocoder();
	}
	return gmpGeocoder;
}
function getInfoWindow(title, content, markerItem, mapParams) {
	if(markerItem && parseInt(markerItem.params.title_is_link) && markerItem.params.marker_title_link) {
		title = '<a href="'+ markerItem.params.marker_title_link+ '" target="_blank" class="gmpInfoWIndowTitleLink">'+ title+ '</a>'
	}

	if(parseInt(markerItem.params.more_info_link) && content && content != '') {
		content = gmpContentPrevFull(content);
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
function gmpContentPrevFull(content, params) {
	params = params || {};
	var previewContent = gmpGetPreviewContent(content)
	,	contentShell = jQuery('<div class="gmpMarkerDescShell"/>')
	,	previewHtmlObj = jQuery('<div />').addClass('gmpPreviewContent').html( previewContent )
	,	fullHtmlObj = jQuery('<div />').addClass('gmpFullContent').html( content )
	,	moreInfoButt = jQuery('<a href="#" onclick="gmpToggleInfowndMoreInfoClickButt(this); return false;"/>').html(toeLangGmp('Read more')).addClass('gmpMarkerMoreInfoButt');

	contentShell.append(previewHtmlObj).append(fullHtmlObj);
	if(!params.withoutMoreLink)
		contentShell.append(moreInfoButt);
	content = contentShell.get(0).outerHTML;
	return content;
}
function gmpGetPreviewContent(content) {
	var tmpDiv = jQuery('<div />').html(content);
	if(tmpDiv.find('img').size()) {
		return tmpDiv.find('img:first').get(0).outerHTML;
	} else if(content && content != '') {
		return jQuery('<span />').html(content.substring(0, 30)+ ' ...').get(0).outerHTML;
	}
	return content;
}
function gmpToggleInfowndMoreInfoClickButt(link) {
	var contentShell = jQuery(link).parents('.gmpMarkerDescShell:first');
	if(contentShell.find('.gmpPreviewContent').is(':visible')) {
		contentShell.find('.gmpPreviewContent').hide(100);
		contentShell.find('.gmpFullContent').show(100, function(){
			var infoWnd = contentShell.parents('.gmpMarkerInfoWindow:first');
			// If infoWnd have scroll - move more link to the left
			if(infoWnd.get(0).scrollHeight > infoWnd.height()) {
				jQuery(link).css({
					'right': '30px'
				});
			}
		});
		jQuery(link).html(toeLangGmp('Hide'));
	} else {
		contentShell.find('.gmpFullContent').hide(100);
		contentShell.find('.gmpPreviewContent').show(100);
		jQuery(link).css({
			'right': '0px'
		}).html(toeLangGmp('Read more'));
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
,	getMapById: function(id) {
		for(var i in gmapPreview.maps) {
			if(gmapPreview.maps[i].mapParams.id == id)
				return gmapPreview.maps[i];
		}
		console.log('CAN NOT FIND MAP BY ID', id, '!!!');
		return false;
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
		
		mapOptions.mapTypeId = google.maps.MapTypeId[mapForPreview.params.type];

		if(typeof(gmpCmcPrepareMapOptions) !== 'undefined') {
			mapOptions = gmpCmcPrepareMapOptions(mapOptions, mapForPreview);
		}
		var map = new google.maps.Map(document.getElementById(mapElemId), mapOptions);
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
		var markerIcon;
		if(parseInt(markerItem.params.icon_fit_standard_size)) {
			markerIcon = new google.maps.MarkerImage(iconUrl, null, null, null, new google.maps.Size(18, 30));
		} else {
			markerIcon = {
				url: iconUrl
			,	origin: new google.maps.Point(0,0)
			};
			console.log(iconUrl);
		}

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
			if(typeof(gmpGoToMarkerInList) === 'function') {
				gmpGoToMarkerInList(gmapPreview.maps[mapId].mapParams, gmapPreview.maps[mapId].markerArr[markerItem.id]);
			}
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
/**
 * Convert angel - to radians
 * @param {number} a angel to convert
 * @return {number} angel in Rad
 */
function gmpToRad(a) {
	return a * Math.PI / 180;
}
/**
 * Get distance, in meter, betweent two point positions
 * @param {object} p1 google maps API position of first point
 * @param {object} p2 google maps API position of second point
 * @return {number} distance in meter
 */
function gmpGetDistance(p1, p2) {
	var R = 6378137; // Earth’s mean radius in meter
	var dLat = gmpToRad(p2.lat() - p1.lat());
	var dLong = gmpToRad(p2.lng() - p1.lng());
	var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
		Math.cos(gmpToRad(p1.lat())) * Math.cos(gmpToRad(p2.lat())) *
		Math.sin(dLong / 2) * Math.sin(dLong / 2);
	var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
	var d = R * c;
	return d; // returns the distance in meter
}
function gmpM2Km(d) {
	return d / 1000;
}
function gmpKm2M(d) {
	return d * 1000;
}
