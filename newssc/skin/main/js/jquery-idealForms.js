/*
 * Ideal Forms
 * by Cedric Ruiz 
 * elclanrs@gmail.com
 * www.jqidealforms.com
 *
 * Version 0.72
*/
(function ($) {
    $.fn.idealForms = function () {
        var form = this;
		
		
        /* Button 
		
		***************************************************************/
		
        form.find(':button, :submit').each(function () {
            var button = $(this),
                title = button.val(),
                id = button.attr('id');
            button.hide().after('<a href="#" class="button" id="' + id + '">' + title + '</a>').next('a').click(function (e) {
                e.preventDefault();
				e.stopPropagation();
				$(this).focus();
                button.trigger('click');
            });
        });
		
		
        /* Radio and Check 
		
		***************************************************************/
		
        form.find('input:checkbox, input:radio').each(function () {
		
            var input = $(this),
                name = input.attr('name');
				
            input
				.css({'position': 'absolute', 'margin-left': '-9999px'})
				.after('<span>&nbsp;</span>').parents('p').attr('id', name);
				
            var span = input.next('span');
			
            if (input.is(':checked')) {
                span.addClass('selected');
            }
			
            if (input.val() !== '') {
                input.attr('value', input.parent().text());
            }

            input.click(function () {
				input.focus();
                if (input.is(':checkbox')) {
                    span.toggleClass('selected');
                }
                if (input.is(':radio')) {
                    $('input[name="' + name + '"]').next('span').removeClass('selected');
                    span.addClass('selected');
                }
				
                // IE checkmark fix
                if ($.browser.msie) {
                    if (input.is(':checkbox')) {
                        if (input.is(':checked')) {
                            span.append('<em>|</em>');
                        } else {
                            span.children().remove();
                        }
                    }
                }
                /////////////////////////////////
				
            });
        });
		
		
        /* Select 
		
		***************************************************************/
		
        form.find('select').each(function () {
		
			var select = $(this);
			
			select.css({'position': 'absolute', 'margin-left': '-9999px'}); // Hide original select menu
			
			var SelectMenu = { // Original select menu
				
				id: select.attr('id'),
				title: select.attr('title'),	
				items: select.find('option'),
				itemsHtml: function(){
					var items = '';
					select.children('option').each(function(){
						var item = $(this).text();
						if ($(this).val() !== '') {
							$(this).attr('value', item);
						}
						items += '<li>' + item + '</li>';
					});
					return items;
				}
				
			};
			
			(function(){ // Create Ideal Select menu
				var html =
					'<ul class="idealSelect" id="' + SelectMenu.id + '">' + 
					'<div>' + '<span></span>' + '<li>' + SelectMenu.title + '</li>' + '</div>' + 
					'<ul>' + SelectMenu.itemsHtml() + '</ul>' + 
					'</ul>';
				select.after(html);
			}());
						
			var IdealSelect = function(){ // Ideal Select menu
				
				this.menu = select.next('ul');
				this.header = this.menu.children('div');
				this.headerTitle = this.header.children('li');
				this.headerArrow = this.header.children('span');
                this.dropDown =  this.menu.find('ul');
                this.items = this.dropDown.find('li');
				this.setHeight = function(){ /* Set height to fix Firefox annoying hover bug */
					var height = this.header.height();
					this.menu.css('height', height);
				};
				this.setWidth = function(){
					var maxWidth = 0;
					this.items.each(function(){
						$(this).css('fontWeight', 'bold');
						var currentWidth = $(this).width();
						if (currentWidth > maxWidth) { maxWidth = currentWidth; }
						$(this).css('fontWeight', 'normal');
					});
					//Set select width
					var itemPadding = this.items.css('padding-left').replace('px', '');
					maxWidth += (itemPadding * 2);
					this.headerTitle.width(maxWidth);		
					this.items.width(maxWidth);
					this.dropDown.width(maxWidth + (itemPadding * 2)); // For scrollbar
					// Set arrow position
					var headerHeight = this.header.outerHeight();
					var arrowHeight = form.css('font-size').replace('px', '');					
					this.headerArrow.css({
						'left': (maxWidth) + 'px',
						'top': ((headerHeight-(arrowHeight/2))/2) + 'px'
					});

				};				
				this.show = function(){
					select.focus();
					this.menu.addClass('menuOpen');
					this.dropDown.css('visibility', 'visible');
				};
				this.hide = function(){
					this.menu.removeClass('menuOpen');
					this.dropDown.css('visibility', 'hidden');
				};
				this.change = function(index, title){
					select.focus();
					this.headerTitle.text(title);
					SelectMenu.items
						.removeAttr('selected')
						.eq(index).attr('selected', true);
				};	
				this.next = function(){
					var title = select.find(':selected').val();
					this.headerTitle.text(title);
				};			
			};

			var idealSelect = new IdealSelect();
			idealSelect.setHeight();
			idealSelect.setWidth();
						
			// Actions
			
			idealSelect.header.click(function(){ idealSelect.show(); }); // Open menu
			idealSelect.menu.hover(function(){}, function(){ idealSelect.hide(); }); // Hide menu
			idealSelect.items.click(function(){ // Change option
				var index = $(this).index();
				var title = $(this).text();
				idealSelect.change(index, title);
				idealSelect.hide();
			});
					
			select
				.focus(function(){
					idealSelect.menu.addClass('focused');
				})
				.blur(function(){
					idealSelect.menu.removeClass('focused');
				});
			
			select.keyup(function(e){ // Keyboard arrows change
				if (e.keyCode === 40 || e.keyCode === 38) {
					idealSelect.next();
				}			
			});			
			
            // IE z-index fix
			
            var zIndexNumber = 1000;
            $('ul').each(function () {
                $(this).css('zIndex', zIndexNumber);
                zIndexNumber -= 10;
            });
            /////////////////////////////////////////////////////////////	

			
        });
    };
})(jQuery);