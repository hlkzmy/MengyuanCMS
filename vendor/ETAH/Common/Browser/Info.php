<?php

namespace Etah\Common\Browser;

class Info
{
	 
	function getBrowser() {
		
		$sys = $_SERVER['HTTP_USER_AGENT'];
		
		if (stripos($sys, "NetCaptor") > 0) {
			$exp[0] = "NetCaptor";
			$exp[1] = "";
		} 
		elseif (stripos($sys, "Firefox/") > 0) {
			preg_match("/Firefox\/([^;)]+)+/i", $sys, $b);
			$exp[0] = "Mozilla Firefox";
			$exp[1] = $b[1];
		} 
		elseif (stripos($sys, "MAXTHON") > 0) {
			preg_match("/MAXTHON\s+([^;)]+)+/i", $sys, $b);
			preg_match("/MSIE\s+([^;)]+)+/i", $sys, $ie);
			// $exp = $b[0]." (IE".$ie[1].")";
			$exp[0] = $b[0] . " (IE" . $ie[1] . ")";
			$exp[1] = $ie[1];
		} 
		elseif (stripos($sys, "MSIE") > 0) {
			preg_match("/MSIE\s+([^;)]+)+/i", $sys, $ie);
			//$exp = "Internet Explorer ".$ie[1];
			$exp[0] = "Internet Explorer";
			$exp[1] = $ie[1];
		} 
		elseif (stripos($sys, "Netscape") > 0) {
			$exp[0] = "Netscape";
			$exp[1] = "";
		} 
		elseif (stripos($sys, "Opera") > 0) {
			$exp[0] = "Opera";
			$exp[1] = "";
		} 
		elseif (stripos($sys, "Chrome") > 0) {
			$exp[0] = "Chrome";
			$exp[1] = "";
		} 
		else {
			$exp = "未知浏览器";
			$exp[1] = "";
		}
		
		return $exp;
		
	}//getBrowser
    
    
}
