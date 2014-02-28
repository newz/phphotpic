<?

if(!defined('PHPHOTPIC'))
exit('Access Denied');


class mysql_database{
	
	var $link = null;
	var $query_return = null;
	
	function connect($data){
		$this->link = @mysql_connect($data[host],$data[user],$data[pass]);
		@mysql_select_db($data[name],$this->link);
		$this->query('SET NAMES \'' . $data[charset] . '\'');
		return $this->link;
	}
	
	function query($query){
		$this->query_return = @mysql_query($query,$this->link) or die(error_report(mysql_error(),'Database Error'));
	}
	
	function fetch(){
		return mysql_fetch_array($this->query_return);
	}
	
	function first($query,$key=''){
		$this->query($query);
		if($return = $this->fetch()){
			if($key)
				$return = $return[$key];
			return $return;
		}
		return 0;

	}
	
	function last_rows() {
		return mysql_affected_rows($this->link);
	}

	function last_id() {
		return mysql_insert_id($this->link);
	}
	
	function num_rows($query) {
		$this->query($query);
		return mysql_num_rows($this->query_return);
	}
	
	function close() {
		return mysql_close($this->link);
	}
	
}

?>