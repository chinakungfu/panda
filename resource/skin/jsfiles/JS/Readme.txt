<!--
/**
 *
 * JSCalendar
 *
 * Author           :H.Z. Shang (Jack)
 * Email            :shhongzhang@cntomorrow.com
 * Site             :http://www.cntomorrow.com:3310
 * Version          :1.0.1
 * Finished Date    :2003-3-2
 * Beijing Huasun Mingtian Tech. Co., Ltd.
 * No CopyRight,Can be modified by you if you want improve it's function!!!!
 * LET'S MAKE IT BETTER TOGETHER!
 * HISTORY:
 *  1. [2003-3-4 by Jack] 采用IFRAME修正了会被页面SELECT对象挡住的BUG!
 *  2. [2003-3-4 by Jack] 增加了清空控件值的功能
 *  3. [2003-3-5 by Jack] 修正了当用户翻年、翻月时原输入框值被覆盖的情况
 */

 使用方法：
 1。包含JSCalendar.js文件
    a) <script src=JSCalendar.js><script> /* 用于一般html页面 */
    b) <script src=/MyWebApp/comm/js/JSCalendar/JSCalendar.js><script> /* 用户部署到应用服务器上的页面 */

 2。对需要进行时间输入的INPUT输入框，添加onClick函数
    如：对于 <input name=startDate>，通过下面的方法即可对该输入框使用控件方式获取时间
    a) <input name=startDate onClick=JSCalendar(this)> //this 参数为必需参数
    b) <input name=startDate onClick=JSCalendar(this, 2003, 3, 4)> //this 参数为必需参数， 将控件的默认值设为2003-3-4


 几点要注意的地方：
 1。必须正确指定 _sNeededFilePath 变量的值。该值在JSCalendar.js文件中 49 行
 /**
  * _sNeededFilePath 变量设定了JSCalendar控件所需的所有文件的位置
  * 当你将你的应用部署到应用服务器上后，你需要给改变量设定相应的值。
  * 例如：
  *		_sNeededFilePath = "/MyWebAPP/comm/js/JSCalendar/";
  *
  * 该变量的值必须正确设置，否则程序在运行中可能出现错误！ 
  */

  2。为了提高程序运行速度，最好将 _nShadowLength 的值设为 0。 该值在JSCalendar.js文件中 39 行
     该值的默认值为 4 ；

  
  如有其他疑问或建议，请与我联系！ :)
  shhongzhang@cntomorrow.com
  QQ: 1156065
