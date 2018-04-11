<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
     * application/controllers/Login.php
	 */

    
    private $role = false;
    private $fullname = false;
    
    private $is_logged_in = false;
    
    private $utenti = array("admin"=>array("role"=>"Administrator", "password"=>"1234", "fullname"=>"Luigi Volpe",                                                      "image"=>"assets/img/avatar5.png"),
                           "utente"=>array("role"=>"Utente", "password"=>"1234", "fullname"=>"Ospite", "image"=>"assets/img/avatar3.png"));
    
    private function db() {
//        $this->load->dbforge();
//        
//        $this->dbforge->drop_table("utenti");
//        
//        $this->dbforge->add_field("id");
//        $this->dbforge->add_key("id");
//        $this->dbforge->create_table('utenti', TRUE);
//        
//        $this->dbforge->add_column('utenti', 'username');
//        $this->dbforge->add_column('utenti', 'password');
//        $this->dbforge->add_column('utenti', 'fullname');
//        $this->dbforge->add_column('utenti', 'image');
    }
    
    public function __construct() {

        parent::__construct();
        
        $this->db();

        //$utenti = $this->db->query("SELECT * FROM utenti")->result();

        $this->template->page_header = "Accesso al dashboard";
        
        if (!$this->session->login) {
            $username  = "";
            $password  = "";

            if (isset($this->input->post()["username"])) {
                $username = $this->input->post()["username"];
            }
            if (isset($this->input->post()["password"])) {
                $password = $this->input->post()["password"];
            }

            if ($username!="" && $password!="") {
                // controlla l'accesso perché ha ricevuto i dati dal form!
                $username = trim(strtolower($username));

                if (isset($this->utenti[$username])) {
                    if ($this->utenti[$username]["password"] == $password) {
                        $this->role = $this->utenti[$username]["role"];
                        $this->fullname = $this->utenti[$username]["fullname"];
                        $this->image = base_url($this->utenti[$username]["image"]);
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
                $this->is_logged_in = true;



            } else {
                $this->session->login = false;
                $this->session->username = false;
                $this->session->role = false;
                $this->session->image = false;
                $this->session->fullname = false;
                
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
        
        $this->template->load('login');
    }


    public function profile() {
        if ($this->is_logged_in) {
            $this->template->page_header = "Il mio profilo";
            $this->template->load('profile');
        } else {
            $this->template->load('login');
        }
    }
}
