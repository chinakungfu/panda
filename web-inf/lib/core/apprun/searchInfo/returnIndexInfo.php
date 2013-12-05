<?
require ( "sphinxapi.php" );
require ( "returnRearchId.php" );
function getIndexInfo($host,$port,$keyword,$index)
{
	//$searchWord= $keyword;
	$mode = SPH_MATCH_ALL;
	//$host = "localhost";
	//$port = 3312;
	//$index = "yellowpage";
	$groupby = "";
	$groupsort = "";
	$filter = "";
	$filtervals = array();
	$distinct = "";
	$sortby = "";
	$limit = 20;
	$ranker = SPH_RANK_PROXIMITY_BM25;
	////////////
	// do query
	////////////
	$cl = new SphinxClient ();
	$cl->SetServer ( $host, $port );
	$cl->SetWeights ( array ( 100, 1 ) );
	$cl->SetMatchMode ( $mode );
	if ( count($filtervals) )	$cl->SetFilter ( $filter, $filtervals );
	if ( $groupby )				$cl->SetGroupBy ( $groupby, SPH_GROUPBY_ATTR, $groupsort );
	if ( $sortby )				$cl->SetSortMode ( SPH_SORT_EXTENDED, $sortby );
	if ( $sortexpr )			$cl->SetSortMode ( SPH_SORT_EXPR, $sortexpr );
	if ( $distinct )			$cl->SetGroupDistinct ( $distinct );
	if ( $limit )				$cl->SetLimits ( 0, $limit, ( $limit>1000 ) ? $limit : 1000 );
	$cl->SetRankingMode ( $ranker );
	$cl->SetArrayResult ( true );
	$res = $cl->Query ( $keyword, $index );
	return $res;
}
?>