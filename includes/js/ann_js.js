/**
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: ann_js.js 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
*/
var marqueeContent = anns_arr;   
                  	

var marqueeInterval = new Array();  

var marqueeId = 0;
var marqueeDelay = 3000;
var marqueeHeight = 18;
function initMarquee(){
	var str=marqueeContent[0];
	document.write('<div id=marqueeBox style="overflow:hidden;height:'+marqueeHeight+'px" onmouseover="clearInterval(marqueeInterval[0])" onmouseout="marqueeInterval[0]=setInterval(\'startMarquee()\',marqueeDelay)"><div>'+str+'</div></div>');
	marqueeId++;
	marqueeInterval[0]=setInterval("startMarquee()",marqueeDelay);
}

function startMarquee(){
	var str=marqueeContent[marqueeId];
	marqueeId++;
	if(marqueeId>=marqueeContent.length) marqueeId=0;
	if(getId('marqueeBox').childNodes.length==1) {
		var nextLine=document.createElement('DIV');
		nextLine.innerHTML=str;
		getId('marqueeBox').appendChild(nextLine);
	}else{
		getId('marqueeBox').childNodes[0].innerHTML=str;
		getId('marqueeBox').appendChild(getId('marqueeBox').childNodes[0]);
		getId('marqueeBox').scrollTop=0;
	}
	clearInterval(marqueeInterval[1]);
	marqueeInterval[1]=setInterval("scrollMarquee()",10);
}
function scrollMarquee(){
	getId('marqueeBox').scrollTop++;
	if(getId('marqueeBox').scrollTop%marqueeHeight==marqueeHeight){
		clearInterval(marqueeInterval[1]);
	}
}
initMarquee();
