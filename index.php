<?php
/*
Plugin Name: ACF Get All Objects
Plugin URI:  #
Description:  get_field has cost in front end! it means when you perform this function it calls multiple time queries as you store data in your backend. in simple words if you had 1000 text box in your acf option back-end and you call acf get_field in front-end it will call mysql query 1000 times and if you want use acf and care about your performance you will need to use this plugin or other approciate approche.
Version:     1.0.0
Author:      dariushvesal
Author URI:  http://www.devlife.ir
License:     No License
License URI: -
*/


class ACFAllObjects
{
  public function existACFAllObjects($key)
  {
      $re = get_option($key, []);
      if (empty($re)) {
          return false;
      } else {
          return true;
      }
  }
}

class ACFAllObjectsBackend extends ACFAllObjects
{
    public function __construct()
    {
      add_action('acf/save_post', [$this, 'my_acf_save_post'], 9999);
    }

    public function my_acf_save_post($post_id)
    {
        if (! function_exists('get_fields')) {
            return;
        }

        if (empty($_POST['acf'])) {
            return;
        }
        $re = get_fields($post_id);
        $this->setACFAllObjects($post_id, $re);
    }

    public function setACFAllObjects($post_id, $value)
    {
        $jsonValue = json_encode($value);
        $newKey = "acfAllObjects_$post_id";
        //acfAllObjects_options
        if ($this->existACFAllObjects($newKey)) {
            update_option($newKey, $jsonValue, 'no');
        } else {
            add_option($newKey, $jsonValue, '', 'no');
        }
    }

  
}

class ACFAllObj {
  public static function all($post_id)
  {
      $newKey = "acfAllObjects_$post_id";
      $re = get_option($newKey, []);
      return json_decode($re);
  }

  public static function get($key = '', $post_id)
  {
      if($post_id === 'option') {
        $post_id = 'options';
      }

      $newKey = "acfAllObjects_$post_id";
      $re = get_option($newKey, []);
      

      $reArray = json_decode($re, true);
      if (! empty($reArray) ) {
        if (isset($reArray[$key])) {
          return $reArray[$key];
        }
      }
      return [];
  }
}


new ACFAllObjectsBackend();