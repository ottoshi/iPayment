<?php

function fn_IPAYMENTPROM_order_list() {
    global $wpdb;
    
    $flag= "1"; // Show only
     //$_REQUEST["search"] = $_REQUEST["search"];
     $search = $_REQUEST["search"];
     /*if (isset($_REQUEST['flag'])) {
        $flag= "1";
    } else {
        $flag = $_REQUEST['flag'];
    }*/

    ($_REQUEST["perpage"])? $perpage = $_REQUEST["perpage"] : $perpage =  IPAYMENTPROM::LIST_ORDER_PER_PAGE; // Set perpage default

    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/<?php echo IPAYMENTPROM::PLUGIN_FOLDER_NAME;?>/css/style-admin.css" rel="stylesheet" />
    <script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="<?php echo WP_PLUGIN_URL; ?>/<?php echo IPAYMENTPROM::PLUGIN_FOLDER_NAME;?>/css/excellentexport.js"></script>
    
    <div class="wrap">
        <h2>Order List</h2>
        <div class="tablenav top">
            
            <div class="ss-field-width">
                <form method="post" action="admin.php?page=fn_ipayment_order_list">
                <input name="search" id="search" type="text" value="<?=$_REQUEST["search"]?>">
                <input name="flag" id="flag" type="hidden" value='1'>
                Perpages <input type="text" name="perpage" size="2" id="perpage" value="<?=$perpage;?>">
                <input type='submit' name="btnsearch" value='Search' class='button'>
                 <?php // if($_REQUEST["search"]) { echo "Keysearch : ".$_REQUEST["search"];}?>
                 
                </form>
            </div>

            <br class="clear">
        </div>

        <div class="widefat">
           <?php
               	$update_date = date("Y-m-d H:i:s");

               if (isset($_REQUEST['removeid'])) {
                $pageid = $_REQUEST['pageid'];
                $wpdb->update($wpdb->prefix . IPAYMENTPROM::TABLE_MASTER_PAYMENT_LOG, array('i_flag'=>'0','r_sysdate'=>$update_date), array('i_id'=>$_REQUEST['removeid']));
                // $wpdb->delete( $wpdb->prefix . IPAYMENTPROM::TABLE_MASTER_PAYMENT_LOG , array( 'i_id' => $_REQUEST['removeid'] ) );
                echo "<span style='font-color:green'>Remove id  ".$_REQUEST["removeid"]." Successful</span><br class='clear'>";
                } 
                if (isset($_REQUEST['chageid'])) {      
                    ($_REQUEST["stype"]=='0') ? $new_status = 1 : $new_status = 0;
                    $wpdb->update($wpdb->prefix . IPAYMENTPROM::TABLE_MASTER_PAYMENT_LOG, array('i_status'=>$new_status,'r_sysdate'=>$update_date), array('i_id'=>$_REQUEST['chageid']));
                    echo "<span style='font-color:green'>Update id  ".$_REQUEST["chageid"]." Successful</span><br class='clear'>";                       
                }
                
            ?>
        </div>
        <?php     


        $table_name = $wpdb->prefix . IPAYMENTPROM::TABLE_MASTER_PAYMENT_LOG;
        //$perpage = IPAYMENT::LIST_ORDER_PER_PAGE;
        $start = (isset($_REQUEST['pageid'])) ? $_REQUEST['pageid'] : 0;

        /// Condition Option
        //if ((isset($_REQUEST['btnsearch'])) && (isset($_REQUEST['search']))) {
        if (isset($_REQUEST['search'])) {            
            // $option .= " and i_flag=".$flag; // Show only 1 =show , 0 disable
            $option .= " and ( ";
            $option .= " (i_name like '%".$_REQUEST['search']."%')";
            $option .= " or  (i_email like '%".$_REQUEST['search']."%')";
            $option .= " or  (i_amount like '%".$_REQUEST['search']."%')";
            $option .= " or  (i_email like '%".$_REQUEST['search']."%')";
            $option .= " or  (i_phone like '%".$_REQUEST['search']."%')";
            $option .= " or  (i_noties like '%".$_REQUEST['search']."%')";            
            $option .= " ) ";

        }        

        $totalfound =  $wpdb->get_results("SELECT count(*) as totalfound from $table_name where  i_flag=$flag ");

		$TotalRec =  $wpdb->get_results("SELECT count(*) as totalfound  from $table_name where i_flag=$flag  $option");
        
        $rows = $wpdb->get_results("SELECT * from  $table_name where  i_flag=$flag  $option order by i_id desc LIMIT  $start, $perpage ");
        //echo "SELECT * from  $table_name where 1=1 $option order by i_id desc LIMIT  $start, $perpage";
        //$Totalrows = $wpdb->get_results("SELECT * from  $table_name where 1=1 $option");
        // echo "SELECT * from  $table_name where 1=1 $option order by i_id desc LIMIT  $start, $perpage"; // LOG SQL
        
        ?>
        <div><b>Total / Found </b>: <?=$totalfound[0]->totalfound;?> / <?=$TotalRec[0]->totalfound;?> 

         <span style="float:right">
         <a download="Export_<?php echo Generate_UNIQID()?>.xls" href="#" onclick="return ExcellentExport.excel(this, 'datatable', 'Sheet Name Here');"><img src="<?php echo WP_PLUGIN_URL; ?>/<?php echo IPAYMENTPROM::PLUGIN_FOLDER_NAME;?>/css/xls.png" border='0'></a>
        &nbsp;<!-- a download="somedata.csv" href="#" onclick="return ExcellentExport.csv(this, 'datatable');">Export to CSV</a--> 
        </span>
        </div>
    
        <table class='wp-list-table-list widefat fixed striped posts' id="datatable">
            <tr>
                <th class="manage-column ss-list-width">ID</th>
                <th class="manage-column ss-list-width">Submit Datetime</th>
                <th class="manage-column ss-list-width">Update Datetime</th>                
                <th class="manage-column ss-list-width">Refence ID</th>
                <th class="manage-column ss-list-width">Name</th>
                <th class="manage-column ss-list-width">Amount</th>
                <th class="manage-column ss-list-width">Email</th>
                <th class="manage-column ss-list-width">Phone</th>
                <th class="manage-column ss-list-width">Noties</th>                
                <th class="manage-column ss-list-width">STATUS</th>
                <th>&nbsp;</th>
            </tr>            
            <?php foreach ($rows as $row) { 
			
			//print_r($row);
			//echo "<hr>";
			?>
                <tr>
                    <td class="manage-column ss-list-width"><?php echo $row->i_id; ?></td>                    
                    <td class="manage-column ss-list-width"><?php echo $row->i_sysdate; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->r_sysdate; ?></td>                    
                    <td class="manage-column ss-list-width"><?php echo $row->i_refence; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->i_name; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->i_amount; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->i_email; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->i_phone; ?></td>
                    <td class="manage-column ss-list-width"><div style="inline-block; width: 150px; white-space: nowrap; overflow: hidden !important; text-overflow: ellipsis;"><?php echo $row->i_noties; ?></div></td>                    
                    <td class="manage-column ss-list-width"><a href="admin.php?page=fn_IPAYMENTPROM_order_list&chageid=<?php echo $row->i_id;?>&pageid=<?=$start;?>&stype=<?=$row->i_status;?>" onclick="return confirm('Confirm Update Status id <?php echo $row->i_id;?>')"><?php echo IPAYMENTPROM::MYSTATUS[$row->i_status]; ?></a></td>
                    <td><a href="admin.php?page=fn_IPAYMENTPROM_order_list&removeid=<?php echo $row->i_id;?>&pageid=<?=$start;?>" onclick="return confirm('Confirm Delete id <?php echo $row->i_id;?>')">Remove</a></td>
                </tr>
            <?php } ?>
        </table>
        <?php	
        
        // Get All for      
		if($start == 0) {   echo "Previous Page |"; } else { 
            $next = $start-$perpage;
            echo "<a href='admin.php?page=fn_IPAYMENTPROM_order_list&pageid=$next&search=$search&flag=$flag&perpage=$perpage'>Previous Page</a> |";            
        }
		if($start + $perpage >= $TotalRec) { echo " Next Page ";}	else{              
            $next = $start+$perpage;
            echo " <a href='admin.php?page=fn_IPAYMENTPROM_order_list&pageid=$next&search=$search&flag=$flag&perpage=$perpage'>Next Page</a> ";
        }


		?>
    </div>
    <?php
}
