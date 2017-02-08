<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Section extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('section/section_model');
	}

	public function index()
	{
		$this->load->helper('url');
		$this->load->view('section/section_view');


	}

	public function ajax_list()
	{
		$list = $this->section_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
                $i=1;
		foreach ($list as $fields) {
			$no++;
			$row = array();
                        $row[] =$i++;
			$row[] = ucwords($fields->secname);
			$row[] = $fields->secdesc;
				$deptcode = $fields->deptid;
				$abc=$this->section_model->get_deptname($deptcode);	
			$row[] =$abc->deptname;
			$row[] = $fields->createdate;
			//$row[] = $person->deleted;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_person('."'".$fields->secid."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
				  <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="delete_person('."'".$fields->secid."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->section_model->count_all(),
						"recordsFiltered" => $this->section_model->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->section_model->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
				$this->_validate();
				$data = array(
				'secname' => ucwords($this->input->post('secname')),
				'secdesc' => $this->input->post('secdesc'),
				'deptid' => $this->input->post('deptid'),
				'createdate' => date("Y-m-d"),
				'deleted' => "0"			
			);
			
		$insert = $this->section_model->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'secname' => $this->input->post('secname'),
				'secdesc' => $this->input->post('secdesc'),
				'deptid' => $this->input->post('deptid'),
				'createdate' => date("Y-m-d"),
				'deleted' => "0"
			);
		$this->section_model->update(array('secid' => $this->input->post('secid')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->section_model->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}


	public function load_dept()
	{				
		$data=$this->section_model->load_dept();
		//print_r($data);
		$d="<select>";
		$d="<option value='0'>Select one</option>";
		foreach($data as $k){
			$d .= "<option value='".$k->deptid."'>".$k->deptname."</option>";
			}
			$d .="</select>";
		echo $d;
	}



	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('secname') == '')
		{
			$data['inputerror'][] = 'secname';
			$data['error_string'][] = 'Section Title is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('secdesc') == '')
		{
			$data['inputerror'][] = 'secdesc';
			$data['error_string'][] = 'Section Description is required';
			$data['status'] = FALSE;
		}
/*
		if($this->input->post('deleted') == '')
		{
			$data['inputerror'][] = 'deleted';
			$data['error_string'][] = 'Date of Birth is required';
			$data['status'] = FALSE;
		}
		*/

		if($this->input->post('deptid') == '0')
		{
			$data['inputerror'][] = 'deptid';
			$data['error_string'][] = 'Please select department';
			$data['status'] = FALSE;
		}

	/*	if($this->input->post('createdate') == '')
		{
			$data['inputerror'][] = 'createdate';
			$data['error_string'][] = 'Addess is required';
			$data['status'] = FALSE;
		}*/

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

}
