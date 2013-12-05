<?php
/**
 * 管理 COOKIE 数据
 */

class cookieCart
{
    /**
     * 购物车中现有商品信息
     */
    private $data;
    /**
     * 最后一条错误信息
     */
    private $lastError;
    /**
     * cookie保存时间,单位：分钟
     */
    private $cookieTime;

    public function __construct($cookieTime = 60)
    {
        //初始化类的时候将数据从cookie从读取出来缓存到内存
        if (!empty($_COOKIE['xydreamCartCookie'])) {
            $this->data = unserialize(base64_decode($_COOKIE['xydreamCartCookie']));
        } else {
            $this->data = array();
        }
        //初始化cookie保存时间，默认为关闭浏览器后清除
        $this->cookieTime = $cookieTime;

    }

    /**
     * 返回购物车中物品信息
     */
    public function getItems()
    {
        return $this->data;
    }

    /**
     * 添加商品到购物车
     * @param array $items 商品信息数组
     * @param string $field 用来判断商品是否已存在于购物车中的字段名
     * @param string $quantityField 数量字段名，用于商品重复时对数量累加
     */
    public function addItem($items, $field = 'name', $quantityField = 'num')
    {
        if (is_array($items)) {
            $flag = false; //是否已存在于购物车的标记
            foreach ($this->data as $key => $value) {
                if (!isset($value[$field])){
                    $this->lastError = '用于判断重复的字段名不存在！';
                    return "3";
                }
                if (isset($value[$field]) && $value[$field] == $items[$field]) {
                    $flag = true;
                    $quantity = $value[$quantityField] + $items[$quantityField];
                    $this->data[$key] = array_merge($value, $items);
                    $this->data[$key][$quantityField] = $quantity;
                    $this->__updateCart();
                    return "1";
                } 
            }
            if (!$flag) {
                $this->data[] = $items;
                $this->__updateCart();
                return "2";
            }
        } else {
            $this->lastError = '商品信息错误，无法加入到购物车！';
            return "4";
        }
    }

    /**
     * 编辑购物车中的一条商品
     * @param array $data 要修改的信息。如:array('price'=>100,'quantity'=>20)
     * @param string $whereField 修改条件字段名称
     * @param mix $whereValue 修改条件字段值
     */
    public function editItem(array $data, $whereValue, $whereField = 'name')
    {
        $flag = false;
        foreach ($this->data as $key => $item) {
            if (isset($item[$whereField]) && $item[$whereField] == $whereValue) {
                $flag = true;
                foreach ($data as $key1 => $value) {
                    if (!isset($item[$key1])) {
                        unset($data[$key1]);
                    }
                }
                $this->data[$key] = array_merge($this->data[$key], $data);
            }
        }
        if (!$flag) {
            $this->lastError = '购物车中不存在这条商品@！';
            return false;
        } else {
            $this->__updateCart();
            return true;
        }
    }

    /**
     * 删除购物车中的一条或多条商品
     * @param string $whereField 删除条件字段名称
     * @param mix $whereValue 删除条件字段值
     */
    public function deleteItem($whereValue, $whereField = 'name')
    {
        $flag = false;
        foreach ($this->data as $key => $item) {
            if (isset($item[$whereField]) && $item[$whereField] == $whereValue) {
                $flag = true;
                unset($this->data[$key]);
            }
        }
        if (!$flag) {
            $this->lastError = '购物车中不存在这条商品@！';
            return false;
        } else {
            $this->__updateCart();
            return true;
        }
    }

    /**
     * 删除购物车中所有商品
     */
    public function deleteAll()
    {
        $this->data = array();
		echo $this->data;
        $this->__updateCart();
        return true;
    }

    /**
     * 返回错误信息
     */
    public function getError()
    {
        return $this->lastError;
    }

    /**
     * 更新购物车
     */
    private function __updateCart()
    {
        if ($this->cookieTime == 0) {
            $cTime = 0;
        } else {
            $cTime = time() + (int)$this->cookieTime * 60;
        }
        setcookie("xydreamCartCookie", base64_encode(serialize($this->data)), $cTime);
    }

}
?>