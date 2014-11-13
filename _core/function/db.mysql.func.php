<?php
function isConnectedToDB($db)
{
	$conn = mysql_connect($db['host'].':'.$db['port'],$db['user'],$db['pass']);
	$selc = mysql_select_db($db['name'],$conn);
	return $selc ? $conn : false;
}
function db_query($sql,$con)
{
	mysql_query('set names utf8',$con);
	mysql_query('set sql_mode=\'\'',$con);
	return mysql_query($sql,$con);
}
function db_fetch_array($que)
{
	return @mysql_fetch_array($que);
}
function db_fetch_assoc($que)
{
	return mysql_fetch_assoc($que);
}
function db_num_rows($que)
{
	return mysql_num_rows($que);
}
function db_info()
{
	return mysql_get_server_info();
}
function db_error()
{
	return mysql_error();
}
function db_close($conn)
{
	return mysql_close($conn);
}
function db_insert_id($conn)
{
	return mysql_insert_id($conn);
}
//DB-UID데이터 
function getUidData($table,$uid)
{
	return getDbData($table,'uid='.(int)$uid,'*');
}
//DB데이터 1ROW
function getDbData($table,$where,$data)
{
	$row = db_fetch_array(getDbSelect($table,getSqlFilter($where),$data));
	return $row;
}
//DB데이터 ARRAY
function getDbArray($table,$where,$data,$sort,$orderby,$recnum,$p)
{
	global $DB_CONNECT;
	$rcd = db_query('select '.$data.' from '.$table.($where?' where '.getSqlFilter($where):'').' order by '.$sort.' '.$orderby.($recnum?' limit '.(($p-1)*$recnum).', '.$recnum:''),$DB_CONNECT);
	return $rcd;
}
//DB데이터 NUM
function getDbRows($table,$where)
{
	global $DB_CONNECT;
	$rows = db_fetch_array(db_query('select count(*) from '.$table.($where?' where '.getSqlFilter($where):''),$DB_CONNECT));
	return $rows[0] ? $rows[0] : 0;
}
//DB데이터 MAX
function getDbCnt($table,$type,$where)
{
	global $DB_CONNECT;
	$cnts = db_fetch_array(db_query('select '.$type.' from '.$table.($where?' where '.getSqlFilter($where):''),$DB_CONNECT));
	return $cnts[0] ? $cnts[0] : 0;
}
//DB셀렉트
function getDbSelect($table,$where,$data)
{
	global $DB_CONNECT;
	$r = db_query('select '.$data.' from '.$table.($where?' where '.getSqlFilter($where):''),$DB_CONNECT);
	return $r;
}
//DB삽입
function getDbInsert($table,$key,$val)
{
	global $DB_CONNECT;
	db_query("insert into ".$table." (".$key.")values(".$val.")",$DB_CONNECT);
}
//DB업데이트
function getDbUpdate($table,$set,$where)
{
	global $DB_CONNECT;
	db_query("update ".$table." set ".$set.($where?' where '.getSqlFilter($where):''),$DB_CONNECT);
}
//DB삭제
function getDbDelete($table,$where)
{
	global $DB_CONNECT;
	db_query("delete from ".$table.($where?' where '.getSqlFilter($where):''),$DB_CONNECT);
}
//SQL필터링
function getSqlFilter($sql)
{
	return preg_replace("( union| update| insert| delete| drop|\/\*|\*\/|\\\|\;)",'',$sql);
}
?>