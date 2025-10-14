"use strict";

// Initialize Basic Gmap
function initBasicGmap() {
	var map;
	$(document).ready(function () {
		map = new GMaps({
			el: "#basicGmap",
			lat: -12.043333,
			lng: -77.028333,
			zoomControl: true,
			zoomControlOpt: {
				style: "SMALL",
				position: "TOP_LEFT",
			},
			panControl: false,
			streetViewControl: false,
			mapTypeControl: false,
			overviewMapControl: false,
		});
	});
}

// Initialize Events Gmap
function initEventsGmap() {
	var map;
	$(document).ready(function () {
		map = new GMaps({
			el: "#eventsGmap",
			zoom: 16,
			lat: -12.043333,
			lng: -77.028333,
			click: function (e) {
				alert("click");
			},
			dragend: function (e) {
				alert("dragend");
			},
		});
	});
}

// Initialize Marker Gmap
function initMarkerGmap() {
	var map;
	$(document).ready(function () {
		map = new GMaps({
			el: "#markerGmap",
			lat: -12.043333,
			lng: -77.028333,
		});
		map.addMarker({
			lat: -12.043333,
			lng: -77.03,
			title: "Lima",
			details: {
				database_id: 42,
				author: "HPNeo",
			},
			click: function (e) {
				if (console.log) console.log(e);
				alert("You clicked in this marker");
			},
			mouseover: function (e) {
				if (console.log) console.log(e);
			},
		});
		map.addMarker({
			lat: -12.042,
			lng: -77.028333,
			title: "Marker with InfoWindow",
			infoWindow: {
				content: "<p>HTML Content</p>",
			},
		});
	});
}

// Initialize Geolocation Gmap
function initgeolocationGmap() {
	var map;
	$(document).ready(function () {
		map = new GMaps({
			el: "#geolocationGmap",
			lat: -12.043333,
			lng: -77.028333,
		});

		GMaps.geolocate({
			success: function (position) {
				map.setCenter(position.coords.latitude, position.coords.longitude);
			},
			error: function (error) {
				alert("Geolocation failed: " + error.message);
			},
			not_supported: function () {
				alert("Your browser does not support geolocation");
			},
			always: function () {
				alert("Done!");
			},
		});
	});
}

// Initialize Polylines Gmap
function initPolylinesGmap() {
	var map;
	$(document).ready(function () {
		map = new GMaps({
			el: "#polylinesGmap",
			lat: -12.043333,
			lng: -77.028333,
			click: function (e) {
				console.log(e);
			},
		});

		var path = [
			[-12.044012922866312, -77.02470665341184],
			[-12.05449279282314, -77.03024273281858],
			[-12.055122327623378, -77.03039293652341],
			[-12.075917129727586, -77.02764635449216],
			[-12.07635776902266, -77.02792530422971],
			[-12.076819390363665, -77.02893381481931],
			[-12.088527520066453, -77.0241058385925],
			[-12.090814532191756, -77.02271108990476],
		];

		map.drawPolyline({
			path: path,
			strokeColor: "#BBD8E9",
			strokeOpacity: 0.6,
			strokeWeight: 6,
		});
	});
}

// Initialize Overlays Gmap
function initOverlaysGmap() {
	var map;
	$(document).ready(function () {
		map = new GMaps({
			el: "#overlaysGmap",
			lat: -12.043333,
			lng: -77.028333,
		});
		map.drawOverlay({
			lat: map.getCenter().lat(),
			lng: map.getCenter().lng(),
			layer: "overlayLayer",
			content: '<div class="overlay">Lima<div class="overlay_arrow above"></div></div>',
			verticalAlign: "top",
			horizontalAlign: "center",
		});
	});
}

// Initialize Polygons Gmap
function initPolygonsGmap() {
	var map, path, paths;
	$(document).ready(function () {
		map = new GMaps({
			el: "#polygonsGmap",
			lat: -12.040397656836609,
			lng: -77.03373871559225,
			click: function (e) {
				console.log(e);
			},
		});

		paths = [
			[
				[
					[-105.00432014465332, 39.74732195489861],
					[-105.00715255737305, 39.7462000683517],
					[-105.00921249389647, 39.74468219277038],
					[-105.01067161560059, 39.74362625960105],
					[-105.01195907592773, 39.74290029616054],
					[-105.00989913940431, 39.74078835902781],
					[-105.00758171081543, 39.74059036160317],
					[-105.00346183776855, 39.74059036160317],
					[-105.00097274780272, 39.74059036160317],
					[-105.00062942504881, 39.74072235994946],
					[-105.00020027160645, 39.74191033368865],
					[-105.00071525573731, 39.74276830198601],
					[-105.00097274780272, 39.74369225589818],
					[-105.00097274780272, 39.74461619742136],
					[-105.00123023986816, 39.74534214278395],
					[-105.00183105468751, 39.74613407445653],
					[-105.00432014465332, 39.74732195489861],
				],
				[
					[-105.00361204147337, 39.74354376414072],
					[-105.00301122665405, 39.74278480127163],
					[-105.00221729278564, 39.74316428375108],
					[-105.00283956527711, 39.74390674342741],
					[-105.00361204147337, 39.74354376414072],
				],
			],
			[
				[
					[-105.00942707061768, 39.73989736613708],
					[-105.00942707061768, 39.73910536278566],
					[-105.00685214996338, 39.73923736397631],
					[-105.00384807586671, 39.73910536278566],
					[-105.00174522399902, 39.73903936209552],
					[-105.00041484832764, 39.73910536278566],
					[-105.00041484832764, 39.73979836621592],
					[-105.00535011291504, 39.73986436617916],
					[-105.00942707061768, 39.73989736613708],
				],
			],
		];

		path = [
			[-12.040397656836609, -77.03373871559225],
			[-12.040248585302038, -77.03993927003302],
			[-12.050047116528843, -77.02448169303511],
			[-12.044804866577001, -77.02154422636042],
		];

		map.drawPolygon({
			paths: paths,
			useGeoJSON: true,
			strokeColor: "#BBD8E9",
			strokeOpacity: 0.6,
			strokeWeight: 6,
			fillColor: "#BBD8E9",
		});

		map.drawPolygon({
			paths: path,
			strokeColor: "#BBD8E9",
			strokeOpacity: 0.6,
			strokeWeight: 6,
			fillColor: "#BBD8E9",
		});
	});
}

// Initialize Context Menu
function initContextMenuGmap() {
	var map;
	$(document).ready(function () {
		map = new GMaps({
			el: "#contextMenuGmap",
			lat: -12.043333,
			lng: -77.028333,
		});
		map.setContextMenu({
			control: "map",
			options: [
				{
					title: "Add marker",
					name: "add_marker",
					action: function (e) {
						console.log(e.latLng.lat());
						console.log(e.latLng.lng());
						this.addMarker({
							lat: e.latLng.lat(),
							lng: e.latLng.lng(),
							title: "New marker",
						});
						this.hideContextMenu();
					},
				},
				{
					title: "Center here",
					name: "center_here",
					action: function (e) {
						this.setCenter(e.latLng.lat(), e.latLng.lng());
					},
				},
			],
		});
		map.setContextMenu({
			control: "marker",
			options: [
				{
					title: "Center here",
					name: "center_here",
					action: function (e) {
						this.setCenter(e.latLng.lat(), e.latLng.lng());
					},
				},
			],
		});
	});
}

// Initialize Fusion Tables
function initFusionTablesGmap() {
	var map, infoWindow;
	$(document).ready(function () {
		infoWindow = new google.maps.InfoWindow({});
		map = new GMaps({
			el: "#fusionTablesGmap",
			zoom: 11,
			lat: 41.850033,
			lng: -87.6500523,
		});
		map.loadFromFusionTables({
			query: {
				select: "'Geocodable address'",
				from: "1mZ53Z70NsChnBMm-qEYmSDOvLXgrreLTkQUvvg",
			},
			suppressInfoWindows: true,
			events: {
				click: function (point) {
					infoWindow.setContent("You clicked here!");
					infoWindow.setPosition(point.latLng);
					infoWindow.open(map.map);
				},
			},
		});
	});
}

// Initialize KML Layers
function initKMLLayersGmap() {
	var map, infoWindow;
	$(document).ready(function () {
		infoWindow = new google.maps.InfoWindow({});
		map = new GMaps({
			el: "#kmlLayersGmap",
			zoom: 12,
			lat: 40.65,
			lng: -73.95,
		});
		map.loadFromKML({
			url: "http://api.flickr.com/services/feeds/geo/?g=322338@N20&lang=en-us&format=feed-georss",
			suppressInfoWindows: true,
			events: {
				click: function (point) {
					infoWindow.setContent(point.featureData.infoWindowHtml);
					infoWindow.setPosition(point.latLng);
					infoWindow.open(map.map);
				},
			},
		});
	});
}

// Initialize Map Types
function initMapTypesGmap() {
	var map;
	$(document).ready(function () {
		map = new GMaps({
			el: "#mapTypesGmap",
			lat: -12.043333,
			lng: -77.028333,
			mapTypeControlOptions: {
				mapTypeIds: ["hybrid", "roadmap", "satellite", "terrain", "osm", "cloudmade"],
			},
		});
		map.addMapType("osm", {
			getTileUrl: function (coord, zoom) {
				return "http://tile.openstreetmap.org/" + zoom + "/" + coord.x + "/" + coord.y + ".png";
			},
			tileSize: new google.maps.Size(256, 256),
			name: "OpenStreetMap",
			maxZoom: 18,
		});
		map.addMapType("cloudmade", {
			getTileUrl: function (coord, zoom) {
				return "http://b.tile.cloudmade.com/8ee2a50541944fb9bcedded5165f09d9/1/256/" + zoom + "/" + coord.x + "/" + coord.y + ".png";
			},
			tileSize: new google.maps.Size(256, 256),
			name: "CloudMade",
			maxZoom: 18,
		});
		map.setMapTypeId("osm");
	});
}

// Initialize Panoramas Gmap
function initPanoramasGmap() {
	var panorama;
	$(document).ready(function () {
		panorama = GMaps.createPanorama({
			el: "#panoramasGmap",
			lat: 42.3455,
			lng: -71.0983,
		});
	});
}

//Public method to initialize all charts
(function () {
	initBasicGmap();
	initEventsGmap();
	initMarkerGmap();
	initgeolocationGmap();
	initPolylinesGmap();
	initOverlaysGmap();
	initPolygonsGmap();
	initContextMenuGmap();
	initFusionTablesGmap();
	initKMLLayersGmap();
	initMapTypesGmap();
	initPanoramasGmap();
})();
