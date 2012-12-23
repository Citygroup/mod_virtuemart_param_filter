(function($){
	$(document).ready(function(){
		$('#category_filter input:checked').each(function(){
			$(this).parents(':hidden').toggle();
			$(this).closest('li').find('ul input[type=checkbox]').prop('checked',true)
		})
		$('#category_filter input').change(function(){
			var checked = $(this).prop('checked');
			$(this).closest('li').find('ul input[type=checkbox]').prop('checked',checked)
		});
		$('#category_filter a.next_depth').click(function(){
			$(this).siblings('ul').toggle();
			return false;
		});
		if($('.chosen').length > 0){
			$('.chosen').chosen({
				allow_single_deselect: true
			});
		}
		if($('#paramfilter div.sliderbox').length > 0){
			// if(!(('ui' in jQuery) && jQuery.ui && ('version' in jQuery.ui))){
				// $.getScript('https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js');
			// }
			// Single slider for handle and list values
			$('#paramfilter .slider-single-handle .slider-line,#paramfilter .slider-single-list .slider-line').prop('slide',null).each(function(){
				var parent = $(this).closest('.sliderbox')
				var max = parent.find('input').length - 1;
				var value = parent.find('input').index(parent.find('input:checked'));
				if(parent.find('input:checked').length == 1)
					parent.find('.slider-msg').html(parent.find('input:checked').siblings('span').text());
				$(this).empty().slider({
					range: false,
					min: 0,
					max: max,
					values: [value],
					slide: function( event, ui ) {
						var input = parent.find('input:eq('+ui.values[0]+')');
						parent.find('.slider-msg').html(input.siblings('span').text());
						parent.find('input').prop('checked',false)
						input.prop('checked',true);
					}
						
				});
			});
			// Double slider for handle int values
			$('#paramfilter .slider-double-handle .slider-line').prop('slide',null).each(function(){
				var parent = $(this).closest('.sliderbox')
				var min = parseFloat(parent.find('input.slider-range-gt').attr('rel'));
				var max = parseFloat(parent.find('input.slider-range-lt').attr('rel'));
				var value_1 = parent.find('input.slider-range-gt').val() == '' ? min : parent.find('input.slider-range-gt').val();
				var value_2 = parent.find('input.slider-range-lt').val() == '' ? max : parent.find('input.slider-range-lt').val();
				$(this).empty().slider({
					range: true,
					min: min,
					max: max,
					values: [value_1,value_2],
					slide: function( event, ui ) {
						parent.find('input.slider-range-gt').val(ui.values[0]);
						parent.find('input.slider-range-lt').val(ui.values[1]);
					}
				});
			});
			// Double slider for handle text and list values
			$('#paramfilter .slider-double-list .slider-line').prop('slide',null).each(function(){
				var parent = $(this).closest('.sliderbox')
				var max = parent.find('input').length - 1;
				var value_1 = parent.find('input').index(parent.find('input:checked:first'));
				var value_2 = parent.find('input').index(parent.find('input:checked:last'));
				value_1 = value_1==-1 ? 0 : value_1;
				value_2 = value_2==-1 ? max : value_2;
				parent.find('div.slider-range-gt').text(parent.find('input:eq('+value_1+')').siblings('span').text());
				parent.find('div.slider-range-lt').text(parent.find('input:eq('+value_2+')').siblings('span').text());
				$(this).empty().slider({
					range: true,
					min: 0,
					max: max,
					values: [value_1,value_2],
					slide: function( event, ui ) {
						parent.find('input').prop('checked',true)
						parent.find('input:lt('+ui.values[ 0 ]+')').prop('checked',false);
						parent.find('input:gt('+ui.values[ 1 ]+')').prop('checked',false);
						parent.find('div.slider-range-gt').text(parent.find('input:eq('+ui.values[0]+')').siblings('span').text());
						parent.find('div.slider-range-lt').text(parent.find('input:eq('+ui.values[1]+')').siblings('span').text());
					}
				});
			});
		}
		$('#paramfilter a.reset').click(function(){
			var values = $(this).parent().siblings('div.values');
			values.find('input[type=text]').val('');
			values.find('input[type=checkbox],input[type=radio]').prop('ckecked',false);
			values.find('select option:selected').prop('selected',false);
			values.find('select option:first').prop('selected',true);
			values.find('.slider-line').each(function(){
				$(this).slider('values',0,0);
			})
			return false;
		});
	})
})(jQuery)