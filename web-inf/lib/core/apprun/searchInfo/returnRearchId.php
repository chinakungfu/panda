<?
/**
*��SPHINX�������ص������е�ID����һ�������в����أ�
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