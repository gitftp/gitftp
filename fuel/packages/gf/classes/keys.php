<?php

namespace Gf;

use phpseclib\Crypt\RSA;

class Keys {
    const db = 'default';
    const table = 'keys';

    const privateKey = 'private';
    const publicKey = 'public';

    /**
     * @param null   $comment
     * @param string $postComment
     *
     * @return mixed
     */
    private static function generateNewRsaKey ($comment = null, $postComment = '-deploy@gitftp') {
        $rsa = new RSA();
        $rsa->setPublicKeyFormat(6); // CRYPT_RSA_PUBLIC_FORMAT_OPENSSH is int 6
        if (is_null($comment)) $comment = \Str::random('alum', 6);

        $rsa->comment = $comment . $postComment;
        $keys = $rsa->createKey();

        return $keys;
    }

    /**
     * @param null $id
     *
     * @return array [$id, public key path, private key path]
     * @throws \Gf\Exception\AppException
     */
    public static function getPair ($id = null) {
        if (!$id or is_null($id)) {
            $keys = self::generateNewRsaKey();
            $publicKey = $keys['publickey'];
            $privateKey = $keys['privatekey'];

            $id = self::insert([
                'public'  => $publicKey,
                'private' => $privateKey,
            ]);
        } else {
            $key = self::getById($id);
            $privateKey = $key['private'];
            $publicKey = $key['public'];
        }

        return [
            $id,
            $publicKey,
            $privateKey,
        ];
    }

    public static function getById ($id, $key = null) {
        $a = self::get_one([
            'id' => $id,
        ]);

        return !$a ? false : ($key ? $a[$key] : $a);
    }

    public static function get ($where = [], $select = null, $limit = false, $offset = 0, $order_by = 'id', $direction = 'desc', $count_total = true) {
        $q = \DB::select_array($select)
            ->from(self::table)->where($where);

        if ($limit) {
            $q->limit($limit);
            if ($offset)
                $q->offset($offset);
        }

        if ($order_by)
            $q->order_by($order_by, $direction);

        $compiled_query = $q->compile();
        if ($count_total)
            $compiled_query = Utils::sqlCalcRowInsert($compiled_query);

        $result = \DB::query($compiled_query)->execute(self::db)->as_array();

        return count($result) ? $result : false;
    }

    public static function get_one (Array $where = [], $select = null, $limit = false, $offset = 0, $order_by = 'id', $direction = 'desc', $count_total = true) {
        $a = self::get($where, $select, $limit, $offset, $order_by, $direction, $count_total);

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
