<?php

class Model_Record extends Model {

    // table name
    private $table = 'records';

    // user_id for filtering data for current logged in user.
    public $user_id;

    // status states
    public $in_queue = '3';
    public $in_progress = '2';
    public $success = '1';
    public $failed = '0';

    // update files to the latest.
    public $type_update = '0';

    // update all files, to the latest.
    public $type_sync = '1';

    // rollback or front to a particular hash.
    public $type_rollback = '2';

    // push from service. Github or bitbucket.
    public $type_service_push = '3';

    // Wheather if to check for user related content.
    public $direct = FALSE;

    public function __construct() {
        if (Auth::check()) {
            $this->user_id = Auth::get_user_id()[1];
        } else {
            $this->user_id = '*';
        }
    }


    /**
     * Returns latest id, hash, date record by branch_id.
     *
     * @param $branch_id
     * @return mixed
     */
    public function get_latest_revision_by_branch_id($branch_id) {
        $result = DB::select('id', 'hash', 'date')->from($this->table)->where('branch_id', $branch_id)->and_where('status', $this->success)->limit(1)->order_by('id', 'DESC');

        return $result->execute()->as_array();
    }


    /**
     * Get only last row from queue.
     * if nothing in queue return false.
     *
     * @param $deploy_id
     * @return bool
     */
    public function get_next_from_queue($deploy_id) {
        $result = DB::select()->from($this->table)->where('deploy_id', $deploy_id)->and_where('status', $this->in_queue)->order_by('id', 'asc')->limit(1)->execute()->as_array();

        if (count($result)) {
            return $result[0];
        } else {
            return FALSE;
        }
    }

    /**
     * Determine whether the queue is currently under process.
     * Queue via deploy_id.
     *
     * @param $deploy_id
     * @return bool
     */
    public function is_queue_active($deploy_id) {
        $progress = DB::select('id')->from($this->table)->where('deploy_id', $deploy_id)
            ->and_where('status', $this->in_progress)->execute()->as_array();
        $queue = DB::select('id')->from($this->table)->where('deploy_id', $deploy_id)
            ->and_where('status', $this->in_queue)->execute()->as_array();

        if (count($progress) == 0 && count($queue) == 0) {
            return FALSE;
        }
        if (count($progress) > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Get records by deploy_id
     * filter by
     *      limit
     *      offset
     *      status
     *
     * @param null $id -> deploy_id
     * @param bool $limit
     * @param bool $offset
     * @param bool $status
     * @return mixed
     *
     * returns everything except raw and post_data.
     */
    public
    function get($id = NULL, $limit = FALSE, $offset = FALSE, $status = FALSE) {

        $q = DB::select_array(array(
            'id',
            'deploy_id',
            'user_id',
            'status',
            'branch_id',
            'amount_deployed_raw',
            'amount_deployed',
            'record_type',
            'raw',
            'date',
            'triggerby',
            'post_data',
            'avatar_url',
            'hash_before',
            'hash',
            'commits',
            'file_add',
            'file_remove',
            'file_skip',
            'total_files',
            'processed_files',
        ))->from($this->table);

        // if direct is set, doesnt check for user_id.
        if (!$this->direct) {
            $q = $q->where('user_id', $this->user_id);
        }

        if ($id != NULL) {
            $q = $q->and_where('deploy_id', $id);
        }

        if ($limit) {
            $q = $q->limit($limit);
            if ($offset) {
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
            if (isset($r[$key]['commits'])) {
                try { // todo: we might not need try catch here in the future.
                    $r[$key]['commits'] = unserialize($r[$key]['commits']);
                } catch (Exception $e) {

                }
            }
        }

        return $r;
    }

    /**
     *
     * Get raw deploy output by record id
     * @param $record_id
     * @return mixed
     */
    public
    function get_raw_by_record($record_id, $direct = FALSE) {
        $q = DB::select('raw')->from($this->table)->where('id', $record_id);

        if (!$direct) {
            $q = $q->and_where('user_id', $this->user_id);
        }

        $q = $q->execute()->as_array();

        return $q;
    }

    /**
     * Get list of raw deploy output by deploy id.
     * @param $deploy_id
     * @return mixed
     */
    public
    function get_raw_by_deploy($deploy_id, $direct = FALSE) {
        $q = DB::select('raw')->from($this->table)->where('deploy_id', $deploy_id);

        if (!$direct) {
            $q = $q->and_where('user_id', $this->user_id);
        }

        $q = $q->execute()->as_array();

        return $q;
    }

    /**
     * get post data by record id.
     * @param $record_id
     * @return mixed
     */
    public
    function get_post_data_by_record($record_id, $direct = FALSE) {
        $q = DB::select('post_data')->from($this->table)->where('id', $record_id);

        if (!$direct) {
            $q = $q->and_where('user_id', $this->user_id);
        }

        $q = $q->execute()->as_array();

        return $q;
    }


    /**
     * get list of post data by deploy id.
     * @param $deploy_id
     * @return mixed
     */
    public
    function get_post_data_by_deploy($deploy_id) {
        $q = DB::select('post_data')->from($this->table)->where('deploy_id', $deploy_id)->execute()->as_array();

        return $q;
    }

    /**
     * return number of records.
     * @param type $id
     * @param bool $direct
     * @param bool $status
     * @return type
     */
    public function get_count($id = NULL, $direct = FALSE, $status = FALSE) {
        $q = DB::select('id')->from($this->table);

        if ($id)
            $q = $q->where('deploy_id', $id);

        if (!$direct)
            $q = $q->and_where('user_id', $this->user_id);

        if ($status)
            $q = $q->and_where('status', $status);

        $q = $q->execute()->as_array();

        return count($q);
    }

    public function get_sum_deployed_data($id = NULL, $direct = FALSE) {
        $ex = DB::expr('SUM(amount_deployed_raw) as deploy_count');
        $q = DB::select($ex)->from($this->table);
        $result = $q->execute()->as_array();

        return $result[0]['deploy_count'];
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
     * commits
     * file_add
     * file_remove
     * file_skip
     *
     * @param type $ar
     */
    public
    function set($id, $set = array(), $direct = FALSE) {

        if (!$direct) {
            $a = DB::select()->from($this->table)->where('id', $id)->execute()->as_array();

            if (empty($a) or $a[0]['user_id'] != $this->user_id) {
                return FALSE;
            }
        }

        return DB::update($this->table)->set($set)->where('id', $id)->execute();
    }

    /**
     * COLUMNS:
     * id,
     * deploy_id,
     * user_id,
     * record_type,
     * status,
     * hash_before
     * record_type
     * branch_id,
     * amount_deployed_raw,
     * amount_deployed,
     * raw,
     * date,
     * triggerby,
     * post_data
     * avatar_url
     * hash
     * commits
     * file_add
     * file_remove
     * file_skip
     *
     * @param array $ar
     * @param bool $user
     * @return mixed
     */
    public
    function insert($ar, $user = FALSE) {
        if (!$user) {
            $ar['user_id'] = $this->user_id;
        } else {
            $ar['user_id'] = $user;
        }

        $r = DB::insert($this->table)->set($ar)->execute();

        return $r[0];
    }

    public
    function delete($id, $direct = FALSE) {
        $a = DB::select('id')->from($this->table)->where('id', $id);
        if (!$direct) {
            $a = $a->and_where('user_id', $this->user_id);
        }
        $a = $a->execute()->as_array();

        if (empty($a)) {
            return FALSE;
        }

        return DB::delete($this->table)->where('id', $id)->execute();
    }

    public
    function delete_by_branch_id($id, $direct = FALSE) {
        $a = DB::select('id')->from($this->table)->where('branch_id', $id);
        if (!$direct) {
            $a = $a->and_where('user_id', $this->user_id);
        }
        $a = $a->execute()->as_array();

        if (empty($a)) {
            return FALSE;
        }

        return DB::delete($this->table)->where('branch_id', $id)->execute();
    }

    public
    function delete_by_deploy_id($id, $direct = FALSE) {
        $a = DB::select('id')->from($this->table)->where('deploy_id', $id);
        if (!$direct) {
            $a = $a->and_where('user_id', $this->user_id);
        }
        $a = $a->execute()->as_array();

        if (empty($a)) {
            return FALSE;
        }

        return DB::delete($this->table)->where('deploy_id', $id)->execute();
    }

}
