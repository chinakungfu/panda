function validatorformat(datavalue,message) 
{ 
	if (datavalue=="") 
	{
		return true;
	}
	else
	{ 
		m = datavalue.match(new	RegExp("^((\\d{4})|(\\d{2}))([-./])(\\d{1,2})\\4(\\d{1,2})$")); 
		if(m ==null ) 
		{ 
			alert(message+"格式错误,正确的格式应该是yyyy.mm.dd"); 
			return false; 
		}
	}	
	return true;	
}