<if expr="$method=='registerSubmit'">

<pp:var name="result" value="<pp:memfunc funcname="API_register({$IN.memberName},{$IN.passWord},{$IN.email})"/>"/>

<if expr="$result == -1">
已经被人注册
<elseif expr="$result > 1 ">
注册成功
<else/>
注册失败
</if>

</if>