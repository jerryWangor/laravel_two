<?php

	/**
	 * 调试不断点
	 * @author  Typ.    date:2016-06-04

	 */
	function xmp($data) {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
	}
	/**
	 * 调试并断点
	 * @author  Typ.    date:2016-06-04

	 */
	function stop($data) {
	    echo '<pre>';
	    var_dump($data);
	    echo '</pre>';
	    exit;
	}

	if(!function_exists('returnJson')) {
	    function returnJson($msg = '', $code = -1, $data = array(), $other = array()) {
	        $_msg = array(
	            'data'      =>  $data ? $data : array(),
	            'msg'       =>  $msg ? $msg : '',
	            'code'      =>  $code
	        );
	        if(!empty($other) && is_array($other)) {
	            foreach($other as $key=>$value) {
	                $_msg[$key] = $value;
	            }
	        }
	        exit(json_encode($_msg));
	    }
	}
?>