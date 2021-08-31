<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
	{
		    header("Access-Control-Allow-Origin: *");
			parent::__construct();
			$this->load->model('labelplv');
			$this->load->helper('url_helper');
			$this->load->helper('form');
			$this->load->library('javascript');
    		$this->load->library('javascript/jquery');
			$this->load->helper('url');
			
	}

	public function index()
	{
		$data['labelplv'] = $this->labelplv->get_plv();
		$this->load->view('index_plv',$data);
	}



	public function searchRef(){

		$ref = $this->input->post('searchRef');
		$data['labelplv'] = $this->labelplv->get_plv_search($ref);
        $this->load->view('plv_single', $data);

	}


	function autocompleteData() {
        $returnData = array();
        
        // reçois les donnée de reference
        $conditions['searchTerm'] = $this->input->get('term');
        
        $skillData = $this->labelplv->getRows($conditions);
        
        // Génere un tableau
        if(!empty($skillData)){
            foreach ($skillData as $row){
                $data['value'] = $row['reference'];
                array_push($returnData, $data);
            }
        }
        
        // Retourne le résultat comme un tableau JSON
        echo json_encode($returnData);die;
    }

}
	

