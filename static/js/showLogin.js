/* http://www.malsup.com/jquery/block/#overview
 *
 */
//$.blockUI.defaults.css.border = '0px'; //убираем серую границу
$.blockUI.defaults.fadeIn = 100;  //ускоряем появление
$.blockUI.defaults.fadeOut = 100; //и исчезновение
$.blockUI.defaults.css.left = '40%'; //окно будет почти в центре

$(document).ready(function() {
	//По этим кнопкам модальное окно закрывается
	$('.rotes_kreuz, .close_dialog').click(function() {
		$.unblockUI();
		return false;
	});
 
	//Эта кнопка будет вызывать наше окно
	$('#login_a').click(function() {
		$.blockUI({message: $('#modal_dialog'), css: {width: '282px'}});
	});
 
	//Да
	$('#modal_dialog #yes').click(function() {
		$('#modal_dialog form').submit();
	});
});