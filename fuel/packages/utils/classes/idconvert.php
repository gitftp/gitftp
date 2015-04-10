<?php

/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.5
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2013 Fuel Development Team
 * @link       http://fuelphp.com
 */
class idconvert {

    public static function get_data_model($where = array()) {
        $data = \Model_CommonFunction::get_data(array('table' => $where['table']));
        return $data;
    }

    public static function get_data_model_where($where = array()) {
        $data = \Model_CommonFunction::get_data(array('table' => $where['table'], 'where' => $where['where'], 'value' => $where['value']));
        return $data;
    }

    public static function get_property_mode($id) {
        $value = \Model_CommonFunction::get_data(array('table' => 'property_mode', 'where' => 'mode_id', 'value' => $id), array('mode_name'));
        if (isset($value[0]['mode_name'])) {
            return $value[0]['mode_name'];
        } else {
            return '';
        }
    }

    /* get property ind details start */

    public static function get_property_name($id) {
        $value = \Model_CommonFunction::get_data(array('table' => 'property_master', 'where' => 'property_id', 'value' => $id), array('property_name'));
        if (isset($value[0]['property_name'])) {
            return $value[0]['property_name'];
        } else {
            return '';
        }
    }

    public static function get_property_location_by_id($id) {
        $value = \Model_CommonFunction::get_data(array('table' => 'property_master', 'where' => 'property_id', 'value' => $id), array('location'));
        if (isset($value[0]['location'])) {
            $details = \Model_CommonFunction::get_data(array('table' => 'location', 'where' => 'location_Id', 'value' => $value[0]['location']), array('locality_name'));
            if (isset($details[0]['locality_name'])) {
                return $details[0]['locality_name'];
            } else {
                return '';
            }
        } else {
            return '';
        }
    }

    public static function get_property_price_by_id($id) {
        $value = \Model_CommonFunction::get_data(array('table' => 'property_master', 'where' => 'property_id', 'value' => $id), array('property_price'));
        if (isset($value[0]['property_price'])) {
            return $value[0]['property_price'];
        } else {
            return '';
        }
    }

    public static function get_bg_color_status($state) {
        switch ($state) {
            case 'Pending':
                return '';
                break;
            case 'Pending':
                return 'rgb(252, 186, 186)';
                break;
            case 'Final':
                return 'rgb(179, 244, 179)';
                break;
            case 'Waiting for Response':
                return 'rgb(249, 249, 120)';
                break;
            case 'Call not Responding':
                return 'rgb(249, 249, 120)';
                break;
            case 'Not Interested':
                return 'gainsboro';
                break;
            case 'Hot Property':
                return 'rgb(252, 186, 186)';
                break;
        }
    }

    /* get property ind details end */

    public static function get_property_type($id) {
        $value = \Model_CommonFunction::get_data(array('table' => 'property_type', 'where' => 'type_id', 'value' => $id), array('type_name'));
        if (isset($value[0]['type_name'])) {
            return $value[0]['type_name'];
        } else {
            return '';
        }
    }

    public static function get_property_location($id) {
        $value = \Model_CommonFunction::get_data(array('table' => 'location', 'where' => 'location_Id', 'value' => $id), array('locality_name'));
        if (isset($value[0]['locality_name'])) {
            return $value[0]['locality_name'];
        } else {
            return '';
        }
    }

    public static function get_property_conduction($id) {
        $value = \Model_CommonFunction::get_data(array('table' => 'property_conduction', 'where' => 'conduction_id', 'value' => $id), array('conduction_name'));
        if (isset($value[0]['conduction_name'])) {
            return $value[0]['conduction_name'];
        } else {
            return '';
        }
    }

    public static function get_property_builder($id) {
        $value = \Model_CommonFunction::get_data(array('table' => 'builder', 'where' => 'builder_id', 'value' => $id), array('builder_name'));
        if (isset($value[0]['builder_name'])) {
            return $value[0]['builder_name'];
        } else {
            return '';
        }
    }

    public static function get_property_builder_img($id) {
        $value = \Model_CommonFunction::get_data(array('table' => 'builder', 'where' => 'builder_id', 'value' => $id), array('image_name'));
        if (isset($value[0]['image_name'])) {
            return $value[0]['image_name'];
        } else {
            return 'companylogo.jpg';
        }
    }

    public static function get_property_builder_desc($id) {
        $value = \Model_CommonFunction::get_data(array('table' => 'builder', 'where' => 'builder_id', 'value' => $id), array('builder_desc'));
        if (isset($value[0]['builder_desc'])) {
            return $value[0]['builder_desc'];
        } else {
            return '';
        }
    }

    public static function get_location_by_limit($limit) {
        return \Model_Location::get_location_limit($limit);
    }

    public static function get_count_property_locaton($id) {
        return \Model_Property::get_count($id);
    }

    public static function get_count_property_newproject($id) {
        return \Model_Property::get_count_new_project($id);
    }

    public static function get_count_property_readyposs($id) {
        return \Model_Property::get_count_ready($id);
    }

    public static function get_count_property_builder($id = null, $type = null) {
        return \Model_Property::get_count_builder($id, $type);
    }

    public static function get_budget($type_value = null) {
        return \Model_CommonFunction::get_data(array('table' => 'budget_master', 'where' => 'type', 'value' => $type_value));
    }

    public static function get_floor($type_value = null) {
        if ($type_value == null) {
            return \Model_CommonFunction::get_data(array('table' => 'floor_master'));
        } else {
            return \Model_CommonFunction::get_data(array('table' => 'floor_master', 'where' => 'floor_id', 'value' => $type_value));
        }
    }

    public static function get_serch_title($search = array()) {
        $contact_valiable = '';
        if ($search['location'] != '') {
            $data = \Model_CommonFunction::get_data(array('table' => 'location', 'where' => 'location_Id', 'value' => $search['location']));
            $contact_valiable .= $data[0]['locality_name'] . ' ';
        }
        if ($search['property_mode'] != '') {
            if ($search['property_mode'] == 1) {
                $data = 'property for Purchase';
            } else if ($search['property_mode'] == 2) {
                $data = 'property for Rent';
            } else {
                $data = '';
            }
            $contact_valiable .= ' ' . $data;
        }
        if ($search['property_type'] != '') {
            $data = \Model_CommonFunction::get_data(array('table' => 'property_type', 'where' => 'type_id', 'value' => $search['property_type']));
            $contact_valiable .= ' | ' . $data[0]['type_name'];
        }
        $conduction_array = $search['property_conduction'];
        if (!empty($conduction_array)) {
            $contact_valiable .= ' | ';
            foreach ($conduction_array as $key => $value) {
                $data = \Model_CommonFunction::get_data(array('table' => 'property_conduction', 'where' => 'conduction_id', 'value' => $value));
                if (isset($data[0]['conduction_name'])) {
                    $contact_valiable .= $data[0]['conduction_name'] . ', ';
                }
            }
        }

        if ($search['bedrooms'] != '') {
            $data = \Model_CommonFunction::get_data(array('table' => 'floor_master', 'where' => 'floor_id', 'value' => $search['bedrooms']));
            $contact_valiable .= ' | ' . $data[0]['floor_name'];
        }
        if ($search['property_price'] != '') {
            $data = \Model_CommonFunction::get_data(array('table' => 'budget_master', 'where' => 'budget_id', 'value' => $search['property_price']));
            $contact_valiable .= ' | Budget ' . $data[0]['budget'];
        }
        return $contact_valiable;
    }

    /* intro page get property function start */

    public static function get_budget_property() {
        $selection = array(
            'location' => 15,
            'property_conduction' => '',
            'property_type' => '',
            'property_mode' => '1',
            'bedrooms' => '',
            'property_price' => 15,
        );
        $count = Model_Property::budget_home($selection);
        return $count;
    }

    public static function get_feature_property() {
        return Model_Property::get_home_project_feature();
    }

    /* intro page get property function end */

    public static function get_nav_details($switch = null) {
        switch ($switch) {
            case 'location':
                return Model_Location::get_location();
                break;
            case 'newproject':

                break;
            case 'builder':
                return Model_Commonfunction::get_data(array('table' => 'builder'));
                break;
            default:

                break;
        }
        return Model_Location::get_location();
    }

    /* get as details  start */

    public static function get_pt_sub_title($data = array()) {
        $details = '';
        if ($data['project_details'] != '') {
            $details .= $data['project_details'];
        }
        if ($data['property_price'] != '' && $data['property_price'] != '0') {
            $details .= ' - (' . $data['property_price'] . ')';
        }
        if (substr($details, 0, 25)) {
            return substr($details, 0, 25);
        } else {
            return '';
        }
    }

    public static function get_pt_status_details($data = array()) {
        $details = '';
        if ($data['property_conduction'] != '') {
            $details .= idconvert::get_property_conduction($data['property_conduction']);
        }
        if ($data['builder_id'] != '') {
            $details .= ' - Builder: ' . idconvert::get_property_builder($data['builder_id']);
        }

        return $details;
    }

    public static function get_pt_details($data = array()) {
        $details = '';
        $property_details = \Model_Property::get_single_details($data['property_id']);
        $c = 0;
        foreach ($property_details as $key => $value) {
            $f = idconvert::get_floor($value['bhk']);
            if ($c == 0) {
                $details .= '<p><span class="content-title">details:</span>' . $f[0]['floor_name'] . ' - ' . $value['type'] . ' - ' . $value['size'] . ' Sq.Fts</p>';
            } else {
                $details .= '<p><span class="content-title"></span>' . $f[0]['floor_name'] . ' - ' . $value['type'] . ' - ' . $value['size'] . ' Sq.Ft </p>';
            }
            $c++;
        }

        return $details;
    }

    public static function get_pt_rt_side_details($data = array()) {
        $details = '';
        if ($data['property_price'] != '') {
            $details .= '<strong>' . $data['property_price'] . '</strong>';
        }
        if ($data['property_area'] != '') {

            $details .= '<span class = "small">Negotiable</span>';
            $details .= '<span class="small">' . $data['property_area'] . ' per sqft</span>';
        }
        return $details;
    }

    public static function get_pt_img($data = array()) {
        $details = '';
        $url = Uri::base(false) . 'assets/img/property/' . $data['property_id'] . '-1.jpg';
        return $url;
    }

    /* get as details  end */

    /* property details page idconvert start */

    public static function get_dt_pull_right_sqt($size = null) {
        if ($size != '') {
            return '<span class="pull-right">' . $size . ' per sqft</span>';
        }
    }

    public static function get_dt_table($details_data = array()) {
        $filter_details = array();

        if ($details_data['property_address'] != '' && $details_data['property_address'] != 0) {
            array_push($filter_details, array('name' => 'Address', 'value' => $details_data['property_address']));
        }
        if ($details_data['property_area'] != '' && $details_data['property_area'] != 0) {
            array_push($filter_details, array('name' => 'Area', 'value' => $details_data['property_area'] . ' SqFt'));
        }
        if ($details_data['property_price'] != '' && $details_data['property_price'] != 0) {
            array_push($filter_details, array('name' => 'Price', 'value' => '' . $details_data['property_price']));
        }
        if ($details_data['location'] != '' && $details_data['location'] != 0) {
            array_push($filter_details, array('name' => 'Location', 'value' => idconvert::get_property_location($details_data['location'])));
        }
        if ($details_data['property_conduction'] != '' && $details_data['property_conduction'] != 0) {
            if ($details_data['possesion_date'] != '' && $details_data['possesion_date'] != 0) {
                array_push($filter_details, array('name' => 'Status', 'value' => idconvert::get_property_conduction($details_data['property_conduction']) . ' Possession on ' . $details_data['possesion_date']));
            } else {
                array_push($filter_details, array('name' => 'Status', 'value' => idconvert::get_property_conduction($details_data['property_conduction'])));
            }
        }
        if ($details_data['property_type'] != '' && $details_data['property_type'] != 0) {
            array_push($filter_details, array('name' => 'Property type', 'value' => idconvert::get_property_type($details_data['property_type'])));
        }

        if ($details_data['property_type'] != '' && $details_data['property_type'] != 0) {
            array_push($filter_details, array('name' => 'Property type', 'value' => idconvert::get_property_type($details_data['property_type'])));
        }

        return $filter_details;
    }

    public static function get_dt_distance($details_data = array()) {
        $filter_details = array();
        if ($details_data['hospital_dis'] != '' && $details_data['hospital_dis'] != 0) {
            array_push($filter_details, array('name' => 'Hospital', 'value' => $details_data['hospital_dis']));
        }
        if ($details_data['school_dis'] != '' && $details_data['school_dis'] != 0) {
            array_push($filter_details, array('name' => 'School', 'value' => $details_data['school_dis']));
        }
        if ($details_data['railway_dis'] != '' && $details_data['railway_dis'] != 0) {
            array_push($filter_details, array('name' => 'Railway', 'value' => $details_data['railway_dis']));
        }
        if ($details_data['airport_dis'] != '' && $details_data['airport_dis'] != 0) {
            array_push($filter_details, array('name' => 'Airport', 'value' => $details_data['airport_dis']));
        }
        if ($details_data['city_center'] != '' && $details_data['city_center'] != 0) {
            array_push($filter_details, array('name' => 'City Center', 'value' => $details_data['city_center']));
        }
        return $filter_details;
    }

    public static function get_dt_project_floor_details($details_data = array()) {
        $filter_details = array();

        return $filter_details;
    }

    /* property details page idconvert end */
    /* view the search in a proper way */

    public static function get_search_show() {
        return 'this <strong>is</strong> the serach';
    }

    /* Geting the demo name api */

    public static function get_am_checked_admin($data, $a) {
        if ($data == $a) {
            return 'checked';
        } else {
            if ($data == '' && $a == 'No') {
                return 'checked';
            } else {
                return '';
            }
        }
    }

    public static function get_am_checked($data) {
        if ($data == 'Yes') {
            return 'checked';
        } else {
            return 'plain';
        }
    }

    public static function get_dist_def($data = null, $display_name = null) {
        if ($data == '') {
            return '';
        } else {
            return '<li>' . $display_name . ': ' . $data . ' Km</li>';
        }
    }

    public static function get_blank_name($data = null, $display_name = null) {
        if ($data == '' || $data == 0) {
            return ' ';
        } else {
            return $data;
        }
    }

    public static function get_cart_count($user_id = null) {
        $count = Model_Property::get_cart($user_id, 'count');
        return count($count);
    }

    public static function get_postadv() {
        return Model_Commonfunction::get_data(array('table' => 'post_adv'));
    }

    public static function get_seo_details($page_name = null) {
        $default_data = array(
            'title' => 'this is default',
            'meta_description' => 'this is default descf',
            'meta_keywords' => 'this is default key word',
            'meta_revisit_after' => 'period',
        );
        if (!is_null($page_name)) {
            $data = Model_Commonfunction::get_data(array('table' => 'seo_desc', 'where' => 'page_name', 'value' => $page_name), array('title', 'meta_description', 'meta_keywords', 'meta_revisit_after'));
            if (isset($data[0]['title'])) {
                return $data[0];
            } else {
                return $default_data;
            }
        } else {
            return $default_data;
        }
    }

}

/* end of file auth.php */
