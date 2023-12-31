<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<section class="content-header">
    <form id="exp_excel" style="float:right;padding:0px;margin: 0px;" method="post"
        action="<?php echo base_url();?>ctasxpagar/excel/<?php echo $permisos->opc_id?>/<?php echo $fec1?>/<?php echo $fec2?>"
        onsubmit="return exportar_excel()">
        <input type="submit" value="EXCEL" class="btn btn-success" />
        <input type="hidden" id="datatodisplay" name="datatodisplay">
    </form>
    <h1>
        Pagos
    </h1>
</section>
<section class="content">
    <div class="box box-solid">
        <div class="box box-body">

            <div class="row">
                <div class="col-md-9">
                    <form action="<?php echo $buscar;?>" method="post">

                        <table width="100%">
                            <tr>
                                <td><label>Buscar:</label></td>
                                <td><input type="text" id='txt' name='txt' class="form-control" style="width: 180px"
                                        value='<?php echo $txt?>' /></td>
                                <td><label>Desde:</label></td>
                                <td><input type="date" id='fec1' name='fec1' class="form-control" style="width: 150px"
                                        value='<?php echo $fec1?>' /></td>
                                <td><label>Hasta:</label></td>
                                <td><input type="date" id='fec2' name='fec2' class="form-control" style="width: 150px"
                                        value='<?php echo $fec2?>' /></td>
                                <td><button type="submit" class="btn btn-info"><span class="fa fa-search"></span>
                                        Buscar</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <table id="tbl_list" class="table table-bordered table-list table-hover" width="100%">
                        <thead>
                            <th>No</th>
                            <th>Ruc</th>
                            <th>Proveedor</th>
                            <th>Factura</th>
                            <th>Fecha Pago</th>
                            <th>Forma Pago</th>
                            <th>Documento</th>
                            <th>Concepto</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </thead>
                        <tbody>
                            <?php 
						$n=0;
						$dec=$dec->con_valor;
						if(!empty($pagos)){
							foreach ($pagos as $pago) {
								$n++;
								switch ($pago->ctp_forma_pago) {
                                    case '11': $fp="TARJETA DE CREDITO"; break;
                                    case '13': $fp="TARJETA DE DEBITO"; break;
                                    case '4': $fp="CHEQUE"; break;
                                    case '1': $fp="EFECTIVO"; break;
                                    case '5': $fp="CERTIFICADOS"; break;
                                    case '6': $fp="TRANSFERENCIA"; break;
                                    case '7': $fp="RETENCION"; break;
                                    case '8': $fp="NOTA CREDITO"; break;
                                    case '9': $fp="CREDITO"; break;
                                    case '10': $fp="CRUCE DE CUENTAS"; break;
                                  }
						?>
                            <tr>
                                <td><?php echo $n?></td>
                                <td style="mso-number-format:'@'"><?php echo $pago->cli_ced_ruc?></td>
                                <td><?php echo $pago->cli_raz_social?></td>
                                <td><?php echo $pago->reg_num_documento?></td>
                                <td><?php echo $pago->ctp_fecha_pago?></td>
                                <td><?php echo $fp?></td>
                                <td><?php echo $pago->num_documento?></td>
                                <td><?php echo $pago->ctp_concepto?></td>
                                <td class="number">
                                    <?php echo str_replace(',', '', number_format($pago->ctp_monto,$dec))?></td>
                                <td align="center">
                                    <div class="btn-group">
                                        <?php
										if($permisos->rop_eliminar){
										?>
                                        <a onclick="anular(<?php echo $pago->ctp_id?>,<?php echo $pago->num_documento?>,'<?php echo $pago->reg_num_documento?>',<?php echo $permisos->opc_id?>)"
                                            class="btn btn-danger " title="Anular"><span
                                                class="fa fa-times"></span></a>
                                        <?php 
										}
										?>
                                    </div>
                                </td>
                            </tr>
                            <?php
								
							}
						}
						?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- href="<?php echo base_url();?>anular_ctasxpagar/anular/<?php echo $pago->ctp_id?>/<?php echo $pago->num_documento?>/<?php echo $pago->reg_num_documento?>/<?php echo $permisos->opc_id?> -->

<script>

function anular(id, num_doc, reg_num, opc) {


    var aut = '<?php echo $cre_aut->con_valor ?>';

    var clave = '<?php echo $cre_aut->con_valor2 ?>';
    if (aut.trim() == '0') {

// url: '<?php echo base_url();?>anular_ctasxpagar/anular/' + id + "/" + num_doc +  "/" + reg_num + "/" + opc,
        Swal.fire({
              title: '¿Desea Anular el registro? \nIngrese la clave de seguridad: ',
              html:'<input type="" class="form-control" name="clave" id="clave" value="">',
              inputAttributes: {
                autocapitalize: 'none'
              },
              showCancelButton: true,
              confirmButtonText: 'Aceptar',
              cancelButtonText: 'Cancelar',
              showLoaderOnConfirm: true,
              }).then((result) => {
                 cred = $('#clave').val();
                 if (result.isConfirmed) {

                    if (cred.trim()==clave.trim()) {
                        var ruta='<?php echo base_url();?>anular_ctasxpagar/anular/' + id + "/" + num_doc +  "/" + reg_num + "/" + opc;
                        $.ajax({
                            url: ruta,
                            type: 'JSON',
                            dataType: 'JSON',
                            success: function (resp) {
                                if(resp.estado==1){
                                    alert(resp.sms);
                                }else{
                                    window.location.href= base_url+resp.url;
                                }
                            }
                        })

                    }else{
                        Swal.fire("La clave es incorrecta");
                    }
                }
            }) 
        }else{
            Swal.fire({
              title: '¿Desea Anular el registro?',
              showCancelButton: true,
              confirmButtonText: 'Aceptar',
              cancelButtonText: 'Cancelar',
              showLoaderOnConfirm: true,
              }).then((result) => {
                 if (result.isConfirmed) {
                    var ruta='<?php echo base_url();?>anular_ctasxpagar/anular/' + id + "/" + num_doc +  "/" + reg_num + "/" + opc;
                    $.ajax({
                            url: ruta,
                            type: 'JSON',
                            dataType: 'JSON',
                            success: function (resp) {
                                if(resp.estado==1){
                                    alert(resp.sms);
                                }else{
                                    window.location.href= base_url+resp.url;
                                }
                            }
                    })

                }
            })
        }     
    }      
</script>