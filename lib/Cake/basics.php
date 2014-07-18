<?php
/**
 * Basic Cake functionality.
 *
 * Core functions for including other source files, loading models and so forth.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Basic defines for timing functions.
 */
	define('SECOND', 1);
	define('MINUTE', 60);
	define('HOUR', 3600);
	define('DAY', 86400);
	define('WEEK', 604800);
	define('MONTH', 2592000);
	define('YEAR', 31536000);

/**
 * Loads configuration files. Receives a set of configuration files
 * to load.
 * Example:
 *
 * `config('config1', 'config2');`
 *
 * @return boolean Success
 * @link http://book.cakephp.org/2.0/en/core-libraries/global-constants-and-functions.html#config
 */
function config() {
	$args = func_get_args();
	foreach ($args as $arg) {
		if (file_exists(APP . 'Config' . DS . $arg . '.php')) {
			include_once APP . 'Config' . DS . $arg . '.php';

			if (count($args) == 1) {
				return true;
			}
		} else {
			if (count($args) == 1) {
				return false;
			}
		}
	}
	return true;
}

/**
 * Prints out debug information about given variable.
 *
 * Only runs if debug level is greater than zero.
 *
 * @param boolean $var Variable to show debug information for.
 * @param boolean $showHtml If set to true, the method prints the debug data in a browser-friendly way.
 * @param boolean $showFrom If set to true, the method prints from where the function was called.
 * @link http://book.cakephp.org/2.0/en/development/debugging.html#basic-debugging
 * @link http://book.cakephp.org/2.0/en/core-libraries/global-constants-and-functions.html#debug
 */
function debug($var = false, $showHtml = null, $showFrom = true) {
	if (Configure::read('debug') > 0) {
		App::uses('Debugger', 'Utility');
		$file = '';
		$line = '';
		$lineInfo = '';
		if ($showFrom) {
			$trace = Debugger::trace(array('start' => 1, 'depth' => 2, 'format' => 'array'));
			$file = str_replace(array(CAKE_CORE_INCLUDE_PATH, ROOT), '', $trace[0]['file']);
			$line = $trace[0]['line'];
		}
		$html = <<<HTML
<div class="cake-debug-output">
%s
<pre class="cake-debug">
%s
</pre>
</div>
HTML;
		$text = <<<TEXT
%s
########## DEBUG ##########
%s
###########################
TEXT;
		$template = $html;
		if (php_sapi_name() == 'cli' || $showHtml === false) {
			$template = $text;
			if ($showFrom) {
				$lineInfo = sprintf('%s (line %s)', $file, $line);
			}
		}
		if ($showHtml === null && $template !== $text) {
			$showHtml = true;
		}
		$var = Debugger::exportVar($var, 25);
		if ($showHtml) {
			$template = $html;
			$var = h($var);
			if ($showFrom) {
				$lineInfo = sprintf('<span><strong>%s</strong> (line <strong>%s</strong>)</span>', $file, $line);
			}
		}
		printf($template, $lineInfo, $var);
	}
}

if (!function_exists('sortByKey')) {

/**
 * Sorts given $array by key $sortby.
 *
 * @param array $array Array to sort
 * @param string $sortby Sort by this key
 * @param string $order  Sort order asc/desc (ascending or descending).
 * @param integer $type Type of sorting to perform
 * @return mixed Sorted array
 * @link http://book.cakephp.org/2.0/en/core-libraries/global-constants-and-functions.html#sortByKey
 */
	function sortByKey(&$array, $sortby, $order = 'asc', $type = SORT_NUMERIC) {
		if (!is_array($array)) {
			return null;
		}

		foreach ($array as $key => $val) {
			$sa[$key] = $val[$sortby];
		}

		if ($order == 'asc') {
			asort($sa, $type);
		} else {
			arsort($sa, $type);
		}

		foreach ($sa as $key => $val) {
			$out[] = $array[$key];
		}
		return $out;
	}

}

/**
 * Convenience method for htmlspecialchars.
 *
 * @param string|array|object $text Text to wrap through htmlspecialchars.  Also works with arrays, and objects.
 *    Arrays will be mapped and have all their elements escaped.  Objects will be string cast if they
 *    implement a `__toString` method.  Otherwise the class name will be used.
 * @param boolean $double Encode existing html entities
 * @param string $charset Character set to use when escaping.  Defaults to config value in 'App.encoding' or 'UTF-8'
 * @return string Wrapped text
 * @link http://book.cakephp.org/2.0/en/core-libraries/global-constants-and-functions.html#h
 */
function h($text, $double = true, $charset = null) {
	if (is_array($text)) {
		$texts = array();
		foreach ($text as $k => $t) {
			$texts[$k] = h($t, $double, $charset);
		}
		return $texts;
	} elseif (is_object($text)) {
		if (method_exists($text, '__toString')) {
			$text = (string)$text;
		} else {
			$text = '(object)' . get_class($text);
		}
	} elseif (is_bool($text)) {
		return $text;
	}

	static $defaultCharset = false;
	if ($defaultCharset === false) {
		$defaultCharset = Configure::read('App.encoding');
		if ($defaultCharset === null) {
			$defaultCharset = 'UTF-8';
		}
	}
	if (is_string($double)) {
		$charset = $double;
	}
	return htmlspecialchars($text, ENT_QUOTES, ($charset) ? $charset : $defaultCharset, $double);
}

/**
 * Splits a dot syntax plugin name into its plugin and classname.
 * If $name does not have a dot, then index 0 will be null.
 *
 * Commonly used like `list($plugin, $name) = pluginSplit($name);`
 *
 * @param string $name The name you want to plugin split.
 * @param boolean $dotAppend Set to true if you want the plugin to have a '.' appended to it.
 * @param string $plugin Optional default plugin to use if no plugin is found. Defaults to null.
 * @return array Array with 2 indexes.  0 => plugin name, 1 => classname
 * @link http://book.cakephp.org/2.0/en/core-libraries/global-constants-and-functions.html#pluginSplit
 */
function pluginSplit($name, $dotAppend = false, $plugin = null) {
	if (strpos($name, '.') !== false) {
		$parts = explode('.', $name, 2);
		if ($dotAppend) {
			$parts[0] .= '.';
		}
		return $parts;
	}
	return array($plugin, $name);
}

/**
 * Print_r convenience function, which prints out <PRE> tags around
 * the output of given array. Similar to debug().
 *
 * @see	debug()
 * @param array $var Variable to print out
 * @link http://book.cakephp.org/2.0/en/core-libraries/global-constants-and-functions.html#pr
 */
function pr($var) {
	if (Configure::read('debug') > 0) {
		echo '<pre>';
		print_r($var);
		echo '</pre>';
	}
}

/**
 * Merge a group of arrays
 *
 * @param array First array
 * @param array Second array
 * @param array Third array
 * @param array Etc...
 * @return array All array parameters merged into one
 * @link http://book.cakephp.org/2.0/en/development/debugging.html#am
 */
function am() {
	$r = array();
	$args = func_get_args();
	foreach ($args as $a) {
		if (!is_array($a)) {
			$a = array($a);
		}
		$r = array_merge($r, $a);
	}
	return $r;
}

/**
 * Gets an environment variable from available sources, and provides emulation
 * for unsupported or inconsistent environment variables (i.e. DOCUMENT_ROOT on
 * IIS, or SCRIPT_NAME in CGI mode).  Also exposes some additional custom
 * environment information.
 *
 * @param  string $key Environment variable name.
 * @return string Environment variable setting.
 * @link http://book.cakephp.org/2.0/en/core-libraries/global-constants-and-functions.html#env
 */
function env($key) {
	if ($key === 'HTTPS') {
		if (isset($_SERVER['HTTPS'])) {
			return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
		}
		return (strpos(env('SCRIPT_URI'), 'https://') === 0);
	}

	if ($key === 'SCRIPT_NAME') {
		if (env('CGI_MODE') && isset($_ENV['SCRIPT_URL'])) {
			$key = 'SCRIPT_URL';
		}
	}

	$val = null;
	if (isset($_SERVER[$key])) {
		$val = $_SERVER[$key];
	} elseif (isset($_ENV[$key])) {
		$val = $_ENV[$key];
	} elseif (getenv($key) !== false) {
		$val = getenv($key);
	}

	if ($key === 'REMOTE_ADDR' && $val === env('SERVER_ADDR')) {
		$addr = env('HTTP_PC_REMOTE_ADDR');
		if ($addr !== null) {
			$val = $addr;
		}
	}

	if ($val !== null) {
		return $val;
	}

	switch ($key) {
		case 'SCRIPT_FILENAME':
			if (defined('SERVER_IIS') && SERVER_IIS === true) {
				return str_replace('\\\\', '\\', env('PATH_TRANSLATED'));
			}
			break;
		case 'DOCUMENT_ROOT':
			$name = env('SCRIPT_NAME');
			$filename = env('SCRIPT_FILENAME');
			$offset = 0;
			if (!strpos($name, '.php')) {
				$offset = 4;
			}
			return substr($filename, 0, -(strlen($name) + $offset));
		case 'PHP_SELF':
			return str_replace(env('DOCUMENT_ROOT'), '', env('SCRIPT_FILENAME'));
		case 'CGI_MODE':
			return (PHP_SAPI === 'cgi');
		case 'HTTP_BASE':
			$host = env('HTTP_HOST');
			$parts = explode('.', $host);
			$count = count($parts);

			if ($count === 1) {
				return '.' . $host;
			} elseif ($count === 2) {
				return '.' . $host;
			} elseif ($count === 3) {
				$gTLD = array(
					'aero',
					'asia',
					'biz',
					'cat',
					'com',
					'coop',
					'edu',
					'gov',
					'info',
					'int',
					'jobs',
					'mil',
					'mobi',
					'museum',
					'name',
					'net',
					'org',
					'pro',
					'tel',
					'travel',
					'xxx'
				);
				if (in_array($parts[1], $gTLD)) {
					return '.' . $host;
				}
			}
			array_shift($parts);
			return '.' . implode('.', $parts);
	}
	return null;
}

/**
 * Reads/writes temporary data to cache files or session.
 *
 * @param  string $path	File path within /tmp to save the file.
 * @param  mixed  $data	The data to save to the temporary file.
 * @param  mixed  $expires A valid strtotime string when the data expires.
 * @param  string $target  The target of the cached data; either 'cache' or 'public'.
 * @return mixed  The contents of the temporary file.
 * @deprecated Please use Cache::write() instead
 */
function cache($path, $data = null, $expires = '+1 day', $target = 'cache') {
	if (Configure::read('Cache.disable')) {
		return null;
	}
	$now = time();

	if (!is_numeric($expires)) {
		$expires = strtotime($expires, $now);
	}

	switch (strtolower($target)) {
		case 'cache':
			$filename = CACHE . $path;
		break;
		case 'public':
			$filename = WWW_ROOT . $path;
		break;
		case 'tmp':
			$filename = TMP . $path;
		break;
	}
	$timediff = $expires - $now;
	$filetime = false;

	if (file_exists($filename)) {
		//@codingStandardsIgnoreStart
		$filetime = @filemtime($filename);
		//@codingStandardsIgnoreEnd
	}

	if ($data === null) {
		if (file_exists($filename) && $filetime !== false) {
			if ($filetime + $timediff < $now) {
				//@codingStandardsIgnoreStart
				@unlink($filename);
				//@codingStandardsIgnoreEnd
			} else {
				//@codingStandardsIgnoreStart
				$data = @file_get_contents($filename);
				//@codingStandardsIgnoreEnd
			}
		}
	} elseif (is_writable(dirname($filename))) {
		//@codingStandardsIgnoreStart
		@file_put_contents($filename, $data, LOCK_EX);
		//@codingStandardsIgnoreEnd
	}
	return $data;
}

/**
 * Used to delete files in the cache directories, or clear contents of cache directories
 *
 * @param string|array $params As String name to be searched for deletion, if name is a directory all files in
 *   directory will be deleted. If array, names to be searched for deletion. If clearCache() without params,
 *   all files in app/tmp/cache/views will be deleted
 * @param string $type Directory in tmp/cache defaults to view directory
 * @param string $ext The file extension you are deleting
 * @return true if files found and deleted false otherwise
 */
function clearCache($params = null, $type = 'views', $ext = '.php') {
	if (is_string($params) || $params === null) {
		$params = preg_replace('/\/\//', '/', $params);
		$cache = CACHE . $type . DS . $params;

		if (is_file($cache . $ext)) {
			//@codingStandardsIgnoreStart
			@unlink($cache . $ext);
			//@codingStandardsIgnoreEnd
			return true;
		} elseif (is_dir($cache)) {
			$files = glob($cache . '*');

			if ($files === false) {
				return false;
			}

			foreach ($files as $file) {
				if (is_file($file) && strrpos($file, DS . 'empty') !== strlen($file) - 6) {
					//@codingStandardsIgnoreStart
					@unlink($file);
					//@codingStandardsIgnoreEnd
				}
			}
			return true;
		} else {
			$cache = array(
				CACHE . $type . DS . '*' . $params . $ext,
				CACHE . $type . DS . '*' . $params . '_*' . $ext
			);
			$files = array();
			while ($search = array_shift($cache)) {
				$results = glob($search);
				if ($results !== false) {
					$files = array_merge($files, $results);
				}
			}
			if (empty($files)) {
				return false;
			}
			foreach ($files as $file) {
				if (is_file($file) && strrpos($file, DS . 'empty') !== strlen($file) - 6) {
					//@codingStandardsIgnoreStart
					@unlink($file);
					//@codingStandardsIgnoreEnd
				}
			}
			return true;
		}
	} elseif (is_array($params)) {
		foreach ($params as $file) {
			clearCache($file, $type, $ext);
		}
		return true;
	}
	return false;
}

/**
 * Recursively strips slashes from all values in an array
 *
 * @param array $values Array of values to strip slashes
 * @return mixed What is returned from calling stripslashes
 * @link http://book.cakephp.org/2.0/en/core-libraries/global-constants-and-functions.html#stripslashes_deep
 */
function stripslashes_deep($values) {
	if (is_array($values)) {
		foreach ($values as $key => $value) {
			$values[$key] = stripslashes_deep($value);
		}
	} else {
		$values = stripslashes($values);
	}
	return $values;
}

/**
 * Returns a translated string if one is found; Otherwise, the submitted message.
 *
 * @param string $singular Text to translate
 * @param mixed $args Array with arguments or multiple arguments in function
 * @return mixed translated string
 * @link http://book.cakephp.org/2.0/en/core-libraries/global-constants-and-functions.html#__
 */
function __($singular, $args = null) {
	if (!$singular) {
		return;
	}

	App::uses('I18n', 'I18n');
	$translated = I18n::translate($singular);
	if ($args === null) {
		return $translated;
	} elseif (!is_array($args)) {
		$args = array_slice(func_get_args(), 1);
	}
	return vsprintf($translated, $args);
}

/**
 * Returns correct plural form of message identified by $singular and $plural for count $count.
 * Some languages have more than one form for plural messages dependent on the count.
 *
 * @param string $singular Singular text to translate
 * @param string $plural Plural text
 * @param integer $count Count
 * @param mixed $args Array with arguments or multiple arguments in function
 * @return mixed plural form of translated string
 * @link http://book.cakephp.org/2.0/en/core-libraries/global-constants-and-functions.html#__n
 */
function __n($singular, $plural, $count, $args = null) {
	if (!$singular) {
		return;
	}

	App::uses('I18n', 'I18n');
	$translated = I18n::translate($singular, $plural, null, 6, $count);
	if ($args === null) {
		return $translated;
	} elseif (!is_array($args)) {
		$args = array_slice(func_get_args(), 3);
	}
	return vsprintf($translated, $args);
}

/**
 * Allows you to override the current domain for a single message lookup.
 *
 * @param string $domain Domain
 * @param string $msg String to translate
 * @param mixed $args Array with arguments or multiple arguments in function
 * @return translated string
 * @link http://book.cakephp.org/2.0/en/core-libraries/global-constants-and-functions.html#__d
 */
function __d($domain, $msg, $args = null) {
	if (!$msg) {
		return;
	}
	App::uses('I18n', 'I18n');
	$translated = I18n::translate($msg, null, $domain);
	if ($args === null) {
		return $translated;
	} elseif (!is_array($args)) {
		$args = array_slice(func_get_args(), 2);
	}
	return vsprintf($translated, $args);
}

/**
 * Allows you to override the current domain for a single plural message lookup.
 * Returns correct plural form of message identified by $singular and $plural for count $count
 * from domain $domain.
 *
 * @param string $domain Domain
 * @param string $singular Singular string to translate
 * @param string $plural Plural
 * @param integer $count Count
 * @param mixed $args Array with arguments or multiple arguments in function
 * @return plural form of translated string
 * @link http://book.cakephp.org/2.0/en/core-libraries/global-constants-and-functions.html#__dn
 */
function __dn($domain, $singular, $plural, $count, $args = null) {
	if (!$singular) {
		return;
	}
	App::uses('I18n', 'I18n');
	$translated = I18n::translate($singular, $plural, $domain, 6, $count);
	if ($args === null) {
		return $translated;
	} elseif (!is_array($args)) {
		$args = array_slice(func_get_args(), 4);
	}
	return vsprintf($translated, $args);
}

/**
 * Allows you to override the current domain for a single message lookup.
 * It also allows you to specify a category.
 *
 * The category argument allows a specific category of the locale settings to be used for fetching a message.
 * Valid categories are: LC_CTYPE, LC_NUMERIC, LC_TIME, LC_COLLATE, LC_MONETARY, LC_MESSAGES and LC_ALL.
 *
 * Note that the category must be specified with a numeric value, instead of the constant name.  The values are:
 *
 * - LC_ALL       0
 * - LC_COLLATE   1
 * - LC_CTYPE     2
 * - LC_MONETARY  3
 * - LC_NUMERIC   4
 * - LC_TIME      5
 * - LC_MESSAGES  6
 *
 * @param string $domain Domain
 * @param string $msg Message to translate
 * @param integer $category Category
 * @param mixed $args Array with arguments or multiple arguments in function
 * @return translated string
 * @link http://book.cakephp.org/2.0/en/core-libraries/global-constants-and-functions.html#__dc
 */
function __dc($domain, $msg, $category, $args = null) {
	if (!$msg) {
		return;
	}
	App::uses('I18n', 'I18n');
	$translated = I18n::translate($msg, null, $domain, $category);
	if ($args === null) {
		return $translated;
	} elseif (!is_array($args)) {
		$args = array_slice(func_get_args(), 3);
	}
	return vsprintf($translated, $args);
}

/**
 * Allows you to override the current domain for a single plural message lookup.
 * It also allows you to specify a category.
 * Returns correct plural form of message identified by $singular and $plural for count $count
 * from domain $domain.
 *
 * The category argument allows a specific category of the locale settings to be used for fetching a message.
 * Valid categories are: LC_CTYPE, LC_NUMERIC, LC_TIME, LC_COLLATE, LC_MONETARY, LC_MESSAGES and LC_ALL.
 *
 * Note that the category must be specified with a numeric value, instead of the constant name.  The values are:
 *
 * - LC_ALL       0
 * - LC_COLLATE   1
 * - LC_CTYPE     2
 * - LC_MONETARY  3
 * - LC_NUMERIC   4
 * - LC_TIME      5
 * - LC_MESSAGES  6
 *
 * @param string $domain Domain
 * @param string $singular Singular string to translate
 * @param string $plural Plural
 * @param integer $count Count
 * @param integer $category Category
 * @param mixed $args Array with arguments or multiple arguments in function
 * @return plural form of translated string
 * @link http://book.cakephp.org/2.0/en/core-libraries/global-constants-and-functions.html#__dcn
 */
function __dcn($domain, $singular, $plural, $count, $category, $args = null) {
	if (!$singular) {
		return;
	}
	App::uses('I18n', 'I18n');
	$translated = I18n::translate($singular, $plural, $domain, $category, $count);
	if ($args === null) {
		return $translated;
	} elseif (!is_array($args)) {
		$args = array_slice(func_get_args(), 5);
	}
	return vsprintf($translated, $args);
}

/**
 * The category argument allows a specific category of the locale settings to be used for fetching a message.
 * Valid categories are: LC_CTYPE, LC_NUMERIC, LC_TIME, LC_COLLATE, LC_MONETARY, LC_MESSAGES and LC_ALL.
 *
 * Note that the category must be specified with a numeric value, instead of the constant name.  The values are:
 *
 * - LC_ALL       0
 * - LC_COLLATE   1
 * - LC_CTYPE     2
 * - LC_MONETARY  3
 * - LC_NUMERIC   4
 * - LC_TIME      5
 * - LC_MESSAGES  6
 *
 * @param string $msg String to translate
 * @param integer $category Category
 * @param mixed $args Array with arguments or multiple arguments in function
 * @return translated string
 * @link http://book.cakephp.org/2.0/en/core-libraries/global-constants-and-functions.html#__c
 */
function __c($msg, $category, $args = null) {
	if (!$msg) {
		return;
	}
	App::uses('I18n', 'I18n');
	$translated = I18n::translate($msg, null, null, $category);
	if ($args === null) {
		return $translated;
	} elseif (!is_array($args)) {
		$args = array_slice(func_get_args(), 2);
	}
	return vsprintf($translated, $args);
}

/**
 * Shortcut to Log::write.
 *
 * @param string $message Message to write to log
 * @return void
 * @link http://book.cakephp.org/2.0/en/core-libraries/global-constants-and-functions.html#LogError
 */
function LogError($message) {
	App::uses('CakeLog', 'Log');
	$bad = array("\n", "\r", "\t");
	$good = ' ';
	CakeLog::write('error', str_replace($bad, $good, $message));
}

/**
 * Searches include path for files.
 *
 * @param string $file File to look for
 * @return Full path to file if exists, otherwise false
 * @link http://book.cakephp.org/2.0/en/core-libraries/global-constants-and-functions.html#fileExistsInPath
 */
function fileExistsInPath($file) {
	$paths = explode(PATH_SEPARATOR, ini_get('include_path'));
	foreach ($paths as $path) {
		$fullPath = $path . DS . $file;

		if (file_exists($fullPath)) {
			return $fullPath;
		} elseif (file_exists($file)) {
			return $file;
		}
	}
	return false;
}

/**
 * Convert forward slashes to underscores and removes first and last underscores in a string
 *
 * @param string String to convert
 * @return string with underscore remove from start and end of string
 * @link http://book.cakephp.org/2.0/en/core-libraries/global-constants-and-functions.html#convertSlash
 */
function convertSlash($string) {
	$string = trim($string, '/');
	$string = preg_replace('/\/\//', '/', $string);
	$string = str_replace('/', '_', $string);
	return $string;
}

	function mascara($num){
		switch ($num) {
		case $num < 10:
			return "000".$num;
			break;
			
		case $num >=10 && $num < 100:
			return "00".$num;
			break;
		case $num >=100 && $num < 1000:
			return "0".$num;
			break;
		case $num >=1000:
			return $num;
			break;
		}
	}
	
	function codigo($num){
		switch ($num) {
		case 0:
			return "00";
			break;
		case $num < 10:
			return "0".$num;
			break;
			
		default:
			return $num;
			break;
		}
	}
/**
* Funcion que devuelve la fecha al contrario.
* Ejemplo:
* 23/12/1983 devuelve 1983/12/23
* 1986/02/02 devuelve 02/02/1986
*
* @param mixed $fecha fecha a convertir
* @param int $tipo tipo de salida 1 = 23-12-1983
* 
*/
	function turnFecha($fecha=null, $tipo=1){
		if($tipo == 1){
			$fecha_array = explode('-', $fecha);
		}else{
			
			$fecha_array = explode('/', $fecha);
		}
		
		$newFecha = $fecha_array[2]."/".$fecha_array[1]."/".$fecha_array[0];
		//echo $newFecha;
		return $newFecha;
	}

/**
* Funcion que devuelve el mes en letras. 
* Por defecto devuelve el mes actual
* Ejemplo:
* 01 devuelve Enero
*
* @param mixed $mes numero del mes a convertir
*/	
	function mes2letras($mes=null){
		if(is_null($mes)) $mes = date('m');
		switch($mes){
			case 1:
				$mes_letra = "Enero";
				break;
				
			case 2:
				$mes_letra = "Febrero";
				break;
				
			case 3:
				$mes_letra = "Marzo";
				break;
				
			case 4:
				$mes_letra = "Abril";
				break;
				
			case 5:
				$mes_letra = "Mayo";
				break;
				
			case 6:
				$mes_letra = "Junio";
				break;
				
			case 7:
				$mes_letra = "Julio";
				break;
				
			case 8:
				$mes_letra = "Agosto";
				break;
				
			case 9:
				$mes_letra = "Septiembre";
				break;
				
			case 10:
				$mes_letra = "Octubre";
				break;
				
			case 11:
				$mes_letra = "Noviembre";
				break;
				
			case 12:
				$mes_letra = "Diciembre";
				break;
		}
		return $mes_letra;
	
	}

/*!
* @function suma_fechas 
* @abstract suma o resta dias a una fecha
* ejemplo: $f2="30-01-1992";
* $f11=suma_fechas($f1, 25);
*/

	function suma_fechas($fecha,$ndias)
	{
            
 
      if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
            
 
              list($dia,$mes,$anio)=split("/", $fecha);
            
 
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
            
 
              list($dia,$mes,$anio)=split("-",$fecha);
        $nueva = mktime(0,0,0, $mes,$dia,$anio) + $ndias * 24 * 60 * 60;
        $nuevafecha=date("d-m-Y",$nueva);
            
 
      return ($nuevafecha);  
	}
	
	function fecha2letras($fecha=null){
		if(is_null($fecha)) $fecha = date('d/m/Y');
		$fecha_array = explode('/', $fecha);
		$fecha_letras = num2letras($fecha_array[0])." de ".mes2letras($fecha_array[1])." del aÑo ".num2letras($fecha_array[2]);
		
		return up($fecha_letras);
	}
/*!
  @function num2letras ()
  @abstract Dado un n?mero lo devuelve escrito.
  @param $num number - N?mero a convertir.
  @param $fem bool - Forma femenina (true) o no (false).
  @param $dec bool - Con decimales (true) o no (false).
  @result string - Devuelve el n?mero escrito en letra.

*/
function num2letras($num, $fem = false, $dec = true) {
//if (strlen($num) > 14) die("El n?mero introducido es demasiado grande");
   $matuni[2]  = "dos";
   $matuni[3]  = "tres";
   $matuni[4]  = "cuatro";
   $matuni[5]  = "cinco";
   $matuni[6]  = "seis";
   $matuni[7]  = "siete";
   $matuni[8]  = "ocho";
   $matuni[9]  = "nueve";
   $matuni[10] = "diez";
   $matuni[11] = "once";
   $matuni[12] = "doce";
   $matuni[13] = "trece";
   $matuni[14] = "catorce";
   $matuni[15] = "quince";
   $matuni[16] = "dieciseis";
   $matuni[17] = "diecisiete";
   $matuni[18] = "dieciocho";
   $matuni[19] = "diecinueve";
   $matuni[20] = "veinte";
   $matunisub[2] = "dos";
   $matunisub[3] = "tres";
   $matunisub[4] = "cuatro";
   $matunisub[5] = "quin";
   $matunisub[6] = "seis";
   $matunisub[7] = "sete";
   $matunisub[8] = "ocho";
   $matunisub[9] = "nove";

   $matdec[2] = "veint";
   $matdec[3] = "treinta";
   $matdec[4] = "cuarenta";
   $matdec[5] = "cincuenta";
   $matdec[6] = "sesenta";
   $matdec[7] = "setenta";
   $matdec[8] = "ochenta";
   $matdec[9] = "noventa";
   $matsub[3]  = 'mill';
   $matsub[5]  = 'bill';
   $matsub[7]  = 'mill';
   $matsub[9]  = 'trill';
   $matsub[11] = 'mill';
   $matsub[13] = 'bill';
   $matsub[15] = 'mill';
   $matmil[4]  = 'millones';
   $matmil[6]  = 'billones';
   $matmil[7]  = 'de billones';
   $matmil[8]  = 'millones de billones';
   $matmil[10] = 'trillones';
   $matmil[11] = 'de trillones';
   $matmil[12] = 'millones de trillones';
   $matmil[13] = 'de trillones';
   $matmil[14] = 'billones de trillones';
   $matmil[15] = 'de billones de trillones';
   $matmil[16] = 'millones de billones de trillones';

   $num = trim((string)@$num);
   if ($num[0] == '-') {
      $neg = 'menos ';
      $num = substr($num, 1);
   }else
      $neg = '';
   while ($num[0] == '0') $num = substr($num, 1);
   if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num;
   $zeros = true;
   $punt = false;
   $ent = '';
   $fra = '';
   for ($c = 0; $c < strlen($num); $c++) {
      $n = $num[$c];
      if (! (strpos(".,'''", $n) === false)) {
         if ($punt) break;
         else{
            $punt = true;
            continue;
         }

      }elseif (! (strpos('0123456789', $n) === false)) {
         if ($punt) {
            if ($n != '0') $zeros = false;
            $fra .= $n;
         }else

            $ent .= $n;
      }else

         break;

   }
   $ent = '     ' . $ent;
   if ($dec and $fra and ! $zeros) {
      $fin = ' coma';
      for ($n = 0; $n < strlen($fra); $n++) {
         if (($s = $fra[$n]) == '0')
            $fin .= ' cero';
         elseif ($s == '1')
            $fin .= $fem ? ' una' : ' un';
         else
            $fin .= ' ' . $matuni[$s];
      }
   }else
      $fin = '';
   if ((int)$ent === 0) return 'Cero ' . $fin;
   $tex = '';
   $sub = 0;
   $mils = 0;
   $neutro = false;
   while ( ($num = substr($ent, -3)) != '   ') {
      $ent = substr($ent, 0, -3);
      if (++$sub < 3 and $fem) {
         $matuni[1] = 'una';
         $subcent = 'as';
      }else{
         $matuni[1] = $neutro ? 'un' : 'uno';
         $subcent = 'os';
      }
      $t = '';
      $n2 = substr($num, 1);
      if ($n2 == '00') {
      }elseif ($n2 < 21)
         $t = ' ' . $matuni[(int)$n2];
      elseif ($n2 < 30) {
         $n3 = $num[2];
         if ($n3 != 0) $t = 'i' . $matuni[$n3];
         $n2 = $num[1];
         $t = ' ' . $matdec[$n2] . $t;
      }else{
         $n3 = $num[2];
         if ($n3 != 0) $t = ' y ' . $matuni[$n3];
         $n2 = $num[1];
         $t = ' ' . $matdec[$n2] . $t;
      }
      $n = $num[0];
      if ($n == 1) {
         $t = ' ciento' . $t;
      }elseif ($n == 5){
         $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t;
      }elseif ($n != 0){
         $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t;
      }
      if ($sub == 1) {
      }elseif (! isset($matsub[$sub])) {
         if ($num == 1) {
            $t = ' mil';
         }elseif ($num > 1){
            $t .= ' mil';
         }
      }elseif ($num == 1) {
         $t .= ' ' . $matsub[$sub] . '?n';
      }elseif ($num > 1){
         $t .= ' ' . $matsub[$sub] . 'ones';
      }
      if ($num == '000') $mils ++;
      elseif ($mils != 0) {
         if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub];
         $mils = 0;
      }
      $neutro = true;
      $tex = $t . $tex;
   }
   $tex = $neg . substr($tex, 1) . $fin;
   return $tex;
}

	
	function formato($num, $dec = 2){
		return number_format($num,$dec, ',', '.');
	}
	
	function formatoDB($num, $dec = 2){
		$num = str_replace('.', '', $num);
		$num = str_replace(',', '.', $num);
		return $num;
	}
	
	function delTree($dir) {
	    $files = glob( $dir . '*', GLOB_MARK );
	    foreach( $files as $file ){
	        if( substr( $file, -1 ) == '/' )
	            delTree( $file );
	        else
	            unlink( $file );
	    }
	   
	    if (is_dir($dir)) rmdir( $dir );
	   
	}
	
	function show_mensaje($mensaje){
		echo "<div class='message'>".$mensaje."</div>";
		echo "<script type=\"text/javascript\">
			$(document).ready(function() {
				$(\".message\").addClass(\"visible\");
				$(\".message\").slideDown(1500, function(){
					setTimeout(\"$('.message').slideUp(1500);\", 7000);
				});
				
			});
		</script>";
	}
	
	function getExtension($filename){
	    $exts = array(
	        '.jpg' => 'image',
			'.jpeg' => 'image',
	        '.png' => 'image',
			'.gif' => 'image',
			'.tiff' => 'image',
			'.gtiff' => 'map',
			'.map' => 'map',
			'.mp3' => 'music',
			'.wav' => 'music',
			'.ogg' => 'music',
	        '.php' => 'php',
	        '.html' => 'html',
	        '.swf' => 'movie',
			'.wav' => 'movie',
			'.avi' => 'movie',
			'.mov' => 'movie',
	        '.gz' => 'compressed',
	        '.tar' => 'compressed',
			'.rar' => 'compressed',
			'.pdf' => 'pdf',
			'.txt' => 'text',
			'.log' => 'text',
			'.sql' => 'text',
			'.exe' => 'application',
			'.bin' => 'application',
			'.bat' => 'application',
			'.sh' => 'application',
			'.deb' => 'application',
			'.doc' => 'word',
			'.docx' => 'word',
			'.odt' => 'word',
			'.ppt' => 'presentation',
			'.pptx' => 'presentation'
	    );
	    $ext = strrchr(low($filename),'.');
	    if ($exts[$ext]) { return $exts[$ext]; }
	    else { return "unknown"; }
	}
	
	function getDatum($datum_id, &$datums){
		foreach($datums as $datum){
			if($datum['Datum']['id'] == $datum_id){
				return $datum['Datum']['name'];
			}
		}
	}

	function getElipsoide($elipsoide_id, &$elipsoides){
		foreach($elipsoides as $elipsoide){
			if($elipsoide['Elipsoide']['id'] == $elipsoide_id){
				return $elipsoide['Elipsoide']['name'];
			}
		}
	}
	