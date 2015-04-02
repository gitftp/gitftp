<div style="height: 20px;"></div>
<script>
    (function($){

        $(document).on('click', '#dashboard-navigation a', function(e){
            e.preventDefault();
            var $this = $(this);
            $this.parents('#dashboard-navigation').find('li').removeClass("active");
            $this.parent().addClass('active');

            $('.tab-model').hide();
            $('#'+$this.attr('data-id')).show();


        });

    })(jQuery); 
</script>

<div class="container">
    <div class="row">
        <div class="span12">
            <ul class="nav nav-tabs" id="dashboard-navigation">
                <li class="active">
                    <a href="#" data-id="tab1">Settings</a>
                </li>
                <li class="">
                    <a href="#" data-id="tab2">Properties listed by me</a>
                </li>
                <li class="">
                    <a href="#" data-id="tab3">Favourites</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="span12 details">
            <h1>
                Account Settings
            </h1>
            <form class="form-horizontal">
                <div class="control-group">
                    <label class="control-label" for="username">Username</label>
                    <div class="controls">
                        <input type="text" id="username" placeholder="Username">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="firstname">Firstname</label>
                    <div class="controls">
                        <input type="text" id="firstname" placeholder="First name">
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn">Save</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="span12 ">
            <h1>
                Account Settings
            </h1>
            
            <div style="height: 10px;"></div>

            <form class="form-horizontal">
                <div class="control-group">
                    <label class="control-label" for="username">Username</label>
                    <div class="controls">
                        <input type="text" id="username" placeholder="Username">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="firstname">Firstname</label>
                    <div class="controls">
                        <input type="text" id="firstname" placeholder="First name">
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<!-- END user settings -->

<!-- property listing  -->
    <div class="row tab-model hide" id="tab2">
        <div class="span12">
            <h1>
                Properties Entries by me
            </h1>
            
            <div style="height: 10px;"></div>

            <table class="table table-bordered">
                <tr>
                    <th>
                        Name
                    </th>
                    <th>
                        Description
                    </th>
                    <th>
                        Address
                    </th>
                    <th>
                        More Details
                    </th>
                    <th>
                        actions
                    </th>
                </tr>
                <tr>
                    <td>
                        ASKHAR GREY STONE
                    </td>
                    <td>
                        The new signpost of luxury & comfort in New Bombay
                    </td>
                    <td>
                        kharghar
                    </td>
                    <td>
                        <strong>Building floors</strong> : 0 <br>
                        <strong>Project details</strong> : 2BHK <br>
                        <strong>Bedrooms</strong> : 1 <br>
                    </td>
                    <td>
                        <a href="#">remove</a>
                    </td>
                </tr>
            </table>

        </div>
    </div>
<!-- END property listing -->

<!-- Favourites -->
    <div class="row tab-model hide" id="tab3">
        <div class="span12">
            <h1>
                Properties favourites
            </h1>
            
            <div style="height: 10px;"></div>

            <table class="table table-bordered">
                <tr>
                    <th>
                        Name
                    </th>
                    <th>
                        Description
                    </th>
                    <th>
                        Address
                    </th>
                    <th>
                        More Details
                    </th>
                    <th>
                        actions
                    </th>
                </tr>
                <tr>
                    <td>
                        ASKHAR GREY STONE
                    </td>
                    <td>
                        The new signpost of luxury & comfort in New Bombay
                    </td>
                    <td>
                        kharghar
                    </td>
                    <td>
                        <strong>Building floors</strong> : 0 <br>
                        <strong>Project details</strong> : 2BHK <br>
                        <strong>Bedrooms</strong> : 1 <br>
                    </td>
                    <td>
                        <a href="#">remove</a>
                    </td>
                </tr>
            </table>

        </div>
    </div>
<!-- END favourites -->

</div>
