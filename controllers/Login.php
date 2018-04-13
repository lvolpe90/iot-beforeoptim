<?php

class Login extends CI_Controller {

	/**
     * application/controllers/Login.php
	 */

    
    private $role = false;
    private $fullname = false;
    
    private $is_logged_in = false;
    

    public function __construct() {
        


        parent::__construct();
        
        $utenti = array('admin'=>array('role'=>'Administrator', 'password'=>'1234', 'fullname'=>'Luigi Volpe',                                                      'image'=>'assets/img/avatar5.png', 'id'=>0),
               'utente'=>array('id'=>1, 'role'=>'Utente', 'password'=>'utente', 'fullname'=>'CLIENTE 1', 'image'=>'assets/img/avatar3.png'));


        //$utenti = $this->db->query('SELECT * FROM utenti')->result();

        $this->template->page_header = 'Accesso al dashboard';
        
        if (!$this->session->login) {
            $username  = '';
            $password  = '';

            if (isset($this->input->post()['username'])) {
                $username = $this->input->post()['username'];
            }
            if (isset($this->input->post()['password'])) {
                $password = $this->input->post()['password'];
            }

            if ($username!='' && $password!='') {
                // controlla l'accesso perché ha ricevuto i dati dal form!
                $username = trim(strtolower($username));

                if (isset($utenti[$username])) {
                    if ($utenti[$username]['password'] == $password) {
                        $this->role = $utenti[$username]['role'];
                        $this->fullname = $utenti[$username]['fullname'];
                        $this->image = base_url($utenti[$username]['image']);
                        $this->id = $utenti[$username]['id'];
                    }
                }

            }


            if ($this->role) {
                // Login valido

                $this->session->login = true;
                $this->session->username = $username;
                $this->session->role = $this->role;
                $this->session->image = $this->image;
                $this->session->fullname = $this->fullname;
                $this->session->id = $this->id;
                
                $this->is_logged_in = true;



            } else {
                $this->session->login = false;
                $this->session->username = false;
                $this->session->role = false;
                $this->session->image = false;
                $this->session->fullname = false;
                $this->session->id = false;
                
                $this->is_logged_in = false;


            }           
        } else {
            $this->is_logged_in = true;
        }

    }
    
	public function index()
	{

        if ($this->is_logged_in) {
            redirect(); // effettua un redirect alla home  
        } else {
            $this->template->load('login');
        }

        
		//$this->load->view('welcome_message', $params);
	}
    
    
    public function logout() {
        $this->session->login = false;
        $this->session->username = false;
        $this->session->role = false;   
        $this->session->image = false;
        $this->session->fullname = false;
        $this->session->id = false;
        
        $this->template->load('login');
    }


    public function profile() {
        if ($this->is_logged_in) {
            $this->template->page_header = 'Il mio profilo';
            $this->template->load('profile');
        } else {
            $this->template->load('login');
        }
    }
}
