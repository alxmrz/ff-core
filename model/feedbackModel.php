<?php
namespace model;

class feedbackModel {
     protected $db;
     
     public function __construct() {
         $this->db = new \core\databaseConnection;
     }
}
