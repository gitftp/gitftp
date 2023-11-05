<?php

namespace App\Helpers\Deploy;

use Illuminate\Database\Eloquent\Model;

class Deploy {

    const TYPE_CLONE = 'clone';
    const TYPE_DEPLOY = 'deploy';
    const TYPE_FRESH_DEPLOY = 'fresh_deploy';

    const STATUS_NEW = 'new';
    const STATUS_PROCESSING = 'processing';
    const STATUS_REVERT = 'revert';
    const STATUS_CLONE = 'clone';


    public function deploy(){

    }

}
