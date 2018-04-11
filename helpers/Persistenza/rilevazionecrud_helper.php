<?php



class RilevazioneCrud {
    
    protected $ci;
    
        
    public function __construct() {
        $this->ci =& get_instance();

        $this->ci->load->database();
        
        $this->ci->db->query('CREATE TABLE IF NOT EXISTS rilevazione (idSensore INTEGER, idImpianto INTEGER, dataora DATETIME, valore REAL, note TEXT, idRilevazione INTEGER PRIMARY KEY)');
        
        $this->ci->db->query('CREATE TABLE IF NOT EXISTS impianto (idAmbiente INTEGER, descrizione TEXT, idImpianto INTEGER PRIMARY KEY)');
        
        $this->ci->db->query('CREATE TABLE IF NOT EXISTS sensore (tipo TEXT, marca TEXT, idSensore INTEGER PRIMARY KEY)');

        $this->ci->db->query('CREATE TABLE IF NOT EXISTS sensore_impianto (idSensore INTEGER, idImpianto INTEGER, idSensoreImpianto PRIMARY KEY)');
        
        $this->ci->load->model('Impianto');
        $this->ci->load->model('Sensore');
        $this->ci->load->model('Rilevazione');
    }
    
    
    public function ScriviRilevazione($r) {
        
        $this->ci->db->insert('rilevazione', $r);
        
    }
    
    
    public function LeggiRilevazione($idRilevazione) {
        
        // ritorna Rilevazione
        
        return $this->ci->db->get_where('rilevazione', array('idRilevazione'=>$idRilevazione))->result('Rilevazione');
        
    }
    
    
    public function LeggiRilevazioni($idImpianto) {
        
    }
    
    
    public function LeggiRilevazioniTempo($idImpianto, $dataDa, $dataA) {
        
        
        
    }
    
    
}