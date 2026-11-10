function getURLVar(key) {
    var value = [];
    
    var query = String(document.location).split('?');
    
    if (query[1]) {
        var part = query[1].split('&');

        for (i = 0; i < part.length; i++) {
            var data = part[i].split('=');
            
            if (data[0] && data[1]) {
                value[data[0]] = data[1];
            }
        }
        
        if (value[key]) {
            return value[key];
        } else {
            return '';
        }
    }
} 

$(document).ready(function() {
	var route = getURLVar('route');
	
	if (!route) {
		$('#menu #home').addClass('active');
	} else {
		var part = route.split('/');
		var url = part[0];
		
		if (part[1]) {
			url += '/' + part[1];
		}
		
		$('#menu a[href]').filter(function() {
			var href = $(this).attr('href') || '';
			return href.indexOf('index.php?route=' + url) !== -1;
		}).parents('li[id]').addClass('active');
	}
});