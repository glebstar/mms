<?php

class Db 
{
    private static $_connect = null;

    private static function _getConnect() {
        if (!empty(self::$_connect)) {
            return self::$_connect;
        }

        global $mainCfg;

        self::$_connect = new PDO('mysql:host=' . $mainCfg['db']['host'] . ';dbname=' . $mainCfg['db']['dbname'], $mainCfg['db']['user'], $mainCfg['db']['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

        return self::$_connect;
    }

    public static function getOne($sql, $bind) {
        $connect = self::_getConnect()->prepare($sql);
        $connect->execute($bind);
        $res = $connect->fetch();
        if ( $res ) {
            return $res[0];
        }
        
        return false;
    }
    
    public static function getRow($sql, $bind) {
        $connect = self::_getConnect()->prepare($sql);
        $connect->execute($bind);
        return $connect->fetch(PDO::FETCH_ASSOC);
    }
    
    public static function getAll($sql, $bind=array()) {
        $connect = self::_getConnect()->prepare($sql);
        $connect->execute($bind);
        return $connect->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function insertArray($table, $data) {
        $fields = '';
        $signs = '';
        $values = array();
        foreach ($data as $_key=>$_value) {
            $fields .= "{$_key},";
            $signs  .= '?,';
            $values[] = $_value;
        }
        $fields = preg_replace('/,$/', '', $fields);
        $signs = preg_replace('/,$/', '', $signs);
        
        $sql = "INSERT INTO {$table} ($fields) VALUES($signs)";
        
        $connect = self::_getConnect()->prepare($sql);
        $connect->execute($values);
    }
    
    public static function deleteFromTable($tbl) {
        $sql = "DELETE FROM {$tbl}";
        $connect = self::_getConnect()->prepare($sql);
        $connect->execute();
    }
}
