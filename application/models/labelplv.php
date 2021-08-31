<?php
class Labelplv extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }

        public function get_plv()
        {
                $this->db->select('*');
                $this->db->from('ps_product_lang');
                $this->db->join('ps_product', 'ps_product.id_product = ps_product_lang.id_product');
            return $query = $this->db->get();
        }

        

        public function get_plv_search($ref)
        {
                $this->db->select('ps_product.id_product, ps_product.id_product as id_product_one,ps_product.price as prix_unique,ps_product.reference,ps_product_lang.description_short,ps_product_lang.description,ps_product_attribute.id_product,ps_product_attribute.price,id_image');
                $this->db->from('ps_product');
                $this->db->join('ps_product_lang', 'ps_product_lang.id_product = ps_product.id_product');
                $this->db->join('ps_product_attribute', 'ps_product.id_product = ps_product_attribute.id_product','left');
                $this->db->join('ps_product_attribute_image', 'ps_product_attribute_image.id_product_attribute = ps_product_attribute.id_product_attribute','left');
                $this->db->where('ps_product.reference',$ref);
                return $query= $this->db->get();
        }

        public function getRows($params = array()){
                $this->db->select("*");
                $this->db->from('ps_product');
                
                //Recupere les donnée par condition
                if(array_key_exists("conditions",$params)){
                    foreach ($params['conditions'] as $key => $value) {
                        $this->db->where($key,$value);
                    }
                }
                
                //recherche par terme
                if(!empty($params['searchTerm'])){
                    $this->db->like('reference', $params['searchTerm']);
                }
                
                $this->db->order_by('reference', 'asc');
                
                if(array_key_exists("id",$params)){
                    $this->db->where('id',$params['id']);
                    $query = $this->db->get();
                    $result = $query->row_array();
                }else{
                    $query = $this->db->get();
                    $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
                }
        
                //Recupération des donnée une fois trier par les conditions ci-dessus
                return $result;
            }
        
}