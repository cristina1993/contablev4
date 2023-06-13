<table width="100%">

    <tr>
        <td colspan="2" width="100%">
            <table class="encabezado5" width="100%">
                <tr>
                    <td style="font-size:12px"><?php echo $empresa->emp_nombre; ?></td>
                    <td></td>
                    <td> </td>
                    <td></td>
                    <td></td>
                    <td rowspan="4" width="15%">
                        <img src="<?php echo base_url().'imagenes/'.$empresa->emp_logo?>" width="120px" height="70px">
                    </td>
                </tr>
                <tr>
                    <td style="font-size:12px"><?php echo $empresa->emp_identificacion; ?> </td>
                </tr>
                <tr>
                    <td style="font-size:12px">
                        <?php echo $empresa->emi_ciudad."-".$empresa->emi_pais; ?> </td>
                </tr>
                <tr>
                    <td style="font-size:12px"><?php echo "TELEFONO: " . $empresa->emi_telefono ?> </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br>
<br>


<center><h3>DESGLOCE DE FACTURAS</h3> </center>
<table id="tbl_list" width="100%">
    <tr id="tbl_thead">
        <!-- <th class="hidden-mobile">No</th> -->
        <th>Fecha</th>
        <th>Factura No.</th>
        <th style="width: 5px; !important">Monto</th>
        <th>Cliente</th>
        <th style="width: 5px; !important" class="hidden-mobile"><?php echo utf8_encode('Código') ?> </th>
        <th>Producto</th>
        <th style="width: 5px; !important">Cantidad</th>
        <th style="width: 5px; !important" >Precio</th>
        <th style="width: 5px; !important">Descuento</th>
        <th style="width: 5px; !important">Valor</th>

    </tr>
    <tbody>
        <?php
							$dec=$dec->con_valor;
							$dcc=$dcc->con_valor;
							$t_monto=0;
								$t_cnt=0;
								$t_prec=0;
								$t_desc=0;
								$t_val=0;
							if(!empty($facturas)){
								$n=0;

								$grup='';
								foreach ($facturas as $factura) {
									$n++;
						?>
        <tr>
            <?php
									if($grup!=$factura->fac_id){
									?>
            <!-- <td class="hidden-mobile"><?php echo $n?></td> -->
            <td><?php echo $factura->fac_fecha_emision?></td>
            <td><?php echo $factura->fac_numero?></td>
            <td style="width: 5px; !important" class="number"><?php echo number_format($factura->fac_total_valor,$dec)?></td>
            <td><?php echo  substr($factura->fac_nombre ,0,20)  ?></td>

            <?php
									$t_monto+=round($factura->fac_total_valor,$dec);
									}else{
									?>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <?php
									}
									?>

            <td style="width: 5px;!important" class="hidden-mobile"><?php echo  substr($factura->mp_c,0,13)?></td>
            <td><?php echo  substr($factura->mp_d,0,15)  ?></td>
            <td style="width: 5px; !important" class="number"><?php echo number_format($factura->dfc_cantidad,$dcc)?></td>
            <td style="width: 5px; !important" class="number"><?php echo number_format($factura->dfc_precio_unit,$dec)?></td>
            <td style="width: 5px; !important" class="number"><?php echo number_format($factura->dfc_val_descuento,$dec)?></td>
            <td style="width: 5px; !important" class="number"><?php echo number_format($factura->dfc_precio_total,$dec)?></td>
        </tr>

        <?php	
								$grup=$factura->fac_id;		
								
								$t_cnt+=round($factura->dfc_cantidad,$dec);
								$t_prec+=round($factura->dfc_precio_unit,$dec);
								$t_desc+=round($factura->dfc_val_descuento,$dec);
								$t_val+=round($factura->dfc_precio_total,$dec);
								
								}
							}
						?>
        <tr class="total">
            <th>Total</th>
            <th></th>
            
            <th class="number"><?php echo number_format($t_monto,$dec)?></th>
            <th></th>
            <th></th>
            <th></th>
            <th class="number"><?php echo number_format($t_cnt,$dec)?></th>
            <th class="number"><?php echo number_format($t_prec,$dec)?></th>
            <th class="number"><?php echo number_format($t_desc,$dec)?></th>
            <th class="number"><?php echo number_format($t_val,$dec)?></th>

        </tr>
    </tbody>

</table>



<style>
 #tbl_list td,
#tbl_list th {
    border-right: 2px solid #d7d7d7 !important;
    border-top: 2px solid #d7d7d7 !important;
    border-bottom: 2px solid #d7d7d7 !important;
    border-left: 2px solid #d7d7d7 !important;
    text-align: left !important;

}

#tbl_list tr:nth-child(2n-1) td,
#tbl_list tr:nth-child(2n-1) th {
    background: #DFDFDF !important; 

}
</style>