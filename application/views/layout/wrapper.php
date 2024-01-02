<?php

$this->load->helper('arr');
$this->load->library('authenticated');
$this->authenticated->checkAuth();

$tempRes = $this->navs->get();
$res = keyBy($tempRes, 'is_top_nav', true);
$navs = parseChildrenAlt($res['N'], 'id', 'parent_id', 'childrens');
$topNav = $res['Y'];

require_once(VIEW_PATH . 'header.php');
require_once(VIEW_PATH . 'head.php');
require_once(VIEW_PATH . 'sidebar.php');
require_once(VIEW_PATH . 'content.php');
require_once(VIEW_PATH . 'foot.php');
require_once(VIEW_PATH . 'footer.php');
