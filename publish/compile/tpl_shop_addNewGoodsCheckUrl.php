<?php import('core.util.RunFunc'); ?>
<?php
	if($this->_tpl_vars["IN"]["goodsUrl"]){
		$urls= parse_url($this->_tpl_vars["IN"]["goodsUrl"]);
		if(empty($urls['scheme']) || empty($urls['host'])){
			$translate = runFunc("translate",array($this->_tpl_vars["IN"]["goodsUrl"]));
			if($translate){
				$result['status'] = 1;
				$result['keyword'] = $translate;
			}else{
				$result['status'] = -2;
			}
		}else{
			$result['status'] = -3;
		}		
	}else{
		$result['status'] = -1;
	}
	echo json_encode($result);
?>
