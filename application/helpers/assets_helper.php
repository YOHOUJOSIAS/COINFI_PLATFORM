<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('logo_url'))
{
	 function logo_url($lien_image)
	 { 
	  	return base_url().$lien_image;
	 }
}

if ( ! function_exists('lib_url'))
{
	function lib_url($nom)
	{
		return base_url() . 'assets/lib/' . $nom;
	}
}

if ( ! function_exists('bowers_url'))
{
	function bowers_url($nom)
	{
		return base_url() . 'assets/' . $nom;
	}
}

if ( ! function_exists('dist_url'))
{
	function dist_url($nom)
	{
		return base_url() . 'assets/sapp_assets/dist/' . $nom;
	}
}

if ( ! function_exists('img_url'))
{
	function img_url($nom)
	{
		return base_url() . 'assets/img/' . $nom;
	}
}

if ( ! function_exists('login_css_url'))
{
	function login_css_url($nom)
	{
		return base_url() . 'assets/login_assets/css/' . $nom;
	}
}

if ( ! function_exists('login_bower_url'))
{
	function login_bower_url($nom)
	{
		return base_url() . 'assets/login_assets/bootstrap/' . $nom;
	}
}

if ( ! function_exists('login_test_url'))
{
	function login_test_url($nom)
	{
		return base_url() . 'assets/login_assets/test/' . $nom;
	}
}


if ( ! function_exists('login_plugins_url'))
{
	function login_plugins_url($nom)
	{
		return base_url() . 'assets/login_assets/vendors/' . $nom;
	}
}

if ( ! function_exists('login_js_url'))
{
	function login_js_url($nom)
	{
		return base_url() . 'assets/login_assets/js/' . $nom;
	}
}


if ( ! function_exists('adminLTE_url'))
{
	function adminLTE_url()
	{
		return base_url() . 'assets/adminLTE3/';
	}
}



