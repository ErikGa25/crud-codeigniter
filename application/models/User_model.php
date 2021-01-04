<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    
    public function save($data) {
        $this->db->query("ALTER TABLE user AUTO_INCREMENT 1");
        $this->db->insert("user", $data);
    }

    public function getUsers() {
        
    }
}