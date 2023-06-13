<section class="content">
    <div class="box box-solid">
        <div class="box box-body">

            <div class="row">

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
                                    <td rowspan="4" width="20%">
                                        <img src="<?php echo base_url().'imagenes/'.$empresa->emp_logo?>" width="120px"
                                            height="70px">
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

                <div class="col-md-8">

                    <div class="row">
                        <div class="col-md-12">
                            <table id="tbl_list" class="table table-bordered table-list table-hover">
                                <tr>

                                    <th>RUC/CI</th>
                                    <th ><?php echo utf8_encode('Razón Social')?></th>
                                    <th class="hidden-mobile">Ciudad</th>
                                    <th class="hidden-mobile"><?php echo utf8_encode('Teléfono') ?></th>
                                    <th class="hidden-mobile">Email</th>
                                    <th>Estado</th>

                                </tr>
                                <tbody>
                                    <?php 
						$n=0;
						if(!empty($clientes)){
							foreach ($clientes as $cliente) {
								$n++;
						?>
                                    <tr>

                                        <td style="mso-number-format:'@'"><?php echo $cliente->cli_ced_ruc?></td>
                                        <td><?php echo $cliente->cli_raz_social?></td>
                                        <td class="hidden-mobile"><?php echo $cliente->cli_canton?></td>
                                        <td class="hidden-mobile" style="mso-number-format:'@'">
                                            <?php echo $cliente->cli_telefono?></td>
                                        <td class="hidden-mobile" style="text-transform: lowercase;">
                                            <?php echo $cliente->cli_email?></td>
                                        <td><?php echo $cliente->est_descripcion?></td>

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

<style>
     #tbl_list td, #tbl_list th{
        /*border: 1px solid;
        border-color: #ffffff;
         background:#d7d7d7; */
        border-right: 2px solid #d7d7d7 !important;
        border-top: 2px solid #d7d7d7 !important;
        border-bottom: 2px solid #d7d7d7 !important;
        border-left: 2px solid #d7d7d7 !important;

    }

    #tbl_list tr:nth-child(2n-1) td ,#tbl_list tr:nth-child(2n-1) th {
      background: #DFDFDF !important;

    }
</style>