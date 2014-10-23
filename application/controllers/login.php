<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
        $data_header['css_list'] = array('login');
        $data_header['js_list'] = array('');
		$this->load->view('header_view', $data_header);
        
		$this->load->view('login_view');
        
		$this->load->view('footer_view');
	}
    
    public function validate()
    {
        //load
		$this->load->model('user_model');
		
        $username = stripslashes($this->input->post('username'));
        $password = md5(stripslashes($this->input->post('password')));
        $users = $this->user_model->get($username, $password);
        
        if(count($users) > 0)
        {	//user ada
            $user = $users[0];
            
            $userdata = array(
                'id' => $user->id,
                'username' => $username,
                'role' => $user->role
            );
            $this->session->set_userdata($userdata);	
            
            if ($user->role == "admin")
            {
                //redirect('admin');
            }
            else if ($user->role == "laporan")
            {
                redirect('laporan');
            }
            else if ($user->role == "kasir")
            {
                redirect('kasir');
            }
        }
        else
        {
            redirect('');
        }
    }
    
	public function logout(){
		$this->session->sess_destroy();
		redirect('');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */