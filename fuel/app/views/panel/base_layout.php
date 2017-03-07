<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title><?php echo isset($title) ? $title : 'Gitftp' ?></title>
    <meta name="description"
          content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>

    <?php echo $css ?>
    <base href="<?php echo \Fuel\Core\Uri::base(); ?>">
    <script>
        var BASE = '<?php echo \Fuel\Core\Uri::base() ?>';
        var PATH = '<?php echo \Fuel\Core\Uri::string(); ?>';
        var API_PATH = '<?php echo $apiUrl; ?>'
        var GITHUB_CALLBACK = '<?php echo $githubCallback; ?>';
        var BITBUCKET_CALLBACK = '<?php echo $bitbucketCallback; ?>';
    </script>
</head>
<body ng-init='user = <?php echo json_encode($user); ?>;
availableProviders = <?php echo json_encode($availableProviders) ?>;
readyProviders = <?php echo json_encode($readyProviders) ?>'>
<div class="app">

    <div id="content" class="app-content" role="main">
        <div class="box">
            <div top-header></div>
            <div class="box-row">
                <div class="box-cell">
                    <div class="box-inner">
                        <div ng-view></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="user" data-backdrop="false">
        <div class="right w-xl bg-white md-whiteframe-z2">
            <div class="box">
                <div class="p p-h-md">
                    <a data-dismiss="modal" class="pull-right text-muted-lt text-2x m-t-n inline p-sm">&times;</a>
                    <strong>Members</strong>
                </div>
                <div class="box-row">
                    <div class="box-cell">
                        <div class="box-inner">
                            <div class="list-group no-radius no-borders">
                                <a data-toggle="modal" data-target="#chat" data-dismiss="modal"
                                   class="list-group-item p-h-md">
                                    <img src="images/a1.jpg" class="pull-left w-40 m-r img-circle">
                                    <div class="clear">
                                        <span class="font-bold block">Jonathan Doe</span>
                                        <span class="clear text-ellipsis text-xs">"Hey, What's up"</span>
                                    </div>
                                </a>
                                <a data-toggle="modal" data-target="#chat" data-dismiss="modal"
                                   class="list-group-item p-h-md">
                                    <img src="images/a2.jpg" class="pull-left w-40 m-r img-circle">
                                    <div class="clear">
                                        <span class="font-bold block">James Pill</span>
                                        <span class="clear text-ellipsis text-xs">"Lorem ipsum dolor sit amet onsectetur adipiscing elit"</span>
                                    </div>
                                </a>
                                <div class="p-h-md m-t p-v-xs">Work</div>
                                <a data-toggle="modal" data-target="#chat" data-dismiss="modal"
                                   class="list-group-item p-h-md">
                                    <i class="fa fa-circle text-success text-xs m-r-xs"></i>
                                    <span>Jonathan Morina</span>
                                </a>
                                <a data-toggle="modal" data-target="#chat" data-dismiss="modal"
                                   class="list-group-item p-h-md">
                                    <i class="fa fa-circle text-success text-xs m-r-xs"></i>
                                    <span>Mason Yarnell</span>
                                </a>
                                <a data-toggle="modal" data-target="#chat" data-dismiss="modal"
                                   class="list-group-item p-h-md">
                                    <i class="fa fa-circle text-warning text-xs m-r-xs"></i>
                                    <span>Mike Mcalidek</span>
                                </a>
                                <a data-toggle="modal" data-target="#chat" data-dismiss="modal"
                                   class="list-group-item p-h-md">
                                    <i class="fa fa-circle text-muted-lt text-xs m-r-xs"></i>
                                    <span>Cris Labiso</span>
                                </a>
                                <a data-toggle="modal" data-target="#chat" data-dismiss="modal"
                                   class="list-group-item p-h-md">
                                    <i class="fa fa-circle text-muted-lt text-xs m-r-xs"></i>
                                    <span>Daniel Sandvid</span>
                                </a>
                                <a data-toggle="modal" data-target="#chat" data-dismiss="modal"
                                   class="list-group-item p-h-md">
                                    <i class="fa fa-circle text-muted-lt text-xs m-r-xs"></i>
                                    <span>Helder Oliveira</span>
                                </a>
                                <a data-toggle="modal" data-target="#chat" data-dismiss="modal"
                                   class="list-group-item p-h-md">
                                    <i class="fa fa-circle text-muted-lt text-xs m-r-xs"></i>
                                    <span>Jeff Broderik</span>
                                </a>
                                <a data-toggle="modal" data-target="#chat" data-dismiss="modal"
                                   class="list-group-item p-h-md">
                                    <i class="fa fa-circle text-muted-lt text-xs m-r-xs"></i>
                                    <span>Daniel Sandvid</span>
                                </a>
                                <a data-toggle="modal" data-target="#chat" data-dismiss="modal"
                                   class="list-group-item p-h-md">
                                    <i class="fa fa-circle text-muted-lt text-xs m-r-xs"></i>
                                    <span>Helder Oliveira</span>
                                </a>
                                <a data-toggle="modal" data-target="#chat" data-dismiss="modal"
                                   class="list-group-item p-h-md">
                                    <i class="fa fa-circle text-muted-lt text-xs m-r-xs"></i>
                                    <span>Jeff Broderik</span>
                                </a>
                                <div class="p-h-md m-t p-v-xs">Partner</div>
                                <a data-toggle="modal" data-target="#chat" data-dismiss="modal"
                                   class="list-group-item p-h-md">
                                    <i class="fa fa-circle text-success text-xs m-r-xs"></i>
                                    <span>Mason Yarnell</span>
                                </a>
                                <a data-toggle="modal" data-target="#chat" data-dismiss="modal"
                                   class="list-group-item p-h-md">
                                    <i class="fa fa-circle text-warning text-xs m-r-xs"></i>
                                    <span>Mike Mcalidek</span>
                                </a>
                                <a data-toggle="modal" data-target="#chat" data-dismiss="modal"
                                   class="list-group-item p-h-md">
                                    <i class="fa fa-circle text-muted-lt text-xs m-r-xs"></i>
                                    <span>Cris Labiso</span>
                                </a>
                                <a data-toggle="modal" data-target="#chat" data-dismiss="modal"
                                   class="list-group-item p-h-md">
                                    <i class="fa fa-circle text-muted-lt text-xs m-r-xs"></i>
                                    <span>Jonathan Morina</span>
                                </a>
                                <a data-toggle="modal" data-target="#chat" data-dismiss="modal"
                                   class="list-group-item p-h-md">
                                    <i class="fa fa-circle text-muted-lt text-xs m-r-xs"></i>
                                    <span>Daniel Sandvid</span>
                                </a>
                                <a data-toggle="modal" data-target="#chat" data-dismiss="modal"
                                   class="list-group-item p-h-md">
                                    <i class="fa fa-circle text-muted-lt text-xs m-r-xs"></i>
                                    <span>Helder Oliveira</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-h-md p-v">
                    <p>Invite People</p>
                    <a href class="text-muted"><i class="fa fa-fw fa-twitter"></i> Twitter</a>
                    <a href class="text-muted m-h"><i class="fa fa-fw fa-facebook"></i> Facebook</a>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="chat" data-backdrop="false">
        <div class="right w-xxl bg-white md-whiteframe-z2">
            <div class="box">
                <div class="p p-h-md">
                    <a data-dismiss="modal" class="pull-right text-muted-lt text-2x m-t-n inline p-sm">&times;</a>
                    <strong>Chat</strong>
                </div>
                <div class="box-row bg-light lt">
                    <div class="box-cell">
                        <div class="box-inner">
                            <div class="p-md">
                                <div class="m-b">
                                    <a href class="pull-left w-40 m-r-sm"><img src="images/a2.jpg" alt="..."
                                                                               class="w-full img-circle"></a>
                                    <div class="clear">
                                        <div class="p p-v-sm bg-warning inline r">
                                            Hi John, What's up...
                                        </div>
                                        <div class="text-muted-lt text-xs m-t-xs"><i class="fa fa-ok text-success"></i>
                                            2 minutes ago
                                        </div>
                                    </div>
                                </div>
                                <div class="m-b">
                                    <a href class="pull-right w-40 m-l-sm"><img src="images/a3.jpg"
                                                                                class="w-full img-circle" alt="..."></a>
                                    <div class="clear text-right">
                                        <div class="p p-v-sm bg-info inline text-left r">
                                            Lorem ipsum dolor soe rooke..
                                        </div>
                                        <div class="text-muted-lt text-xs m-t-xs">1 minutes ago</div>
                                    </div>
                                </div>
                                <div class="m-b">
                                    <a href class="pull-left w-40 m-r-sm"><img src="images/a2.jpg" alt="..."
                                                                               class="w-full img-circle"></a>
                                    <div class="clear">
                                        <div class="p p-v-sm bg-warning inline r">
                                            Good!
                                        </div>
                                        <div class="text-muted-lt text-xs m-t-xs"><i class="fa fa-ok text-success"></i>
                                            5 seconds ago
                                        </div>
                                    </div>
                                </div>
                                <div class="m-b">
                                    <a href class="pull-right w-40 m-l-sm"><img src="images/a3.jpg"
                                                                                class="w-full img-circle" alt="..."></a>
                                    <div class="clear text-right">
                                        <div class="p p-v-sm bg-info inline text-left r">
                                            Dlor soe isep..
                                        </div>
                                        <div class="text-muted-lt text-xs m-t-xs">Just now</div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-h-md p-v">
                    <a class="pull-left w-32 m-r"><img src="images/a3.jpg" class="w-full img-circle" alt="..."></a>
                    <form>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Say something">
                            <span class="input-group-btn">
            <button class="btn btn-default" type="button">SEND</button>
          </span>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>
<?php echo $js ?>
<script type="text/javascript" src="<?php echo \Fuel\Core\Uri::base(); ?>app/main.js"></script>
</body>
</html>
