<?php


class AmbienteCrud {
    
    
    protected $ci;
    
        
    public function __construct() {
        $this->ci =& get_instance();

        $this->ci->load->database();
        
        $this->ci->load->model('Ambiente');
        $this->ci->load->model('Impianto');

    }
    
    
    public function GetImpiantoBySensore($id_sensore) {
        $row = $this->ci->db->get_where('sensore_impianto', array('idSensoreImpianto'=>$id_sensore))->result();
        if (count($row)>0)
            return $row[0]->idImpianto;
        else
            return 0;
    }
    
    public function ListaAmbienti($utente) {
        // utente -> string
        // ritorna lista di ambienti
        
        
    }
    
    public function ListaImpianti($idAmbiente) {
        
        // ritorna lista impianti
        
        
        
    }

    
    
}