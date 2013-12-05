<?php

/**
 * @author xydream@gmail.com
 * @copyright 2012
 */

//$test = getGoodInfo('http://detail.tmall.com/item.htm?spm=110492Kl.2-ay*vz.v-5wmlEP&id=13317869214');
//print_r($test);


function getGoodInfo($url)
{
    $good = new goods($url);
    $info = $good->getResult();
    if (!$info) {
        return $good->getError();
    }
    return $info;
}


/**
 * 该类实现商品信息的采集
 */
class goods
{
    /**
     * 网页HTML源文件
     */
    private $html;
    /**
     * 解析后得到的数据信息
     */
    private $data;
    /**
     * 需要采集的URL
     */
    private $url;
    /**
     * 允许采集的站点列表
     */
    private $siteList;
    /**
     * 最后一次出现的错误
     */
    private $lastError;

    public function __construct($url = '')
    {
        $this->siteList = array('taobao' => 'taobao.com', 'tmall' => 'tmall.com');
        $this->url = $url;
    }

    /**
     * 获取结果
     * 返回false:抓取失败 -1:商品已下架 array:商品信息
     */
    public function getResult()
    {
        if (!in_array($this->getMainDomain($this->url), $this->siteList)) {
            $this->lastError = '您输入的URL暂无法采集，你核对URL！';
            return false;
        }
        $this->html = $this->getContents($this->url);
        if (!$this->html) {
            $this->lastError = '没有获取到网页内容或网页内容过少！';
            return false;
        }
        $fun = array_pop(array_keys($this->siteList, $this->getMainDomain($this->url)));
        return $this->$fun($this->html);
    }

    /**
     * 淘宝商品信息解析
     */
    private function taobao($html)
    {
        if (preg_match("/点此查看最新宝贝详情/Ui", $html, $matches)) { //已下架商品判断
            return '-1';
        }
        if (preg_match("/<title>(.*)<\/title>/Ui", $html, $matches)) { //获取商品名称
            $this->data['title'] = str_replace('-淘宝网', '', $matches[1]);
        } else {
            $this->data['title'] = '商品名称获取失败，请联系作者进行程序升级！';
        }
        if (preg_match("/id=(\'|\")?J_StrPrice(\'|\")?(.*)?>(.*)<\/strong>/Ui", $html, $matches)) { //获取商品价格
            $this->data['price'] = trim($matches[4]);
        } else {
            $this->data['price'] = '商品价格获取失败，请联系作者进行程序升级！';
        }
        if (preg_match("/所在地区(.*)30天售出/Usi", $html, $matches)) { //获取商品运费
            if (preg_match("/卖家承担运费/Ui", $matches[1], $matches1)) { //判断是否为卖家承担运费
                $this->data['postage'] = 0;
            } else {
                if (preg_match("/快递:(.*)?元/Ui", $matches[1], $matches1)) { //判断是否为卖家承担运费
                    $this->data['postage'] = $matches1[1];
                } else {
                    $this->data['postage'] = '商品运费获取失败，请联系作者进行程序升级！';
                }
            }
        } else {
            $this->data['postage'] = '商品运费获取失败，请联系作者进行程序升级！';
        }
        return $this->data;
    }

    /**
     * 天猫商品信息解析
     */
    private function tmall($html)
    {
        if (preg_match("/点此查看最新宝贝详情/Ui", $html, $matches)) { //已下架商品判断
            return '-1';
        }
        if (preg_match("/<title>(.*)<\/title>/Ui", $html, $matches)) { //获取商品名称
            $this->data['title'] = str_replace('-tmall.com天猫', '', $matches[1]);
        } else {
            $this->data['title'] = '商品名称获取失败，请联系作者进行程序升级！';
        }
        if (preg_match("/id=(\'|\")?J_StrPrice(\'|\")?(.*)?>(.*)<\//Ui", $html, $matches)) { //获取商品价格
            $this->data['price'] = trim($matches[4]);
        } else {
            $this->data['price'] = '商品价格获取失败，请联系作者进行程序升级！';
        }
        if (preg_match("/价　　格(.*)月 销 量/Usi", $html, $matches)) { //获取商品运费
            if (preg_match("/卖家承担运费/Ui", $matches[1], $matches1)) { //判断是否为卖家承担运费
                $this->data['postage'] = 0;
            } else {
                if (preg_match("/快递:(.*)?元/Ui", $matches[1], $matches1)) { //判断是否为卖家承担运费
                    $this->data['postage'] = $matches1[1];
                } else {
                    $this->data['postage'] = '商品运费获取失败，请联系作者进行程序升级！';
                }
            }
        } else {
            $this->data['postage'] = '商品运费获取失败，请联系作者进行程序升级！';
        }
        return $this->data;
    }

    public function getError()
    {
        return $this->lastError;
    }

    /**
     * 获取网页内容
     */
    private function getContents($url)
    {
        for ($i = 0; $i < 3; $i++) {
            $c = @file_get_contents($url);
            if (strlen($c) > 1000)
                break;
        }
        return $this->html = $c;
    }

    /**
     * 获取网站的主域名
     */
    private function getMainDomain($url)
    {
        $strUrl = trim($url);
        $intReturn = strpos($strUrl, "/", 7);
        $strUrl = substr($strUrl, 7, strlen($strUrl) - 1);
        if ($intReturn == false) {
            $fchar = substr($strUrl, 0, 1);
            if (is_numeric($fchar)) {
                $dealDoain = $strUrl;
            } else {
                $arrayUrl = explode(".", $strUrl);
                $dealDoain = $arrayUrl[sizeof($arrayUrl) - 2] . "." . $arrayUrl[sizeof($arrayUrl) -
                    1];
            }
        } else {
            $arrayUrl = explode("/", $strUrl);
            $strUrl = $arrayUrl[0];
            $fchar = substr($strUrl, 0, 1);
            if (is_numeric($fchar)) {
                $dealDoain = $strUrl;
            } else {
                $arraydomain = explode(".", $strUrl);
                $dealDoain = $arraydomain[sizeof($arraydomain) - 2] . "." . $arraydomain[sizeof($arraydomain) -
                    1];
            }
        }
        return $dealDoain;
    }

}

?>