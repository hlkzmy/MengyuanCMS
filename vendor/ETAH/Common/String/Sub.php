<?php
/**
 * 
 * @author Edward_sj
 *
 */
namespace Etah\Common\String;

class Sub{
	
	
	/**
	 * 使用iconv的系统函数的方式进行字符串的截取
	 * @author Edward_sj
	 * @param string $str
	 * @param int $offset
	 * @param int $length
	 * @param string $charset
	 * @param string $ellipsis
	 * @return string
	 */
	
	public static function iconvSubString($string,$offset,$length,$charset,$ellipsis="…")
	{
		if(iconv_strlen($string,$charset)>$length){
			$string = iconv_substr($string,$offset,$length,$charset).$ellipsis;
		}
		else{
			$string = iconv_substr($string,$offset,$length,$charset);
		}
		
		return $string;
		
	}//function iconvSubString() end
	
	
	
	
	
	
	
	
	
	
	
	
}//class Sub end