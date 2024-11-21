<?php

    class MTemplate extends CI_Model {
        public function __construct() {
            parent::__construct();
        }

        public function get_list(){
            $this->db->select("*");
            $this->db->from("template");
            $query = $this->db->get();
            return $query->result();
        }

        public function get_template($id){
            if (is_numeric($id) && $id > 0) {
                $this->db->select("*");
                $this->db->from("template");
                $this->db->where("id",$id);
                $query = $this->db->get();
                return $query->result();
            } else {
                return false;
            }   
        }

    }