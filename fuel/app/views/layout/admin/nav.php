<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.html">Global Real State</a>
    </div>
    <!-- /.navbar-header -->
    <!-- /.navbar-top-links -->
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li class="sidebar-search">
                    <!-- /input-group -->
                </li>
                <li>
                    <a class="active" href="<?php echo Uri::base(false); ?>admin/"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Property<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?php echo Uri::base(false); ?>admin/addproperty">Add Property Buy</a>
                        </li>
                        <li>
                            <a href="<?php echo Uri::base(false); ?>admin/addpropertyrent">Add Property Rent</a>
                        </li>
                        <li>
                            <a href="<?php echo Uri::base(false); ?>admin/viewproperty">View Property Buy</a>
                        </li>
                        <li>
                            <a href="<?php echo Uri::base(false); ?>admin/viewpropertyrent">View Property Rent</a>
                        </li>
                        <li>
                            <a href="<?php echo Uri::base(false); ?>admin/postadv">Post Advs</a>
                        </li>
                        <li>
                            <a href="<?php echo Uri::base(false); ?>admin/seopage">SEO Page</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> User <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="#">Add User</a>
                        </li>
                        <li>
                            <a href="<?php echo Uri::base(false) . 'admin/addbuilder'; ?>">Add Builder</a>
                        </li>
                        <li>
                            <a href="<?php echo Uri::base(false) . 'admin/userlist'; ?>">View User</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i>Property Response<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?php echo Uri::base(false) . 'admin/enquiryview'; ?>">View Response</a>
                        </li>
                        <li>
                            <a href="<?php echo Uri::base(false) . 'admin/enquiryview'; ?>">View Requirement</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="<?php echo Uri::base(false); ?>user/logout"><i class="fa fa-bar-chart-o fa-fw"></i> Logout <span class="fa arrow"></span></a>
                    <!-- /.nav-second-level -->
                </li>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>