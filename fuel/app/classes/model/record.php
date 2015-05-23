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

    /**
     *
     * @param type $id -> deploy id
     * @param type $limit -> data limit
     * @param type $offset -> data offset
     * @return type
     */
    public function get($id = null, $limit = FALSE, $offset = FALSE, $status = FALSE) {

        $q = DB::select_array(array(
            'id',
            'deploy_id',
            'user_id',
            'status',
            'branch_id',
            'amount_deployed_raw',
            'amount_deployed',
            // 'raw',
            'date',
            'triggerby',
            // 'post_data',
            'avatar_url',
            'hash',
            'commit_count',
            'commit_message',
            'file_add',
            'file_remove',
            'file_skip',
            'total_files',
            'processed_files',
        ))->from($this->table)->where('user_id', $this->user_id);

        if ($id != null) {
            $q = $q->and_where('deploy_id', $id);
        }
        if($limit){
            $q = $q->limit($limit);
            if($offset){
                $q = $q->offset($offset);
            }
        }

        if ($status) {
            $q = $q->and_where('status', $status);
        }

        $r = $q->order_by('id', 'DESC')->execute()->as_array();

        foreach ($r as $key => $value) {
            if (isset($r[$key]['raw'])) {
                $r[$key]['raw'] = unserialize($r[$key]['raw']);
            }
        }

        return $r;
    }


    public function get_raw_by_record($record_id) {
        $q = DB::select('raw')->from($this->table)->where('id', $record_id)->execute()->as_array();

        return $q;
    }

    public function get_raw_by_deploy($deploy_id) {
        $q = DB::select('raw')->from($this->table)->where('deploy_id', $deploy_id)->execute()->as_array();

        return $q;
    }


    public function get_post_data_by_record($record_id) {
        $q = DB::select('post_data')->from($this->table)->where('id', $record_id)->execute()->as_array();

        return $q;
    }

    public function get_post_data_by_deploy($deploy_id) {
        $q = DB::select('post_data')->from($this->table)->where('deploy_id', $deploy_id)->execute()->as_array();

        return $q;
    }

    /**
     * return number of records.
     * @param type $id
     * @return type
     */
    public function get_count($id = null){
        $q = DB::select('id')->from($this->table)
                ->where('user_id', $this->user_id)
                ->and_where('deploy_id', $id)
                ->execute()
                ->as_array();
        return count($q);
    }

    /**
     * COLUMNS:
     * id,
     * deploy_id,
     * user_id,
     * status,
     * branch_id,
     * amount_deployed_raw,
     * amount_deployed,
     * raw,
     * date,
     * triggerby,
     * post_data
     * avatar_url
     * hash
     * commit_count
     * commit_message
     * file_add
     * file_remove
     * file_skip
     *
     * @param type $ar
     */
    public function set($id, $set = array(), $direct = false) {
        
        if(!$direct){
            $a = DB::select()->from($this->table)->where('id', $id)->execute()->as_array();

            if (empty($a) or $a[0]['user_id'] != $this->user_id) {
                return false;
            }
        }

        return DB::update($this->table)->set($set)->where('id', $id)->execute();
    }

    /**
     * COLUMNS:
     * id,
     * deploy_id,
     * user_id,
     * status,
     * branch_id,
     * amount_deployed_raw,
     * amount_deployed,
     * raw,
     * date,
     * triggerby,
     * post_data
     * avatar_url
     * hash
     * commit_count
     * commit_message
     * file_add
     * file_remove
     * file_skip
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
