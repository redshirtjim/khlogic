<?php

class Membership_model extends CI_Model {
	function validate()
	{
		$this->db->where('email', $this->input->post('email'));
		$this->db->where('passw', sha1($this->input->post('passw')));
		$query = $this->db->get('users');
		
		if($query->num_rows == 1)
		{
			return true;
		}
	}
}