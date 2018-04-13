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
    
    public function ListaAmbienti($idUtente) {
        // utente -> id utente
        // ritorna lista di ambienti
        
        $rows = $this->ci->db->get_where('accesso', array('idUtente'=>$idUtente))->result('Ambiente');
        
        return $rows;
        
    }
    
    public function ListaImpianti($idAmbiente) {
        
        // ritorna lista impianti
        
        $rows = $this->ci->db->get_where('impianto', array('idAmbiente'=>$idAmbiente))->result('Impianto');
     
        
        return $rows;
    }

    
    
}