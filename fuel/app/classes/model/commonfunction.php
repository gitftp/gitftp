<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CommonFunction
 *
 * @author ASR1
 */
class Model_Commonfunction extends Model {
    /*     * *******************************************
     * 
     * 
     * 
     * 
      $result =  new Model_CommonFunction();
      $array = array('id','name','email','pass'); TABLE FIELDS.
      $table=array('table'=>'tablename','value'=>$value);
      return $result->get_data($table,$array);
     * 
     * 
     * 
     * 
     * ********************************************** */

    public static function get_data($table = array(), $select = array()) {
        if (empty($select)) {
            if (!isset($table['value'])) {
                $result = \DB::select('*')
                        ->from($table['table'])
                        ->execute();
            } else {
                $result = \DB::select('*')
                        ->from($table['table'])
                        ->where($table['where'], '=', $table['value'])
                        ->execute();
            }
        } else {
            if (!isset($table['value'])) {
                $result = \DB::select_array($select)
                        ->from($table['table'])
                        ->execute();
            } else {
                $result = \DB::select_array($select)
                        ->from($table['table'])
                        ->where($table['where'], '=', $table['value'])
                        ->execute();
            }
        }
        return $result->as_array();
    }

    /*

      $model =  new Model_CommonFunction();
      $table='administrator';
      $data = array('name'=>$name['name'],'user_name'=>$name['username'],'password'=>$name['password'],'email'=>$name['email'],'insertion_date'=>date("d m Y h:i:s"),'modify_date'=>'');
      return $model->insertData($table,$data);

     */

    public function insertData($table, $data = array()) {
        $result = \DB::insert($table)->set($data)->execute();
        return $result;
    }

    public static function insertData3($table, $data = array()) {
        $result = \DB::insert($table)->set($data)->execute();
        return $result;
    }

    /*

      $model =  new Model_CommonFunction();
      $table='tablename';
      $data = array('name'=>$name['name'],'user_name'=>$name['username'],'password'=>$name['password'],'email'=>$name['email'],'insertion_date'=>date("d m Y h:i:s"),'modify_date'=>'');
      return $model->insertData($table,$data);

     */

    public function updateData($table, $data, $where, $value) {
        $result = \DB::insert($table)
                ->set($data)
                ->where($where, '=', $value)
                ->execute();
        return $result;
    }

    public function updateData_v1($where = array(), $data = array()) {
        $result = \DB::update($where['table'])
                ->set($data)
                ->where($where['where'], '=', $where['value'])
                ->execute();
        return $result;
    }

    /*
     * $model =  new Model_CommonFunction();
     * $table='tablename';
     * $where =''where field'
     * $value = where value.
     */

    public function delete($table, $where, $value) {
        $query = DB::delete($table)->where($where, 'like', $value)->execute();
    }

    public static function delete_id($table, $where, $value) {
        $query = DB::delete($table)->where($where, '=', $value)->execute();
    }

    public static function search($table, $where = array()) {


        $result = \DB::select('*')
                ->from($table['table']);

        if ($where['location'] != '') {
            $result->where('location', '=', $where['location']);
        }

        if ($where['bedrooms'] != '') {
            $result->where('bedrooms', '=', $where['bedrooms']);
        }

        if ($where['property_type'] != '') {
            $result->where('property_type', '=', $where['property_type']);
        }

        if ($where['property_mode'] != '') {
            $result->where('property_mode', '=', $where['property_mode']);
        }

        return $result->execute()->as_array();
    }

    public static function search2($table, $where = array(), $value = array()) {


        $result = \DB::select('*')
                ->from($table['table']);
        return $result->execute()->as_array();
    }

    public static function get_bunglow() {
        $result = \DB::select('*')
                        ->from('baunglow_master')->execute()->as_array();
        return $result;
    }

}
