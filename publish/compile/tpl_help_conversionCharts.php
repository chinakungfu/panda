<!DOCTYPE HTML>
<html>
	<head>
		<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/common_header.tpl
LNMV
);
include($inc_tpl_file);
?>

</head>
<body>
<div class="box">	
			<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/shop_header.tpl
LNMV
);
include($inc_tpl_file);
?>
<div class="contentHelp clb">
    <div class="navHelp">
        <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=main'));?>">Help Center</a> > Other
    </div>    
    <div class="contentHelpContLeft fl">
        <h3>Conversion Charts</h3>
        <div class="conRate">
        	<p style="margin:10px auto;"><span style="font:bold 14px Arial, Helvetica, sans-serif;color:#333;">Women's clothes</span> (Coat, T-shirt, dress etc)</p>
			<table cellpadding="0" cellspacing="0" width="775px">
            	<tr>
                	<td class="th" width="130px">Standard</td>
                    <td class="th" colspan="5">size</td>
         		</tr>
            	<tr>
                	<td>Chinese(cm)</td>
                    <td>160-165/84-86</td>
                    <td>165-170/88-90</td>
                    <td>168-173/92-96</td>
                    <td>168-173/98-102</td>
                    <td>170-176/106-110</td>
         		</tr>
            	<tr>
                	<td>Internetional</td>
                    <td>XS</td>
                    <td>S</td>
                    <td>M</td>
                    <td>L</td>
                    <td>XL</td>
         		</tr>        	
                <tr>
                	<td>American</td>
                    <td>2</td>
                    <td>4-6</td>
                    <td>8-10</td>
                    <td>12-14</td>
                    <td>16-18</td>
         		</tr>              	
                <tr>
                	<td>European</td>
                    <td>34</td>
                    <td>36</td>
                    <td>38-40</td>
                    <td>42</td>
                    <td>44</td>
         		</tr>                                                                                                                                          
            </table>
        </div>
        
         <div class="conRate">
        	<p style="margin:10px auto;"><span style="font:bold 14px Arial, Helvetica, sans-serif;color:#333;">Men's clothes</span> (coat, T-shirt, etc)</p>
			<table cellpadding="0" cellspacing="0" width="775px">
            	<tr>
                	<td class="th" width="130px">Standard</td>
                    <td class="th" colspan="5">size</td>
         		</tr>
            	<tr>
                	<td>Chinese(cm)</td>
                    <td>165-165/88-90</td>
                    <td>170/96-98</td>
                    <td>175/108-110</td>
                    <td>180/118-122</td>
                    <td>185/126-130</td>
         		</tr>
            	<tr>
                	<td>Internetional</td>
                    <td>XS</td>
                    <td>M</td>
                    <td>L</td>
                    <td>XL</td>
                    <td>XXL</td>
         		</tr>        	
 			</table>
        </div> 
        
         <div class="conRate">
        	<p style="margin:10px auto;"><span style="font:bold 14px Arial, Helvetica, sans-serif;color:#333;">Men's blouse</span></p>
			<table cellpadding="0" cellspacing="0" width="775px">
            	<tr>
                	<td class="th" width="130px">Standard</td>
                    <td class="th" colspan="5">size</td>
         		</tr>
            	<tr>
                	<td>Chinese(cm)</td>
                    <td>36-37</td>
                    <td>38-39</td>
                    <td>40-42</td>
                    <td>43-44</td>
                    <td>45-47</td>
         		</tr>
            	<tr>
                	<td>European</td>
                    <td>S</td>
                    <td>M</td>
                    <td>L</td>
                    <td>XL</td>
                    <td>XXL</td>
         		</tr>        	
 			</table>
        </div>
        
         <div class="conRate">
        	<p style="margin:10px auto;"><span style="font:bold 14px Arial, Helvetica, sans-serif;color:#333;">Men's suit pants</span></p>
			<table cellpadding="0" cellspacing="0" width="775px">
            	<tr>
                	<td class="th" width="130px">Standard</td>
                    <td class="th" colspan="5">size</td>
         		</tr>
            	<tr>
                	<td>Size</td>
                    <td>42</td>
                    <td>44</td>
                    <td>46</td>
                    <td>48</td>
                    <td>50</td>
         		</tr>
            	<tr>
                	<td>Waist</td>
                    <td>68-72 CM</td>
                    <td>71-76CM</td>
                    <td>75-80 CM</td>
                    <td>79-84 CM</td>
                    <td>83-88 CM</td>
         		</tr> 
            	<tr>
                	<td>Length</td>
                    <td>99 CM</td>
                    <td>101.5 CM</td>
                    <td>104 CM</td>
                    <td>106.5 CM</td>
                    <td>109 CM</td>
         		</tr>   
 			</table>
        </div>
        
         <div class="conRate">
        	<p style="margin:10px auto;"><span style="font:bold 14px Arial, Helvetica, sans-serif;color:#333;">Women's bra - under bust girth</span></p>
			<table cellpadding="0" cellspacing="0" width="775px">
            	<tr>
                	<td class="th" width="130px">Standard</td>
                    <td class="th" colspan="14">size</td>
         		</tr>
            	<tr>
                	<td>Chinese(cm)</td>
                    <td>76.2</td>
                    <td>81.3</td>
                    <td>86.4</td>
                    <td>91.5</td>
                    <td>101.6</td>
                    
                    <td>106.7</td>
                    <td>112</td>
                    <td>117</td>
                    <td>122</td>
                    <td>127</td>
                    
                    <td>132</td>
                    <td>137</td>
                    <td>142</td>                                           
         		</tr>
            	<tr>
                	<td>American</td>
                    <td>30</td>
                    <td>32</td>
                    <td>34</td>
                    <td>36</td>
                    <td>38</td>
                    
                    <td>40</td>
                    <td>44</td>
                    <td>46</td>
                    <td>48</td>
                    <td>50</td>
                    
                    <td>52</td>
                    <td>54</td>
                    <td>56</td> 
         		</tr> 
            	<tr>
                	<td>British</td>
                    <td>30</td>
                    <td>32</td>
                    <td>34</td>
                    <td>36</td>
                    <td>38</td>
                    
                    <td>40</td>
                    <td>44</td>
                    <td>46</td>
                    <td>48</td>
                    <td>50</td>
                    
                    <td>52</td>
                    <td>54</td>
                    <td>56</td> 
         		</tr>
            	<tr>
                	<td>European</td>
                    <td>42</td>
                    <td>70</td>
                    <td>75</td>
                    <td>80</td>
                    <td>85</td>
                    
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    
                    <td></td>
                    <td></td>
                    <td></td> 
         		</tr>
            	<tr>
                	<td>French</td>
                    <td>68-72 CM</td>
                    <td>85</td>
                    <td>90</td>
                    <td>95</td>
                    <td>100</td>
                    
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    
                    <td></td>
                    <td></td>
                    <td></td> 
         		</tr> 
            	<tr>
                	<td>Italian</td>
                    <td>99 CM</td>
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                    <td>4</td>
                    
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    
                    <td></td>
                    <td></td>
                    <td></td> 
         		</tr>                 
 			</table>
        </div> 
        
         <div class="conRate">
        	<p style="margin:10px auto;"><span style="font:bold 14px Arial, Helvetica, sans-serif;color:#333;">Women's bra - cup</span></p>
			<table cellpadding="0" cellspacing="0" width="775px">
            	<tr>
                	<td class="th" width="130px">Standard</td>
                    <td class="th" colspan="15">size</td>
         		</tr>
            	<tr>
                	<td>Chinese</td>
                    <td width="42px">A</td>
                    <td width="42px">B</td>
                    <td width="71px">C</td>
                    <td width="42px">D</td>
                    <td width="42px">E</td>
                    
                    <td width="42px"></td>
                    <td width="70px"></td>
                    <td width="42px"></td>
                    <td width="42px"></td>
                    <td width="42px"></td>
                    <td width="42px"></td> 
                    
                    <td width="42px"></td>
                    <td width="42px"></td>
                    <td width="42px"></td>                                           
         		</tr>
            	<tr>
                	<td>American</td>
                    <td>AA</td>
                    <td>A</td>
                    <td>B</td>
                    <td>C</td>
                    <td>D</td>
                    
                    <td>DD</td>
                    <td>DDD/E</td>
                    <td>F</td>
                    <td>FF</td>
                    <td>G</td>
                    <td>GG</td>
                    
                    <td>H</td>
                    <td>HH</td>
                    <td>J</td> 
         		</tr> 
            	<tr>
                	<td>British</td>
                    <td>AA</td>
                    <td>A</td>
                    <td>B</td>
                    <td>C</td>
                    <td>D</td>
                    
                    <td>DD</td>
                    <td>E</td>
                    <td>F</td>
                    <td>FF</td>
                    <td>G</td>
                    <td>GG</td>
                    
                    <td>H</td>
                    <td>HH</td>
                    <td>J</td> 
         		</tr> 
            	<tr>
                	<td>European</td>
                    <td>AA</td>
                    <td>A</td>
                    <td>B</td>
                    <td>C</td>
                    <td>D</td>
                    
                    <td>E</td>
                    <td>F</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    
                    <td></td>
                    <td></td>
                    <td></td> 
         		</tr> 
            	<tr>
                	<td>French</td>
                    <td>AA</td>
                    <td>A</td>
                    <td>B</td>
                    <td>C</td>
                    <td>D</td>
                    
                    <td>E</td>
                    <td>F</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    
                    <td></td>
                    <td></td>
                    <td></td> 
         		</tr> 
            	<tr>
                	<td>Italian</td>
                    <td></td>
                    <td>B</td>
                    <td>E or none</td>
                    <td>C</td>
                    <td>D</td>
                    
                    <td>DD</td>
                    <td>E</td>
                    <td>F</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    
                    <td></td>
                    <td></td>
                    <td></td> 
         		</tr>                 
 			</table>
        </div>
        
         <div class="conRate">
        	<p style="margin:10px auto;"><span style="font:bold 14px Arial, Helvetica, sans-serif;color:#333;">Women's lingerie</span></p>
			<table cellpadding="0" cellspacing="0" width="775px">
            	<tr>
                	<td class="th" width="130px">Standard</td>
                    <td class="th" colspan="8">size</td>
         		</tr>
            	<tr>
                	<td>Chinese(cm)</td>
                    <td>S</td>
                    <td>M</td>
                    <td>L</td>
                    <td>XL</td>
                    <td>XXL</td>
                    
                    <td>XXXL</td>
                    <td></td>                                          
         		</tr>
            	<tr>
                	<td>International</td>
                    <td>XS</td>
                    <td>S</td>
                    <td>M</td>
                    <td>L</td>
                    <td>XL</td>
                    <td>XXL</td>
                    
                    <td>XXXL</td> 
         		</tr>
            	<tr>
                	<td>American</td>
                    <td>2</td>
                    <td>4</td>
                    <td>6</td>
                    <td>8</td>
                    <td>10</td>
                    <td>12</td>
                    
                    <td>14</td> 
         		</tr>                  
            	<tr>
                	<td>British</td>

                    <td>6</td>
                    <td>8</td>
                    <td>10</td>
                    <td>12</td>
                    
                    <td>14</td> 
                    <td>16</td>
                    <td>18</td>                    
         		</tr> 
            	<tr>
                	<td>European</td>
                    <td>32</td>
                    <td>34</td>
                    <td>36</td>
                    <td>38</td>
                    <td>40</td>
                    
                    <td>42</td>
                    <td>44F</td> 
         		</tr> 
            	<tr>
                	<td>French</td>             
                    <td>34</td>
                    <td>36</td>
                    <td>38</td>
                    <td>40</td>
                    
                    <td>42</td>
                    <td>44</td>  
                    <td>46</td>
         		</tr> 
            	<tr>
                	<td>Italian</td>
                    
                    <td>36</td>
                    <td>38</td>
                    <td>40</td>
                    
                    <td>42</td>
                    <td>44</td>  
                    <td>46</td>
                    <td>48</td>
         		</tr>                 
 			</table>
        </div> 
        
         <div class="conRate">
        	<p style="margin:10px auto;"><span style="font:bold 14px Arial, Helvetica, sans-serif;color:#333;">Men's underwear</span></p>
			<table cellpadding="0" cellspacing="0" width="775px">
            	<tr>
                	<td class="th" width="130px">Standard</td>
                    <td class="th" colspan="8">size</td>
         		</tr>
            	<tr>
                	<td>Chinese(cm)</td>
                    <td>72-76</td>
                    <td>76-81</td>
                    <td>81-87</td>
                    <td>87-93</td>
                    <td>93-98</td>                                         
         		</tr>
            	<tr>
                	<td>International</td>
                    <td>S</td>
                    <td>M</td>
                    <td>L</td>
                    <td>XL</td>
                    <td>XXL</td>
         		</tr>
            	<tr>
                	<td>American</td>
                    <td>28-30</td>
                    <td>30-32</td>
                    <td>32-34</td>
                    <td>34-38</td>
                    <td>38-42</td>
         		</tr>                          
 			</table>
        </div>          
        
         <div class="conRate">
        	<p style="margin:10px auto;"><span style="font:bold 14px Arial, Helvetica, sans-serif;color:#333;">Women's shoes</span></p>
			<table cellpadding="0" cellspacing="0" width="775px">
            	<tr>
                	<td class="th" width="130px">Standard</td>
                    <td class="th" colspan="10">size</td>
         		</tr>
            	<tr>
                	<td>Chinese</td>
                    <td>35.0</td>
                    <td>36.0</td>
                    <td>36.5</td>
                    <td>37.5</td>
                    <td>38.0</td>
                    
                    <td>38.5</td>
                    <td>39.0</td>
                    <td>40.0</td>
                    <td>40.5</td>
                    <td>41.0</td>                                                              
         		</tr>
            	<tr>
                	<td>American</td>
                    <td>5.0</td>
                    <td>5.5</td>
                    <td>6.0</td>
                    <td>6.5</td>
                    <td>7.0</td>
                    
                    <td>7.5</td>
                    <td>8.0</td>
                    <td>8.5</td>
                    <td>9.0</td>
                    <td>9.5</td>   
         		</tr>
            	<tr>
                	<td>Japanese(cm)</td>
                    <td>22.0</td>
                    <td>22.5</td>
                    <td>23.0</td>
                    <td>23.5</td>
                    <td>24.0</td>
                    
                    <td>24.5</td>
                    <td>25.0</td>
                    <td>25.5</td>
                    <td>26.0</td>
                    <td>26.5</td>
         		</tr>                          
 			</table>
        </div>
        
         <div class="conRate">
        	<p style="margin:10px auto;"><span style="font:bold 14px Arial, Helvetica, sans-serif;color:#333;">Men's shoes</span></p>
			<table cellpadding="0" cellspacing="0" width="775px">
            	<tr>
                	<td class="th" width="130px">Standard</td>
                    <td class="th" colspan="19">size</td>
         		</tr>
                
            	<tr>
                	<td>Chinese</td>
                    <td>38.5</td>
                    <td>39.0</td>
                    <td>40.0</td>
                    <td>40.5</td>
                    <td>41.0</td>        
                    <td>42.0</td>
                    <td>42.5</td>
                    <td>43.0</td>
                    <td>44.0</td>
                    <td>44.5</td>
                    <td>45.0</td>
                    <td>45.5</td>
                    
                    <td>46.0</td>
                    <td>47.0</td>
                    <td>47.5</td>
                    <td>48.0</td> 
                    
                    <td>48.5</td>
                    <td>49.5</td>
                    <td>50.5</td>                                                                                                                      
         		</tr>
            	<tr>
                	<td>American</td>
                    <td>6.0</td>
                    <td>6.5</td>
                    <td>7.0</td>
                    <td>7.5</td>
                    <td>8.0</td>        
                    <td>8.5</td>
                    <td>9.0</td>
                    <td>9.5</td>
                    <td>10.0</td>
                    <td>10.5</td>
                    <td>11.0</td>
                    <td>11.5</td>
                    
                    <td>12.0</td>
                    <td>12.5</td>
                    <td>13.0</td>
                    <td>13.5</td> 
                    
                    <td>14.0</td>
                    <td>15.0</td>
                    <td>16.0</td>    
         		</tr>
            	<tr>
                	<td>Japanese(cm)</td>
                    <td>24.0</td>
                    <td>24.5</td>
                    <td>25.0</td>
                    <td>25.5</td>
                    <td>26.0</td>        
                    <td>26.5</td>
                    <td>27.0</td>
                    <td>27.5</td>
                    <td>28.0</td>
                    <td>28.5</td>
                    <td>29.0</td>
                    <td>29.5</td>
                    
                    <td>30.0</td>
                    <td>30.5</td>
                    <td>31.0</td>
                    <td>31.5</td> 
                    
                    <td>32.0</td>
                    <td>33.0</td>
                    <td>34.0</td>  
         		</tr>                          
 			</table>
        </div>          
         
         <div class="conRate">
        	<p style="margin:10px auto;"><span style="font:bold 14px Arial, Helvetica, sans-serif;color:#333;">Length</span></p>
			<table cellpadding="0" cellspacing="0" width="775px">
            	<tr>
                	<td class="th"  colspan="2">Imperial</td>
                    <td class="th">Metric</td>
         		</tr>
                
            	<tr>
                	<td width="258px">1 inch [in]</td>
                    <td width="258px"></td>
                    <td>2.54cm</td>                                                                                                           
         		</tr>
            	<tr>
                	<td>1 foot [ft]</td>
                    <td>12 in</td>
                    <td>0.3048M</td>    
         		</tr>
            	<tr>
                	<td>1 yard [yd]</td>
                    <td>3 foot</td>
                    <td>0.9144M</td> 
         		</tr>
            	<tr>
                	<td>1 mile</td>
                    <td>1760 yd</td>
                    <td>1.6093 KM</td> 
         		</tr>
            	<tr>
                	<td>1 int nautical mile</td>
                    <td>2025.4 yd</td>
                    <td>1.853 KM</td> 
         		</tr>                                                            
 			</table>
        </div>
         
         <div class="conRate">
        	<p style="margin:10px auto;"><span style="font:bold 14px Arial, Helvetica, sans-serif;color:#333;">Area</span></p>
			<table cellpadding="0" cellspacing="0" width="775px">
            	<tr>
                	<td class="th"  colspan="2">Imperial</td>
                    <td class="th">Metric</td>
         		</tr>
                
            	<tr>
                	<td width="258px">1 sq inch [in2]</td>
                    <td width="258px"></td>
                    <td>6.4516 cm2</td>                                                                                                           
         		</tr>
            	<tr>
                	<td>1 sq foot [ft2]</td>
                    <td>144 in2</td>
                    <td>0.0929 m2</td>    
         		</tr>
            	<tr>
                	<td>1 sq yd [yd2]</td>
                    <td>9 ft2</td>
                    <td>0.8361 m2</td> 
         		</tr>
            	<tr>
                	<td>1 acre</td>
                    <td>4840 yd2</td>
                    <td>4046.9 m2</td> 
         		</tr>
            	<tr>
                	<td>1 sq mile [mile2]</td>
                    <td>640 acres</td>
                    <td>2.59 km2</td> 
         		</tr>                                                            
 			</table>
        </div>          
         
         <div class="conRate">
        	<p style="margin:10px auto;"><span style="font:bold 14px Arial, Helvetica, sans-serif;color:#333;">Volume/Capacity</span></p>
			<table cellpadding="0" cellspacing="0" width="775px">
            	<tr>
                	<td class="th"  colspan="2">USA measure</td>
                    <td class="th">Metric</td>
         		</tr>
                
            	<tr>
                	<td width="258px">1 fluid ounce</td>
                    <td width="258px">1.0408 UK fl oz</td>
                    <td>29.574 ml</td>                                                                                                           
         		</tr>
            	<tr>
                	<td>1 pint (16 fl oz )</td>
                    <td>0.8327 UK pt</td>
                    <td>0.4731 l</td>    
         		</tr>
            	<tr>
                	<td>1 gallon</td>
                    <td>0.8327 UK gal</td>
                    <td>3.7854 l</td> 
         		</tr>                                                           
 			</table>
        </div>          
         
         <div class="conRate">
        	<p style="margin:10px auto;"><span style="font:bold 14px Arial, Helvetica, sans-serif;color:#333;">Weight</span></p>
			<table cellpadding="0" cellspacing="0" width="775px">
            	<tr>
                	<td class="th"  colspan="2">Imperial</td>
                    <td class="th">Metric</td>
         		</tr>
                
            	<tr>
                	<td width="258px">1 ounce [oz]</td>
                    <td width="258px">437.5 grain</td>
                    <td>28.35 g</td>                                                                                                           
         		</tr>
            	<tr>
                	<td>1 pound [lb]</td>
                    <td>16 oz</td>
                    <td>0.4536 kg</td>    
         		</tr>
            	<tr>
                	<td>1 stone</td>
                    <td>14 lb</td>
                    <td>6.3503 kg</td> 
         		</tr> 
                
            	<tr>
                	<td>1 hundredweight [cwt]</td>
                    <td>112 lb.</td>
                    <td>50.802 kg</td>                                                                                                           
         		</tr>
            	<tr>
                	<td>1 long ton (UK)</td>
                    <td>20 cwt</td>
                    <td>1.016 t</td>    
         		</tr>                                                                          
 			</table>
        </div>                                                                           
  		<div class="conListBottom" style="margin-top:200px;"><a style="color:#de8908;" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=main'));?>">Back</a>  <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=exchangeRate'));?>">Exchange Rate</a></div>
    </div>
    

			<?php
$inc_tpl_file=includeFunc(<<<LNMV
help/main/right.tpl
LNMV
);
//include($inc_tpl_file);
?>    
    
</div>
			
			<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/footer/shop_footer.tpl
LNMV
);
include($inc_tpl_file);
?>

		</div>
	</body>
</html>