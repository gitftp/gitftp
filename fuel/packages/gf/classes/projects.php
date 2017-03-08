<?php

namespace Gf;

use Fuel\Core\Input;
use Fuel\Core\Str;
use Gf\Exception\AppException;
use Gf\Exception\UserException;
use Gf\Git\Git;

class Projects {
    const db = 'default';
    const table = 'projects';

    /**
     * Creates a project in database
     * + adds web hooks
     *
     * @param $repository_id
     * @param $repository_provider
     * @param $repository_full_name
     * @param $user_id
     *
     * @return mixed
     * @throws \Exception
     */
    public static function create ($repository_id, $repository_provider, $repository_full_name, $user_id) {
        try {
            \DB::start_transaction();

            if (!$repository_id or !$repository_provider or !$repository_full_name or !$user_id)
                throw new AppException('Missing parameters');

            list($username, $repoName) = explode('/', $repository_full_name);

            $git = new Git($user_id, $repository_provider);
            $repository = $git->api()->getRepository($username, $repoName);

            $project_id = self::insert([
                'name'     => $repository['name'],
                'uri'      => $repository['repo_url'],
                'git_name' => $repository['name'],
                'sh_name'  => null,
                'git_id'   => $repository['id'],
                'hook_id'  => null,
                'hook_key' => null,
                'owner_id' => $user_id,
            ]);

            if (!$project_id)
                throw new UserException('Could not insert project data to database.');

            $key = Str::random('alnum', 6);
            $key = strtolower($key);

            $hookUrl = $git->createHookUrl($project_id, $key, $user_id);
            $hook = $git->api()->setHook($repoName, $username, $hookUrl);
            $hook_id = $hook['id'];

            $af = self::update([
                'id' => $project_id,
            ], [
                'hook_id'  => $hook_id,
                'hook_key' => $key,
            ]);
            if (!$af)
                throw new UserException('Could not update project record.');

            \DB::commit_transaction();

            return $project_id;
        } catch (\Exception $e) {
            \DB::rollback_transaction();
            throw $e;
        }
    }


    public static function get ($where = [], $select = [], $limit = false, $offset = 0, $count_total = true) {
        $q = \DB::select_array($select)
            ->from(self::table)->where($where);

        if ($limit) {
            $q->limit($limit);
            if ($offset)
                $q->offset($offset);
        }

        $compiled_query = $q->compile();
        if ($count_total)
            $compiled_query = Utils::sqlCalcRowInsert($compiled_query);

        $result = \DB::query($compiled_query)->execute(self::db)->as_array();

        return count($result) ? $result : false;
    }

    public static function get_one (Array $where = [], $select = null) {
        $a = self::get($where, $select);

        return ($a) ? $a[0] : false;
    }

    public static function update (Array $where, Array $set) {
        return \DB::update(self::table)->where($where)->set($set)->execute(self::db);
    }

    public static function insert (Array $set) {
        $set['created_at'] = Utils::timeNow();
        list($id) = \DB::insert(self::table)->set($set)->execute(self::db);

        return $id;
    }
}
