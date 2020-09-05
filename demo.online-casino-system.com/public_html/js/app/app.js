app = angular.module('tp', ['ngSanitize', 'ipCookie', 'ui.bootstrap', 'ngAnimate', 'ngAside']);

var hostname = "http://localhost:8080/tp/public";
var objURL = new Object();
 
window.location.search.replace( 
	new RegExp( "([^?=&]+)(=([^&]*))?", "g" ),
				
	function( $0, $1, $2, $3 ){
		objURL[ $1 ] = $3;
	}
);