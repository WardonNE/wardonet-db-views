<?php 
namespace app\utils;

class WEStringBuilder {

    protected $value;

	public function __construct($str = '') {
		$this->value = is_string($str) ? $str : strval($str);
	}

	public function __destruct() {
		$this->value = '';
	}

	public function __toString() {
		return $this->toString();
	}

	public function append($s, $offset = null, $len = null) {
		$type = gettype($s);
		switch ($type) {
		case 'boolean':
			$this->appendBool($s);
			break;
		case 'integer':
			$this->appendInt($s);
			break;
		case 'string':
			$this->appendString($s);
			break;
		case 'array':
			$this->appendArray($s, $offset, $len);
			break;
		case 'double':
			$this->appendDouble($s);
			break;
		case 'NULL':
			$this->appendNull($s);
			break;
		case 'resource':
			$this->appendResource($s);
			break;
		case 'object':
			$this->appendObject($s);
			break;
		default:
			$this->appendString($s);
			break;
		}
		return $this;
	}

	private function appendBool($b) {
		$this->value .= $b ? 'true' : 'false';
	}

	private function appendInt($i) {
		$this->value .= $i;
	}

	private function appendString($s) {
		$this->value .= $s;
	}

	private function appendArray($a, $offset, $len) {
		if ($offset === null) {
			$offset = 0;
		}
		if ($len === null) {
			$len = count($a);
		}
		$values = array_values($a);
		for ($i = $offset; $i < $len; $i++) {
			$this->append($values[$i]);
		}
	}

	private function appendDouble($d) {
		$this->value .= $d;
	}

	private function appendNull($n) {
		$this->value .= 'null';
	}

	private function appendResource($r) {
		$this->value .= get_resource_type($r);
	}

	public function appendObject($o) {
		if (is_callable($o)) {
			$this->append(call_user_func($o));
		} elseif ($o instanceof StringBuilder) {
			$this->appendString($o->toString());
		} elseif (method_exists($o, '__toString')) {
			$this->appendString($o);
		} else {
			$this->appendString(get_class($o));
		}
	}

	public function appendChar($c) {
		$this->append(chr($c));
		return $this;
	}

	public function appendCodePoint($c) {
		$builder = new self('{"str":"');
		$json = $builder->append($c)->append('"}')->toString();
		$array = json_decode($json, true);
		$this->append($array['str']);
		return $this;
	}

	public function insert($offset, $s, $soffset = null, $slen = null) {
		$type = gettype($s);
		switch ($type) {
		case 'boolean':
			$this->insertBoolean($offset, $s);
			break;
		case 'integer':
			$this->insertInt($offset, $s);
			break;
		case 'string':
			$this->insertString($offset, $s);
			break;
		case 'array':
			$this->insertArray($offset, $s, $soffset, $slen);
			break;
		case 'double':
			$this->insertDouble($offset, $s);
			break;
		case 'NULL':
			$this->insertNull($offset, $s);
			break;
		case 'resource':
			$this->insertResource($offset, $s);
			break;
		case 'object':
			$this->insertObject($offset, $s);
			break;
		default:
			$this->insertString($offset, $s);
			break;
		}
		return $this;
	}

	private function insertBoolean($offset, $s) {
		$this->value = substr_replace($this->value, $s ? 'true' : 'false', $offset, 0);
	}

	private function insertInt($offset, $i) {
		$this->value = substr_replace($this->value, $i, $offset, 0);
	}

	private function insertString($offset, $s) {
		$this->value = substr_replace($this->value, $s, $offset, 0);
	}

	private function insertArray($offset, $a, $aoffset, $alen) {
		if ($aoffset === null) {
			$aoffset = 0;
		}
		if ($alen === null) {
			$alen = count($a);
		}
		$values = array_values($a);
		for ($i = $aoffset; $i < $alen; $i++) {
			$this->insert($offset, $values[$i], $offset);
			if(is_string($a[$i])){
				$offset += strlen($a[$i]);
			}
		}
	}

	private function insertDouble($offset, $d) {
		$this->value = substr_replace($this->value, $d, $offset, 0);
	}

	private function insertNull($offset, $n) {
		$this->value = substr_replace($this->value, $n, $offset, 0);
	}

	private function insertResource($offset, $r) {
		$this->value = substr_replace($this->value, get_resource_type($r), $offset, 0);
	}

	private function insertObject($offset, $o) {
		if (is_callable($o)) {
			$this->insert($offset, call_user_func($o));
		} elseif ($o instanceof StringBuilder) {
			$this->insertString($offset, $o->toString());
		} elseif (method_exists($o, '__string')) {
			$this->insertString($offset, string($o));
		} else {
			$this->insertString($offset, get_class($o));
		}
	}

	public function insertChar($offset, $c) {
		$this->value = substr_replace($this->value, chr($c), $offset, 0);
		return $this;
	}

	public function insertCodePoint($offset, $c) {
		$builder = new self('{"str":"');
		$json = $builder->append($c)->append('"}')->toString();
		$array = json_decode($json, true);
		$this->insert($offset, $array['str']);
		return $this;
	}

	public function replace($offset, $len, $s, $aoffset = null, $alen = null) {
		$type = gettype($s);
		switch ($type) {
		case 'boolean':
			$this->relpaceBoolean($offset, $len, $s);
			break;
		case 'integer':
			$this->replaceInt($offset, $len, $s);
			break;
		case 'string':
			$this->replaceString($offset, $len, $s);
			break;
		case 'array':
			$this->replaceArray($offset, $len, $s, $aoffset, $alen);
			break;
		case 'double':
			$this->replaceDouble($offset, $len, $s);
			break;
		case 'NULL':
			$this->replaceNull($offset, $len, $s);
			break;
		case 'resource':
			$this->replaceResource($offset, $len, $s);
			break;
		case 'object':
			$this->replaceObject($offset, $len, $s);
			break;
		default:
			$this->replaceString($offset, $len, $s);
			break;
		}
		return $this;
	}

	private function relpaceBoolean($offset, $len, $b) {
		$this->value = substr_replace($this->value, $b ? 'true' : 'false', $offset, $len);
	}

	private function replaceInt($offset, $len, $i) {
		$this->value = substr_replace($this->value, $i, $offset, $len);
	}

	private function replaceString($offset, $len, $s) {
		$this->value = substr_replace($this->value, $s, $offset, $len);
	}

	private function replaceArray($offset, $len, $a, $aoffset, $alen) {
		if ($aoffset === null) {
			$aoffset = 0;
		}
		if ($alen === null) {
			$alen = count($a);
		}
		$values = array_values($a);
		for ($i = $aoffset; $i < $alen; $i++) {
			$this->replace($offset, $len, $values[$i], null, null);
			if(is_string($a[$i])){
				$offset += strlen($a[$i]);
			}
		}
	}

	private function replaceDouble($offset, $len, $d) {
		$this->value = substr_replace($this->value, $d, $offset, $len);
	}

	private function replaceNull($offset, $len, $n) {
		$this->value = substr_replace($this->value, 'null', $offset, $len);
	}

	private function replaceResource($offset, $len, $r) {
		$this->value = substr_replace($this->value, get_resource_type($r), $offset, $len);
	}

	private function replaceObject($offset, $len, $o) {
		if (is_callable($o)) {
			$this->replace($offset, $len, call_user_func($o));
		} elseif ($o instanceof StringBuilder) {
			$this->replaceString($offset, $len, $o->toString());
		} elseif (method_exists($o, '__string')) {
			$this->replaceString($offset, $len, $o);
		} else {
			$this->replaceString($offset, $len, get_class($o));
		}
	}

	public function replaceChar($offset, $len, $c) {
		$this->replace($offset, $len, chr($c));
		return $this;
	}

	public function replaceCodePoint($offset, $len, $c) {
		$builder = new self('{"str":"');
		$json = $builder->append($c)->append('"}')->toString();
		$array = json_decode($json, true);
		$this->replace($offset, $len, $array['str']);
		return $this;
	}

	public function replaceSubString($search, $s) {
		$this->value = str_replace($search, $s, $this->value);
		return $this;
	}

	public function delete($offset, $len) {
		$this->value = substr_replace($this->value, '', $offset, $len);
		return $this;
	}
    /**
     * TODO: FIX Chinese Scrambling Problem
     */
	public function reverse() {
		$this->value = strrev($this->value);
		return $this;
	}

	public function indexOf($sub, $offset = 0) {
		return strpos($this->value, $sub, $offset);
	}

	public function lastIndexOf($sub, $offset = 0) {
		return strrpos($this->value, $sub, $offset);
	}

	public function substring($offset, $len) {
		return substr($this->value, $offset, $len);
	}

	public function equals($s) {
		return $this->value === $s;
	}

	public function contains($s, $ignorecase = false) {
		return $ignorecase?strpos($this->upper($this->value), $s) !== false:strpos($this->value, $s) !== false;
	}

	public function upper() {
		$this->value = strtoupper($this->value);
		return $this;
	}

	public function lower() {
		$this->value = strtolower($this->value);
		return $this;
	}

	public function toString() {
		return $this->value;
	}
}