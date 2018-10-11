<?php
class Tools {
	private static $_instance;
	private static $temp_var = '';

	public static function qr($value, $size, $margin) {
		if(empty($value)) {
			return '';
		}

		if(empty($size)) {
			$matrixPointSize = "4"; 
		} else {
			$matrixPointSize = $size;
		}

		ob_start();
		QRcode::png($value, false, "L", $matrixPointSize, $margin);
		$ret = ob_get_clean();

		return $ret;
	}

	# explode的加强版
	function explode($con = '', $token = ',') {
		return !is_string($con) || empty($con) || !strlen($token)
			? array()
			: array_unique(array_filter(explode($token, $con)));
	}

	function implode($array, $tag = ',', $ring = "'") {
		$ret = array();
		foreach($array as $v) {
			$ret[] = $ring . $v . $ring;
		}
		return implode($tag, $ret);
	}

	public static function getInstance() {
        if(!(self::$_instance instanceof self)) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

	/**
	 * 根据needs数组中的数据,返回array中对应的数据
	 * @param  [type] $array [description]
	 * @param  [type] $needs [description]
	 * @return [type]        [description]
	 */
	function arrayNeedsBack($array, $needs) {
		if(empty($array) && !is_array(reset($array))) {
			return array();
		}

		$ret = array();
		foreach($array as $k => $v) {
			$temp = array();	
			foreach($needs as $v1) {
				$temp[$v1] = $v[$v1];
			}
			$ret[$k] = $temp;
		}

		return $ret;
	}

	/**
	 * 数组排序
	 * @param  [type] $arr  [description]
	 * @param  [type] $keys [description]
	 * @param  string $type [description]
	 * @return [type]       [description]
	 */
	function sortArray($arr, $keys, $type='desc') {
        $keysvalue = $new_array = array();
        foreach ($arr as $k=>$v){
            $keysvalue[$k] = $v[$keys];
        }
        if($type == 'asc'){
            asort($keysvalue);
        }else{
            arsort($keysvalue);
        }
        reset($keysvalue);
        foreach ($keysvalue as $k=>$v){
            $new_array[$k] = $arr[$k];
        }
        return $new_array;
	}

	/**
	 * 统计数组中某项不同值出现的次数
	 * @param  [type] $array 需要
	 * @param  [type] $key   [description]
	 * @return [type]        [description]
	 */
	function arrayDiffValCountNum($array, $key) {
		if(empty($array) || empty($key)) {
			return 0;
		}

		$temp = array();
		foreach($array as $v) {
			$temp[$v[$key]] = 1;
		}

		return count($temp);
	}

	function stripslashes_ar($info) {
		if(empty($info) || !is_array($info)) {
			return $info;
		}

		foreach ($info as $k => $v) {
			$v = stripslashes($v);
			$info[$k] = $v;
		}
		
		return $info;
	}

	function arStrShow($info, $in_ar = array(), $out_ar = array()) {
		if(empty($info) || !is_array($info)) { return ''; }

		$ret = '';	
		if(!empty($out_ar) && !empty($in_ar)) {
			foreach($info as $k => $v) {
				if(in_array($k, array_diff($in_ar, $out_ar))) {
					$ret .= "[{$k}:{$v}]";
				}
			}
		} elseif(!empty($out_ar)) {
			foreach($info as $k => $v) {
				if(in_array($k, $out_ar)) { continue; }
				$ret .= "[{$k}:{$v}]";
			}
		} elseif(!empty($in_ar)) {
			foreach($info as $k => $v) {
				if(in_array($k, $in_ar)) {
					$ret .= "[{$k}:{$v}]";
				}
			}
		} else {
			foreach($info as $k => $v) {
				$ret .= "[{$k}:{$v}]";
			}
		}

		return $ret;
	}

	# 打印数组信息
	function print_ar($info, $type='')
    {
        if(!is_array($info) || empty($info)) {
            return false;
        }

        $title = array_keys($info['0']);

        // 定义首行
        $ret = '<table class="table table-striped table-hover"><tbody>';
        $ret .= '<tr>';
        foreach($title as $tcol) {
            $ret .= "<td>{$tcol}</td>";
        }
        $ret .= '</tr>';

        // 添加内容
        foreach($info as $row) {
            $ret .= '<tr>';
            foreach($row as $col) {
                if(empty($col)) {
                    $col = '-';
                }
                $ret .= "<td>{$col}</td>";
            }
            $ret .= '</tr>';
        }
        $ret .= '</tbody></table>';

        return $ret;
    }

    function err($msg) {
		return array(
			'error' => 1,
			'msg' => $msg,
		);
	}

	function ret($msg) {
		return array(
			'error' => 0,
			'msg'   => $msg,
		);
	}

	function jerr($msg, $is_end = true) {
		$ret = json_encode(array(
			'error' => 1,
			'msg'   => $msg,
		));

		if($is_end) {
			die($ret);
		}

		return $ret;
	}

	function jret($msg, $is_end = true) {
		$ret = json_encode(array(
			'error' => 0,
			'msg'   => $msg,
		));

		if($is_end) {
			die($ret);
		}

		return $ret;
	}

	# 返回一条BUG跟踪信息
	function BugTrace($args) {
		$ret = debug_backtrace();

		krsort($ret, SORT_NUMERIC);

		$info = array();
		foreach($ret as $v) {
			$info[] = end(explode('\\', $v['file'])) . '::' . $v['class'] . $v['type'] . $v['function'] . "[{$v['line']}]";;
		}

		return implode(', ', $info);
	}

	function trace($key = '') {
		$trace_info = debug_backtrace();

		return strlen($key) ? $trace_info[$key] : $trace_info;
	}

	function memSetStart() {
		if($_REQUEST['debug'] != 'pgI3YfjUbNymp4XSgCgBdsJaAcqFLUND') {
			return;	
		}

		if(!function_exists('memory_get_usage') || !function_exists('memory_get_peak_usage')) {
			return;
		}

		self::$temp_var = memory_get_usage();
	}

	function memSetEnd() {
		if($_REQUEST['debug'] != 'pgI3YfjUbNymp4XSgCgBdsJaAcqFLUND') {
			return;	
		}

		if(!function_exists('memory_get_usage') || !function_exists('memory_get_peak_usage')) {
			return;
		}

		$start = self::$temp_var;
		$end = memory_get_usage();
		$max = memory_get_peak_usage();

		echo '<hr />';

		echo self::print_ar(array(
			array(
				'开始使用' => round(($start / 1024 / 1024), 2) . 'MB',
				'结束使用' => round(($end / 1024 / 1024), 2) . 'MB',
				'最大使用' => round(($max / 1024 / 1024), 2) . 'MB',
			),
			array(
				'开始使用' => $start . 'B',
				'结束使用' => $end . 'B',
				'最大使用' => $max . 'B',
			),
		));

		echo '<hr />';
	}

	function sys_msg($msg) {
		$smarty = $GLOBALS['smarty'];
		$smarty->assign('msg', $msg);
		$smarty->display('sysmsg.htm');
		exit;
	}

	function headerFile($file_name) {
        header("Content-Transfer-Encoding: binary");
        header("Cache-Control: public");
        header("Cache-Control: maxage=3600"); 
        header("Pragma: public");
        header('Expires: 0');
        header("Content-type: application/txt;charset=GBK");
        header("Content-Disposition: attachment; filename={$file_name}");
    }

    function msg($msg_detail, $links) {

		$ret = '';
		if(empty($links)) {
			$ret .= '<script language="javascript"> window.setTimeout(function(){javascript:history.go(-1); }, 300000); </script>';
			$data = array(
				array(
					'NOTE' => "<a href='javascript:history.go(-1);' >$msg_detail</a>", 
				),
				array(
					'NOTE' => '300秒后自动跳转!', 
				),
			);
			$ret .= self::print_ar($data);
			die($ret);
		}

		$ret .= '<script language="javascript"> window.setTimeout(function(){ window.location= "' . $links['0']['href'] . '"; }, 300000); </script>';
		$data = array(
			array(
				'NOTE' => $msg_detail, 
			),
		);
		foreach($links as $v) {
			$data[] = array(
				'NOTE' => "<span style='color:red;'>链接:</span><a target='_self' href='{$v['href']}'>{$v['text']}</a>", 
			);
		}
		$data[] = array(
			'NOTE' => '300秒后自动跳转!', 
		);
		$ret .= self::print_ar($data);
		die($ret);
	}

    /**
     * 调用规则核心函数
     * @param  [str]   $alias_name  [规则的别名]
     * @param  [array] $param       [传递给规则的名称]
     * @param  integer $needAll     [规则的need_all]
     * @param  integer $time        [最长链接时长]
     * @return [type]               [msg]
     */
	function callRule($alias_name, $param = array(), $needAll = 1, $time = 30) {
	    $serviceName = self::getRuleName($alias_name);
	    $serviceName = $serviceName ? $serviceName : $alias_name;

	    $data = array(
	        'serviceName' => $serviceName,
	        'param'       => empty($param) && !is_object($param) ? (object) $param : $param,
	        'needAll'     => (int) $needAll,
        );

	    $result = self::callUrl(RULE_ENGINE_URL, $time, $data, true, true);

	    return self::ret($result['rows']);
	}

	/**
     * 调用规则核心函数
     * @param  [str]   $serviceName  [规则名]
     * @param  [array] $param       [传递给规则的名称]
     * @param  integer $needAll     [规则的need_all]
     * @param  integer $time        [最长链接时长]
     * @return [type]               [msg]
     */
	function callRule45($serviceName, $param = array(), $needAll = 1, $time = 30) {

	    $data = array(
	        'serviceName' => $serviceName,
	        'param'       => empty($param) && !is_object($param) ? (object) $param : $param,
	        'needAll'     => (int) $needAll,
        );

	    $result = self::callUrl('http://192.168.0.45:3030/service', $time, $data, true, true);

	    return self::ret($result['rows']);
	}

	public function callUrlMethod($method, $url, $data = array(), $time = 300, $json = true) {
        $url .= strtolower($method) == 'get' ? '?' . http_build_query($data) : '';
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_HEADER, 0);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, TRUE);

        $data_ori = $data;
        if(strtolower($method) == 'post'){
            if($json){
                // curl_setopt($this->curl, CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
                // $data = json_encode($data);
            }else{
                $data = http_build_query($data);
                if(!$data) {
                    $data = $data_ori;
                }
            }
            curl_setopt($this->curl, CURLOPT_POST, 1);
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
        } else {
            curl_setopt($this->curl, CURLOPT_POST, 0);
        }
        curl_setopt($this->curl, CURLOPT_NOBODY, FALSE);
        curl_setopt($this->curl, CURLOPT_TIMEOUT, $time);
        $result = curl_exec($this->curl);

        return $json ? json_decode($result, true) : $result; 
    }

    function callUrlByConfig($url, $data, $config) {
    	$curl = new TCurl($url, $config, $data);
        $result = $curl->execOne();
        return array(
            'url'       => $url,
            'result'    => $result,
            'http_code' => $curl->result['info']['http_code'],
            'time_cost' => $curl->result['info']['total_time'],
        );
    }

	function callUrl($url, $time = 60, $data = array(), $json = false, $for_result = false) 
    {
        $postData = $json ? json_encode($data) : http_build_query($data);
        $curl = new TCurl($url, array(
			'timeOut'    => $time,
        ), $postData);
        $result = $curl->execOne();

        if($for_result) {
        	$back_json = json_decode($result, true);
        	return $back_json ? $back_json : $result;
        }

        return array(
            'url'       => $url,
            'result'    => $result,
            'http_code' => $curl->result['info']['http_code'],
            'time_cost' => $curl->result['info']['total_time'],
        );
    }

	function getRuleName($rule_name) {
		if(empty($rule_name)) {
			return '';
		}

		$ret = self::callUrl(RULE_ENGINE_URL, 30, array(
			'serviceName' => 'BUV1_RuleConfig',
	        'param'       => array(
	        	'alias_name' => $rule_name,
	        ),
	        'needAll'     => 1,
		), true, true);

		if($ret['code'] != 0) {
			return '';
		}

		return $ret['rows']['0']['name'];
	}

	function writeToSmatyCacheTempFile($file_name, $con) {
		if(empty($file_name)) {
			return false;
		}
		
		$filename = SMARTY_TEMPLATES_C_DIR . $file_name;
		$handle   = fopen($filename, 'w+');
		$con      = $con;
        fwrite($handle, $con);
        fclose($handle);

        return true;
	}

	/**
	 * 写入信息到文本文件里面以保存
	 * @param  [type] $name [description]
	 * @param  [type] $con  [description]
	 * @return [type]       [description]
	 */
	function wfd($name, $con) {
		$handle = fopen('../Data/TagData/' . $name, 'w');
        $ret = fwrite($handle, $con);
        fclose($handle);
        return $ret;
	}

	/**
	 * 读取相关名字
	 * @param  [type] $name [description]
	 * @return [type]       [description]
	 */
	function rfd($name) {
		return file_get_contents('../Data/TagData/' . $name);
	}

	function getCookieStr() {
        $ret = array();
        foreach($_COOKIE as $key => $val) {
            $ret[] = "{$key}={$val}";
        }
        return implode('; ', $ret);
    }

    function delRuleCache($rule_name) {
		if(empty($rule_name)) {
			return true;
		}
		$url = self::getDBVariableFromRule('delRuleCache');
		$ret = Tools::callUrl($url, 30, array(
			"path" => "/rengine/remove_cache",
			"content" => json_encode(array(
				"serviceName" => $rule_name,
			)),
		), true, true);

		return is_array($ret) 
			&& $ret['code'] == 0 
			&& $ret['description'] == 'Succeed' 
			? true : false;
	}

	/**
	 * 通过规则返回系统变量
	 * @param  array  $info [description]
	 * @return [type]       [description]
	 */
	function getDBVariableFromRule($info = array())
	{
	    if(empty($info)) {
	        return false;
	    }

		$config_info = self::callUrl(RULE_ENGINE_URL, 30, array(
			'serviceName' => 'Order_BUV1_variabletable',
	        'param'       => array(
	        	'var_name_str' => (string) is_array($info) ? "'" . implode("','", $info) . "'" : "'{$info}'",
	        ),
	        'needAll'     => 1,
		), true, true);

	    if(!empty($config_info['code'])) {
	        return false;
	    }

	    if(!is_array($info)) {
	        return $config_info['rows']['0']['var_value'];
	    }

	    $ret = array();
	    foreach($config_info['rows'] as $v) {
	        $ret[$v['var_name']] = $v['var_value'];
	    }

	    return $ret;
	}

	function sockUrl($url, $time = 60, $data = array(), $json = false, $for_result = false, $port = 80) {
		
		# 处理url	
		$matches = parse_url($url);
        !isset ($matches['host']) && $matches['host'] = '';
        !isset ($matches['path']) && $matches['path'] = '';
        !isset ($matches['query']) && $matches['query'] = '';
        !isset ($matches['port']) && $matches['port'] = '';

		$host     = $matches['host'];
		$path     = $matches['path'] 
			? $matches['path'] . ($matches['query'] 
				? '?' . $matches['query'] 
				: '') 
			: '/';
		$port     = !empty ($matches['port']) 
			? $matches['port'] 
			: 80;
		$scheme   = $matches['scheme'] 
			? $matches['scheme'] 
			: 'http';

		$method      = empty($data) ? 'GET' : 'POST';
		$postData    = http_build_query($data);
		$postDataLen = strlen($postData);
		$cookSrt     = self::getCookieStr();

		# 生成头部信息
        $head = "$method $path HTTP/1.1\r\n";
        $head .= "Host: $host\r\n";
        $head .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $head .= "Content-Length: {$postDataLen}\r\n";
        $head .= "Cookie: {$cookSrt}\r\n";
        
		$errno  = '';
		$errstr = '';
        $fp = fsockopen($host, $port, $errno, $errstr, $time);
        if(!$fp) {
        	return '';
        }

        stream_set_blocking($fp, true);
        stream_set_timeout($fp, $this->timeout);
        // 写数据
        fwrite($fp, $reqstring);
        $status = stream_get_meta_data($fp);

        // 超时直接返回数据
        if ($status['timed_out']) { 
        	return '';
        }

        // 下面的循环用来读取响应头部
        while (!feof($fp)) {
            $h = fgets($fp);
            if ($h && ($h == "\r\n" || $h == "\n"))
                break;
            $pos = strpos($h, ':');
            if ($pos) {
                $k = strtolower(trim(substr($h, 0, $pos)));
                $v = trim(substr($h, $pos +1));

                if ($k == 'set-cookie') {
                    // 更新Cookie
                    if ($this->keepcontext) {
                        $this->context->addCookie(new SinCookie($v));
                    }
                } else {
                    // 添加到头里面去
                    $this->response->setHeader($k, $v);
                }
            } else {
                // 第一行数据
                // 解析响应状态
                $preg = '/^(\S*) (\S*) (.*)$/';
                preg_match_all($preg, $h, $arr);
                isset ($arr[1][0]) & $this->response->scheme = trim($arr[1][0]);
                isset ($arr[2][0]) & $this->response->stasus = trim($arr[2][0]);
                isset ($arr[3][0]) & $this->response->code = trim($arr[3][0]);
            }
        }
        // 获取响应正文长度
        $len = (int) $this->response->header['content-length'];
        $res = '';
        // 下面的循环读取正文
        while (!feof($fp) && $len > 0) {
            $c = fread($fp, $len);
            $res .= $c;
            $len -= strlen($c);
        }
        $this->response->body = $res;
	    // 关闭Socket
	    fclose($fp);
	    // 把返回保存到上下文维持中
	    $this->context->refrer = $url;
	}

	function getArrayBack($info) 
	{
		$ret = array();

		$tmp_info = explode("\n", $info);
		foreach($tmp_info as $k => $v) {
			// $v = str_replace(array("\t", "\n", "\r"), '', $v);
			$v = trim($v, "\t\n\r ");
			if(!empty($v)) {
				$ret[$k] = $v;
			}
		}

		return $ret;
	}

	function mysql_escape_string_self(&$info) {
        $info = mysql_escape_string($info);
    }

    function stripslashes_self(&$info) {
        $info = addslashes($info);
    }

    /**
     * 将$str传入的字符串属于$array数组里面的值的都替换成$split的字符串
     * @param  [type] $str  [description]
     * @param  [type] $array [description]
     * @param  [type] $split [description]
     * @return [type]        [description]
     */
    function filterPostData($str, $array, $split) {
    	if(empty($str)) {
    		return '';
    	}

    	return str_replace($array, $split, trim($str));	
    }

    /**
     * 根据所给的提示来获取数据的分组
     * @param  [type] $info  [description]
     * @param  string $split [description]
     * @return [type]        [description]
     */
    function get_array_back($info, $split = "\n") {
        $ret = array();

        $tmp_info = explode("\n", $info);
        foreach($tmp_info as $k => $v) {
            // $v = str_replace(array("\t", "\n", "\r"), '', $v);
            $v = trim($v, "\t\n\r");
            if(!empty($v)) {
                $ret[$k] = $v;
            }
        }

        return $ret;
    }

    /**
     * 通过开始时间结束时间来返回中间间隔的天数
     * @param  [type] $start [description]
     * @param  [type] $end   [description]
     * @param  [type] $include_equal   [是否包括等于]
     * @return [type]        [description]
     */
    function getDaysByStartEnd($start, $end, $include_equal = true) {
    	v($start, $end, $include_equal);
    }

}