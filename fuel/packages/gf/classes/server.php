<?php

namespace Gf;

use Fuel\Core\File;
use Fuel\Core\Input;
use Fuel\Core\Str;
use Gf\Exception\AppException;
use Gf\Exception\UserException;
use Gf\Git\GitApi;
use phpseclib\Crypt\RSA;

class Server {
    const db = 'default';
    const table = 'servers';

    const type_ftp = 1;
    const type_sftp = 2;
    const type_local = 3;

    const key_path = 'repositories/keys/';

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

    /**
     * Path were the pr pu key pair are kept
     * this is dir, two files named , 'pu' and 'pr' should be present
     *
     * @param null $hash
     *
     * @return mixed
     */
    private static function getPublicPrivateKeyPairDir ($hash = null) {
        if (!$hash)
            $hash = Str::random('alnum', 8) . Utils::timeNow();
        // then length goes to 8 + 10 = 18

        try {
            File::create_dir(DOCROOT . self::key_path, $hash);
        } catch (\Exception $e) {
        }

        return [
            $hash,
            Utils::systemDS(DOCROOT . self::key_path . "$hash/"),
        ];
    }

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
     */
    public static function getPublicPrivateKeyPair ($id = null) {
        if (is_null($id)) {
            $keys = self::generateNewRsaKey();
            $publicKey = $keys['publickey'];
            $privateKey = $keys['privatekey'];
            list($id, $path) = self::getPublicPrivateKeyPairDir();
            File::create($path, 'pu', $publicKey);
            File::create($path, 'pr', $privateKey);
        }

        $pub = DOCROOT . self::key_path . "$id/pu";
        $pri = DOCROOT . self::key_path . "$id/pr";

        return [
            $id,
            $pub,
            $pri,
        ];
    }


    public static function get_one (Array $where = [], $select = null) {
        $a = self::get($where, $select);

        return ($a) ? $a[0] : false;
    }

    public static function update (Array $where, Array $set) {
        $set['updated_at'] = Utils::timeNow();

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
