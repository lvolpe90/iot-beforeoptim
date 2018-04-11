<?php 
/**
 * This CI library allows you to load a view 
 * together with its header and footer in one
 * call.
 * 
 * @author Nelson Ameyo <nelson@blackpay.co.ke>
 * @version 1.0
 * @license GNU General Public License v2.0
 * @link https://github.com/DeveintLabs/CI-Template-Loader
 * 
 * */
class Template
{
  protected 	$ci;
  	# Header and footer location
 	public $header = 'template/header';
 	public $footer = 'template/footer';
    public $admin_header = 'template/admin/header';
    public $admin_footer = 'template/admin/footer';
    public $page_header = '';
    
    public $is_admin = false;
    
	public function __construct()
	{
        $this->ci =& get_instance();
	}
	public function load($views='', $data='')
	{
		// load header
        
        if (!is_array($data)) $data = array();
        
        $data['page_header'] = $this->page_header;
        
        if (! $this->ci->session->login ) {
            $this->is_admin = false;    
        } else {
            $this->is_admin = true;
        }
        

        if ($this->is_admin) {
            
            $userData = array();
            $userData['name'] = $this->ci->session->username;
            $userData['role'] = $this->ci->session->role;
            $userData['image'] = $this->ci->session->image;
            $userData['fullname'] = $this->ci->session->fullname;
            
            $data['user'] = $userData;
            
            if($this->admin_header)
            {
                $this->ci->load->view($this->admin_header, $data);
                $data = '';
            }
            // Load content, can be more than one view
            if(is_array($views))
            {
                foreach ($views as $view) 
                {
                    $this->ci->load->view($view, $data);
                    $data = '';
                }
            } else {
                $this->ci->load->view($views, $data);
            }
            // load footer
            if($this->admin_footer)
            {
                $this->ci->load->view($this->admin_footer, $data);
                $data = '';
            }                  
        } else {
            if($this->header)
            {
                $this->ci->load->view($this->header, $data);
                $data = '';
            }
            // Load content, can be more than one view
            if(is_array($views))
            {
                foreach ($views as $view) 
                {
                    $this->ci->load->view($view, $data);
                    $data = '';
                }
            } else {
                $this->ci->load->view($views, $data);
            }
            // load footer
            if($this->footer)
            {
                $this->ci->load->view($this->footer, $data);
                $data = '';
            }           
        }
        

	}
	
}