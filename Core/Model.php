<?php
namespace Core;

class Model{
    
    /**
     *
     * @var PDO
     */

    protected $db;

    public function __construct()
    {
        global $db;
        $this->db = $db;
    }


}

?>