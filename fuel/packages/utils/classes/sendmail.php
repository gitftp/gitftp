<?php

class Sendmail {
        public static function gitGetBranches($repo){
        exec("git ls-remote --heads $repo", $op);
        if(empty($op))
            return false;
        
        foreach ($op as $k => $v) {
            $b = preg_split('/\s+/', $v);
            $b = explode('/', $b[1]);
            $op[$k] = $b[2];
        }
        return $op;
    }
}