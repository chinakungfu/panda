<?
/**
*把SPHINX搜索返回的数组中的ID放入一个数组中并返回，
**/
function returnRearchId($indexInfoArray)
{
	for($i=0;$i<count($indexInfoArray['matches']);$i++)
	{
		$idArray[$i] = $indexInfoArray['matches'][$i]['id'];
	}
	return $idArray;
}
?>