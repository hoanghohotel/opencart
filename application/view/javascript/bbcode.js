// JavaScript Document
(function($) {
	$.fn.bbcode = function(option) {
		return this.each(function() {
			var element = this;
				
			html  = '<div class="bbcode">';
			html += '  <div class="bbcode-toolbar">';
			html += '    <button type="button" data-event="preview" data-toggle="tooltip" title="Preview" class="btn btn-default"><i class="fa fa-eye"></i></button>';
			html += '    <div class="btn-group">';
			html += '      <button type="button" data-event="bold" data-toggle="tooltip" title="Bold" class="btn btn-default"><i class="fa fa-bold"></i></button>';
			html += '      <button type="button" data-event="italic" data-toggle="tooltip" title="Italic" class="btn btn-default"><i class="fa fa-italic"></i></button>';
			html += '      <button type="button" data-event="underline" data-toggle="tooltip" title="Underline" class="btn btn-default"><i class="fa fa-underline"></i></button>';
			html += '      <button type="button" data-event="blockquote" data-toggle="tooltip" title="Quote" class="btn btn-default"><i class="fa fa-quote-left"></i></button>';
			html += '      <button type="button" data-event="code" data-toggle="tooltip" title="Code" class="btn btn-default"><i class="fa fa-code"></i></button>';
			html += '      <button type="button" data-event="strikethrough" data-toggle="tooltip" title="Strikethrough" class="btn btn-default"><i class="fa fa-strikethrough"></i></button>';
			html += '    </div>';
			html += '    <div class="btn-group">';
			html += '      <button type="button" data-event="size" data-toggle="tooltip" title="Font Size" data-size="100" class="btn btn-default"><i class="fa fa-text-height"></i></button>';
			html += '      <button type="button" data-event="sizepicker" data-toggle="dropdown" class="btn btn-default dropdown-toggle"><i class="caret"></i></button>';
			html += '      <ul class="dropdown-menu">';
			html += '        <li><a href="50" style="font-size: 50%;">Tiny</a><li>';
			html += '        <li><a href="85" style="font-size: 85%;">Small</a><li>';
			html += '        <li><a href="100" style="font-size: 100%;">Normal</a><li>';
			html += '        <li><a href="150" style="font-size: 150%;">Large</a><li>';
			html += '        <li><a href="200" style="font-size: 200%;">Huge</a><li>';
			html += '      </ul>';
			html += '    </div>';
			html += '    <div class="btn-group">';
			html += '      <button type="button" data-event="color" data-toggle="tooltip" title="Font Color" data-color="#AA3399" class="btn btn-default"><i class="fa fa-square"></i></button>';
			html += '      <button type="button" data-event="colorpicker" class="btn btn-default dropdown-toggle"><i class="caret"></i></button>';
			html += '    </div>';
			html += '    <div class="btn-group">';
			html += '      <button type="button" data-event="list-ul" data-toggle="tooltip" title="Unordered List" class="btn btn-default"><i class="fa fa-list-ul"></i></button>';
			html += '      <button type="button" data-event="list-ol" data-toggle="tooltip" title="Ordered List" class="btn btn-default"><i class="fa fa-list-ol"></i></button>';
			html += '      <button type="button" data-event="list-li" data-toggle="tooltip" title="List Item" class="btn btn-default"><i class="fa fa-list"></i></button>';
			html += '    </div>';
			html += '    <button type="button" data-event="image" data-toggle="tooltip" title="Insert Image" class="btn btn-default"><i class="fa fa-camera"></i></button>';
			html += '    <button type="button" data-event="link" data-toggle="tooltip" title="Insert Link" class="btn btn-default"><i class="fa fa-link"></i></button>';
			html += '    <button type="button" data-event="youtube" data-toggle="tooltip" title="Insert YouTube Video" class="btn btn-default"><i class="fa fa-youtube-play"></i></button>';
			html += '  </div>';
			html += '  <br />';
			html += '  <div class="bbcode-preview form-control" style="display: none; overflow-y: scroll;"></div>';
			html += '</div>';		

			$(element).wrap('<div class="bbcode-editor"><div class="bbcode"/></div>');

			$(element).parent().prepend(html);

			// Preview
			$(this).parent().parent().find('button[data-event="preview"]').on('click', function() {
				if (!$(this).hasClass('active')) {
					var escapeHtml = function(str) {
						return String(str)
							.replace(/&/g, '&amp;')
							.replace(/</g, '&lt;')
							.replace(/>/g, '&gt;')
							.replace(/"/g, '&quot;')
							.replace(/'/g, '&#39;');
					};

					var sanitizeUrl = function(rawUrl) {
						var u = String(rawUrl || '').trim();
						if (/^(https?:\/\/|\/|image\/|application\/)/i.test(u)) {
							return u;
						}
						return '#';
					};

					var bbcode = escapeHtml($(element).val());

					// Bold, Italic, Underlined, Quote, Code, Strikethrough
					bbcode = bbcode.replace(/\[b\]([\s\S]+?)\[\/b\]/gi, '<strong>$1</strong>');
					bbcode = bbcode.replace(/\[i\]([\s\S]+?)\[\/i\]/gi, '<em>$1</em>');
					bbcode = bbcode.replace(/\[u\]([\s\S]+?)\[\/u\]/gi, '<u>$1</u>');
					bbcode = bbcode.replace(/\[quote\]([\s\S]+?)\[\/quote\]/gi, '<blockquote>$1</blockquote>');
					bbcode = bbcode.replace(/\[code\]([\s\S]+?)\[\/code\]/gi, '<code>$1</code>');
					bbcode = bbcode.replace(/\[s\]([\s\S]+?)\[\/s\]/gi, '<s>$1</s>');

					// Linear non-backtracking List Item & Lists
					bbcode = bbcode.replace(/\[\*\]([^\r\n\[]*)/g, '<li>$1</li>');
					bbcode = bbcode.replace(/\[list\]([\s\S]+?)\[\/list\]/gi, '<ul>$1</ul>');
					bbcode = bbcode.replace(/\[list=(1|A|a|I|i)\]([\s\S]+?)\[\/list\]/gi, '<ol type="$1">$2</ol>');

					// Safe Image & URL protocols only
					bbcode = bbcode.replace(/\[img\]([^\[]*?)\[\/img\]/gi, function(_, src) {
						return '<img src="' + sanitizeUrl(src) + '" alt="" />';
					});
					bbcode = bbcode.replace(/\[url\]([^\[]+?)\[\/url\]/gi, function(_, href) {
						var safe = sanitizeUrl(href);
						return '<a href="' + safe + '" rel="nofollow noopener noreferrer">' + href + '</a>';
					});
					bbcode = bbcode.replace(/\[url=([^\]]+?)\]([\s\S]+?)\[\/url\]/gi, function(_, href, label) {
						return '<a href="' + sanitizeUrl(href) + '" rel="nofollow noopener noreferrer">' + label + '</a>';
					});

					// Font Size & Font Color
					bbcode = bbcode.replace(/\[size=([+-]?\d{1,3})\]([\s\S]+?)\[\/size\]/gi, '<span style="font-size: $1%;">$2</span>');
					bbcode = bbcode.replace(/\[color=(#[0-9a-f]{3}|#[0-9a-f]{6}|[a-z-]+)\]([\s\S]+?)\[\/color\]/gi, '<span style="color: $1;">$2</span>');

					// Safe HTTPS YouTube Embed ID only
					bbcode = bbcode.replace(/\[youtube\]([a-zA-Z0-9_-]{6,20})\[\/youtube\]/gi, '<iframe width="560" height="315" src="https://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>');

					// Line Break
					bbcode = bbcode.replace(/\r\n|\r|\n/g, '<br />');

					$(element).parent().parent().find('.bbcode-preview').html(bbcode);
				
					$(this).addClass('active');
					
					$(element).parent().parent().find('.bbcode-preview').height($(element).height());
					
					$(element).parent().parent().find('.bbcode-preview').show();
					
					$(element).parent().parent().find('.bbcode-editor').hide();
					
					$(element).parent().parent().find('.bbcode-toolbar button').not('button[data-event="preview"]').prop('disabled', true);
				} else {
					$(this).removeClass('active');
					
					$(element).parent().parent().find('.bbcode-preview').hide();
					
					$(element).parent().parent().find('.bbcode-editor').show();
					
					$(element).parent().parent().find('.bbcode-toolbar button').not('button[data-event="preview"]').prop('disabled', false);
				}
			});
			
			this.insert = function(start, end) {
				element.focus();
				
				var selection_start = element.selectionStart;
				var selection_end = element.selectionEnd;
				
				element.value = element.value.substring(0, element.selectionStart) + start + element.value.substring(element.selectionStart, element.selectionEnd) + end + element.value.substring(element.selectionEnd, element.value.length);
				
				element.selectionStart = selection_end + (start.length + end.length);
				element.selectionEnd = selection_end + (start.length + end.length);
			}
					
			// Bold
			$(this).parent().parent().find('button[data-event="bold"]').on('click', function() {
				element.insert('[b]', '[/b]');
			});
			
			// Italic		
			$(this).parent().parent().find('button[data-event="italic"]').on('click', function() {
				element.insert('[i]', '[/i]');
			});			
			
			// Underline
			$(this).parent().parent().find('button[data-event="underline"]').on('click', function() {
				element.insert('[u]', '[/u]');
			});		
			
			// Quote
			$(this).parent().parent().find('button[data-event="blockquote"]').on('click', function() {
				element.insert('[quote]', '[/quote]');
			});	
			
			// Code	
			$(this).parent().parent().find('button[data-event="code"]').on('click', function() {
				element.insert('[code]', '[/code]');
			});	
							
			// Strikethrough
			$(this).parent().parent().find('button[data-event="strikethrough"]').on('click', function() {
				element.insert('[s]', '[/s]');
			});	
					
			// List
			$(this).parent().parent().find('button[data-event="list-ul"]').on('click', function() {
				element.insert('[list]', '[/list]');
			});						
			
			// Ordered List
			$(this).parent().parent().find('button[data-event="list-ol"]').on('click', function() {
				element.insert('[list=1]', '[/list]');
			});	
			
			// List Item
			$(this).parent().parent().find('button[data-event="list-li"]').on('click', function() {
				element.insert('[*]', '');
			});
			
			// Image
			$(this).parent().parent().find('button[data-event="image"]').on('click', function() {
				var node = this;
				
				$('#form-upload').remove();
				
				$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="image" value="" /></form>');
			
				$('#form-upload input[name="image"]').trigger('click');
				
				if (typeof timer != 'undefined') {
					clearInterval(timer);
				}
				
				timer = setInterval(function() {
					if ($('#form-upload input[name="image"]').val() != '') {
						clearInterval(timer);		
						
						$.ajax({
							url: 'index.php?route=common/image&member_token=' + encodeURIComponent(getURLVar('member_token')),
							type: 'post',		
							dataType: 'json',
							data: new FormData($('#form-upload')[0]),
							cache: false,
							contentType: false,
							processData: false,		
							beforeSend: function() {
								$(node).css({opacity: 1});
								$(node).find('i').removeClass('fa-camera');
								$(node).find('i').addClass('fa-circle-o-notch fa-spin');
							},
							complete: function() {
								$(node).css({opacity: ''});
								$(node).find('i').removeClass('fa-circle-o-notch fa-spin');
								$(node).find('i').addClass('fa-camera');
							},	
							success: function(json) {
								if (json['error']) {
									alert(json['error']);
								}
								
								if (json['image']) {
									element.insert('[img]' + json['image'], '[/img]');
								}
							},			
							error: function(xhr, ajaxOptions, thrownError) {
								alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
							}
						});
					}
				}, 500);	
			});
			
			// URL
			$(this).parent().parent().find('button[data-event="link"]').on('click', function() {
				param = prompt('Enter URL', 'http://');
				
				if (param) {
					element.insert('[url=' + param + ']', '[/url]');
				} else {
					element.insert('[url]', '[/url]');	
				}
			});
			
			// Font Size
			$(this).parent().parent().find('button[data-event="sizepicker"]').parent().find('li a').on('click', function(e) {
				e.preventDefault();
				
				$('button[data-event="size"]').attr('data-size', $(this).attr('href'));
			});	
						
			$(this).parent().parent().find('button[data-event="size"]').on('click', function(e) {
				element.insert('[size=' + $(this).attr('data-size') + ']', '[/size]');
			});

			// Font Color
			$(this).parent().parent().find('button[data-event="colorpicker"]').colorpicker().on('changeColor', function(e) {
				$('button[data-event="color"]').attr('data-color', $(this).colorpicker('getValue'));
				$('button[data-event="color"]').css({'color': $(this).colorpicker('getValue')});
			});				
			
			$(this).parent().parent().find('button[data-event="color"]').on('click', function() {
				element.insert('[color=' + $(this).parent().find('button[data-event="colorpicker"]').colorpicker('getValue') + ']', '[/color]');
			});	
		
			// Youtube
			$(this).parent().parent().find('button[data-event="youtube"]').on('click', function() {
				element.insert('[youtube]', '[/youtube]');
			});	
		});
	}
})(window.jQuery);