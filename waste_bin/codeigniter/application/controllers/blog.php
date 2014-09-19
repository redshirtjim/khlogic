<?php
class Blog extends CI_Controller {

	public function index()
	{
		$data['todo_list'] = array('Clean House', 'Call Mom', 'Run Errands');
		$data['title'] = "My Real Title";
		$data['heading'] = "My Real Heading";
		
		$this->load->view('blogview', $data);
		$this->load->view('menu');
		$this->load->view('content');
		$this->load->view('footer');
	}
	public function comments()
	{
		echo 'Look at this!';
	}
	 public function shoes($sandals, $id)
    {
        echo $sandals . "<br/>";
        echo $id;
    }
}
?>