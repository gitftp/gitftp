<?php

class Model_Record extends Model {

    private $table = 'records';
    private $user_id;

    public function __construct() {
        if (Auth::check()) {
            $this->user_id = Auth::get_user_id()[1];
        } else {
            return false;
        }
    }

    public function get($id = null) {

        $q = DB::select()->from($this->table)
                ->where('user_id', $this->user_id);

        if ($id != null) {
            $q = $q->and_where('deploy_id', $id);
        }

        $r = $q->order_by('id', 'DESC')->execute()->as_array();
        
        foreach ($r as $key => $value) {
            $r[$key]['raw'] = unserialize($r[$key]['raw']);
            $r[$key]['date'] = Date::time_ago($r[$key]['date']);
        }
        
        return $r;
    }
    
    /**
     * COLUMNS:
     * id,
     * deploy_id,
     * user_id,
     * status,
     * amount_deployed,
     * raw,
     * date,
     * triggerby,
     * post_data
     * 
     * @param type $ar
     */
    public function set($id, $set = array(), $direct = false) {
        
        if($direct){
            
        }
        $a = DB::select()->from($this->table)->where('id', $id)->execute()->as_array();

        if (empty($a) or $a[0]['user_id'] != $this->user_id) {
            return false;
        }

        return DB::update($this->table)->set($set)->where('id', $id)->execute();
    }

    /**
     * COLUMNS:
     * id,
     * deploy_id,
     * user_id,
     * status,
     * amount_deployed,
     * raw,
     * date,
     * triggerby,
     * post_data
     * 
     * @param type $ar
     */
    public function insert($ar) {
        
        $ar['user_id'] = $this->user_id;
        $r = DB::insert($this->table)
                ->set($ar)
                ->execute();
        
        return $r[0];
    }

    public function delete($id) {
        $a = DB::select()->from($this->table)->where('id', $id)->execute()->as_array();

        if (empty($a) or $a[0]['user_id'] != $this->user_id) {
            return false;
        }

        return DB::delete($his->table)->where('id', $id)->execute();
    }

}
