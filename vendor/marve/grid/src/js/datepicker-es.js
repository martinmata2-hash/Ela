/* Written by Keith Wood (kbwood{at}iinet.com.au),
			  StÃ©phane Nahmani (sholby@sholby.net),
			  StÃ©phane Raimbault <stephane.raimbault@gmail.com> */
(function(factory) {
	if (typeof define === "function" && define.amd) {

		// AMD. Register as an anonymous module.
		define(["jquery.ui.datepicker"], factory);
	} else {

		// Browser globals
		factory(jQuery.datepicker);
	}
}(function(datepicker) {
	datepicker.regional['es'] = {
		closeText: 'Cerrar',
		prevText: 'Anterior',
		nextText: 'Siguiente',
		currentText: 'Actual',
		monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
			'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
			'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
		dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
		dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
		dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
		weekHeader: 'Semana',
		dateFormat: 'yy-mm-dd',
		changeYear: true,
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''
	};
	datepicker.setDefaults(datepicker.regional['es']);

	return datepicker.regional['es'];

}));