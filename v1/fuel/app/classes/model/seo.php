<?php

class Model_Seo extends Model {

    private $table = 'seo';
    public $db;

    function __construct() {
        $this->db = 'frontend';
    }

    /**
     *
     *   $default = [
        'title'       => 'Gitftp',
        'description' => 'Gitftp description',
        'keywords'    => 'some other key words and things like that',
        'author'      => ''
        ];
     *
     * @param string $url
     * @return mixed
     */
    public function getByUrl($url = '/') {
        if($url == 'home' || $url == 'welcome')
            $url = '/';

        $d = \DB::select()->from($this->table)->where('path', $url)->execute($this->db)->as_array();
        $default = \DB::select()->from($this->table)->where('path', 'default')->execute($this->db)->as_array();

        if(!count($d)){
            $d = $default;
            $d = unserialize($d[0]['data']);
        }else{
            $d = unserialize($d[0]['data']);
            $default = unserialize($default[0]['data']);

            $d['description'] = empty($d['description']) ? $default['description'] : $d['description'];
            $d['keywords'] = empty($d['keywords']) ? $default['keywords'] : $d['keywords'];
            $d['title'] = empty($d['title']) ? $default['title'] : $d['title'];
        }


        return $d;
    }

    public function getById($id) {
        $a = \DB::select()->from($this->table)->where('id', $id)->execute($this->db)->as_array();
        if (!count($a))
            return FALSE;

        $a = $a[0];
        $a['data'] = unserialize($a['data']);

        return $a;
    }

    public function insert($slug, $meta) {
        $data = [
            'path' => $slug,
            'data' => serialize($meta)
        ];

        return \DB::insert($this->table)->set($data)
            ->execute($this->db);
    }

    public function update($id, $slug, $meta) {
        $data = [
            'path' => $slug,
            'data' => serialize($meta)
        ];

        return \DB::update($this->table)->set($data)->where('id', $id)
            ->execute($this->db);
    }

    public function getAll() {
        $a = \DB::select()->from($this->table)->execute($this->db)->as_array();

        foreach ($a as $k => $c) {
            $a[$k]['data'] = unserialize($c['data']);
        }

        return $a;
    }

    public function select($select = NULL) {
        $q = \DB::select($select)->from($this->table);

        return $q;
    }

    public function delete($id) {
        return \DB::delete($this->table)->where('id', $id)->execute($this->db);
    }
}
