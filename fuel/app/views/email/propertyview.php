<html>
    <head>
        <title></title>
    </head>
    <body>
        
        <h2><font color="#222222" face="arial, sans-serif"><span style="font-size: 17.6000003814697px; background-color: rgb(255, 255, 255);">Customer Detai&nbsp;</span></font></h2>
         <p><strong>Name:</strong>-&nbsp;<?php echo $name; ?></p>
         <p><strong>Email:</strong>-&nbsp;<?php echo $email; ?></p>
         <p><strong>Mobile No:</strong>-&nbsp;<?php echo $mobileno; ?></p>
        <hr>
        <h2><font color="#222222" face="arial, sans-serif"><span style="font-size: 17.6000003814697px; background-color: rgb(255, 255, 255);">Property Requested&nbsp;</span></font></h2>

        <p><strong>Property name:</strong>-&nbsp;<?php echo $detailsdata[0]['property_name']; ?></p>

        <p>Property Desciption: <br><?php echo $detailsdata[0]['property_desc']; ?></p>

        <p>Property Type:- <?php echo idconvert::get_property_type($detailsdata[0]['property_type']); ?></p>

        <p>&nbsp;Location:- <?php echo idconvert::get_property_location($detailsdata[0]['location']); ?></p>

        <p>BHK:- <?php echo $detailsdata[0]['project_details']; ?></p>

        <p><span style="color: rgb(51, 51, 51); font-family: Arial; font-size: 14px; font-weight: bold; line-height: 20px; background-color: rgb(255, 255, 255);">Stage of Construction:-</span></p>

        <p>Property Details:</p>

        <table border="1" cellpadding="1" cellspacing="1" style="width: 500px;">
            <tbody>
                <tr>
                    <td>Property Type</td>
                    <td>BHK</td>
                    <td>Size</td>
                    <td>Price Per Sq. Ft</td>
                    <td><span style="color: rgb(255, 255, 255); font-family: Arial; font-size: 14px; font-weight: bold; line-height: 20px; background-color: rgb(0, 64, 80);">Total Price</span></td>
                </tr>
                <?php
                if (!empty($property_detail)) {
                    foreach ($property_detail as $key => $value) {
                        $bhk = idconvert::get_floor($value['bhk']);
                        echo '<tr>';
                        echo '<td>' . $value['type'] . '</td>';
                        echo '<td>' . $bhk[0]['floor_name'] . '</td>';
                        echo '<td>' . $value['size'] . ' Sqft</td>';
                        if ($value['visibility'] == 'No') {
                            $tempver = "'.popup.example'";
                            echo '<td colspan="2"><a href="#" onclick="$(' . $tempver . ').show()"><strong>Price on Request</strong></a></td>';
                        } else {
                            echo '<td>' . $value['priceper'] . '</td>';
                            echo '<td>' . $value['totalprice'] . '</td>';
                        }
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="5">Sorry no details to display.</td></tr>';
                }
                ?>
            </tbody>
        </table>

        <p>&nbsp;</p>

        <p>Images:</p>

        <p><img alt="" src="http://globalpropertykart.com/public/assets/img/property/<?php echo $detailsdata[0]['property_id']; ?>-1.jpg" style="height: 250px; width: 167px;" />&nbsp;<img alt="" src="http://globalpropertykart.com/public/assets/img/property/<?php echo $detailsdata[0]['property_id']; ?>-2.jpg" style="width: 200px; height: 122px;" />&nbsp;<img alt="" src="http://globalpropertykart.com/public/assets/img/property/<?php echo $detailsdata[0]['property_id']; ?>-3.jpg" style="width: 250px; height: 225px;" /></p>

        <p><span style="color: rgb(34, 34, 34); font-family: arial; font-size: 12px; background-color: rgb(255, 255, 255);">Thanks and Regards,</span><br style="color: rgb(34, 34, 34); font-family: arial; font-size: 12px; background-color: rgb(255, 255, 255);" />
            <span style="color: rgb(34, 34, 34); font-family: arial; font-size: 12px; background-color: rgb(255, 255, 255);"><a href="http://globalpropertykart.com">globalpropertykart.com</a>&nbsp;Team.</span></p>
    </body>
</html>
