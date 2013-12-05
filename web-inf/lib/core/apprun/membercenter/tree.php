<?
/*
function nodeTree()
{
	$nodeArray = $GLOBALS['app']['membercenter']['apptreeconfig'];
	//
	foreach ($nodeArray as $key => $val)
	{
		$treeStr .= "<div class=\"dtree\"><script> d = new dTree('d');";
		$treeStr .= "d.add(0,-1,'<b>".$nodeArray[$key]['apptreename']."</b>','','','rightFrame');";
		if(is_array($val['sonnodename']))
		{
			$sonNode = $val['sonnodename'];
			foreach ($sonNode as $key1 => $val1)
			{
				$treeStr .= "d.add(1,0,'<b>".$sonNode[$key1]['sonnodename']."</b>','','','rightFrame');";
				if(is_array($val1['leafnodename']))
				{
					$leafnode = $val1['leafnodename'];
					foreach ($leafnode as $key2 => $val2)
					{
						$treeStr .= "d.add(2,1,'<b>".$leafnode[$key2]['leafnodename']."</b>','".$leafnode[$key2]['leafnodesource']."','','rightFrame');";
					}
				}
			}
		}
		$treeStr .= "</script></div><br>";
	}
	return $treeStr;
}*/

function nodeTree()
{
	$nodeArray = $GLOBALS['app']['membercenter']['apptreeconfig'];
	foreach ($nodeArray as $key => $val)
	{
		$treeStr .= "<div class=\"dtree\">";
		$treeStr .="<ul id='tree'>";
		$treeStr .= "<li>".$nodeArray[$key]['apptreename']."</li>";
		if(is_array($val['sonnodename']))
		{
			$sonNode = $val['sonnodename'];
			$treeStr .="<ul>";
			foreach ($sonNode as $key1 => $val1)
			{
				$treeStr .= "<li>".$sonNode[$key1]['sonnodename']."</li>";
				if(is_array($val1['leafnodename']))
				{
					$leafnode = $val1['leafnodename'];
					$treeStr .="<ul>";
					foreach ($leafnode as $key2 => $val2)
					{
						//print $leafnode[$key2]['leafnodesource'];
						$url = $leafnode[$key2]['urlname']."index.php?action=".$leafnode[$key2]['actionname']."&method=".$leafnode[$key2]['methodname'];
						$treeStr .= "<li onclick=\"rightFrame('".$url."');\" style=\"cursor:   hand\">".$leafnode[$key2]['leafnodename']."</li>";
					}
					$treeStr .= "</ul>";
				}
			}
			$treeStr .= "</ul>";
		}
		$treeStr .= "</ul>";
		$treeStr .= "</div>";
	}
	return $treeStr;
}
?>