<?php
    namespace CreateCraft;

    class RDB{
        public function __construct($host, $user, $password, $db){
            $this->rdb = new \mysqli($host, $user, $password, $db);
    
            if (mysqli_connect_error()){
                $this->rdb = false;
            }
        }

        public function __destruct() {
            if ($this->rdb) {
                $this->rdb->close();
            }
        }

        public function actSql($sql){
            $result = $this->rdb->query($sql);
        }

        public function actSelect($sql){
            $result = $this->rdb->query($sql);
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function actSelectAndKeySorting($sql, $key){
            $rtn = [];
            $result = $this->actSelect($sql);
            
            foreach($result as $index => $rows){
                if(!array_key_exists($rows[$key], $rtn)){
                    $rtn[$rows[$key]] = [];
                }
                $rtn[$rows[$key]][] = $rows;
            }

            return $rtn;
        }
    }
?>
