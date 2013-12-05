<?php

class XMLTag
{
 var $parent;//父节点
 var $child;//子节点
 var $attribute;//节点属性
 var $data;//节点的数据
 var $TagName;//节点名称
 var $depth;//节点的深度
 function XMLTag($tag='')
 {
  $this->attribute = array();
  $this->child = array();
  $this->depth = 0;
  $this->parent = null;
  $this->data = '';
  $this->TagName = $tag;
 }
 function SetTagName($tag)
 {
  $this->TagName = $tag;
 }
 function SetParent(&$parent)
 {
  $this->parent = &$parent;
 }
 function SetAttribute($name,$value)
 {
  $this->attribute[$name] = $value;
 }
 function AppendChild(&$child)
 {
  $i = count($this->child);
  $this->child[$i] = &$child;
 }
 function SetData($data)
 {
  $this->data= $data;
 }
 function GetAttr()
 {
  return $this->attribute;
 }
 function GetProperty($name)
 {
  return $this->attribute[$name];
 }
 function GetData()
 {
  return $this->data;
 }
 function GetParent()
 {
  return $this->parent;
 }
 function GetChild()
 {
  return $this->child;
 }
 function GetChildByName($name)
 {
  $total = count($this->child);
  for($i=0;$i<$total;$i++)
  {
   if($this->child[$i]->attribute['name'] == $name)
   {
    return $this->child[$i];
   }
  }
  return null;
 }
  function GetChildByTagName($name)
 {
  $total = count($this->child);
  for($i=0;$i<$total;$i++)
  {
   if($this->child[$i]->TagName == $name)
   {
    return $this->child[$i];
   }
  }
  return null;
 }

    function GetElementsByTagName($tag)
    {
     $vector = array();
     $tree = &$this;
     $this->_GetElementByTagName($tree,$tag,$vector);
     return $vector;
    }
    function _GetElementByTagName($tree,$tag,&$vector)
    {
     if($tree->TagName == $tag) array_push($vector,$tree);
     $total = count($tree->child);
     for($i = 0; $i < $total;$i++)
      $this->_GetElementByTagName($tree->child[$i],$tag,$vector);
    }
}
