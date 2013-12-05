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
 * ����ʵ����Ʒ��Ϣ�Ĳɼ�
 */
class goods
{
    /**
     * ��ҳHTMLԴ�ļ�
     */
    private $html;
    /**
     * ������õ���������Ϣ
     */
    private $data;
    /**
     * ��Ҫ�ɼ���URL
     */
    private $url;
    /**
     * ����ɼ���վ���б�
     */
    private $siteList;
    /**
     * ���һ�γ��ֵĴ���
     */
    private $lastError;

    public function __construct($url = '')
    {
        $this->siteList = array('taobao' => 'taobao.com', 'tmall' => 'tmall.com');
        $this->url = $url;
    }

    /**
     * ��ȡ���
     * ����false:ץȡʧ�� -1:��Ʒ���¼� array:��Ʒ��Ϣ
     */
    public function getResult()
    {
        if (!in_array($this->getMainDomain($this->url), $this->siteList)) {
            $this->lastError = '�������URL���޷��ɼ�����˶�URL��';
            return false;
        }
        $this->html = $this->getContents($this->url);
        if (!$this->html) {
            $this->lastError = 'û�л�ȡ����ҳ���ݻ���ҳ���ݹ��٣�';
            return false;
        }
        $fun = array_pop(array_keys($this->siteList, $this->getMainDomain($this->url)));
        return $this->$fun($this->html);
    }

    /**
     * �Ա���Ʒ��Ϣ����
     */
    private function taobao($html)
    {
        if (preg_match("/��˲鿴���±�������/Ui", $html, $matches)) { //���¼���Ʒ�ж�
            return '-1';
        }
        if (preg_match("/<title>(.*)<\/title>/Ui", $html, $matches)) { //��ȡ��Ʒ����
            $this->data['title'] = str_replace('-�Ա���', '', $matches[1]);
        } else {
            $this->data['title'] = '��Ʒ���ƻ�ȡʧ�ܣ�����ϵ���߽��г���������';
        }
        if (preg_match("/id=(\'|\")?J_StrPrice(\'|\")?(.*)?>(.*)<\/strong>/Ui", $html, $matches)) { //��ȡ��Ʒ�۸�
            $this->data['price'] = trim($matches[4]);
        } else {
            $this->data['price'] = '��Ʒ�۸��ȡʧ�ܣ�����ϵ���߽��г���������';
        }
        if (preg_match("/���ڵ���(.*)30���۳�/Usi", $html, $matches)) { //��ȡ��Ʒ�˷�
            if (preg_match("/���ҳе��˷�/Ui", $matches[1], $matches1)) { //�ж��Ƿ�Ϊ���ҳе��˷�
                $this->data['postage'] = 0;
            } else {
                if (preg_match("/���:(.*)?Ԫ/Ui", $matches[1], $matches1)) { //�ж��Ƿ�Ϊ���ҳе��˷�
                    $this->data['postage'] = $matches1[1];
                } else {
                    $this->data['postage'] = '��Ʒ�˷ѻ�ȡʧ�ܣ�����ϵ���߽��г���������';
                }
            }
        } else {
            $this->data['postage'] = '��Ʒ�˷ѻ�ȡʧ�ܣ�����ϵ���߽��г���������';
        }
        return $this->data;
    }

    /**
     * ��è��Ʒ��Ϣ����
     */
    private function tmall($html)
    {
        if (preg_match("/��˲鿴���±�������/Ui", $html, $matches)) { //���¼���Ʒ�ж�
            return '-1';
        }
        if (preg_match("/<title>(.*)<\/title>/Ui", $html, $matches)) { //��ȡ��Ʒ����
            $this->data['title'] = str_replace('-tmall.com��è', '', $matches[1]);
        } else {
            $this->data['title'] = '��Ʒ���ƻ�ȡʧ�ܣ�����ϵ���߽��г���������';
        }
        if (preg_match("/id=(\'|\")?J_StrPrice(\'|\")?(.*)?>(.*)<\//Ui", $html, $matches)) { //��ȡ��Ʒ�۸�
            $this->data['price'] = trim($matches[4]);
        } else {
            $this->data['price'] = '��Ʒ�۸��ȡʧ�ܣ�����ϵ���߽��г���������';
        }
        if (preg_match("/�ۡ�����(.*)�� �� ��/Usi", $html, $matches)) { //��ȡ��Ʒ�˷�
            if (preg_match("/���ҳе��˷�/Ui", $matches[1], $matches1)) { //�ж��Ƿ�Ϊ���ҳе��˷�
                $this->data['postage'] = 0;
            } else {
                if (preg_match("/���:(.*)?Ԫ/Ui", $matches[1], $matches1)) { //�ж��Ƿ�Ϊ���ҳе��˷�
                    $this->data['postage'] = $matches1[1];
                } else {
                    $this->data['postage'] = '��Ʒ�˷ѻ�ȡʧ�ܣ�����ϵ���߽��г���������';
                }
            }
        } else {
            $this->data['postage'] = '��Ʒ�˷ѻ�ȡʧ�ܣ�����ϵ���߽��г���������';
        }
        return $this->data;
    }

    public function getError()
    {
        return $this->lastError;
    }

    /**
     * ��ȡ��ҳ����
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
     * ��ȡ��վ��������
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