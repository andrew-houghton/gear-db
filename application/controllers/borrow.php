<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class borrow extends CI_Controller {
	public function __construct()
	{
        parent::__construct();
		$this->load->helper('application_helper');

		$this->load->model('gear_model');
		$this->load->model('people_model');
		$this->load->model('borrow_model');

        $this->load->view('templates/header');
        $this->load->view('templates/footer');
	}

	public function borrow()
	{
		$output['data']['gear']= $this->gear_model->get_stuff();
		$output['data']['people']= $this->people_model->get_stuff();
		// dbg($output);
        render('borrow/borrow',$output);
	}

	public function save($id=null){

		$postData['gear']=json_decode($_POST['gear_selected'],TRUE);
		$postData['person']=json_decode($_POST['person_borrowing'],TRUE);
		$borrow_insert_data=array();

		dbg($_POST);
		foreach($postData['gear'] as $val){
			$temp_row=array(
				'gear_id'		=>$val['id'],
				'person_id'		=>$postData['person']['id'],
				'deposit'		=>$_POST['deposit'],
				// 'comment'		=>$_POST['comments'],
				'returned'		=>0);
			array_push($borrow_insert_data,$temp_row);
		}

		$this->borrow_model->insert($borrow_insert_data);

		redirect('borrow/view');
	}

	public function view()
	{
		$output['data']['rows']= $this->borrow_model->get_stuff();
		// dbg($output);
		$output['data']['Fields']=array(
				array('Fields'=>'name',				'DisplayName'=>'Borrower Name'),
				array('Fields'=>'gear_name',		'DisplayName'=>'Item Name'),
				array('Fields'=>'deposit',			'DisplayName'=>'Deposit'),
				array('Fields'=>'date_borrow',		'DisplayName'=>'Date of Borrowing'),
				array('Fields'=>'date_return',		'DisplayName'=>'Date of Returning'),
				array('Fields'=>'returned',			'DisplayName'=>'Returned'),
				array('Fields'=>'borrow_group_id',	'DisplayName'=>'Borrow Group Number'),
			);
        render('borrow/view',$output);
	}
}