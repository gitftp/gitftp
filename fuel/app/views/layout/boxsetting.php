<!-- <div>
    <div id="settings">
        <div class="colors">
            <div class="panel-title">Our Service</div> 
            <a><div class="panel-color-title"><img src="http://placehold.it/250x70&text=Anti-Ageing" >&nbsp;&nbsp;Anti-Ageing</div> </a>   
            <a><div class="panel-color-title"><img src="http://placehold.it/250x70&text=Face" >&nbsp;&nbsp;Face</div>    </a>
            <a><div class="panel-color-title"><img src="http://placehold.it/250x70&text=Skin" >&nbsp;&nbsp;Skin</div>    </a>
            <a> <div class="panel-color-title"><img src="http://placehold.it/250x70&text=Laser" >&nbsp;&nbsp;Laser</div>    </a>
            <a> <div class="panel-color-title"><img src="http://placehold.it/250x70&text=Slimming" >&nbsp;&nbsp;Slimming</div></a>     
            <!--            <ul>
                            <li><a title="Anti-Ageing" class="color1 color-switch"> <h2>Anti-Ageing</h2></a></li>
                        </ul>
                        <div class="panel-color-title">Anti-Ageing</div>    
                        <ul>
                            <li><a title="Anti-Ageing" class="color1 color-switch"><i class="fa fa-check"></i> view</a></li>
                        </ul>
        </div>
        <a href="javascript:void(0);" class="settings_link showup"><i class="fa fa-cog"></i></a>
    </div>
</div> -->

<div class="switch">
    <span>Explore our Services</span>
</div>

<div class="switch-container" style="display:none">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <a href="#">
                    <div class="switch-division" style="background-image:url('<?php echo Uri::base(false) ?>/assets/img/images/skin.png')">
                        <span>NuSkin</span>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="#">
                    <div class="switch-division" style="background-image:url('<?php echo Uri::base(false) ?>/assets/img/images/dermal.png')">
                        <span>NuHair</span>
                    </div>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <a href="#">
                    <div class="switch-division" style="background-image:url('<?php echo Uri::base(false) ?>/assets/img/images/3.png')">
                        <span>Something</span>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="#">
                    <div class="switch-division" style="background-image:url('<?php echo Uri::base(false) ?>/assets/img/images/4.png')">
                        <span>Something else</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    
.switch{
    position:fixed;
    top: 200px;
    left: -73px;
    z-index: 999;
    background: white;
    padding: 10px 10px;
    border-radius: 0 0 5px 5px;
    font-size: 15px;
    transform: rotate(-90deg);
    text-transform: uppercase;
    box-shadow: 0 2px 3px rgba(0,0,0,.1);
    cursor: pointer;
}
.switch:hover{
    box-shadow: 0 4px 5px rgba(0,0,0,.1);
}
.switch-division{
    background-color: #eee;
    margin-bottom: 20px;
    padding: 50px 10px;
    text-align: center;
    font-size: 15px;
    vertical-align: bottom !important;
    display: block;
    background-size: cover;
    background-position: center;
    border-radius: 4px;
}
.switch-division:hover{
    opacity: .8;
    box-shadow: 0 0 0 2px #870C55;
}
.switch-division span{
    background-color: rgba(0,0,0,.4);
    padding: 10px;
    border-radius: 3px;
    color: white;
    box-shadow: 0 2px 3px rgba(0,0,0,.3);
}
</style>