<?php
include "../conexion.php";
session_start();

    if(!empty($_POST)){
        //echo "1er if ";
        if($_POST['action']=='infoProducto'){
            //echo "2er if ";
            $producto_id=$_POST['producto'];
            $query=mysqli_query($conection,"SELECT codproducto,descripcion,precio FROM
                                            producto WHERE codproducto=$producto_id AND estado=1");
            //mysqli_close($conection);
            $result=mysqli_num_rows($query);
            if($result>0){
                //echo "3er if ";
                $data=mysqli_fetch_assoc($query);
                echo json_encode($data,JSON_UNESCAPED_UNICODE);
                exit;
            }
            echo 'error';
            exit;

        }

    }
    //Buscar cliente
    if($_POST['action'] == 'searchCliente'){
        //print_r($_POST);
        //echo "Entra al action";
        if(!empty($_POST['cliente'])){
            
            $nombre=$_POST['cliente'];
            $query=mysqli_query($conection,"SELECT * FROM 
            cliente WHERE razon_social LIKE '$nombre' and estatus=1");
            //mysqli_close($conection);
            $result=mysqli_num_rows($query);

            $data='';
            if($result>0){
                $data=mysqli_fetch_assoc($query);
            }else{
                $data=0;
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
       


        }
         //registrar ventas
         if($_POST['action'] == 'addCliente'){
            //print_r($_POST);
            $razon_social=$_POST['razon_social'];
            $rfc=$_POST['rfc_cliente'];
            $contacto=$_POST['con_cliente'];
            $telefono=$_POST['tel_cliente'];
            $email=$_POST['email_cliente'];
            $pais=$_POST['pais_cliente'];
            $usuario_id =$_SESSION['idUser'];

            $query_insert=mysqli_query($conection,"INSERT INTO 
            cliente(razon_social,rfc,contacto,telefono,email,pais,usuario_id) 
            VALUES ('$razon_social','$rfc','$contacto','$telefono','$email','$pais',$usuario_id)");
            
            if($query_insert){
                $codCliente=mysqli_insert_id($conection);
            }else{
               //$msg='error';
                
            }
            //mysqli_close($conection);
            //echo $msg;
            
        }
        //agregar producto al detalle venta
        if($_POST['action'] == 'addProductoDetalle'){
            if(empty($_POST['producto']) || empty($_POST['cantidad'])){
            echo 'error';
        }else{
            //echo "entra 1er else";
            $codproducto=$_POST['producto'];
            $cantidad=$_POST['cantidad'];
            $Cambio=$_POST['Cambio'];
            $token=md5($_SESSION['idUser']);

            $query_iva=mysqli_query($conection,"SELECT iva FROM configuracion");
            $result_iva=mysqli_num_rows($query_iva);

            $query_detalle_temp=mysqli_query($conection,"CALL add_detalle_temp($codproducto,$cantidad,'$token',$Cambio)");
            $result=mysqli_num_rows($query_detalle_temp);

            $detalleTabla='';
            //$detalleTotales='';
            $total_Cambio=0;
            $precioTotal=0;
            $sub_total=0;
            $tl_sniva=0;
            $total_Cambio1=0;
            $iva=0;
            $total=0;
            
            $arrayData=array();

            if($result>0){
                $info_iva=mysqli_fetch_assoc($query_iva);
                $iva=$info_iva['iva'];
            }

            while($data= mysqli_fetch_assoc($query_detalle_temp)){
                $precioTotal=round($data['cantidad'] * $data['precio_venta'],2);
                $sub_total=round($sub_total + $precioTotal,2);
                $total=round($total + $precioTotal,2);
                $total_Cambio1=round($precioTotal*$data['Cambio'],2);
                $total_Cambio +=round($precioTotal*$data['Cambio'],2);
                
                
                $detalleTabla .='<tr>
                                <td>'.$data['codproducto'].'</td>
                                <td colspan="1">'.$data['descripcion'].'</td>
                                <td class="textcenter">'.$data['cantidad'].'</td>
                                <td class="textright">'.$data['precio_venta'].'</td>
                                <td class="textright">'.$precioTotal.'</td>
                                <td class="textright">'.$total_Cambio1.'</td>
                                <td class="textright">'.$data['Cambio'].'</td>
                                <td class="">
                                <a class="link_delete" href="#" onclick="event.preventDefault();
                                del_producto_detalle('.$data['correlativo'].');"><i class="far fa-trash-alt"></i></a>
                                </td>
                            </tr>';

            }

            $impuesto=round($total_Cambio *($iva/100),2);
            $tl_sniva +=round($total_Cambio,2);
            $total=round($tl_sniva + $impuesto,2);

            //echo $impuesto;

            $detalleTotales='<tr>
                                <td colspan="5" class="textright">Sub total</td>
                                <td class="textright">'.$tl_sniva.'</td>
                            </tr>
                            <tr>
                                <td colspan="5" class="textright">IVA ('.$iva.')</td>
                                <td class="textright">'.$impuesto.'</td>
                            </tr>
                            <tr>
                                <td colspan="5" class="textright">total</td>
                                <td class="textright">'.$total.'</td>
                            </tr>';
                            

                            $arrayData['detalle']=$detalleTabla;
                            $arrayData['totales']=$detalleTotales;

                            echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
        }
    }
    //extrae datos de detalle temp
    if($_POST['action'] == 'serchForDetalle'){
        if(empty($_POST['user'])){
        echo 'error';
    }else{
        //echo "entra 1er else";
        $token=md5($_SESSION['idUser']);

        $query=mysqli_query($conection,"SELECT  tmp.correlativo,
                                                tmp.token_user,
                                                tmp.cantidad,
                                                tmp.precio_venta,
                                                tmp.Cambio,
                                                p.codproducto,
                                                p.descripcion
                                                FROM detalle_temp tmp
                                                INNER JOIN producto p
                                                ON tmp.codproducto=p.codproducto 
                                                WHERE token_user='$token' ");

        $result=mysqli_num_rows($query);
        $query_iva=mysqli_query($conection,"SELECT iva FROM configuracion");
        $result_iva=mysqli_num_rows($query_iva);

        
        

        $detalleTabla='';
        //$detalleTotales='';
        $tl_sniva=0;
        $precioTotal=0;
        $total_Cambio=0;
        $total_Cambio1=0;
        $sub_total=0;
        $iva=0;
        $total=0;
        $arrayData=array();

        if($result>0){
            $info_iva=mysqli_fetch_assoc($query_iva);
            $iva=$info_iva['iva'];
        }

        while($data= mysqli_fetch_assoc($query)){
            $precioTotal=round($data['cantidad'] * $data['precio_venta'],2);
            $sub_total=round($sub_total + $precioTotal,2);
            $total=round($total + $precioTotal,2);
            $total_Cambio1=round($precioTotal*$data['Cambio'],2);
            $total_Cambio +=round($precioTotal*$data['Cambio'],2);
            
            
            $detalleTabla .='<tr>
                                <td>'.$data['codproducto'].'</td>
                                <td colspan="1">'.$data['descripcion'].'</td>
                                <td class="textcenter">'.$data['cantidad'].'</td>
                                <td class="textright">'.$data['precio_venta'].'</td>
                                <td class="textright">'.$precioTotal.'</td>
                                <td class="textright">'.$total_Cambio1.'</td>
                                <td class="textright">'.$data['Cambio'].'</td>
                                <td class="">
                                <a class="link_delete" href="#" onclick="event.preventDefault();
                                del_producto_detalle('.$data['correlativo'].');"><i class="far fa-trash-alt"></i></a>
                                </td>
                        </tr>';

        }
        $impuesto=round($total_Cambio *($iva/100),2);
        $tl_sniva +=round($total_Cambio,2);
        $total=round($tl_sniva + $impuesto,2);
        //echo $impuesto;

        $detalleTotales='<tr>
                            <td colspan="5" class="textright">Sub total</td>
                            <td class="textright">'.$tl_sniva.'</td>
                        </tr>
                        <tr>
                            <td colspan="5" class="textright">IVA ('.$iva.')</td>
                            <td class="textright">'.$impuesto.'</td>
                        </tr>
                        <tr>
                            <td colspan="5" class="textright">total</td>
                            <td class="textright">'.$total.'</td>
                        </tr>';
                        

                        $arrayData['detalle']=$detalleTabla;
                        $arrayData['totales']=$detalleTotales;

                        echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
    }
}
//eliminar un producto
if($_POST['action'] == 'del_producto_detalle'){
    //print_r($_POST);
    if(empty($_POST['id_detalle'])){
        echo 'error';
    }else{
        //echo "entra 1er else";
        $id_detalle=$_POST['id_detalle']; 
        $token=md5($_SESSION['idUser']);
        
        
        $query_iva=mysqli_query($conection,"SELECT iva FROM configuracion");
        $result_iva=mysqli_num_rows($query_iva);

        $query_detalle_temp=mysqli_query($conection,"CALL del_detalle_temp($id_detalle,'$token')");
        $result=mysqli_num_rows($query_detalle_temp);

        
        

        $detalleTabla='';
        //$detalleTotales='';
        $total_Cambio=0;
        $total_Cambio1=0;
        $precioTotal=0;
        $sub_total=0;
        $tl_sniva=0;
        $iva=0;
        $total=0;
        $arrayData=array();
       

        if($result>0){
            $info_iva=mysqli_fetch_assoc($query_iva);
            $iva=$info_iva['iva'];
        }

        while($data= mysqli_fetch_assoc($query_detalle_temp)){
            $precioTotal=round($data['cantidad'] * $data['precio_venta'],2);
            $sub_total=round($sub_total + $precioTotal,2);
            $total=round($total + $precioTotal,2);
            $total_Cambio1=round($precioTotal*$data['Cambio'],2);
            $total_Cambio +=round($precioTotal*$data['Cambio'],2);
            
            
            
            
            
            $detalleTabla .='<tr>
                                <td>'.$data['codproducto'].'</td>
                                <td colspan="1">'.$data['descripcion'].'</td>
                                <td class="textcenter">'.$data['cantidad'].'</td>
                                <td class="textright">'.$data['precio_venta'].'</td>
                                <td class="textright">'.$precioTotal.'</td>
                                <td class="textright">'.$total_Cambio1.'</td>
                                <td class="textright">'.$data['Cambio'].'</td>
                                <td class="">
                                <a class="link_delete" href="#" onclick="event.preventDefault();
                                del_producto_detalle('.$data['correlativo'].');"><i class="far fa-trash-alt"></i></a>
                                </td>
                        </tr>';

        }
        $impuesto=round($total_Cambio *($iva/100),2);
        $tl_sniva +=round($total_Cambio,2);
        $total=round($tl_sniva + $impuesto,2);
        //echo $impuesto;

        $detalleTotales='<tr>
                            <td colspan="5" class="textright">Sub total</td>
                            <td class="textright">'.$tl_sniva.'</td>
                        </tr>
                        <tr>
                            <td colspan="5" class="textright">IVA ('.$iva.')</td>
                            <td class="textright">'.$impuesto.'</td>
                        </tr>
                        <tr>
                            <td colspan="5" class="textright">total</td>
                            <td class="textright">'.$total.'</td>
                        </tr>';
                        

                        $arrayData['detalle']=$detalleTabla;
                        $arrayData['totales']=$detalleTotales;

                        echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
    }
}
//Anular venta
if($_POST['action'] == 'anularVenta'){
    $token=md5($_SESSION['idUser']);
    $query_del=mysqli_query($conection,"DELETE FROM detalle_temp WHERE token_user='$token'");
    mysqli_close($conection);

    if($query_del){
        echo 'ok';

    }else{
        echo 'error';
    }
}
if($_POST['action'] == 'editarEstado'){
    print_r($_POST);
}
//Procdesar venta
if($_POST['action'] == 'procesarVenta'){
    
    
        $codcliente=$_POST['codcliente'];
        $idempresa=$_POST['idempresa'];
        $token=md5($_SESSION['idUser']);
        $usuario=$_SESSION['idUser'];
        

        $query=mysqli_query($conection,"SELECT * FROM detalle_temp WHERE token_user='$token'");
        $result=mysqli_num_rows($query);
        if($result>0){
            $query_procesar=mysqli_query($conection,"CALL procesar_venta($usuario,$codcliente,'$token',$idempresa)");
            $result_detalle=mysqli_num_rows($query_procesar);

            if($result_detalle>0){
                $data=mysqli_fetch_assoc($query_procesar);
                echo json_encode($data,JSON_UNESCAPED_UNICODE);
                //print_r($data);

            }else{
                echo 'errorrrrrr';
            }
        }else{
            echo 'errorr';
        }
        mysqli_close($conection);
        exit;
    }
    if($_POST['action'] == 'infofactura'){
        if(!empty($_POST['nofactura'])){
            $nofactura=$_POST['nofactura'];
            $query=mysqli_query($conection,"SELECT * FROM factura WHERE nofactura='$nofactura' AND estatus!=2");
            //mysqli_close($conection);
            $result=mysqli_num_rows($query);
            if($result > 0){
                $data=mysqli_fetch_assoc($query);
                echo json_encode($data,JSON_UNESCAPED_UNICODE);
                exit;
                
            }

        }
        echo 'error';
        exit;

    }
    //anular factura
    if($_POST['action'] == 'anularfactura'){
        //echo 'error';
        if(!empty($_POST['nofactura'])){
            //echo ' 2 entra';
            $nofactura=$_POST['nofactura'];
            $query_anular=mysqli_query($conection,"CALL anular_factura($nofactura)");
            $result=mysqli_num_rows($query_anular);
            if($result>0){
                //echo ' 3 entra';
                $data=mysqli_fetch_assoc($query_anular);
                echo json_encode($data,JSON_UNESCAPED_UNICODE);
                exit;
            }

        }

    }
    //Cambiar contraseña
    if($_POST['action'] == 'changePassword'){
        //echo 'error';
        if(!empty($_POST['passActual']) && !empty($_POST['passNuevo'])){
            $password=md5($_POST['passActual']);
            $newPass=md5($_POST['passNuevo']);
            $idUser=$_SESSION['idUser'];
            

            $code='';
            $msg='';
            $arrData=array();

            $query_user=mysqli_query($conection,"SELECT * FROM usuario 
                                                WHERE clave='$password' AND idusuario=$idUser");
            $result=mysqli_num_rows($query_user);
            if($result>0){
                $query_update=mysqli_query($conection,"UPDATE usuario SET clave='$newPass'
                                                      WHERE idusuario=$idUser");
                mysqli_close($conection);
                if($query_update){
                    $code='00';
                    $msg='Su contraseña se ha actualizado con exito.';

                }else{
                    $code= '2';
                    $msg= 'No es posible cambiar su contraseña.';
                }
            }else{
                $code= '1';
                $msg= 'La contraseña actual es incorrecta.';
            }
            $arrData=array('cod' => $code,'msg' => $msg);
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);


        }else{
            echo 'error';
        }

    }
    //Actualizar datos empresa8
    if($_POST['action']=='updateDataEmpresa'){
        
       
        if(empty($_POST['txtIva'])){
            $code='1';
            $msg="Todos los campos son obligatorios.";

        }else{
            $strid=$_POST['idEmpresa'];
            $strrfc=$_POST['txtRfc'];
            $strNombreEm=$_POST['txtNombre'];
            $strRsocialEm=$_POST['txtRsocial'];
            $strTelEm=$_POST['txtTelefono'];
            $strEmailEm=$_POST['txtEmail'];
            $strDirEm=$_POST['txtDireccion'];
            $strConEm=$_POST['txtContacto'];
            $intiva=$_POST['txtIva'];

            $queryUP=mysqli_query($conection,"UPDATE configuracion SET rfc='$strrfc',
                                             nombre='$strNombreEm',
                                             razon_social='$strRsocialEm',
                                             telefono='$strTelEm',
                                             email='$strEmailEm',
                                             direccion='$strDirEm',
                                             contacto='$strConEm',
                                             iva=$intiva WHERE id=$strid");

            mysqli_close($conection);
            if($queryUP){
                $code='00';
                $msg='Datos actualizados correctamente.';
            }else{
                $code='2';
                $msg='Error al actualizar los datos.';
            }
        }
        $arrData=array('cod' => $code, 'msg' => $msg);
        echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
        

        

        }
        //Actualizar estado factura
        
        if($_POST['action']=='estadofactura'){
           
            if(!empty($_POST['nofactura']) && !empty($_POST['estado'])){
            $estado=$_POST['estado'];
            $nofactura=$_POST['nofactura'];
            
        $query_actualizar=mysqli_query($conection,"UPDATE `factura` SET estatus=$estado WHERE  nofactura=$nofactura");
        
    }
}
if($_POST['action']=='searchEmpresa'){
    if(!empty($_POST['empresa'])){
        $nomEmpresa=$_POST['empresa'];
        $query_empresa=mysqli_query($conection,"SELECT * FROM configuracion WHERE nombre LIKE '%$nomEmpresa%'");
        $result=mysqli_num_rows($query_empresa);
        $data='';
        if($result>0){
            $data=mysqli_fetch_assoc($query_empresa);
        }else{
            $data=0;
        }
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }
    
}
    
    



          
    
        //mysqli_close($conection);
        exit;
        


    

?>