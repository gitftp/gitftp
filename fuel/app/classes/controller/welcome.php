<?php

class Controller_Welcome extends Controller {

    public function action_index() {

        if (Auth::check()) {
            // Credentials ok, go right in.
            list($driver, $userid) = Auth::get_user_id();
            $email = Auth::get_email();
            $screen = Auth::get_screen_name();
        }
        /* model call data start */
        $conduction_project_ready = Model_Property::get_home_project_ready(8);
        $conduction_project_pre = Model_Property::get_home_project_pre_launch(15);
        $conduction_project_under = Model_Property::get_home_project_underconstruction(15);
        $feature_project = Model_Property::get_home_project_feature(6);
        //required model 
        $location = Model_Location::get_location();
        $builder = Model_CommonFunction::get_data(array('table' => 'builder'));
        $recentproperty = Model_Property::get_recentproperty(6);

        /* model call data end */

        $view = View::forge('layout/welcomelayout');
        $view->headerscript = View::forge('layout/headerscript');
        $top = View::forge('layout/topheader');
        /* add city and builder */
        $top->location = $location;
        $top->builder = $builder;

        $top->flex = View::forge('welcome/flexslider');
        $view->topheader = $top;
        $addlocation = View::forge('layout/propertyfilterform');
        $addlocation->location = $location;
        $view->propertyfilterform = $addlocation;

        /* contain start */
        $contain = View::forge('welcome/contain');
        $contain->propertydatafeat = $feature_project;
        $contain->propertydatapre = $conduction_project_pre;
        $contain->propertydataready = $conduction_project_ready;
        $contain->propertydataunder = $conduction_project_under;
        $contain->builder = $builder;
        $searchbar = View::forge('layout/welcomesidebar');
        $searchbar->recentproperty = $recentproperty;
        $contain->welcomesidebar = $searchbar;
        $view->contain = $contain;
        /* contain end */

        /* footer script */
        $footer = View::forge('layout/footertop');
        $footer->location_fotter = $location;
        $view->footertop = View::forge('layout/footertop');
        $view->footerbottom = View::forge('layout/footerbottom');
        $view->footerscript = View::forge('layout/footerscript');

        return $view;
//        exit();
    }

    public function action_about() {
        /* model view add */
        $location = Model_Location::get_location();
        $builder = Model_CommonFunction::get_data(array('table' => 'builder'));

        $view = View::forge('layout/fullscreenlayout');
        $view->headerscript = View::forge('layout/headerscript');
        $top = View::forge('layout/topheader');
        /* add city and builder */
        $top->location = $location;
        $top->builder = $builder;
        $top->flex = View::forge('contact/flexslider');
        $view->topheader = $top;
        $view->propertyfilterform = View::forge('layout/propertyfilterform');

        /* contain start */
//        $view->contain =  View::forge('about/contain');
        $contain = View::forge('about/containleft');
        $contain->welcomesidebar = View::forge('layout/welcomesidebar');
        $view->contain = $contain;
        /* contain end */

        $view->footertop = View::forge('layout/footertop');
        $view->footerbottom = View::forge('layout/footerbottom');
        $view->footerscript = View::forge('layout/footerscript');
        return $view;
    }

    public function action_aboutfull() {
        $view = View::forge('layout/fullscreenlayout');
        $view->headerscript = View::forge('layout/headerscript');
        $top = View::forge('layout/topheader');
        $top->flex = View::forge('contact/flexslider');
        $view->topheader = $top;
        $addlocation = View::forge('layout/propertyfilterform');
        $addlocation->location = $location;
        $view->propertyfilterform = $addlocation;

        /* contain start */
//        $view->contain =  View::forge('about/contain');
        $contain = View::forge('about/containleft');
        $contain->welcomesidebar = View::forge('layout/welcomesidebar');
        $view->contain = View::forge('about/contain');
        /* contain end */

        $view->footertop = View::forge('layout/footertop');
        $view->footerbottom = View::forge('layout/footerbottom');
        $view->footerscript = View::forge('layout/footerscript');
        return $view;
    }

    public function action_blocklist() {
        /* model call data start */
        $conduction_project_ready = Model_Property::get_home_project_ready(6);
        $conduction_project_pre = Model_Property::get_home_project_pre_launch(6);
        $feature_project = Model_Property::get_home_project_feature(6);
        $location = Model_Location::get_location();
        $builder = Model_CommonFunction::get_data(array('table' => 'builder'));
        $recentproperty = Model_Property::get_recentproperty(3);
        /* model call data end */

        $view = View::forge('layout/fullscreenlayout');
        $view->headerscript = View::forge('layout/headerscript');
        $top = View::forge('layout/topheader');
        $top->flex = View::forge('contact/flexslider');
        $top->location = $location;
        $top->builder = $builder;
        $view->topheader = $top;

        $addlocation = View::forge('layout/propertyfilterform');
        $addlocation->location = $location;
        $view->propertyfilterform = $addlocation;


        /* contain start */
//        $view->contain =  View::forge('about/contain');
        $contain = View::forge('propertylist/blocklist');
        $searchbar = View::forge('layout/welcomesidebar');
//        $searchbar->request = 'set';
        $searchbar->recentproperty = $recentproperty;
        $contain->welcomesidebar = $searchbar;
        $view->contain = $contain;
        /* contain end */

        $view->footertop = View::forge('layout/footertop');
        $view->footerbottom = View::forge('layout/footerbottom');
        $view->footerscript = View::forge('layout/footerscript');
        return $view;
    }

    public function action_singlelist($id = null) {
        /* model view add */
        $location = Model_Location::get_location();
        $builder = Model_CommonFunction::get_data(array('table' => 'builder'));
        $location = Model_Location::get_location();
        $base_details = Model_Property::get_single_pm($id);
        $amut_details = Model_Property::get_single_amut($id);
        $distance_details = Model_Property::get_single_distance($id);
        $property_details = Model_Property::get_single_details($id);

        $recentproperty = Model_Property::get_recentproperty(9);
        /* model view end */

        $view = View::forge('layout/welcomelayout');
        $view->headerscript = View::forge('layout/headerscript');
        $top = View::forge('layout/topheader');
        /* add city and builder */
        $top->location = $location;
        $top->builder = $builder;

        $top->flex = View::forge('welcome/flexslider');
        $view->topheader = $top;
        $addlocation = View::forge('layout/propertyfilterform');
        $addlocation->location = $location;
        $view->propertyfilterform = $addlocation;

        /* contain start */
//        $view->contain =  View::forge('about/contain');
        $contain = View::forge('propertylist/singlelist');
        $contain->detailsdata = $base_details;
        $contain->amut_data = $amut_details;
        $contain->distance_details = $distance_details;
        $contain->property_details = $property_details;
        $searchbar = View::forge('layout/welcomesidebar');
        $searchbar->request = $base_details;
        $searchbar->recentproperty = $recentproperty;
        $contain->welcomesidebar = $searchbar;

        $view->contain = $contain;
        /* contain end */

        $view->footertop = View::forge('layout/footertop');
        $view->footerbottom = View::forge('layout/footerbottom');
        $view->footerscript = View::forge('layout/footerscript');
        return $view;
    }

    /* Dashboard view */

    public function action_dpropertylist() {
        $view = View::forge('layout/fullscreenlayout');
        $view->headerscript = View::forge('layout/headerscript');
        $top = View::forge('layout/topheader');
        $top->flex = View::forge('contact/flexslider');
        $view->topheader = $top;
//        $view->propertyfilterform = View::forge('layout/propertyfilterform');
        $view->propertyfilterform = '';

        /* contain start */
//        $view->contain =  View::forge('about/contain');
        $contain = View::forge('dashboard/listproperty');
        //$contain->welcomesidebar = View::forge('layout/welcomesidebar');
        $view->contain = $contain;
        /* contain end */

        $view->footertop = View::forge('layout/footertop');
        $view->footerbottom = View::forge('layout/footerbottom');
        $view->footerscript = View::forge('layout/footerscript');
        return $view;
    }

    public function action_404() {

        $view = View::forge('layout/about');
        $view->headerscript = View::forge('layout/headerscript');
        $view->slider = View::forge('layout/slider');
        $view->nav = View::forge('layout/nav');
        $view->topnav = View::forge('layout/topnav');
        $view->rightbar = View::forge('layout/rightbar');
        $view->contain = View::forge('layout/404');
        $view->footerscript = View::forge('layout/footerscript');
        $view->footer = View::forge('layout/footer');
        return $view;
    }

    public function action_email() {
        $email = Email::forge();
        $email->from('info@globalpropertykart.com', 'info');
        $email->to('megaurishrane@gmail.com');
        $email->header('CC: <info@globalpropertykart.com>');
        $email->subject('Welcome to Globalpropertykart.com');
        // $emailv = View::forge('email/registration');
//        $emailv->name = $name;
//        $emailv->email = $emailid;
        $email->html_body('asdf', true, false);
        $email->priority(\Email::P_HIGH);
        try {
            $email->send();
        } catch (\EmailValidationFailedException $e) {
            $error1 = 'fail';
            echo $error1;
        } catch (\EmailSendingFailedException $e) {
            $error1 = 'driver not found fail';
            echo $error1;
            echo '<pre>';
            print_r($e);
        }
    }

    public function action_email2() {
        $email = Email::forge();
        $email->from('xya@craftpip.com', 'info');
        $email->to('megaurishrane@gmail.com');
        $email->header('CC: <info@globalpropertykart.com>');
        $email->subject('Welcome to Globalpropertykart.com');
        //$emailv = View::forge('email/propertyview');
//        $emailv->name = $name;
//        $emailv->email = $emailid;
        $email->html_body('asd', true, false);
        $email->priority(\Email::P_HIGH);
        try {
            $email->send();
        } catch (\EmailValidationFailedException $e) {
            $error1 = 'fail';
            echo $error1;
        } catch (\EmailSendingFailedException $e) {
            $error1 = 'driver not found fail';
            echo $error1;
        }
    }

    public function action_email3() {
        $email = Email::forge();
        $email->from('info@globalpropertykart.com', 'info');
        $email->to('megaurishrane@gmail.com');
        $email->header('CC: <info@globalpropertykart.com>');
        $email->subject('Welcome to Globalpropertykart.com');
        $emailv = View::forge('email/propertyview');
//        $emailv->name = $name;
//        $emailv->email = $emailid;
        $email->html_body($emailv, true, false);
        $email->priority(\Email::P_HIGH);
        try {
            $email->send();
        } catch (\EmailValidationFailedException $e) {
            $error1 = 'fail';
            echo $error1;
        } catch (\EmailSendingFailedException $e) {
            $error1 = 'driver not found fail';
            echo $error1;
        }
    }

    public function action_demo() {
        $string = "Plastic asdf,Dermaton--";
        $rm = str_replace('--', '', $string);

        if (substr($rm, -1) == ',') {
            $orm = substr($rm, 0, -1);
        } else {
            $orm = $rm;
        }
        echo 'orginal' . $string . '<br>';
        echo 'replace' . $orm . '<br>';
    }

    public function action_testmulti() {

        if (Input::method() == 'POST') {
         
            $file3 = Input::file('fileint');
            foreach ($file3['tmp_name'] as $key => $value) {
                if ($value != '') {
                    File::copy($value, DOCROOT . 'assets/img/temptest/' . $key . '-1.jpg');
                }
            }
        }
        $view = View::forge('testform');
        return $view;
    }

}
