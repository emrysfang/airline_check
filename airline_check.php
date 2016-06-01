<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title></title>
	<style>
		.airline{border:1px solid #3195D3; border-collapse:collapse;}
		.airline th{height:35px; line-height:35px; border:1px solid #e2e2e2; font-weight:bold; background:#3195D3; color:#fff;}
		.airline td{height:28px; line-height:28px; border:1px solid #e2e2e2; text-align:center; background:#F5FCFF;}
	</style>
</head>
<body>
<?php
    $client = new SoapClient("http://ws.webxml.com.cn/webservices/DomesticAirline.asmx?wsdl");
    $res = $client->getDomesticCity();
    //var_dump($res);
    $str = $res->getDomesticCityResult->any;
    $sxe = new SimpleXMLElement($str);
    $citys = array();
    foreach ($sxe->children()->children() as $child) {
        $citys[] = $child->cnCityName;
    }
    
    //当点击查询按钮时完成航班查询
    if (isset($_POST['Button2'])) {
        $startCity = $_POST['fromcity'];
        $lastCity = $_POST['tocity'];
        $theDate = $_POST['date'];

        //构造数组
        $params = array(
            'startCity' => $startCity,
            'lastCity' => $lastCity,
            'theDate' => $theDate
        );
        $res1 = $client->getDomesticAirlinesTime($params);
        //var_dump($res1);
        $str2 = $res1->getDomesticAirlinesTimeResult->any;
        $sxe = new SimpleXMLElement($str2);
        $airlines = array();
        foreach ($sxe->children()->children() as $child) {
            $airlines[] = $child;
        }

    }

?>
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td>&nbsp;</td>
    </tr>
    <tr>
		<td>
			<a href="http://www.webxml.com.cn/">
            <img src="webxml_logo.gif" alt="WebXml Logo" width="250" height="50" border="0" /></a>
		</td>
    </tr>
    <tr>
		<td align="center">
			<a href="http://www.webxml.com.cn/" target="_blank"></a><strong>
Flight Check</strong>
		</td>
    </tr>
    <tr>
		<td>&nbsp;</td>
    </tr>
    <tr>
		<td>   
			<form name="form1" method="post" action="" id="form1">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td style="width: 50%;">Depature
						<select name="fromcity" >
                            <?php foreach ($citys as $city):?>
							<option value="<?php echo $city;?>"><?php echo $city;?></option>
							<?php endforeach;?>
                        </select>       
                       &nbsp;&nbsp;&nbsp;Arrival
                        <select name="tocity" >    
							<?php foreach ($citys as $city):?>
                            <option value="<?php echo $city;?>"><?php echo $city;?></option>
                            <?php endforeach;?>
						</select>
						&nbsp;&nbsp;&nbsp;
                        <label for="CheckBox1">Switch City</label>
                        &nbsp;&nbsp;&nbsp;
                    </td>
                    <td valign="middle">
                            Date
                    <input name="date" value="" type="text" maxlength="10" size="10" id="date" class="input1" />
                                &nbsp;&nbsp;&nbsp;
                    <input type="submit" name="Button2" value="Submit" id="Button2" class="input2" /></td>
                        </tr>
                    </table>    
				</form>
                </td>
            </tr>
            <tr>
                <td>&nbsp;    
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%" border="0" cellpadding="2" cellspacing="1" class="airline">
                        <tr>
                            <th>Airline</th>  
                            <th>Flight Nr</th>
                            <th>Depature</th>
                            <th>Dep Time</th>
                            <th>Arrival</th>
                            <th>Arr time</th>
                            <th>Flight Type</th>
                            <th>Umsteigen</th>
                        </tr>
                        <?php foreach( $airlines as $v ):?>
						 <tr>
                            <td class="tdbg"><?php echo $v->Company;?></td>
                            <td class="tdbg"><?php echo $v->AirlineCode;?></td>
                            <td class="tdbg"><?php echo $v->StartDrome;?></td>
                            <td class="tdbg"><?php echo $v->StartTime;?></td>
                            <td class="tdbg"><?php echo $v->ArriveDrome;?></td>
                            <td class="tdbg"><?php echo $v->ArriveTime;?></td>
                            <td class="tdbg"><?php echo $v->Mode;?></td>
                            <td class="tdbg"><?php echo $v->AirlineStop;?></td>
                        </tr>
                        <?php endforeach;?>
                    </table>
                </td>
            </tr>
      
        </table>
</body>
</html>