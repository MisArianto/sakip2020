<?php @"SourceGuardian"; //v10.1.6
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'7.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='http://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"http://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');