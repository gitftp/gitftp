<?php

class Model_Seo extends Model {

    private $table = 'seo';
    public $db;

    function __construct() {
        $this->db = 'frontend';
    }


    public function getByUrl($url = '/') {
//        $default = [
//            'title'       => 'Gitftp',
//            'description' => 'Gitftp description',
//            'keywords'    => 'some other key words and things like that',
//            'author'      => ''
//        ];

        $d = \DB::select()->from($this->table)->where('path', $url)->execute($this->db)->as_array();
        if (!count($d))
            return $this->getByUrl('default');

        return unserialize($d[0]['data']);
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
