<?php
/**
 * xml文档的解析类
 */
import('core.xml.XMLTag');
class XMLDoc
{
	var $parser;//xml解析指针
	var $XMLTree;//生成的xml树
	var $XMLFile;//要解析的xml文件
	var $XMLData;//将要解析的xml文档信息
	var $error;//错误信息
	var $NowTag;//当前指向的节点
	var $TreeData;//遍历生成xml树得到的数据
	var $MaxDepth;//xml文档节点的深度
	var $encode;//xml文档的编码方式
	var $chs;//字典转换
	function XMLDoc()
	{
		//
		$this->parser = xml_parser_create();
		xml_parser_set_option($this->parser,XML_OPTION_CASE_FOLDING,0);
		xml_set_object($this->parser,$this);
		xml_set_element_handler($this->parser,'_StartElement','_EndElement');
		xml_set_character_data_handler($this->parser,'_CData');
		$this->stack = array();
		$this->XMLTree = null;
		$this->NowTag = null;
		$this->MaxDepth = 0;
	}
	function LoadFromFile($file)
	{
		$this->XMLFile = fopen($file,'r');
		if(!$this->XMLFile)
		{
			$this->error = 'can not open file';
			return false;
		}
		$this->XMLData = '';
		$this->TreeData = '';
		return true;
	}
	function SetXMLData($data)
	{
		if($this->XMLFile) fclose($this->XMLFile);
		$this->XMLData = $data;
		$this->TreeData = '';
	}
	//给树添加一个新的节点
	function AppendChild(&$child)
	{
		if($this->XMLTree == null)
		{
			$child->depth = 1;
			$this->XMLTree = &$child;
			$this->NowTag = &$this->XMLTree;
		}
		else
		{
			$i = count($this->NowTag->child);
			$this->NowTag->child[$i] = &$child;
			$child->parent = &$this->NowTag;
			$child->depth = $this->NowTag->depth+1;
			unset($this->NowTag);
			$this->NowTag = &$child;
		}
		$this->MaxDepth = ($this->MaxDepth < $this->NowTag->depth)?$this->NowTag->depth:$this->MaxDepth;
	}

	//创建一个新的节点
	function &CreateElement($tag)
	{
		$element = new XMLTag($tag);
		return $element;
	}
	function _StartElement($parser,$element,$attribute)
	{

		$tag = new XMLTag();
		$tag->TagName = $element;
		$tag->attribute = $attribute;
		if($this->XMLTree == null)
		{
			$tag->parent = null;
			$tag->depth = 1;
			$this->XMLTree = &$tag;
			$this->NowTag = &$tag;
		}
		else
		{
			$i = count($this->NowTag->child);
			$this->NowTag->child[$i] = &$tag;
			$tag->parent = &$this->NowTag;
			$tag->depth = $this->NowTag->depth+1;
			unset($this->NowTag);
			$this->NowTag = &$tag;
		}
		$this->MaxDepth = ($this->MaxDepth < $this->NowTag->depth)?$this->NowTag->depth:$this->MaxDepth;
	}
	function _CData($paraser,$data)
	{
		$this->NowTag->data = $data;
	}
	function _EndElement($parser,$element)
	{
				

		$parent = &$this->NowTag->parent;

		unset($this->NowTag);
		$this->NowTag = &$parent;
	}
	//解析xml文档方法
	function parse()
	{
		if($this->XMLFile)
		{
			$this->XMLData = '';
			while(!feof($this->XMLFile))
			{
				$this->XMLData .= fread($this->XMLFile,4096);
			}
		}
		fclose($this->XMLFile);
		if($this->XMLData)
		{
			//$this->JudgeEncode();
			if (!xml_parse($this->parser, $this->XMLData))
			{
				$code = xml_get_error_code($this->parser);
				$col = xml_get_current_column_number($this->parser);
				$line = xml_get_current_line_number($this->parser);
				$this->error = "XML error: $col at line $line:".xml_error_string($code);
				return false;
			}
		}
		xml_parser_free($this->parser);
		return true;
	}
	//确定编码方式
	function JudgeEncode()
	{
		$start = strpos($this->XMLData,'<?xml');
		$end = strpos($this->XMLData,'>');
		$str = substr($this->XMLData,$start,$end-$start);
		$pos = strpos($str,'encoding');
		if($pos !== false)
		{
			$str = substr($str,$pos);
			$pos = strpos($str,'=');
			$str = substr($str,$pos+1);
			$pos = 0;
			while(empty($str[$pos])) $pos++;
			$this->encode = '';
			while(!empty($str[$pos]) && $str[$pos] != '?')
			{
				if($str[$pos] != '"' && $str[$pos] != "'")
				$this->encode .= $str[$pos];
				$pos++;
			}
		}
		$this->chs = new Chinese('UTF-8',$this->encode);
	}

	//根据节点名称修改某个节点的值
	function ChangeValueByName($name,$name,$value)
	{
		return $this->_ChangeValueByName($this->XMLTree,$name,$value);
	}
	function _ChangeValueByName($tree,$name,$value)
	{
		if(is_array($tree->attribute))
		{
			while (list($k,$v) = each($tree->attribute))
			{
				if($k = 'name' && $v = $name)
				{
					$tree->data = $value;
					return true;
				}
			}
		}
		$total = count($tree->child);
		for($i = 0;$i<$total;$i++)
		{
			$result = $this->_ChangeValueByName($tree->child[$i],$name,$value);
			if($result == true) break;
		}
		return $result;
	}

	//根据名称来修改xml的属性
	function ChangeAttrByName($name,$attr,$value)
	{
		return $this->_ChangeAttrByName($this->XMLTree,$name,$attr,$value);
	}
	function _ChangeAttrByName(&$tree,$name,$attr,$value)
	{
		if(is_array($tree->attribute))
		{
			while(list($k,$v) = each($tree->atttibute))
			{
				if($k == 'name' && $v == $name)
				{
					$tree->attribute[$attr] = $value;
					return true;
				}
			}
		}
		$total = count($tree->child);
		for($i = 0;$i<$total;$i++)
		{
			$result = $this->_ChangeAttrByName($tree->child[$i],$name,$attr,$value);
			if($result == true) break;
		}
		return $result;
	}
	////获取根节点
	function GetDocumentElement()
	{
		return $this->XMLTree;
	}
	//遍历生成的xml树,重新生成xml文档
	function WalkTree()
	{
		$this->TreeData = '';
		$this->_WalkTree($this->XMLTree);
		return $this->TreeData;
	}
	//递归遍历
	function _WalkTree($tree)
	{
		$this->TreeData .= '<'.$tree->TagName.' ';
		if(is_array($tree->attribute))
		{
			while(list($key,$value) = each($tree->attribute))
			{
				$this->TreeData .="$key=\"$value\" ";
			}
		}
		$this->TreeData .= '>'.$tree->data;
		$total = count($tree->child);
		for($i=0;$i<$total;$i++)
		{
			$this->_WalkTree($tree->child[$i]);
		}
		$this->TreeData .= '</'.$tree->TagName.">\n";
	}
	//获取错误信息
	function GetError()
	{
		return $this->error;
	}
	//获取树的最大深度
	function GetMaxDepth()
	{
		return $this->MaxDepth;
	}
	///将xml树写入xml文件
	function WriteToFile($file,$head='')
	{
		$fp = fopen($file,'w');
		if(!$fp)
		{
			$this->error = '无法打开写入文件';
			return false;
		}
		if(empty($this->TreeData)) $this->WalkTree();
		$head = empty($head)?'<?xml version="1.0" standalone="yes" encoding="gb2312"?>':$head;
		fwrite($fp,$head);
		fwrite($fp,$this->TreeData);
		fclose($fp);
		return true;
	}
}
?>
