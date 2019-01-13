$(document).ready(function(){
	$('.see').on('click', function(){
		var name = $(this).data('name');
		var description = $(this).data('description');

		$('#modalDescription .modal-name-activity').html(name);
		$('#modalDescription .modal-body').html(description);
	});
	$('#form-activity input').on('focusout', function(){
		var _self = this;
		var dateObj1 = new Date($('#begin_date').val());
		var dateObj2 = new Date($('#final_date').val());

		if(dateObj1.getTime() > dateObj2.getTime()){
			$(_self).css({color: 'red', borderColor: 'red'});
			$(_self).focus();
			$(_self).next().css('display', 'block').addClass('active');
		} else {
			$(_self).css({color: '#555', borderColor: '#ccc'});
			$(_self).next().css('display', 'none').removeClass('active');
		}
	});
	$('#form-activity').submit(function(e){
		if($(this).find('.info-data').hasClass('active')){
			e.preventDefault();
		} else {
			$('#form-activity').submit()
		}

	});

})
