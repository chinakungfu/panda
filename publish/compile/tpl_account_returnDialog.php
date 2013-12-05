<div class="returnItems_box gray_line_box oh hide">
	<div class="returnItems_box_tite">
		<h1>Return items</h1>
        <h2>Item ID <span id="returnItem_ID"></span></h2>
	</div>
    <form id="return_form" action="/publish/index.php" method="post">
        <input type="hidden" name="action" value="account">
        <input type="hidden" name="method" value="saveReturn">
        <input type="hidden" name="returnCartID" id="returnCartID" value="">
        <input type="hidden" name="returnOrderID" id="returnOrderID" value="">
    <table width="730px" style="margin:0 auto;">
    	<tr>
        	<td align="right" width="150px">Please choose:</td>
        	<td style="padding-left:100px;"><input type="radio" name="returnType" value="1" checked />&nbsp;Replacement  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="returnType" value="2" />&nbsp;Return</td>
        </tr>
     	<tr>
        	<td align="right" width="150px" valign="top">Instructions:<span class="hong">*</span></td>
        	<td valign="top" style="padding-left:20px;">                
            	<textarea name="instructions" id="instructions" style="width:425px;height:160px;"></textarea>
            </td>
        </tr> 
     	<tr valign="top">
        	<td align="right" width="150px" style="padding-top:10px;">Upload item’s Photo:<span class="hong">*</span></td>
        	<td style="padding-left:20px;padding-top:10px;">
				<input type="file" name="upload_file" photoNum="1" id="upload_file" size="30" />
            	<a style="cursor:pointer;border:none;color:#5e97ed;height:30px;margin-top:10px;display:block;" id="uploadPhotos">Upload Photos</a>
                <span id="msg"></span>
            </td>
        </tr>
     	<tr>
        	<td colspan="2" align="left" width="150px" valign="top" style="padding-left:15px;height:30px;">
            	<span style="font:normal 12px Arial, Helvetica, sans-serif;color:#adaeab;">You can upload 3 photos Size less than 1MB</span>
            </td>

        </tr>
        <tr><td></td>
        	<td valign="top" style="padding-left:20px;">
            	 <div id="returnPhotoShow">
                 
                 </div>
            </td>        
        </tr>
     	<tr>
        	<td align="right" width="150px" valign="top"></td>
        	<td align="right">
           		<input type="hidden" value="" name="returnPhoto" id="returnPhoto" />
                <a class="returnItems_box_close">Cancel</a>&nbsp;&nbsp;&nbsp;
                <a class="returnItems_box_submit">Submit</a>                   
            </td>
        </tr>
     	<tr style="border-bottom:1px solid #ADAEAB;">
        	<td colspan="2" style="height:10px"></td>
        </tr>
     </table>
    </form>
	<div class="returnItems_box_content">
    	<h1>Questions</h1>
        <h2>How to return items after I submit this application?</h2>
		<p>We will send you the sellers address information by e-mail. You can then send the item back to the 
seller. In the case of a wrong item shipped, the seller will pay for the shipping. If you ordered the wrong
item, the shipping cost is at your expense.  The correct item will be shipped by the seller to you, or you 
will receive a refund.</p>
	</div>

</div>