(function(B, undefined){
	//This function is super useful. Source: http://www.communitymx.com/content/article.cfm?cid=8C170
	var html5elmeents = "address|article|aside|audio|canvas|command|datalist|details|dialog|figure|figcaption|footer|header|hgroup|keygen|mark|meter|menu|nav|progress|ruby|section|time|video".split('|');
	for(var i = 0; i < html5elmeents.length; i++){
		document.createElement(html5elmeents[i]);
	}

	B('document').ready(function(){
		B('.vision-tabs-vertical').append('<div class="tl"></div><div class="t"></div><div class="tr"></div><div class="r"></div><div class="br"></div><div class="b"></div><div class="bl"></div><div class="l"></div>');
		B('.vision-tabs-vertical_arrow').css('left', parseInt(B('.vision-tabs-vertical_arrow').css('left')) + 3 + 'px');
	});
})(jQuery);