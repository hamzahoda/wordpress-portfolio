<?php 
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}
?>
<div style="background:#C3D9FF; margin-bottom:10px; padding-left:10px;">
  <h3><?php _e('Update Time Off','appointzilla'); ?></h3> 
</div>

<!--load time-off modal for update -->
<?php 
    if(isset($_GET['update-timeoff'])) {
        $update_id = intval( $_GET['update-timeoff'] );
        global $wpdb;
        $EventTable = $wpdb->prefix . "ap_events";
        $TimeOff = $wpdb->get_row($wpdb->prepare("select * from `$EventTable` where `id` = %s",$update_id), OBJECT);
        ?>
        <form action="" method="post" name="AddNewTimeOff-From" id="AddNewTimeOff-From">
			<?php wp_nonce_field('appointment_update_timeoff_nonce_check','appointment_update_timeoff_nonce_check'); ?>
            <input name="update_id" id="update_id" type="hidden" value="<?php echo esc_attr($update_id); ?>" />
            <input name="fromback" id="fromback" type="hidden" value="<?php if(isset($_GET['from'])) { echo esc_attr($_GET['from']); } ?>" />
            <table width="100%" class="table">
                <tr>
                    <th width="21%" scope="row"><?php _e('All Day Time Off','appointzilla'); ?></th>
                    <td width="4%"><strong>:</strong></td>
                    <td width="75%"><input name="allday" id="allday" type="checkbox" value="1" <?php if($TimeOff->allday) echo "checked=checked"; ?> /></td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Name','appointzilla'); ?></th>
                    <td><strong>:</strong></td>
                    <td><input name="name" id="name" type="text" value="<?php echo esc_attr($TimeOff->name); ?>" /></td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Start Time','appointzilla'); ?></th>
                    <td><strong>:</strong></td>
                    <td><input name="start_time" id="start_time" type="text" value="<?php if(!$TimeOff->allday) echo esc_attr($TimeOff->start_time); ?>" /></td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('End Time','appointzilla'); ?></th>
                    <td><strong>:</strong></td>
                    <td><input name="end_time" id="end_time" type="text" value="<?php if($TimeOff->allday == 0) echo esc_attr($TimeOff->end_time); ?>" /></td>
                </tr>
                    <tr id="event_date_tr" style="display:<?php if($TimeOff->repeat == 'PD') echo "none"; else echo ""; ?> ">
                    <th scope="row"><?php _e('Date','appointzilla'); ?></th>
                    <td><strong>:</strong></td>
                    <td><input name="event_date" id="event_date" type="text"  value="<?php echo esc_attr($TimeOff->start_date); ?>" /></td>
                </tr>

                <tr>
                    <th scope="row"><?php _e('Repeat','appointzilla'); ?></th>
                    <td><strong>:</strong></td>
                    <td>
                        <select name="repeat" id="repeat" onchange="repeatday()">
                            <option onclick="hideAll()" value="N" <?php if($TimeOff->repeat == 'N') echo "selected=selected"; ?> ><?php _e('No','appointzilla'); ?></option>
                            <option onclick="showPD()" value="PD" <?php if($TimeOff->repeat == 'PD') echo "selected=selected"; ?> ><?php _e('Particular Date(s)','appointzilla'); ?></option>
                            <option onclick="showDaily()" value="D" <?php if($TimeOff->repeat == 'D') echo "selected=selected"; ?> ><?php _e('Daily','appointzilla'); ?></option>
                            <option onclick="showWeekly()" value="W" <?php if($TimeOff->repeat == 'W') echo "selected=selected"; ?> ><?php _e('Weekly','appointzilla'); ?></option>
                            <option onclick="showBiWeekly()" value="BW" <?php if($TimeOff->repeat == 'BW') echo "selected=selected"; ?> ><?php _e('Bi-Weekly','appointzilla'); ?></option>
                            <option onclick="showMonthly()" value="M" <?php if($TimeOff->repeat == 'M') echo "selected=selected"; ?> ><?php _e('Monthly','appointzilla'); ?></option>
                        </select>
                    </td>
                </tr>
                <tr id="re_days_tr" style="display:none;">
                <th scope="row"><?php _e('Repeat Day(s)','appointzilla'); ?></th>
                    <td><strong>:</strong></td>
                    <?php
                    $diff = NULL;
                    if($TimeOff->repeat == 'PD' || $TimeOff->repeat == 'D' ) {
                        $diff = ( strtotime($TimeOff->end_date) - strtotime($TimeOff->start_date)  ) /60/60/24;
                        $diff = $diff + 1;
                    }
                    if($TimeOff->repeat == 'W') {
                        $diff = ( strtotime($TimeOff->end_date) - strtotime($TimeOff->start_date)  ) /60/60/24/7;
                        $diff = $diff + 1;
                    }
                    if($TimeOff->repeat == 'BW') {
                        $diff = ( strtotime($TimeOff->end_date) - strtotime($TimeOff->start_date)  ) /60/60/24/7;
                    }
                    if($TimeOff->repeat == 'M') {
                        $diff = ( strtotime($TimeOff->end_date) - strtotime($TimeOff->start_date)  ) /60/60/24/31;
                    }
                    ?>
                    <td><input name="re_days" id="re_days" type="text" value="<?php echo esc_attr($diff); ?>" /></td>
                </tr>
                <tr id="re_weeks_tr" style="display:none;">
                    <th scope="row"><?php _e('Repeat Weeks(s)','appointzilla'); ?></th>
                    <td><strong>:</strong></td>
                    <td><input name="re_weeks" id="re_weeks" type="text" value="<?php echo esc_attr($diff); ?>" /></td>
                </tr>
                <tr id="re_biweeks_tr" style="display:none;">
                    <th scope="row"><?php _e('Repeat Bi-Week(s)','appointzilla'); ?></th>
                    <td><strong>:</strong></td>
                    <td><input name="re_biweeks" id="re_biweeks" type="text" value="<?php echo esc_attr($diff/2); ?>" /></td>
                </tr>
                <tr id="re_months_tr" style="display:none;">
                    <th scope="row"><?php _e('Repeat Month(s)','appointzilla'); ?></th>
                    <td><strong>:</strong></td>
                    <td><input name="re_months" id="re_months" type="text" value="<?php echo esc_attr(ceil($diff)); ?>" /></td>
                </tr>
                <tr id="start_date_tr" style="display:none;">
                    <th scope="row"><?php _e('Start Date','appointzilla'); ?></th>
                    <td><strong>:</strong></td>
                    <td><input name="start_date" id="start_date" type="text" value="<?php echo esc_attr($TimeOff->start_date); ?>" /></td>
                </tr>
                <tr id="end_date_tr" style="display:none;">
                    <th scope="row"><?php _e('End Date','appointzilla'); ?></th>
                    <td><strong>:</strong></td>
                    <td><input name="end_date" id="end_date" type="text" value="<?php if($TimeOff->repeat == 'PD')echo esc_attr($TimeOff->end_date); ?>" /></td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Note','appointzilla'); ?></th>
                    <td><strong>:</strong></td>
                    <td><textarea name="note" id="note"><?php echo esc_html($TimeOff->note); ?></textarea></td>
                </tr>
                <tr>
                    <th scope="row">&nbsp;</th>
                    <td>&nbsp;</td>
                    <td>
                        <button name="create" id="create" class="btn btn-success" type="submit"><i class="icon-pencil icon-white"></i> <?php _e('Update','appointzilla'); ?></button>
                        <?php if(isset($_GET['from'])) { ?>
                        <a href="?page=appointment-calendar" class="btn btn-danger"><i class="icon-remove icon-white"></i> <?php _e("Cancel", "appointzilla"); ?></a></td>
                    <?php } else { ?>
                        <a href="?page=timeoff" class="btn btn-danger"><i class="icon-remove icon-white"></i> <?php _e("Cancel", "appointzilla"); ?></a></td>
                    <?php } ?>
                    </td>
                </tr>
            </table>
        </form>
        <?php
    }
?>

<style type='text/css'>
.error{ 
    color:#FF0000;
}
</style>

<!---Insert/update Time-off in db--->
<?php 
    if(isset($_POST['create'])) {
		
		if( !wp_verify_nonce($_POST['appointment_update_timeoff_nonce_check'],'appointment_update_timeoff_nonce_check') ){
			echo '<script>alert("Sorry, your nonce did not verify.");</script>';
			return false;
		}
		
        $update_id = intval( $_POST['update_id'] );
        $FromBack = sanitize_text_field( $_POST['fromback'] );

        // all day event
        if(isset($_POST['allday']))  {
            $allday = 1;
            $start_time = '12:00 AM';
            $end_time = '11:59 PM';
        } else {
            $allday = 0;
            $start_time = sanitize_text_field( $_POST['start_time'] );
            $end_time = sanitize_text_field( $_POST['end_time'] );
        }

        $name = sanitize_text_field( $_POST['name'] );
        $repeat = intval( $_POST['repeat'] );
        $start_date = sanitize_text_field( $_POST['event_date'] );
        $start_date = date("Y-m-d", strtotime($start_date)); //convert format

        //not repeat
        if($repeat == 'N') {
            $end_date =  date("Y-m-d", strtotime($start_date)); //convert format
        }

        //particular day
        if($repeat == 'PD') {
            $start_date = sanitize_text_field( $_POST['start_date'] );
            $start_date = date("Y-m-d", strtotime($start_date)); //convert format
            $end_date = sanitize_text_field( $_POST['end_date'] );
            $end_date =  date("Y-m-d", strtotime($end_date)); //convert format
        }

        //daily event will be  90 days
        if($repeat == 'D') {
            $repeat_days = intval( $_POST['re_days'] );
            $repeat_days = $repeat_days - 1;
            $end_date = strtotime($start_date);
            $end_date = date("Y-m-d", strtotime("+$repeat_days days", $end_date));      //add 3 month
        }

        //weekly event add 1 week
        if($repeat == 'W') {
            $repeat_weeks = intval( $_POST['re_weeks'] );
            $end_date = strtotime($start_date);
            $end_date = date("Y-m-d", strtotime("+$repeat_weeks week", $end_date));     //add 1 week
        }

        //bi-weekly event multiply 2
        if($repeat == 'BW') {
            $repeat_weeks = intval( $_POST['re_biweeks'] );
            $end_date = strtotime($start_date);
            $repeat_weeks = $repeat_weeks * 2;
            $end_date = date("Y-m-d", strtotime("+$repeat_weeks week", $end_date));     //add 1 week
        }
        //monthly event add 1 month
        if($repeat == 'M') {
            $repeat_months = intval( $_POST['re_months'] + 1 );
            $end_date = strtotime($start_date);
            $end_date = date("Y-m-d", strtotime("+$repeat_months months", $end_date)); //add 1 month
        }
        $note = sanitize_text_field( $_POST['note'] );
        $status = "Up-Coming";

        global $wpdb;
        $EventTable = $wpdb->prefix . "ap_events";
        if($wpdb->query($wpdb->prepare("UPDATE `$EventTable` SET `name` = '$name', `allday` = '$allday', `start_time` = '$start_time', `end_time` = '$end_time', `repeat` = '$repeat', `start_date` = '$start_date', `end_date` = '$end_date', `note` = '$note', `status`= '$status' WHERE `id` =%s;",$update_id))) {
        }

        if($FromBack) {
            echo "<script>alert('".__('Time-off successfully updated.','appointzilla')."')</script>";
            echo "<script>location.href='?page=appointment-calendar';</script>";
        } else {
            echo "<script>alert('".__('Time-off successfully updated.','appointzilla')."')</script>";
            echo "<script>location.href='?page=timeoff';</script>";
        }

    }
?>


<!---Delete single time off--->
<?php 
    if(isset($_GET['delete-timeoff'])) {
        global $wpdb;
        $EventTable = $wpdb->prefix."ap_events";
        $DelId = $_GET['delete-timeoff'];
        if($wpdb->query($wpdb->prepare("delete from `$EventTable` where `id` = %s",$DelId))) {
            echo "<script>alert('".__('Time Off deleted successfully.','appointzilla')."')</script>";
            echo "<script>location.href='?page=timeoff';</script>";
        } else {
            echo "<script>location.href='?page=timeoff';</script>";
        }
    }
?>

<script type="text/javascript">
jQuery(document).ready(function () {

    //select all checkbox for multiple delete
    jQuery('#checkbox').click(function() {
        if(jQuery('#checkbox').is(':checked')) {
            jQuery(":checkbox").prop("checked", true);
        } else {
            jQuery(":checkbox").prop("checked", false);
        }
    });

    //Launch Modal Form - hide modal
    jQuery('#close').click(function(){
        jQuery('#TimeOffModal').hide();
    });

    //show modal
    jQuery('#addnewtimeoff').click(function(){
        jQuery('#TimeOffModal').show();
    });

    //Validation -when load for update time-off
    if (jQuery('#allday').is(':checked'))
    {
        jQuery('#start_time').attr("disabled", true);
        jQuery('#end_time').attr("disabled", true);
    }

    //repeat
    var repeat = jQuery("#repeat").val();
    if (repeat == 'N')
    {
        jQuery('#start_date_tr').hide();
        jQuery('#end_date_tr').hide();
        jQuery('#re_days_tr').hide();
        jQuery('#re_weeks_tr').hide();
        jQuery('#re_biweeks_tr').hide();
        jQuery('#re_months_tr').hide();
        jQuery('#event_date_tr').show();
    }

    if (repeat == 'PD') {
        jQuery('#start_date_tr').show();
        jQuery('#end_date_tr').show();
        jQuery('#re_days_tr').hide();
        jQuery('#re_weeks_tr').hide();
        jQuery('#re_biweeks_tr').hide();
        jQuery('#re_months_tr').hide();
        jQuery('#event_date_tr').hide();
    }

    if (repeat == 'D') {
        jQuery('#event_date_tr').show();
        jQuery('#start_date_tr').hide();
        jQuery('#end_date_tr').hide();
        jQuery('#re_days_tr').show();
        jQuery('#re_weeks_tr').hide();
        jQuery('#re_biweeks_tr').hide();
        jQuery('#re_months_tr').hide();
    }

    if (repeat == 'W') {
        jQuery('#start_date_tr').hide();
        jQuery('#end_date_tr').hide();
        jQuery('#re_days_tr').hide();
        jQuery('#re_weeks_tr').show();
        jQuery('#re_biweeks_tr').hide();
        jQuery('#re_months_tr').hide();
        jQuery('#event_date_tr').show();
    }

    if (repeat == 'BW') {
        jQuery('#start_date_tr').hide();
        jQuery('#end_date_tr').hide();
        jQuery('#re_days_tr').hide();
        jQuery('#re_weeks_tr').hide();
        jQuery('#re_biweeks_tr').show();
        jQuery('#re_months_tr').hide();
        jQuery('#event_date_tr').show();
    }

    if (repeat == 'M') {
        jQuery('#start_date_tr').hide();
        jQuery('#end_date_tr').hide();
        jQuery('#re_days_tr').hide();
        jQuery('#re_weeks_tr').hide();
        jQuery('#re_biweeks_tr').hide();
        jQuery('#re_months_tr').show();
        jQuery('#event_date_tr').show();
    }

    // all day event check
    jQuery('#allday').click(function(){
        if (jQuery(this).is(':checked')) {
            jQuery('#start_time').attr("disabled", true);
             hasST = 1;
            jQuery('#end_time').attr("disabled", true);
             hasET = 1;
        } else {
            jQuery('#start_time').attr("disabled", false);
             hasST = 0;
            jQuery('#end_time').attr("disabled", false);
             hasET = 0;
        }
    });

    //ON-FORM SUBMIT -start/end times and dates
    jQuery('#create').click(function() {
        jQuery(".error").hide();

        //name
        var nameVal = jQuery("#name").val();
        if(nameVal == ''){
            jQuery("#name").after('<span class="error"><br><strong><?php _e('This field required.','appointzilla'); ?></strong></span>');
            return false;
        }

        //if all-day is not checked then check start/ent time required
        if (!jQuery('#allday').is(':checked')) {
            //start time
            var start_time = jQuery("#start_time").val();
            if(start_time == '') {
                jQuery("#start_time").after('<span class="error"><br><strong><?php _e('This field required.','appointzilla'); ?></strong></span>');
                return false;
            }

            //end time
            var end_time = jQuery("#end_time").val();
            if(end_time == '') {
                jQuery("#end_time").after('<span class="error"><br><strong><?php _e('This field required.','appointzilla'); ?></strong></span>');
                return false;
            }


            if(start_time == end_time) {
                jQuery("#start_time").after('<span class="error"><br><strong><?php _e("Start-time and End-time cant be equal.",'appointzilla'); ?></strong></span>');
                jQuery("#end_time").after('<span class="error"><br><strong><?php _e("Start-time and End-time cant be equal.",'appointzilla'); ?></strong></span>');
                return false;
            }

            //convert both time into timestamp
            var stt = new Date("October 13, 2013 " + start_time);
            stt = stt.getTime();

            var endt = new Date("October 13, 2013 " + end_time);
            endt = endt.getTime();
            console.log("Time1: "+ stt + " Time2: " + endt);

            if(stt > endt) {
                jQuery("#start_time").after('<span class="error"><br><strong><?php _e("Start-time must be smaller then End-time.",'appointzilla'); ?></strong></span>');
                jQuery("#end_time").after('<span class="error"><br><strong><?php _e("End-time must be bigger then Start-time.",'appointzilla'); ?></strong></span>');
                return false;
            }
        }

        //date
        var event_date = jQuery("#event_date").val();
        if(event_date == '') {
            jQuery("#event_date").after('<span class="error"><br><strong><?php _e('This field required.','appointzilla'); ?></strong></span>');
            return false;
        }

        //repeat
        var repeat = jQuery("#repeat").val();

        // PARTICULAR DATES
        if(repeat == 'PD'){
            var start_date = jQuery("#start_date").val();
            if(start_date == '') {
                jQuery("#start_date").after('<span class="error"><br><strong><?php _e('This field required.','appointzilla'); ?></strong></span>');
                return false;
            }
            var end_date = jQuery("#end_date").val();
            if(end_date == '') {
                jQuery("#end_date").after('<span class="error"><br><strong><?php _e('This field required.','appointzilla'); ?></strong></span>');
                return false;
            }
        }

        //DAILY
        if(repeat == 'D'){
            var re_days = jQuery("#re_days").val();
            if(re_days == '') {
                jQuery("#re_days").after('<span class="error"><br><strong><?php _e('This field required.','appointzilla'); ?></strong></span>');
                return false;
            }
        }

        //WEEKLY
        if(repeat == 'W'){
            var re_weeks = jQuery("#re_weeks").val();
            if(re_weeks == '') {
                jQuery("#re_weeks").after('<span class="error"><br><strong><?php _e('This field required.','appointzilla'); ?></strong></span>');
                return false;
            }
        }

        //BiWEEKLY
        if(repeat == 'BW'){
            var re_biweeks = jQuery("#re_biweeks").val();
            if(re_biweeks == '') {
                jQuery("#re_biweeks").after('<span class="error"><br><strong><?php _e('This field required.','appointzilla'); ?></strong></span>');
                return false;
            }
        }

        //MONTHLY
        if(repeat == 'M'){
            var re_months = jQuery("#re_months").val();
            if(re_months == '') {
                jQuery("#re_months").after('<span class="error"><br><strong><?php _e('This field required.','appointzilla'); ?></strong></span>');
                return false;
            }
        }
    });
});

jQuery(function(){
    //load date and time picker
    jQuery('#start_time').timepicker({
        ampm: true,
        timeFormat: 'hh:mm TT',
        stepMinute: 5
    });

    jQuery('#end_time').timepicker({
        ampm: true,
        timeFormat: 'hh:mm TT',
        stepMinute: 5
    });

    jQuery('#start_date').datepicker({
        minDate: 0,
        dateFormat: 'dd-mm-yy'
    });

    jQuery('#end_date').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: 0
    });

    jQuery('#event_date').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: 0
    });
});

function repeatday() {
    var repeat = jQuery("#repeat").val();
    if(repeat == "PD"){ showPD(); }
    if(repeat == "N") { hideAll(); }
    if(repeat == "D") { showDaily(); }
    if(repeat == "W") { showWeekly(); }
    if(repeat == "BW"){ showBiWeekly(); }
    if(repeat == "M") { showMonthly(); }
}


function hideAll() {
    jQuery('#start_date_tr').hide();
    jQuery('#end_date_tr').hide();
    jQuery('#re_days_tr').hide();
    jQuery('#re_weeks_tr').hide();
    jQuery('#re_biweeks_tr').hide();
    jQuery('#re_months_tr').hide();
    jQuery('#event_date_tr').show();
}

function showPD() {
    jQuery('#start_date_tr').show();
    jQuery('#end_date_tr').show();
    jQuery('#re_days_tr').hide();
    jQuery('#re_weeks_tr').hide();
    jQuery('#re_biweeks_tr').hide();
    jQuery('#re_months_tr').hide();
    jQuery('#event_date_tr').hide();
}

function showWeekly() {
    jQuery('#start_date_tr').hide();
    jQuery('#end_date_tr').hide();
    jQuery('#re_days_tr').hide();
    jQuery('#re_weeks_tr').show();
    jQuery('#re_biweeks_tr').hide();
    jQuery('#re_months_tr').hide();
    jQuery('#event_date_tr').show();
}

function showBiWeekly() {
    jQuery('#start_date_tr').hide();
    jQuery('#end_date_tr').hide();
    jQuery('#re_days_tr').hide();
    jQuery('#re_weeks_tr').hide();
    jQuery('#re_biweeks_tr').show();
    jQuery('#re_months_tr').hide();
    jQuery('#event_date_tr').show();
}

function showMonthly() {
    jQuery('#start_date_tr').hide();
    jQuery('#end_date_tr').hide();
    jQuery('#re_days_tr').hide();
    jQuery('#re_weeks_tr').hide();
    jQuery('#re_biweeks_tr').hide();
    jQuery('#re_months_tr').show();
    jQuery('#event_date_tr').show();
}

function showDaily() {
    jQuery('#start_date_tr').hide();
    jQuery('#end_date_tr').hide();
    jQuery('#re_days_tr').show();
    jQuery('#re_weeks_tr').hide();
    jQuery('#re_biweeks_tr').hide();
    jQuery('#re_months_tr').hide();
    jQuery('#event_date_tr').show();
}
</script>