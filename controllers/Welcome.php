<?php

class Welcome extends CI_Controller {

	/**
	 * application/controllers/Welcome.php
	 */
	public function index()
	{
        
            $this->template->page_header = 'IoT Inc. - Progetto sensori';

            if (! $this->session->login ) {
                $this->template->load('welcome_message');
            } else {

                redirect('RichiestaDashboard');




            }
        
        
	}

}
