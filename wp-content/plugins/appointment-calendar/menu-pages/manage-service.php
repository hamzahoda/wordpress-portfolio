<?php 
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}
?>
<div style="background:#C3D9FF; margin-bottom:10px; padding-left:10px;"><h3><?php _e("Services", "appointzilla"); ?></h3></div>
<!-- manage service form -->	
<div class="bs-docs-example tooltip-demo">
    <?php global $wpdb;
    if(isset($_GET['sid'])) {
        $sid = intval( $_GET['sid'] );
        $ServiceTable = $wpdb->prefix . "ap_services";
        $ServiceDetails = $wpdb->get_row($wpdb->prepare("SELECT * FROM `$ServiceTable` WHERE `id` =%s",$sid));
        $ServiceDetails->category_id;
    } else {
        $ServiceDetails = NULL;
    } ?>
    <form action="" method="post" name="manageservice">
		<?php wp_nonce_field('appointment_create_service_nonce_check','appointment_create_service_nonce_check'); ?>
        <table width="100%" class="table" >
            <tr>
                <th width="18%" scope="row"><?php _e("Name", "appointzilla"); ?></th>
                <td width="5%">&nbsp;</td>
                <td width="77%"><input name="name" type="text" id="name"  value="<?php if($ServiceDetails) { echo esc_attr($ServiceDetails->name); } ?>" class="inputheight"/>&nbsp;<a href="#" rel="tooltip" title="<?php _e("Service Name", "appointzilla"); ?>" ><i class="icon-question-sign"></i></a></td>
            </tr>
            <tr>
                <th scope="row"><strong><?php _e("Description", "appointzilla"); ?></strong></th>
                <td>&nbsp;</td>
                <td><textarea name="desc" id="desc"><?php if($ServiceDetails) { echo $ServiceDetails->desc; } ?></textarea>&nbsp;<a href="#" rel="tooltip" title="<?php _e("Service Description", "appointzilla"); ?>" ><i class="icon-question-sign"></i></a>
            </td>
            </tr>
            <tr>
                <th scope="row"><strong><?php _e("Duration", "appointzilla"); ?></strong></th>
                <td>&nbsp;</td>
                <td><input name="Duration" type="text" id="Duration"  value="<?php if($ServiceDetails) { echo esc_attr($ServiceDetails->duration); } ?>" class="inputheight"/>&nbsp;<a href="#" rel="tooltip" title="<?php _e("Service Duration.<br>Enter Numeric Value.<br>Eg: 5, 10, 15, 30, 60", "appointzilla"); ?>" ><i class="icon-question-sign"></i> </a></td>
            </tr>
            <tr>
                <th scope="row"><strong><?php _e("Duration Unit", "appointzilla"); ?></strong></th>
                <td>&nbsp;</td>
                <td>
                    <select id="durationunit" name="durationunit">
                    <option value="0"><?php _e("Select Duration's Unit", "appointzilla"); ?></option>
                    <option value="minute" <?php if($ServiceDetails) { if($ServiceDetails->unit == 'minute') echo "selected"; } ?> ><?php _e("Minute(s)", "appointzilla"); ?></option>
                    </select>&nbsp;<a href="#" rel="tooltip" title="<?php _e("Duration Unit", "appointzilla"); ?>" ><i class="icon-question-sign"></i></a>
                </td>
            </tr>
            <tr>
                <th scope="row"><strong><?php _e("Cost", "appointzilla"); ?></strong></th>
                <td>&nbsp;</td>
                <td><input name="cost" type="text" id="cost" value="<?php if($ServiceDetails) { echo esc_attr($ServiceDetails->cost); } ?>" class="inputheight"/>&nbsp;<a href="#" rel="tooltip" title="<?php _e("Service Cost<br>Enter Numeric Value<br> Eg: 5 , 10, 25, 50, 100, 150", "appointzilla"); ?>" ><i class="icon-question-sign"></i></a>
                </td>
            </tr>
            <tr>
                <th scope="row"><strong><?php _e("Availability", "appointzilla"); ?></strong></th>
                <td>&nbsp;</td>
                <td>
                    <select id="availability" name="availability">
                        <option value="0"><?php _e("Select Service Availability", "appointzilla"); ?></option>
                        <option value="yes" <?php if($ServiceDetails) { if($ServiceDetails->availability == 'yes') echo "selected"; } ?> ><?php _e("Yes", "appointzilla"); ?></option>
                        <option value="no" <?php if($ServiceDetails) { if($ServiceDetails->availability == 'no') echo "selected"; } ?> ><?php _e("No", "appointzilla"); ?></option>
                    </select>&nbsp;<a href="#" rel="tooltip" title="<?php _e("Service Availability", "appointzilla"); ?>" ><i class="icon-question-sign"></i></a>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php _e("Category", "appointzilla"); ?></th>
                <td>&nbsp;</td>
                <td>
                    <select id="category" name="category">
                        <option value="0"><?php _e("Select Category", "appointzilla"); ?></option>
                        <?php //get all category list
                            $table_name = $wpdb->prefix . "ap_service_category";
                            $service_category = $wpdb->get_results($wpdb->prepare("select * from $table_name where id > %d",null));
                            foreach($service_category as $gruopname) { ?>
                                <option value="<?php echo esc_attr($gruopname->id); ?>"
                                    <?php if($ServiceDetails) { if($ServiceDetails->category_id == $gruopname->id) echo "selected";  ?><?php if(isset($_GET['gid']) == $gruopname->id) echo "selected"; } ?> >
                                    <?php echo $gruopname->name; ?>
                                </option>
                            <?php } ?>
                        </select>&nbsp;<a href="#" rel="tooltip" title="<?php _e("Service Category", "appointzilla"); ?>" ><i class="icon-question-sign"></i></a>
                </td>
            </tr>
            <tr>
                <th scope="row">&nbsp;</th>
                <td>&nbsp;</td>
                <td>
                    <?php if(isset($_GET['sid'])) { ?>
                    <button id="saveservice" type="submit" class="btn btn-success" name="updateservice"><i class="icon-pencil icon-white"></i> <?php _e("Update", "appointzilla"); ?></button>
                    <?php } else {?>
                    <button id="saveservice" type="submit" class="btn btn-success" name="saveservice"><i class="icon-ok icon-white"></i> <?php _e("Create", "appointzilla"); ?></button>
                    <?php } ?>
                    <a href="?page=service" class="btn btn-danger"><i class="icon-remove icon-white"></i> <?php _e("Cancel", "appointzilla"); ?></a>
                </td>
            </tr>
      </table>
    </form>
</div>

<?php 
//inserting a service
if(isset($_POST['saveservice'])) {
	
	if( !wp_verify_nonce($_POST['appointment_create_service_nonce_check'],'appointment_create_service_nonce_check') ){
			echo '<script>alert("Sorry, your nonce did not verify.");</script>';
			return false;
		}
		
    $servicename = sanitize_text_field( $_POST['name'] );
    $desc = sanitize_text_field( $_POST['desc'] );
    $Duration = intval( $_POST['Duration'] );
    $durationunit = sanitize_text_field( $_POST['durationunit'] );
    $cost = intval( $_POST['cost'] );
    $availability = sanitize_text_field( $_POST['availability'] );
    $category = intval( $_POST['category'] );
    $ServiceTable = $wpdb->prefix . "ap_services";
    if($wpdb->query($wpdb->prepare("INSERT INTO `$ServiceTable` ( `name` , `desc` , `duration` , `unit` , `cost` , `availability`, `category_id` ) VALUES ('$servicename', '$desc', '$Duration', '$durationunit', '$cost', '$availability', %s);",$category))) {
        echo "<script>alert('". __('New service successfully created.', 'appointzilla') ."');</script>";
    }
    echo "<script>location.href='?page=service';</script>";
}

//update a service
if(isset($_POST['updateservice'])) {
	
	if( !wp_verify_nonce($_POST['appointment_create_service_nonce_check'],'appointment_create_service_nonce_check') ){
			echo '<script>alert("Sorry, your nonce did not verify.");</script>';
			return false;
		}
		
    $sid = intval( $_GET['sid'] );
    $ServiceName = sanitize_text_field( $_POST['name'] );
    $desc = sanitize_text_field( $_POST['desc'] );
    $Duration = intval( $_POST['Duration'] );
    $durationunit = sanitize_text_field( $_POST['durationunit'] );
    $cost = intval( $_POST['cost'] );
    $availability = sanitize_text_field( $_POST['availability'] );
    $category = intval( $_POST['category'] );
    $ServiceTable = $wpdb->prefix . "ap_services";
    $wpdb->query($wpdb->prepare("UPDATE `$ServiceTable` SET `name` = '$ServiceName', `desc` = '$desc', `duration` = '$Duration', `unit` = '$durationunit', `cost` = '$cost', `availability` = '$availability', `category_id` = '$category' WHERE `id` = %s;",$sid));
    echo "<script>alert('". __('Service successfully updated.', 'appointzilla') ."');</script>";
    echo "<script>location.href='?page=service';</script>";
} ?>

<style type="text/css">
    .error{  color:#FF0000; }
    input.inputheight { height:30px; }
</style>

<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('#saveservice').click(function() {
            jQuery('.error').hide();
            var name = jQuery("input#name").val();
            if (name == "") {
                jQuery("#name").after('<span class="error">&nbsp;<br><strong><?php _e("Name cannot be blank.", "appointzilla"); ?></strong></span>');
                return false;
            } else {
                var name = isNaN(name);
                if(name == false) {
                    jQuery("#name").after('<span class="error">&nbsp;<br><strong><?php _e("Invalid name.", "appointzilla"); ?></strong></span>');
                    return false;
                }
            }

            var desc = jQuery("textarea#desc").val();
            if (desc == "") {
                jQuery("#desc").after('<span class="error">&nbsp;<br><strong><?php _e('Description  cannot be blank.','appointzilla');?></strong></span>');
                return false;
            }

            var Duration = jQuery("input#Duration").val();
            if (Duration == "") {
                jQuery("#Duration").after('<span class="error">&nbsp;<br><strong><?php _e('Duration cannot be blank.','appointzilla');?></strong></span>');
                return false;
            } else if(Duration != 0) {
                var Duration = isNaN(Duration);
                if(Duration == true) {
                    jQuery("#Duration").after('<span class="error">&nbsp;<br><strong><?php _e('Invalid Duration.','appointzilla');?></strong></span>');
                    return false;
                }  else {
                    var Duration = jQuery("input#Duration").val();
                    var testvalue = Duration%5;
                    if(testvalue !=0) {
                        jQuery("#Duration").after('<span class="error">&nbsp;<br><strong><?php _e('Duration will be in multiple of 5, like as: 5, 10, 15, 20, 25.','appointzilla');?></strong></span>');
                        return false;
                    }
                }
            } else {
                jQuery("#Duration").after('<span class="error">&nbsp;<br><strong><?php _e('Duration will be in multiple of 5, like as: 5, 10, 15, 20, 25.','appointzilla');?></strong></span>');
                return false;
            }

            var durationunit = jQuery('#durationunit').val();
            if(durationunit == 0) {
                jQuery("#durationunit").after('<span class="error">&nbsp;<br><strong><?php _e("Select Durations Unit.", "appointzilla"); ?></strong></span>');
                return false;
            }

            var cost = jQuery("input#cost").val();
            if (cost == "") {
                jQuery("#cost").after('<span class="error">&nbsp;<br><strong><?php _e("Cost cannot be blank.", "appointzilla"); ?></strong></span>');
                return false;
            } else {
                var cost = isNaN(cost);
                if(cost == true) {
                    jQuery("#cost").after('<span class="error">&nbsp;<br><strong><?php _e("Invalid cost.", "appointzilla"); ?></strong></span>');
                    return false;
                }
            }

            var availability = jQuery('#availability').val();
            if(availability == 0) {
                jQuery("#availability").after('<span class="error">&nbsp;<br><strong><?php _e("Select availability.", "appointzilla"); ?></strong></span>');
                return false;
            }

            var category = jQuery('#category').val();
            if(category == 0) {
                jQuery("#category").after('<span class="error">&nbsp;<br><strong><?php _e("Select category.", "appointzilla"); ?></strong></span>');
                return false;
            }
        });
    });
</script>