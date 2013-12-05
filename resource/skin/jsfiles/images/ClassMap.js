function struct(primaryKey,key, value){
  this.key = key;
  this.primaryKey = primaryKey;
  this.value = value;
}
function setAt(primaryKey,key, value){
  
  for (var i = 0; i < this.map.length; i++)
  {
    if ( this.map[i].key === key)
    {
      this.map[i].value = value;
      return;
    }
  }
  
  this.map[this.map.length] = new struct(primaryKey,key, value);
}
function getByIndex(idx)
{
   var arr=new Array();
      arr[0]=this.map[i].primaryKey; 
      arr[1]=this.map[i].Key; 
      arr[2]=this.map[i].value;           

 
   return arr;  
}
function lookUp(key)
{
  var arr=new Array(); 
  for (var i = 0; i < this.map.length; i++)
  {
    if ( this.map[i].key === key )
    {
      arr[0]=primaryKey; 
      arr[1]=Key; 
      arr[2]=value;
      return arr;
    }
  }
  
  return null;
}

function removeKey(key)
{
  var v;
  for (var i = 0; i < this.map.length; i++)
  {
    v = this.map.pop();
    if ( v.key === key )
      continue;
      
    this.map.unshift(v);
  }
}

function getCount(){
  return this.map.length;
}

function isEmpty(){
  return this.map.length <= 0;
}

function classMap() {
  this.map = new Array();
  this.lookUp = lookUp;
  this.setAt = setAt;
  this.removeKey = removeKey;
  this.getCount = getCount;
  this.isEmpty = isEmpty; 
  this.getByIndex=getByIndex;
}


