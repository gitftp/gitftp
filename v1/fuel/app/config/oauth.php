<?php

return [
    'default_group' => 1,
    'providers'     => [
        'GitHub'    => [
            'client_id'     => GF_GITHUB_CLIENT_ID,
            'client_secret' => GF_GITHUB_CLIENT_SECRET,
            'scope'         => 'repo,user:email,admin:repo_hook,admin:org_hook',
        ],
        'Bitbucket' => [
            'key'    => 'JUaXwggVwJphFbXZ47',
            'secret' => 'GPLtw3s3Zp9WQHu3jWDGAWxVBJSDqbBL',
        ],
    ],
];
