<?php
date_default_timezone_set("America/Bogota");
echo date("Y-m-d H:i:s")." INICIANDO PROCESO\n";
#Consulatndo forms
//$mysqli_apex = @new mysqli('localhost','apex_user','4p3x@4dm1n','apex');
$mysqli_apex = @new mysqli('10.220.0.2','apex_user','4p3x@4dm1n','apex');
if ($mysqli_apex->connect_error) {
    echo date("Y-m-d H:i:s")." ERROR EN CONEXION a BD \n";
    die();
}else{
    $hoy = date("Y-m-d");
    $sql= "SELECT * FROM apex_calls WHERE create_form BETWEEN '$hoy 00:00:00' and '$hoy 23:59:59' AND channel = 1 AND uniqueid_pbx!='' AND record_pbx is null AND estado_pbx is null"; 
    $arr = $mysqli_apex->query($sql);
    if ($mysqli_apex->errno==0) {
        $registro_totales = mysqli_num_rows($arr);
        if($registro_totales>0){
            while ($fil = $arr->fetch_assoc()){
                $id_call  = $fil["id_call"];
                $uniqueid = $fil["uniqueid_pbx"];
                echo date("Y-m-d H:i:s")." $id_call -- $uniqueid  \n"; 
                recuperaPBX($uniqueid,$id_call,$mysqli_apex);
            }
        }else{
            echo date("Y-m-d H:i:s")." NO SE ENCONTRARON REGISTROS \n";       
        }
    }else{
	    echo date("Y-m-d H:i:s")." ERROR EN CONSULTAR APEX FORM \n";
    }
}
echo date("Y-m-d H:i:s")." TERMINANDO PROCESO\n";
exit();

function recuperaPBX($uniqueid,$id_call,$mysqli_apex){

    $mysqli_pbx = @new mysqli('localhost','asteriskuser','COLOMBIA123','asteriskcdrdb');
    if ($mysqli_pbx->connect_error) {
        echo date("Y-m-d H:i:s")." ERROR EN CONEXION a BD ASTERISK\n";
    }else{
        $sql= "SELECT disposition,recordingfile, billsec FROM cdr WHERE uniqueid = '$uniqueid'"; 
        $arrx = $mysqli_pbx->query($sql);
        if ($mysqli_pbx->errno==0) {
            $registro_totalesx = mysqli_num_rows($arrx);
            if($registro_totalesx>0){
                while ($filx = $arrx->fetch_assoc()){
                    $disposition    = $filx["disposition"];
                    $recordingfile  = $filx["recordingfile"];
                    $billsec        = $filx["billsec"];
                    echo date("Y-m-d H:i:s")." $disposition -- $recordingfile -- $billsec \n";
                    $recordingfile = str_replace("/var/spool/asterisk/monitor/", "", $recordingfile); 
                    $mysqli_apex->query("UPDATE apex_calls SET estado_pbx='$disposition',record_pbx='$recordingfile',time_call_pbx ='$billsec' WHERE id_call = $id_call");
                    if ($mysqli_apex->errno!=0) {
                        printf("Connect failed: %s\n", $mysqli_apex->connect_error);
                    }
                }
            }else{
                echo date("Y-m-d H:i:s")." NO SE ENCONTRARON REGISTROS \n";  
            }
        }else{
            echo date("Y-m-d H:i:s")." ERROR EN CONSULTAR CDR \n";
        }
    }
}
?>