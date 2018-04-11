<?php

class Welcome extends CI_Controller {

	/**
	 * application/controllers/Welcome.php
	 */
	public function index()
	{
        
                    
            $this->load->helper ('Persistenza/RilevazioneCrud');

            
            $ril = new RilevazioneCrud();
            
            
            echo $ril->LeggiRilevazioni(1);
        
        
        $this->template->page_header = 'IoT Inc. - Progetto sensori';

        if (! $this->session->login ) {
            $this->template->load('welcome_message');
        } else {
            
            // qui mettere la pagina del dashboard
            $this->template->load('admin/dashboard');
            
         

            
        }
        
        
	}

}
