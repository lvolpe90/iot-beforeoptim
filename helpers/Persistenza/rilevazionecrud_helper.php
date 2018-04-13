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
        
        return $this->ci->db->get_where('rilevazione', array('idImpianto'=>$idImpianto))->result('Rilevazione');
        
    }
    
    
    public function LeggiRilevazioniTempo($idImpianto, $dataDa, $dataA) {
        
        $qry = 'SELECT rilevazione.*, tipo as sensore, descrizione as impianto FROM rilevazione LEFT JOIN sensore ON (sensore.idSensore=rilevazione.idSensore) LEFT JOIN impianto ON (impianto.idImpianto=rilevazione.idImpianto) WHERE dataOra BETWEEN datetime(\''.$dataDa.'\') AND datetime(\''.$dataA.'\')  AND rilevazione.idImpianto = '.$idImpianto.' ';

        return $this->ci->db->query($qry)->result('Rilevazione');
        
        
        
    }
    
    
}