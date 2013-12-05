<?php import('core.util.RunFunc'); ?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
check_login.tpl
LNMV
);
include($inc_tpl_file);
?>
<?php
	 $addressId = $this->_tpl_vars["addressId"]; 
	 $addressCN1 = $this->_tpl_vars["addressCN1"];
	 $addressCN2 = $this->_tpl_vars["addressCN2"];
	 $country = $this->_tpl_vars["country"];
	 $province = $this->_tpl_vars["province"];
	 $city = $this->_tpl_vars["city"];	 

	 if($addressId && $addressCN1 && $addressCN2 && $country && $province && $city){
		 $dataArray['addressCN1'] = trim($addressCN1);
		 $dataArray['addressCN2'] = trim($addressCN2);
		 $dataArray['countryCN'] = $country;
		 $dataArray['provinceCN'] = $province;
 		 $dataArray['cityCN'] = $city;
		 $result = runFunc("updateAddressCN",array($addressId,$dataArray));			 
	 }else{
		 $result = false;
	}
	return $result;
?>
