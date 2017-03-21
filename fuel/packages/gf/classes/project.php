<?php

namespace Gf;

use Fuel\Core\File;
use Fuel\Core\Str;
use Fuel\Core\Uri;
use Gf\Exception\AppException;
use Gf\Exception\UserException;
use Gf\Git\GitApi;

class Project {
    const db = 'default';
    const table = 'projects';

    const clone_state_not_cloned = 1;
    const clone_state_cloning = 2;
    const clone_state_cloned = 3;

    const pull_state_pulled = 1;
    const pull_state_pulling = 2;

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

            $git = GitApi::instance($user_id, $repository_provider);
            $repository = $git->api()->getRepository($username, $repoName);

            $exists = self::get_one([
                'uri' => $repository['repo_url'],
            ]);

            if ($exists) {
                throw new UserException('A project with the same repository already exists');
            }

            $project_id = self::insert([
                'name'         => $repository['name'],
                'uri'          => $repository['repo_url'],
                'git_name'     => $repository['name'],
                'sh_name'      => null,
                'git_id'       => $repository['id'],
                'hook_id'      => null,
                'hook_key'     => null,
                'owner_id'     => $user_id,
                'provider'     => $repository_provider,
                'clone_uri'    => $repository['clone_url'],
                'git_username' => $username,
            ]);

            if (!$project_id)
                throw new UserException('Could not insert project data to database.');

            $key = Str::random('alnum', 6);
            $key = strtolower($key);

            $hookUrl = $git->createHookUrl($project_id, $key, $user_id);
            $hook = $git->api()->setHook($repoName, $username, $hookUrl);
            $hook_id = $hook['id'];
            $clonePath = self::getRepoPath($project_id);

            $af = self::update([
                'id' => $project_id,
            ], [
                'hook_id'  => $hook_id,
                'hook_key' => $key,
                'path'     => $clonePath,
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

    public static function delete ($project_id) {
        $project = Project::get_one([
            'id' => $project_id,
        ]);
        if (!$project)
            throw new UserException('Project not found');

        $gitApi = GitApi::instance($project['owner_id'], $project['provider']);

        try {
            \DB::start_transaction();

            $af = Record::delete([
                'project_id' => $project_id,
            ]);

            $af = Server::delete([
                'project_id' => $project_id,
            ]);

            $af = self::remove([
                'id' => $project_id,
            ]);
            if (!$af)
                throw new UserException('Could not delete project');

            $project_dir = self::getRepoPath($project_id);
            try {
                $af = File::delete_dir($project_dir, true, true);
            } catch (\Exception $e) {
            }

            $gitApi->api()->removeHook($project['git_name'], $project['hook_id']);

            \DB::commit_transaction();
        } catch (\Exception $e) {
            \DB::rollback_transaction();
            throw $e;
        }
    }


    /**
     * Gets a repo path, that is relative to the gitftp installation location
     *
     * @param $project_id
     *
     * @return string
     */
    public static function getRepoPath ($project_id) {
        return "repositories" . DS . "$project_id" . DS;
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

    public static function remove (Array $where) {
        $af = \DB::delete(self::table)->where($where)->execute(self::db);

        return $af;
    }
}
