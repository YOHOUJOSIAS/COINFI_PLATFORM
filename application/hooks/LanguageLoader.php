<?php

/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 19/02/2018
 * Time: 12:18
 */
class LanguageLoader
{
    function initialize() {
        $ci =& get_instance();
        $ci->load->helper('language');
        $siteLang = $ci->session->userdata('site_lang');
        //$siteLang = "francais";
        if ($siteLang) {
            $ci->lang->load('message',$siteLang);
        } else {
            $ci->lang->load('message','francais');
        }
    }
}