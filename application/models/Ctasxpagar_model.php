<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ctasxpagar_model extends CI_Model {


	public function lista_factura_buscador($text,$f1,$f2,$emp_id){

		// $this->db->select('f.reg_id,f.reg_femision, pag_fecha_v, f.reg_num_documento, c.cli_raz_social, c.cli_ced_ruc,f.reg_total,pago,saldo,reg_estado');
		// $this->db->from('erp_reg_documentos f');
		// $this->db->join('erp_i_cliente c','f.cli_id=c.cli_id');
		// $this->db->join('pagosxdocumento p','f.reg_id=p.reg_id');
		// $this->db->where("(f.reg_num_documento like '%$text%' or c.cli_raz_social like '%$text%' or cli_ced_ruc like '%$text%') and f.reg_femision between '$f1' and '$f2' and reg_estado!=3 and emp_id=$emp_id", null);
		// $this->db->group_by('f.reg_id,f.reg_femision, , pag_fecha_v, f.reg_num_documento, c.cli_raz_social, c.cli_ced_ruc,f.reg_total,pago,saldo,reg_estado');
		// $this->db->order_by('c.cli_raz_social','asc');
		// $this->db->order_by('reg_num_documento','asc');

		$this->db->select("f.reg_id,f.reg_femision, pag_fecha_v, f.reg_num_documento, c.cli_raz_social, c.cli_ced_ruc,f.reg_total,(select sum(ctp_monto) from erp_ctasxpagar ec  
		where reg_id=f.reg_id and ctp_fecha_pago<='$f2' and ctp_estado=1) as pago
		,reg_estado");
		$this->db->from('erp_reg_documentos f');
		$this->db->join('erp_i_cliente c','f.cli_id=c.cli_id');
		$this->db->join('pagosxdocumento p','f.reg_id=p.reg_id');
		$this->db->where("(f.reg_num_documento like '%$text%' or c.cli_raz_social like '%$text%' or cli_ced_ruc like '%$text%')
		 and f.reg_femision between '$f1' and '$f2' and reg_estado!=3 and emp_id=$emp_id   and(p.reg_total>=(select sum(ct.ctp_monto) from erp_ctasxpagar ct where reg_id=f.reg_id and ct.ctp_estado='1' and ctp_fecha_pago between '$f1' and '$f2') or not exists(select * from erp_ctasxpagar ct where reg_id=f.reg_id and ct.ctp_estado='1' and ctp_fecha_pago between '1900-01-01' and '$f2')) ", null);
		$this->db->group_by('f.reg_id,f.reg_femision, , pag_fecha_v, f.reg_num_documento, c.cli_raz_social, c.cli_ced_ruc,f.reg_total,pago,saldo,reg_estado');
		$this->db->order_by('c.cli_raz_social','asc');
		$this->db->order_by('reg_num_documento','asc');

		$resultado=$this->db->get();
		return $resultado->result();

		//echo $this->db->last_query();

	}

	public function lista_vencer_vencido($text,$f1,$f2,$emp_id){
		// $this->db->select('f.reg_id,f.reg_femision, pag_fecha_v, f.reg_num_documento, c.cli_raz_social, c.cli_ced_ruc,f.reg_total,pago,saldo,reg_estado');
		// $this->db->from('erp_reg_documentos f');
		// $this->db->join('erp_i_cliente c','f.cli_id=c.cli_id');
		// $this->db->join('pagosxdocumento p','f.reg_id=p.reg_id');
		// $this->db->where("(f.reg_num_documento like '%$text%' or cli_raz_social like '%$text%' or cli_ced_ruc like '%$text%') and f.reg_femision between '$f1' and '$f2' and reg_estado!=3 and emp_id=$emp_id and (saldo is null or saldo!=0)", null);
		// $this->db->group_by('f.reg_id,f.reg_femision, pag_fecha_v, f.reg_num_documento, c.cli_raz_social, c.cli_ced_ruc,f.reg_total,pago,saldo,reg_estado');
		// $this->db->order_by('c.cli_raz_social','asc');
		// $this->db->order_by('reg_num_documento','asc');

		$this->db->select(" f.reg_id, f.reg_femision, pag_fecha_v, f.reg_num_documento,c.cli_raz_social, c.cli_ced_ruc, f.reg_total,(select sum(ctp_monto) from erp_ctasxpagar ec  
		where reg_id=f.reg_id and ctp_fecha_pago<='$f2' and ctp_estado=1) as pago, reg_estado ");
		$this->db->from('erp_reg_documentos f');
		$this->db->join('erp_i_cliente c','f.cli_id=c.cli_id');
		$this->db->join('pagosxdocumento p','f.reg_id=p.reg_id');

		$this->db->where("(f.reg_num_documento like '%$text%' or cli_raz_social like '%$text%' or cli_ced_ruc like '%$text%') and f.reg_femision between '$f1' and '$f2' and reg_estado!=3 and emp_id=$emp_id  and(p.reg_total>(select sum(ct.ctp_monto) from erp_ctasxpagar ct where reg_id=f.reg_id and ct.ctp_estado='1' and ctp_fecha_pago between '$f1' and '$f2') or not exists(select * from erp_ctasxpagar ct where reg_id=f.reg_id and ct.ctp_estado='1' and ctp_fecha_pago between '1900-01-01' and '$f2'))", null);

		$this->db->group_by('f.reg_id,f.reg_femision, pag_fecha_v, f.reg_num_documento, c.cli_raz_social, c.cli_ced_ruc,f.reg_total,pago,saldo,reg_estado');
		$this->db->order_by('c.cli_raz_social','asc');
		$this->db->order_by('reg_num_documento','asc');




		$resultado=$this->db->get();
		return $resultado->result();

		//echo $this->db->last_query();
	}

	public function lista_vencer_pagado($text,$f1,$f2,$emp_id){

		// $this->db->select('f.reg_id,f.reg_femision, pag_fecha_v, f.reg_num_documento, c.cli_raz_social, c.cli_ced_ruc,f.reg_total,pago,saldo,reg_estado');
		// $this->db->from('erp_reg_documentos f');
		// $this->db->join('erp_i_cliente c','f.cli_id=c.cli_id');
		// $this->db->join('pagosxdocumento p','f.reg_id=p.reg_id');
		// $this->db->where("(f.reg_num_documento like '%$text%' or c.cli_raz_social like '%$text%' or cli_ced_ruc like '%$text%') and f.reg_femision between '$f1' and '$f2' and reg_estado!=3 and emp_id=$emp_id and (saldo is null or saldo=0) and pag_fecha_v >'$f2'", null);
		// $this->db->group_by('f.reg_id,f.reg_femision, pag_fecha_v, f.reg_num_documento, c.cli_raz_social, c.cli_ced_ruc,f.reg_total,pago,saldo,reg_estado');
		// $this->db->order_by('c.cli_raz_social','asc');
		// $this->db->order_by('reg_num_documento','asc');

		$this->db->select("f.reg_id,f.reg_femision, pag_fecha_v, f.reg_num_documento, c.cli_raz_social, c.cli_ced_ruc,f.reg_total,
		(select sum(ctp_monto) from erp_ctasxpagar ec  
		where reg_id=f.reg_id and ctp_fecha_pago<='$f2' and ctp_estado=1) as pago,reg_estado");
		$this->db->from('erp_reg_documentos f');
		$this->db->join('erp_i_cliente c','f.cli_id=c.cli_id');
		$this->db->join('pagosxdocumento p','f.reg_id=p.reg_id');
		$this->db->where("(f.reg_num_documento like '%$text%' or c.cli_raz_social like '%$text%' or cli_ced_ruc like '%$text%') and f.reg_femision between '$f1' and '$f2' and reg_estado!=3 and emp_id=$emp_id 
		
		and(p.reg_total>(select sum(ct.ctp_monto) from erp_ctasxpagar ct where reg_id=f.reg_id and ct.ctp_estado='1' and ctp_fecha_pago between '$f1' and '$f2') or not exists(select * from erp_ctasxpagar ct where reg_id=f.reg_id and ct.ctp_estado='1' and ctp_fecha_pago between '1900-01-01' and '$f2'))
		
		and pag_fecha_v >'$f2'", null);
		$this->db->group_by('f.reg_id,f.reg_femision, pag_fecha_v, f.reg_num_documento, c.cli_raz_social, c.cli_ced_ruc,f.reg_total,pago,saldo,reg_estado');
		$this->db->order_by('c.cli_raz_social','asc');
		$this->db->order_by('reg_num_documento','asc');



		$resultado=$this->db->get();
		return $resultado->result();
	}

	public function lista_vencido_pagado($text,$f1,$f2,$emp_id){
		// $this->db->select('f.reg_id,f.reg_femision, pag_fecha_v, f.reg_num_documento, c.cli_raz_social, c.cli_ced_ruc,f.reg_total,pago,saldo,reg_estado');
		// $this->db->from('erp_reg_documentos f');
		// $this->db->join('erp_i_cliente c','f.cli_id=c.cli_id');
		// $this->db->join('pagosxdocumento p','f.reg_id=p.reg_id');
		// $this->db->where("(f.reg_num_documento like '%$text%' or c.cli_raz_social like '%$text%' or cli_ced_ruc like '%$text%') and f.reg_femision between '$f1' and '$f2' and reg_estado!=3 and emp_id=$emp_id and (saldo is null or saldo=0) and pag_fecha_v <='$f2'", null);
		// $this->db->group_by('f.reg_id,f.reg_femision, pag_fecha_v, f.reg_num_documento, c.cli_raz_social, c.cli_ced_ruc,f.reg_total,pago,saldo,reg_estado');
		// $this->db->order_by('c.cli_raz_social','asc');
		// $this->db->order_by('reg_num_documento','asc');

		$this->db->select("f.reg_id,f.reg_femision, pag_fecha_v, f.reg_num_documento, c.cli_raz_social, c.cli_ced_ruc,f.reg_total,
		(select sum(ctp_monto) from erp_ctasxpagar ec  
		where reg_id=f.reg_id and ctp_fecha_pago<='$f2' and ctp_estado=1) as pago,reg_estado");
		$this->db->from('erp_reg_documentos f');
		$this->db->join('erp_i_cliente c','f.cli_id=c.cli_id');
		$this->db->join('pagosxdocumento p','f.reg_id=p.reg_id');
		$this->db->where("(f.reg_num_documento like '%$text%' or c.cli_raz_social like '%$text%' or cli_ced_ruc like '%$text%') and f.reg_femision between '$f1' and '$f2' and reg_estado!=3 and emp_id=$emp_id 
		and(p.reg_total>=(select sum(ct.ctp_monto) from erp_ctasxpagar ct where reg_id=f.reg_id and ct.ctp_estado='1' and ctp_fecha_pago between '$f1' and '$f2') or not exists(select * from erp_ctasxpagar ct where reg_id=f.reg_id and ct.ctp_estado='1' and ctp_fecha_pago between '1900-01-01' and '$f2'))
		and pag_fecha_v <='$f2'", null);
		$this->db->group_by('f.reg_id,f.reg_femision, pag_fecha_v, f.reg_num_documento, c.cli_raz_social, c.cli_ced_ruc,f.reg_total,pago,saldo,reg_estado');
		$this->db->order_by('c.cli_raz_social','asc');
		$this->db->order_by('reg_num_documento','asc');

		$resultado=$this->db->get();
		return $resultado->result();
	}

	public function lista_vencer($text,$f1,$f2,$emp_id){
		$this->db->select("f.reg_id,f.reg_femision, pag_fecha_v, f.reg_num_documento, c.cli_raz_social, c.cli_ced_ruc,f.reg_total,
		(select sum(ctp_monto) from erp_ctasxpagar ec  
		where reg_id=f.reg_id and ctp_fecha_pago<='$f2' and ctp_estado=1) as pago,reg_estado");
		$this->db->from('erp_reg_documentos f');
		$this->db->join('erp_i_cliente c','f.cli_id=c.cli_id');
		$this->db->join('pagosxdocumento p','f.reg_id=p.reg_id');
		$this->db->where("(f.reg_num_documento like '%$text%' or cli_raz_social like '%$text%' or cli_ced_ruc like '%$text%') and f.reg_femision between '$f1' and '$f2' and reg_estado!=3 and emp_id=$emp_id 
		and(p.reg_total>=(select sum(ct.ctp_monto) from erp_ctasxpagar ct where reg_id=f.reg_id and ct.ctp_estado='1' and ctp_fecha_pago between '$f1' and '$f2') or not exists(select * from erp_ctasxpagar ct where reg_id=f.reg_id and ct.ctp_estado='1' and ctp_fecha_pago between '1900-01-01' and '$f2'))
		and pag_fecha_v > '$f2'", null);
		$this->db->group_by('f.reg_id,f.reg_femision, pag_fecha_v, f.reg_num_documento, c.cli_raz_social, c.cli_ced_ruc,f.reg_total,pago,saldo,reg_estado');
		$this->db->order_by('c.cli_raz_social','asc');
		$this->db->order_by('reg_num_documento','asc');
		$resultado=$this->db->get();
		return $resultado->result();
	}

	public function lista_vencido($text,$f1,$f2,$emp_id){
		$this->db->select("f.reg_id,f.reg_femision, pag_fecha_v, f.reg_num_documento, c.cli_raz_social, c.cli_ced_ruc,f.reg_total,
		(select sum(ctp_monto) from erp_ctasxpagar ec  
		where reg_id=f.reg_id and ctp_fecha_pago<='$f2' and ctp_estado=1) as pago,reg_estado");
		$this->db->from('erp_reg_documentos f');
		$this->db->join('erp_i_cliente c','f.cli_id=c.cli_id');
		$this->db->join('pagosxdocumento p','f.reg_id=p.reg_id');
		$this->db->where("(f.reg_num_documento like '%$text%' or cli_raz_social like '%$text%' or cli_raz_social like '%$text%') and f.reg_femision between '$f1' and '$f2' and reg_estado!=3 and emp_id=$emp_id 
		and(p.reg_total>=(select sum(ct.ctp_monto) from erp_ctasxpagar ct where reg_id=f.reg_id and ct.ctp_estado='1' and ctp_fecha_pago between '$f1' and '$f2') or not exists(select * from erp_ctasxpagar ct where reg_id=f.reg_id and ct.ctp_estado='1' and ctp_fecha_pago between '1900-01-01' and '$f2'))
		and pag_fecha_v <= '$f2'", null);
		$this->db->group_by('f.reg_id,f.reg_femision, pag_fecha_v, f.reg_num_documento, c.cli_raz_social, c.cli_ced_ruc,f.reg_total,pago,saldo,reg_estado');
		$this->db->order_by('c.cli_raz_social','asc');
		$this->db->order_by('reg_num_documento','asc');
		$resultado=$this->db->get();
		return $resultado->result();
	}

	public function lista_pagado($text,$f1,$f2,$emp_id){
		$this->db->select("f.reg_id,f.reg_femision, pag_fecha_v, f.reg_num_documento, c.cli_raz_social, c.cli_ced_ruc,f.reg_total,
		(select sum(ctp_monto) from erp_ctasxpagar ec  
		where reg_id=f.reg_id and ctp_fecha_pago<='$f2' and ctp_estado=1) as pago, reg_estado");
		$this->db->from('erp_reg_documentos f');
		$this->db->join('erp_i_cliente c','f.cli_id=c.cli_id');
		$this->db->join('pagosxdocumento p','f.reg_id=p.reg_id');
		$this->db->where("(f.reg_num_documento like '%$text%' or cli_raz_social like '%$text%' or cli_ced_ruc like '%$text%') and f.reg_femision between '$f1' and '$f2' and reg_estado!=3 and emp_id=$emp_id and saldo=0", null);
		$this->db->group_by('f.reg_id,f.reg_femision, pag_fecha_v, f.reg_num_documento, c.cli_raz_social, c.cli_ced_ruc,f.reg_total,pago,saldo,reg_estado');
		$this->db->order_by('c.cli_raz_social','asc');
		$this->db->order_by('reg_num_documento','asc');
		$resultado=$this->db->get();
		return $resultado->result();
	}

	
	
	public function lista_pagos_factura($id){
		$this->db->from('erp_pagos_documentos p');
		$this->db->join('erp_reg_documentos c','p.reg_id=c.reg_id');
		$this->db->where('c.reg_id',$id);
		$this->db->where('pag_estado','1');
		$resultado=$this->db->get();
		return $resultado->result();
			
	}

	public function lista_ctasxpagar($id){
		$this->db->from('erp_ctasxpagar c');
		$this->db->join('erp_reg_documentos f','c.reg_id=f.reg_id');
		$this->db->where("f.reg_id", $id);
		$this->db->where('ctp_estado','1');
		$this->db->order_by('ctp_fecha_pago','asc');
		$resultado=$this->db->get();
		return $resultado->result();
	}


	public function lista_saldo_factura($id){
		$this->db->select('f.reg_id,f.reg_femision, pag_fecha_v, f.reg_num_documento, c.cli_raz_social, c.cli_ced_ruc,f.reg_total,pago,saldo,reg_estado');
		$this->db->from('erp_reg_documentos f');
		$this->db->join('erp_i_cliente c','c.cli_id=f.cli_id');
		$this->db->join('pagosxdocumento p','f.reg_id=p.reg_id');
		$this->db->where('f.reg_id',$id);
		$this->db->group_by('f.reg_id,f.reg_femision, pag_fecha_v, f.reg_num_documento, c.cli_raz_social, c.cli_ced_ruc,f.reg_total,pago,saldo,reg_estado');
		$resultado=$this->db->get();
		return $resultado->row();
	}

	public function insert($data){
		$this->db->insert("erp_ctasxpagar",$data);
		return $this->db->insert_id();
	}


    
	public function lista_nota_credito_factura($id){
		$this->db->from('reg_nota_credito');
		$this->db->where('reg_id',$id);
		$this->db->where('rnc_estado !=','3');
		$resultado=$this->db->get();
		return $resultado->row();
			
	}

	
	public function lista_retencion_factura($id){
		$this->db->from('erp_registro_retencion');
		$this->db->where('reg_id',$id);
		$this->db->where('rgr_estado !=','3');
		$resultado=$this->db->get();
		return $resultado->row();
			
	}

	public function lista_una_factura_cliente($num,$id,$emp){
		$this->db->from('erp_factura');
		$this->db->where('fac_numero',$num);
		$this->db->where('cli_id',$id);
		$this->db->where('emp_id',$emp);
		$this->db->where('fac_estado!=3',null);
		$resultado=$this->db->get();
		return $resultado->row();
			
	}

	public function update($id,$data){
		$this->db->where('ctp_id',$id);
		return $this->db->update("erp_ctasxpagar",$data);
			
	}

	

	public function delete_pagos_factura($id){
		$this->db->where('com_id',$id);
		return $this->db->delete("erp_ctasxpagar");
			
	}

    public function lista_secuencial_ctasxpagar(){
		$this->db->order_by('ctp_secuencial','desc');
		$resultado=$this->db->get('erp_ctasxpagar');
		return $resultado->row();
	}

	public function lista_ctasxpagar_retencion($id){
		$this->db->where('doc_id',$id);
		$this->db->where('ctp_forma_pago','7');
		$resultado=$this->db->get('erp_ctasxpagar');
		return $resultado->row();
			
	}

	public function update_cta($id,$data){
		$this->db->where('ctp_id',$id);
		return $this->db->update("erp_ctasxpagar",$data);
			
	}

	public function lista_una_ctaxpagar($id){
		$this->db->from('erp_ctasxpagar c');
		$this->db->join('erp_reg_documentos f','c.reg_id=f.reg_id');
		$this->db->where("ctp_id", $id);
		$resultado=$this->db->get();
		return $resultado->row();
	}

	public function lista_pagos_buscador($emp,$fec1,$fec2,$txt){
		$this->db->from('erp_ctasxpagar c');
		$this->db->join('erp_reg_documentos f','c.reg_id=f.reg_id');
		$this->db->join('erp_i_cliente cl','cl.cli_id=f.cli_id');
		$this->db->where("f.reg_estado!=3 and ctp_forma_pago!='7' and ctp_forma_pago!='8' and ctp_estado!=3 and (reg_num_documento like '%$txt%' or cli_raz_social like '%$txt%' or cli_ced_ruc like '%$txt%') and ctp_fecha_pago between '$fec1' and '$fec2' and c.emp_id=$emp",null);
		$this->db->order_by('ctp_fecha_pago','asc');
		$this->db->order_by('reg_num_documento','asc');
		$resultado=$this->db->get();
		return $resultado->result();
			
	}

	public function lista_notas_credito_cliente($id,$emp){
		$this->db->from('erp_registro_nota_credito');
		$this->db->where('cli_id',$id);
		$this->db->where('emp_id',$emp);
		$this->db->where('rnc_estado','21');
		$resultado=$this->db->get();
		return $resultado->result();
			
	}

	public function lista_pagos_nota_credito($id){
		$query ="SELECT sum(ctp_monto) as ctp_monto FROM erp_ctasxpagar where doc_id='$id' and ctp_forma_pago='8' and ctp_estado!=3";
        $resultado=$this->db->query($query);
		return $resultado->row();
	}
}

?>