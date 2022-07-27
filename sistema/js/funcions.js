
$(document).ready(function(){

    //--------------------- SELECCIONAR FOTO PRODUCTO ---------------------
    $("#foto").on("change",function(){
    	var uploadFoto = document.getElementById("foto").value;
        var foto       = document.getElementById("foto").files;
        var nav = window.URL || window.webkitURL;
        var contactAlert = document.getElementById('form_alert');
        
            if(uploadFoto !='')
            {
                var type = foto[0].type;
                var name = foto[0].name;
                if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png')
                {
                    contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es válido.</p>';                        
                    $("#img").remove();
                    $(".delPhoto").addClass('notBlock');
                    $('#foto').val('');
                    return false;
                }else{  
                        contactAlert.innerHTML='';
                        $("#img").remove();
                        $(".delPhoto").removeClass('notBlock');
                        var objeto_url = nav.createObjectURL(this.files[0]);
                        $(".prevPhoto").append("<img id='img' src="+objeto_url+">");
                        $(".upimg label").remove();
                        
                    }
              }else{
              	alert("No selecciono foto");
                $("#img").remove();
              }              
    });

    $('.delPhoto').click(function(){
    	$('#foto').val('');
    	$(".delPhoto").addClass('notBlock');
        $("#img").remove();
        
        if($("#foto_actual") &&  $("#foto_remove")){
            $("#foto_remove").val('img_producto.png');
        }

    });
    //Activar guardar
    $('.btn_new_cliente').click(function(e){
        e.preventDefault();
        $('#rfc_cliente').removeAttr('disabled');
        $('#con_cliente').removeAttr('disabled');
        $('#tel_cliente').removeAttr('disabled');
        $('#email_cliente').removeAttr('disabled');
        $('#pais_cliente').removeAttr('disabled');
        
        
        $('#div_registro_cliente').slideDown();
        
    });

    
    //buscar cliente
    $('#razon_social').keyup(function(e){
        e.preventDefault();

        var cl= $(this).val();
        var action = 'searchCliente';
        
        $.ajax({
            url: 'ajax.php',
            type: "POST",
            async: true,
            data: {action:action,cliente:cl},

            success:function(response){
                
                if (response==0){
                    $('#idcliente').val('');
                    $('#rfc_cliente').val('');
                    $('#con_cliente').val('');
                    $('#tel_cliente').val('');
                    $('#email_cliente').val('');
                    $('#pais_cliente').val('');
                    //mostrar btn agregar
                    $('.btn_new_cliente').slideDown();
                    

                }else{
                    var data=$.parseJSON(response);

                    //console.log(response);
                    $('#idcliente').val(data.idcliente);
                    $('#rfc_cliente').val(data.rfc);
                    $('#con_cliente').val(data.contacto);
                    $('#tel_cliente').val(data.telefono);
                    $('#email_cliente').val(data.email);
                    $('#pais_cliente').val(data.pais);
                    
                    //ocultar boton agregar
                    $('.btn_new_cliente').slideUp();
                    //bloque campos 
                    $('#rfc_cliente').attr('disabled','disabled');
                    $('#con_cliente').attr('disabled','disabled');
                    $('#tel_cliente').attr('disabled','disabled');
                    $('#email_cliente').attr('disabled','disabled');
                    $('#pais_cliente').attr('disabled','disabled');
                    
                    //oculrar boton guardar 
                    $('#div_registro_cliente').slideUp();
                    
                    

                }

            },
            error: function(error){

            }

            
        });
    });
    //crear cliente -desde las ventas
    $('#form_new_cliente_venta').submit(function(e){
        e.preventDefault();
        var action = 'addCliente';

        $.ajax({
            url: 'ajax.php',
            type: "POST",
            async: true,
            data: $('#form_new_cliente_venta').serialize(),

            success: function(response){
                //console.log(response);
                //agregar id a input hidden
                $('#idcliente').val(response);
                //Bloque campos
                $('#rfc_cliente').attr('disabled','disabled');
                $('#con_cliente').attr('disabled','disabled');
                $('#tel_cliente').attr('disabled','disabled');
                $('#email_cliente').attr('disabled','disabled');
                $('#pais_cliente').attr('disabled','disabled');
                
                //ocultar boton agregar
                $('.btn_new_cliente').slideUp();
                //ocultar boton guardar
                $('#div_registro_cliente').slideUp();

             },
            error: function(error){

            }
        });
    });

    //Agregar productos- ventas
    $('#txt_cod_producto').keyup(function(e){
        e.preventDefault();
        var producto=$(this).val();
        var action='infoProducto';
        if(producto != ''){
            $.ajax({
                url: 'ajax.php',
                type: "POST",
                async: true,
                data: {action:action,producto:producto},
    
                success: function(response){
                    if(response!='error'){
                        var info= JSON.parse(response);
                        $('#txt_descripcion').html(info.descripcion);
                        $('#txt_cant_producto').val('1');
                        $('#txt_precio').html(info.precio);
                        $('#txt_precio_total').html(info.precio);
                        $('#txt_moneda').val('1.00');
                        //Activar cantidad
                        $('#txt_cant_producto').removeAttr('disabled');
                        //Mostar boton agregar
                        $('#add_product_venta').slideDown();



                    }else{
                        $('#txt_descripcion').html('-');
                        $('#txt_cant_producto').html('0');
                        $('#txt_precio').html('0.00');
                        $('#txt_precio_total').html('0.00');
                        $('#txt_precio_total').html('0.00');
                        $('#txt_moneda').html('1.00');
                        //bloquear cantidad
                        $('#txt_cant_producto').attr('disabled','disabled');
                        //ocultar boton agregrar
                        $('#add_product_venta').slideUp();
                    }
                    
    
                 },
                error: function(error){
    
                }
            });

        }
        
    });

    //calcular total
    $('#txt_cant_producto').keyup(function(e){
        e.preventDefault();
        var precio_total1=$(this).val() *$('#txt_precio').html();
        $('#txt_precio_total').html(precio_total1);
         //ocultar el boton de agregrar si la cantidad es menor que 1 
        if($(this).val()<1 || isNaN($(this).val())) {
            $('#add_product_venta').slideUp();


        }else{
            $('#add_product_venta').slideDown();
        }
    });
    $('#txt_moneda').keyup(function(e){
       
        if($(this).val()>=2){
        var precio_total2=$(this).val() * $('#txt_precio_total').html();
        $('#txt_precio_total2').html(precio_total2);
        
        }else{
            var precio_total2=1*$('#txt_precio_total').html();
            $('#txt_precio_total2').html(precio_total2);
            
        }
        
    });

    //Agregar producto al detalle
    $('#add_product_venta').click(function(e){
        e.preventDefault();
        if($('#txt_cant_producto').val()>0){
            var codproducto =$('#txt_cod_producto').val();
            var cantidad =$('#txt_cant_producto').val();
            var Cambio =$('#txt_moneda').val();
            var action = 'addProductoDetalle';

            $.ajax({
                url: 'ajax.php',
                type: "POST",
                async: true,
                data: {action:action,producto:codproducto,cantidad:cantidad,Cambio:Cambio},

                success:function(response){
                    if(response != 'error'){
                        //console.log('si data');
                        //console.log(response);
                        var info = JSON.parse(response);
                        //console.log(info.detalle);
                        $('#detalle_venta').html(info.detalle);
                        $('#detalle_totales').html(info.totales);
                        //limpiar campos
                        $('#txt_cod_producto').val('');
                        $('#txt_descripcion').html('-');
                        $('#txt_cant_producto').val('0');
                        $('#txt_precio').html('0.00');
                        $('#txt_precio_total').html('0.00');
                        $('#txt_precio_total2').html('0.00');
                        $('#txt_moneda').html('1.00');
                        //bloquear cantidad
                        $('#txt_cant_producto').attr('disabled','disabled');

                        //ocultar boton agregar
                        $('#add_product_venta').slideUp();

                    }else{
                        console.log('no data');
                    }
                    viewProcesar();
                    
                },
                error:function(error){

                }
        });
    }
});
//Anular venta
$('#btn_anular_venta').click(function(e){
    e.preventDefault();
    var row=$('#detalle_venta tr').length;

    if(row>0){
        var action = 'anularVenta';

        $.ajax({
            url: 'ajax.php',
            type: "POST",
            async: true,
            data: {action:action},

            success: function(response){
                console.log(response);
                if(response != 'error'){
                    location.reload();
                }
            },
            error:function(error){

            }
            
        });
    }
});

//Fcturas venta
$('#btn_facturar_venta').click(function(e){
    e.preventDefault();
    var row=$('#detalle_venta tr').length;

    if(row > 0){
        var action = 'procesarVenta';
        var codcliente=$('#idcliente').val();
        var idempresa=$('#idempresa').val();

        $.ajax({
            url: 'ajax.php',
            type: "POST",
            async: true,
            data: {action:action,codcliente:codcliente,idempresa:idempresa},

            success: function(response){
                console.log(response);
                if(response != 'error'){
                    
                    var info=JSON.parse(response);
                    console.log(info);
                    generarPDF(info.codcliente,info.nofactura);
                    location.reload();
                }else{
                    console.log('No data');
                }
            },
            error:function(error){

            }
            
        });
    }
});

//modal anular factura
$(".anular_factura_ven").click(function(e){
    e.preventDefault();
    var nofactura=$(this).attr('fac');
    var action = 'infofactura';

    $.ajax({
        url: 'ajax.php',
            type: "POST",
            async: true,
            data: {action:action,nofactura:nofactura},

            success: function(response){
                if(response != 'error'){
                    //console.log(response);
                    var info= JSON.parse(response);
                    //console.log(info);
                    $('.bodyModal').html('<form action="" method="post" name="form_anular_factura" id="form_anular_factura" onsubmit="event.preventDefault(); anularfactura();">'+
                    '<h1><i class="fas fa-file-invoice-dollar" style="font-size: 45pt;"></i> <br><br>Anular Factura</h1><br>'+
                    '<center><p>¿Realmente quiere anular la factura?</p></center><br><br>'+
                    '<center>'+
                    '<p><strong>No. '+info.nofactura+'</strong></p><br>'+
                    '<p><strong>Monto. $ '+info.totaltactura+'</strong></p><br>'+
                    '<p><strong>Fecha. '+info.fecha+'</strong></p><br>'+
                    
                    '</center>'+
                    '<input type="hidden" name="action" value="anularfactura">'+
                    '<input type="hidden" name="no_factura" id="no_factura" value="'+info.nofactura+'" required>'+

                    '<div class="alert alertAddProduct"></div>'+
                    '<a href="lista_ventas_vendedores.php" class="btn_cancel" onclick="coloseModal();"><i class="fas fa-ban"></i> Cerrar</a>'+
                    '<button type="submit" class="btn_ok">Cancelar <i class="far fa-trash-alt"></i> </button>'+
                    '</form>');

                }
                
            },
            error:function(error){

            }
            
        });
        $('.modal').fadeIn();
    
});
//estado factura
$(".estado_factura").click(function(e){
    e.preventDefault();
    var nofactura=$(this).attr('f');
    var action = 'infofactura';

    $.ajax({
        url: 'ajax.php',
            type: "POST",
            async: true,
            data: {action:action,nofactura:nofactura},

            success: function(response){
                if(response != 'error'){
                    //console.log(response);
                    var info= JSON.parse(response);
                    //console.log(info);
                    $('.bodyModal').html('<form action="" method="post" name="form_estado_factura" id="form_estado_factura" onsubmit="event.preventDefault(); estadofactura();">'+
                    '<h1 style="color:green;"><i class="fas fa-file-invoice-dollar" style="font-size: 45pt; color:green;"></i> <br><br>Editar estado de la factura</h1><br>'+
                    '<center><p >¿En que estado va la factura?</p></center><br><br>'+
                    '<center>'+
                    '<p><strong>No. '+info.nofactura+'</strong></p><br>'+
                    '<p><strong>Monto. $ '+info.totaltactura+'</strong></p><br>'+
                    '<p><strong>Fecha. '+info.fecha+'</strong></p><br>'+
                    '<label for="estado">Estado de la factura:</label>'+
                    '<select name="estado" id="estado">'+
                    '<option value="2">Cancelar.</option>'+
                    '<option value="3">Pipeline 15%.</option>'+
                    '<option value="4">Weak Upside 30%.</option>'+
                    '<option value="5">Strong Upside 65%.</option>'+
                    '<option value="6">Presupuesto – tomadores de desición 85%.</option>'+
                    '<option value="7">Negociación 95%.</option>'+
                    '<option value="8">Commit 100%.</option>'+
                    '</select>'+
                    '</center>'+
                    '<input type="hidden" name="action" value="estado_factura">'+
                    '<input type="hidden" name="no_factura" id="no_factura" value="'+info.nofactura+'" required>'+

                    '<div class="alert alertAddProduct"></div>'+
                    '<a href="ventas.php" class="btn_ok" onclick="coloseModal();"><i class="fas fa-ban"></i> Cerrar</a>'+
                    '<button type="submit" class="btn_cancel">Actualizar <i class="far fa-edit"></i></button>'+
                    '</form>');

                }
                
            },
            error:function(error){

            }
            
        });
        $('.modal').fadeIn();
    
});
//Vendedores
$(".estado_factura_ven").click(function(e){
    e.preventDefault();
    var nofactura=$(this).attr('f');
    var action = 'infofactura';

    $.ajax({
        url: 'ajax.php',
            type: "POST",
            async: true,
            data: {action:action,nofactura:nofactura},

            success: function(response){
                if(response != 'error'){
                    //console.log(response);
                    var info= JSON.parse(response);
                    //console.log(info);
                    $('.bodyModal').html('<form action="" method="post" name="form_estado_factura" id="form_estado_factura" onsubmit="event.preventDefault(); estadofactura();">'+
                    '<h1 style="color:green;"><i class="fas fa-file-invoice-dollar" style="font-size: 45pt; color:green;"></i> <br><br>Editar estado de la factura</h1><br>'+
                    '<center><p >¿En que estado va la factura?</p></center><br><br>'+
                    '<center>'+
                    '<p><strong>No. '+info.nofactura+'</strong></p><br>'+
                    '<p><strong>Monto. $ '+info.totaltactura+'</strong></p><br>'+
                    '<p><strong>Fecha. '+info.fecha+'</strong></p><br>'+
                    '<label for="estado">Estado de la factura:</label>'+
                    '<select name="estado" id="estado">'+
                    '<option value="2">Cancelar.</option>'+
                    '<option value="3">Pipeline 15%.</option>'+
                    '<option value="4">Weak Upside 30%.</option>'+
                    '<option value="5">Strong Upside 65%.</option>'+
                    '<option value="6">Presupuesto – tomadores de desición 85%.</option>'+
                    '<option value="7">Negociación 95%.</option>'+
                    '<option value="8">Commit 100%.</option>'+
                    '</select>'+
                    '</center>'+
                    '<input type="hidden" name="action" value="estado_factura">'+
                    '<input type="hidden" name="no_factura" id="no_factura" value="'+info.nofactura+'" required>'+

                    '<div class="alert alertAddProduct"></div>'+
                    '<a href="lista_ventas_vendedores.php" class="btn_ok" onclick="coloseModal();"><i class="fas fa-ban"></i> Cerrar</a>'+
                    '<button type="submit" class="btn_cancel">Actualizar <i class="far fa-edit"></i></button>'+
                    '</form>');

                }
                
            },
            error:function(error){

            }
            
        });
        $('.modal').fadeIn();
    
});
//depto. administracion
$(".estado_factura_admi").click(function(e){
    e.preventDefault();
    var nofactura=$(this).attr('f');
    var action = 'infofactura';

    $.ajax({
        url: 'ajax.php',
            type: "POST",
            async: true,
            data: {action:action,nofactura:nofactura},

            success: function(response){
                if(response != 'error'){
                    //console.log(response);
                    var info= JSON.parse(response);
                    //console.log(info);
                    $('.bodyModal').html('<form action="" method="post" name="form_estado_factura" id="form_estado_factura" onsubmit="event.preventDefault(); estadofactura();">'+
                    '<h1 style="color:green;"><i class="fas fa-file-invoice-dollar" style="font-size: 45pt; color:green;"></i> <br><br>Editar estado de la factura</h1><br>'+
                    '<center><p >¿En que estado va la factura?</p></center><br><br>'+
                    '<center>'+
                    '<p><strong>No. '+info.nofactura+'</strong></p><br>'+
                    '<p><strong>Monto. $ '+info.totaltactura+'</strong></p><br>'+
                    '<p><strong>Fecha. '+info.fecha+'</strong></p><br>'+
                    '<label for="estado">Estado de la factura:</label>'+
                    '<select name="estado" id="estado">'+
                    '<option value="10">Para Facturar.</option>'+
                    '<option value="9">Pagada.</option>'+
                    '</select>'+
                    '</center>'+
                    '<input type="hidden" name="action" value="estado_factura">'+
                    '<input type="hidden" name="no_factura" id="no_factura" value="'+info.nofactura+'" required>'+

                    '<div class="alert alertAddProduct"></div>'+
                    '<a href="lista_ventas_administacion.php" class="btn_ok" onclick="coloseModal();"><i class="fas fa-ban"></i> Cerrar</a>'+
                    '<button type="submit" class="btn_cancel">Actualizar <i class="far fa-edit"></i></button>'+
                    '</form>');

                }
                
            },
            error:function(error){

            }
            
        });
        $('.modal').fadeIn();
    
});
//ver factura
$('.view_factura').click(function(e){
    e.preventDefault();
    var  codcliente=$(this).attr('cl');
    var  nofactura=$(this).attr('f');
    generarPDF(codcliente,nofactura);


})

//Cambiar contraseña
$('.newPass').keyup(function(e){
   valiPass();
})
$('#frmChangePass').submit(function(e){
    e.preventDefault();
    var passActual= $('#txtPassUser').val();
    var passNuevo= $('#txtNewPassUser').val();
    var confirmarPassNuevo= $('#txtPassConfirm').val();
    var action='changePassword';

    if(passNuevo != confirmarPassNuevo){
        //console.log("no iguales");
        $('.alertChangesPass').html('<p style="color:red;">Las contraseñas no son iguales.</p>');
        $('.alertChangesPass').slideDown();
        return false;
    }
    if(passNuevo.length < 6){
        $('.alertChangesPass').html('<p style="color:red;">Las contraseña debe ser de 6 caracteres como minimo.</p>');
        $('.alertChangesPass').slideDown();
        return false;

    }
    $.ajax({
        url: 'ajax.php',
        type: "POST",
        async: true,
        data: {action:action,passActual:passActual,passNuevo:passNuevo},

        success: function(response){
            if(response != 'error'){
                
                var info=JSON.parse(response);
                if(info.cod=='00'){
                        $('.alertChangesPass').html('<p style="color:green;">'+info.msg+'</p>');
                        $('#frmChangePass')[0].reset();

                }else{
                    $('.alertChangesPass').html('<p style="color:red;">'+info.msg+'</p>');
                }
                $('.alertChangesPass').slideDown();
            }
            
        },
        error:function(error){

        }
    
    });
 
    });


    //Actualizar datos empresa
    $('#frmEmpresa').submit(function(e){
        e.preventDefault();
        var strid=$('#idEmpresa').val();
        var strrfc=$('#txtRfc').val();
        var strNombreEm=$('#txtNombre').val();
        var strRsocialEm=$('#txtRsocial').val();
        var strTelEm=$('#txTelefono').val();
        var strEmailEm=$('#txtEmail').val();
        var strDirEm=$('#txtDireccion').val();
        var strConEm=$('#txtContacto').val();
        
        var intiva=$('#txtIva').val();

        if(strrfc=='' || strNombreEm==''|| strRsocialEm==''|| strTelEm==''|| strEmailEm==''|| strDirEm==''|| strConEm==''|| intiva==''){
            $('.alertFormEmpresa').html('<p style="color:red;">Todos lo campos son obligatorios</p>');
            $('.alertFormEmpresa').slideDown();
            return false;
        }
        $.ajax({
            url: 'ajax.php',
            type: "POST",
            async: true,
            data: $('#frmEmpresa').serialize(),
            beforeSend: function(){
                $('.alertFormEmpresa').slideUp();
                $('.alertFormEmpresa').html('');
                $('#frmEmpresa input').attr('disabled','disabled');
            },
    
            success: function(response){
                
                if(response != 'error'){
                    //console.log(response);
                    var info=JSON.parse(response);
                    //console.log(info);
                    if(info.cod=='00'){
                        $('.alertFormEmpresa').html('<p style="color:green;">'+info.msg+'</p>');
                        $('#frmEmpresa input').removeAttr('disabled');
                        $('.alertFormEmpresa').slideDown();
                    }else{
                        $('.alertFormEmpresa').html('<p style="color:red;">'+info.msg+'</p>');
                    }
                    $('.alertFormEmpresa').slideDown();

                }
            },
            error:function(error){
    
            }
        });
 });

 //buscar empresa
 $('#nom_empresa').keyup(function(e){
    e.preventDefault();

    var ep= $(this).val();
    var action = 'searchEmpresa';
    
    $.ajax({
        url: 'ajax.php',
        type: "POST",
        async: true,
        data: {action:action,empresa:ep},

        success:function(response){
            //console.log(response);
            if(response==0){
                $('#idEmpresa').val('');
                $('#txtRfc').val('');
                $('#txtNombre').val('');
                $('#txtRsocial').val('');
                $('#txTelefono').val('');
                $('#txtEmail').val('');
                $('#txtDireccion').val('');
                $('#txtContacto').val('');
                $('#txtIva').val('');

            }else{
                var data=$.parseJSON(response);
                $('#idEmpresa').val(data.id);
                $('#txtRfc').val(data.rfc);
                $('#txtNombre').val(data.nombre);
                $('#txtRsocial').val(data.razon_social);
                $('#txTelefono').val(data.telefono);
                $('#txtEmail').val(data.email);
                $('#txtDireccion').val(data.direccion);
                $('#txtContacto').val(data.contacto);
                $('#txtIva').val(data.iva);
            }
            
            

        },
        error: function(error){

        }

        
    });
});

  
    
    


});//fin ready
function valiPass(){
    var passNuevo= $('#txtNewPassUser').val();
    var confirmarPassNuevo= $('#txtPassConfirm').val();
    
    if(passNuevo != confirmarPassNuevo){
        //console.log("no iguales");
        $('.alertChangesPass').html('<p style="color:red;">Las contraseñas no son iguales.</p>');
        $('.alertChangesPass').slideDown();
        return false;
    }
    if(passNuevo.length < 6){
        $('.alertChangesPass').html('<p style="color:red;">Las contraseña debe ser de 6 caracteres como minimo.</p>');
        $('.alertChangesPass').slideDown();
        return false;

    }
    $('.alertChangesPass').html('');
    $('.alertChangesPass').slideUp();

    
    
}
function anularfactura(){
    var nofactura =$('#no_factura').val();
    var action = 'anularfactura';

    $.ajax({
        url: 'ajax.php',
        type: "POST",
        async: true,
        data: {action:action,nofactura:nofactura}, 
        success: function(response){
            if(response == 'error'){
                $('.alertAddProduct').html('<p style="color:red;">Error al cancelar la factura.</P>');
    
            }else{
                    $('#row_'+nofactura+' .estado').html('<span class="anulada">Cancelada</span>');
                    $('#form_anular_factura .btn_ok').remove();
                    $('#row_'+nofactura+' .divfactura').html('<center><button type="button" class="btn_anular inactive"><i class="fas fa-ban"></i></button></center>');
                    $('.alertAddProduct').html('<p>Factura cancelada.</p>');
                }

            
        },
        error: function(error){

        }
    });
}

function estadofactura(){
    var nofactura =$('#no_factura').val();
    var estado =$('#estado').val();
    var action = 'estadofactura';

    $.ajax({
        url: 'ajax.php',
        type: "POST",
        async: true,
        data: {action:action,nofactura:nofactura,estado:estado}, 
        success: function(response){
            //console.log(response);
            if(response == 'error'){
                $('.alertAddProduct').html('<p style="color:red;">Error al modificar el estado de la factura.</P>');
    
            }else{
                    $('#row_'+nofactura+' .estado').html('<span class="anulada">Estado Actualizado.</span>');
                    $('#form_estado_factura .btn_cancel').remove();
                    $('#row_'+nofactura+' .divfactura').html('<center><button type="button" class="btn_anular inactive"><i class="fas fa-ban"></i></button></center>');
                    $('.alertAddProduct').html('<p>Estado Actualizado.</p>');
                }

            
        },
        error: function(error){

        }
    });
}
function closeModal(){
    $('.modal').fadeOut();
}
function generarPDF(cliente,factura){
    var ancho = 1000;
    var alto = 800;

    //calcular la pocicion x,y para centrar la venta
    var x= parseInt((window.screen.width/2)-(ancho/2));
    var y= parseInt((window.screen.height/2)-(ancho/2));
    
    $url='factura/generaFactura.php?cl='+cliente+'&f='+factura;
    window.open($url,"Factura","left="+x+",top="+y+",height="+alto+",width="+ancho+",scrollbar=si,location=no,resizable=si,menubar=no");
}

function del_producto_detalle(correlativo){
    var action ='del_producto_detalle';
    var id_detalle=correlativo;
    $.ajax({
        url: 'ajax.php',
        type: "POST",
        async: true,
        data: {action:action,id_detalle:id_detalle},

        success:function(response){
            if(response != 'error'){
                //console.log(response);
                var info =JSON.parse(response);
                $('#detalle_venta').html(info.detalle);
                $('#detalle_totales').html(info.totales);
                //limpiar campos
                $('#txt_cod_producto').val('');
                $('#txt_descripcion').html('-');
                $('#txt_cant_producto').val('0');
                $('#txt_precio').html('0.00');
                $('#txt_precio_total').html('0.00');
                $('#txt_moneda').val('1.00');
                //bloquear cantidad
                $('#txt_cant_producto').attr('disabled','disabled');

                //ocultar boton agregar
                $('#add_product_venta').slideUp();


            }else{
                $('#detalle_venta').html('');
                $('#detalle_totales').html('');
            }
            viewProcesar();
            
        },
        error:function(error){

        }
});


}
//Mostrar /ocultar boton procesar
function viewProcesar(){
    if($('#detalle_venta tr').length > 0){
        
        $('#btn_facturar_venta').show();

    }else{
        //console.log("no entro");
        $('#btn_facturar_venta').hide();

    }
}
//Activa y desactiva txt_moneda
$( function() {
    $("#combo_cambio").change( function() {
        if ($(this).val() === "1") {
            $("#txt_moneda").prop("disabled", true);
        } else {
            $("#txt_moneda").prop("disabled", false);
        }
    });
});

function serchForDetalle(id){
    var action ='serchForDetalle';
    var user=id;
    $.ajax({
        url: 'ajax.php',
        type: "POST",
        async: true,
        data: {action:action,user:user},

        success:function(response){
            if(response != 'error'){
                //console.log('si data');
                //console.log(response);
                var info = JSON.parse(response);
                //console.log(info);
                $('#detalle_venta').html(info.detalle);
                $('#detalle_totales').html(info.totales);
                

            }else{
                console.log('no data');
            }
            viewProcesar();
            
        },
        error:function(error){

        }
});
}


