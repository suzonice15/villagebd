<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		session_destroy();
		redirect('admin/login');
	}
}