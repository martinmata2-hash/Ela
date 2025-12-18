var colonia;
$("#CliCp").change(function()
	{
        var data =
        {
            accion:'Domicilio/cp',
            data: {cp: $("#CliCp").val(), pais: $("#CliPais").val()},
            token:$("#CSRF").val()
        }
        AjaxPeticiones.request("/Dashboard/Ajax/Controller.php",data,
            function(datos)
            {
                $("#CliEstado").val(datos.CodEstado);	
                obtenerMunicipios(datos.CodEstado,datos.CodMunicipio);
                obtenerLocalidad( datos.CodCodigo);
            });    
    });
	
	function obtenerMunicipios(estado,municipio)
	{
        var data =
        {
            accion:'Domicilio/municipios',
            data: {estado :estado,municipio:municipio},
            token:$("#CSRF").val()
        }
        AjaxPeticiones.fillSelect("/Dashboard/Ajax/Controller.php",data,$("#CliMunicipio"));		                  
	}

	function obtenerColonia(estado,municipio,pais)
	{
        var data =
        {
            accion:'Domicilio/colonia',
            data: {estado:estado,municipio:municipio,pais:pais},
            token:$("#CSRF").val()
        }
        AjaxPeticiones.fillSelect("/Dashboard/Ajax/Controller.php",data,$("#CliColonia"));	
	}

	function obtenerLocalidad(codigo)
	{
        var data =
        {
            accion:'Domicilio/localidad',
            data: {cp:codigo},
            token:$("#CSRF").val()
        }
        AjaxPeticiones.fillSelect("/Dashboard/Ajax/Controller.php",data,$("#CliColonia"));			
	}

	function obtenerCp(colonia2, nombre)
	{	
         var data =
        {
            accion:'Domicilio/coloniaCp',
            data: {codigo:colonia2, nombre:nombre},
            token:$("#CSRF").val()
        }
        AjaxPeticiones.request("/Dashboard/Ajax/Controller.php",data,
            function(datos)
            {
                $("#CliCp").val(datos);
            });        
	}

	$("#CliPais").change(function()
	{
		obtenerEstados($(this).val());			 
	 });

	$("#CliEstado").change(function()
  	{
	 		var estado = $(this).val();
    	 	var pais = $("#CliPais").val();    	 	
            obtenerMunicipios(estado,0);    	 	  
    });

	$("#CliMunicipio").change(function()
    {
        var pais = $("#CliPais").val();
        var estado = $("#CliEstado").val();
        var municipio = $(this).val();    	 	
        obtenerColonia(estado,municipio, pais);    	 	
        $("#CliMunicipio2").val($(this+"  option:selected").text());  	   
    });

	
	$("#CliColonia").change(function()
    {
		if(colonia === 'undefined')
			colonia = $(this).val();			
		else
			colonia = $(this).val();
    	var nombre = $("#CliColonia option:selected").text();
    	obtenerCp(colonia, nombre);		  
    	$("#CliColonia2").val(nombre); 
     });
	
   	function obtenerPaises(seleccionado)
   	{
        var data =
        {
            accion:'Domicilio/paises',
            data: {pais:0},
            token:$("#CSRF").val()
        }
        AjaxPeticiones.fillSelect("/Dashboard/Ajax/Controller.php",data,$("#CliPais"));	
   	}

	function obtenerEstados(pais)
   	{
        var data =
        {
            accion:'Domicilio/estados',
            data: {pais:pais},
            token:$("#CSRF").val()
        }
        AjaxPeticiones.fillSelect("/Dashboard/Ajax/Controller.php",data,$("#CliEstado"));   	   
   	}    
	