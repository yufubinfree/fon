// ==UserScript==
// @name         Faster
// @version      0.1
// @description  Faster!!!
// @author       FON
// @include      http://*
// @include      https://*
// @require      http://apps.bdimg.com/libs/keymaster/1.6.1/keymaster.min.js
// ==/UserScript==

(function() {
    'use strict';

    key('ctrl+alt+b', function(){
	   window.open("http://www.baidu.com");
	});

    key('ctrl+alt+t', function(){
	   window.open("http://tools.dealmoon.com/?r=tools/index");
	});

	key('ctrl+alt+/', function(){
	   var msg = '使用说明';
	   msg += "ctrl+alt+b : 打开百度\n";

	   alert(msg);
	});	
})();