<?php

/*
Plugin Name: Slippy Slider - Responsive Touch Navigation Slider
Plugin URI: http://wpicode.com/slippy-slider
Description: jQuery content slider with touch-based navigation and responsive layout.
Author: Dimitar Atanasov
Version: 2.0
Author URI: http://wpicode.com/meet-the-team
Tags: jquery, content slider, touch-based navigation, responsive layout
*/


global $wpdb, $wp_version;
define("WP_ssjp_TABLE", $wpdb->prefix . "ssjp");

function slippy_slider_init($slider, $type, $s_width, $s_height) 
{
	global $wpdb;
	$ssjp_width = get_option('ssjp_width_'.$slider);
	if($s_width=='300px' && $ssjp_width!='') {$s_width=$ssjp_width; }
	$ssjp_height = get_option('ssjp_height_'.$slider);
	if($s_height=='100%' && $ssjp_height!='') {$s_height=$ssjp_height; }
	
	
	$ssjp_category = $slider;
	
	
	$ssjp_animation = get_option('ssjp_animation'); if($ssjp_animation=='') $ssjp_animation='none';
	$ssjp_autoplay = get_option('ssjp_autoplay_'.$ssjp_category);
	
	if($cat != "" ) { $ssjp_category=$cat; } if($type == "" ) { $type='widget'; }
	$ssjp_category=$slider; $cat=$slider; 

	$sSql = "select * from ".WP_ssjp_TABLE." where 1=1 and ssjp_status='YES'";
	$sSql = $sSql . " and ssjp_category LIKE '".$ssjp_category."'";
	$sSql = $sSql . " ORDER BY ssjp_order"; 
	$ssjp_data = $wpdb->get_results($sSql);
	$ssjp_num_data = $wpdb->query($sSql); 

	$slider = $slider.rand(10000,99999);
	?>
	<?php if($_REQUEST['pid']=='' || $_REQUEST['pid']==NULL){ ?>
	<script>

var snameDefault = '<?php echo $slider; ?>';

jQuery(document).ready(function() {
		var container = jQuery('.slippy-slider-<?php echo $slider; ?>').width();
slippy_draggable(snameDefault);
<?php if($ssjp_autoplay>0){ ?>  slippy_do_timer( snameDefault,<?php echo intval($ssjp_autoplay.'000'); ?>); <?php } ?>
jQuery("#ssjp_count<?php echo $slider; ?>").val('1');
jQuery('.ssjp_first').css('left','0');

 jQuery('.slippy_slider_description').each(function( index ) {
var leftpos =  jQuery(this).find('.ss_left').attr('id'); leftpos = parseInt(leftpos.replace('left-','')); 
var toppos = jQuery(this).find('.ss_top').attr('id');
toppos = parseInt(toppos.replace('top-','')); 
startleft= leftpos/container*100;  starttop= toppos/container*100;  if(startleft>45){ jQuery(this).css({'left':'auto','right':'3%'});} else {jQuery(this).css('left',startleft+'%');}
 jQuery(this).css('top',starttop+'%');
});


		
});


    </script>
	<?php } ?>
	 <style type="text/css">
	.tu-regimage img {
		float: right;
		vertical-align:bottom;
		padding: 3px;
	}
	.ssjp_navigation {position:relative; }
	
	.ssjp_prev, .ssjp_next { background:url('<?php echo plugins_url('images/navigation-20px.png', __FILE__); ?>'); opacity:0.5; width:20px; height:20px; position:absolute; cursor:pointer; z-index:15;} 
	.ssjp_prev:hover, .ssjp_next:hover {opacity:0.9;}
	.ssjp_next {background-position:20px 0 !important; left:auto; right:7px; top:40%;  } .ssjp_prev { top:40%; left:7px;}
	.tu-arrow {background:url('<?php echo plugins_url('images/navigation-20px.png', __FILE__); ?>');  width:20px; height:10px; display:block; position:absolute; bottom:-10px; left:20px; }
<?php if($type == "page" ) {  $ssjp_width=''; ?> .ssjp_navigation {display:none; } <?php } ?>
	</style>
    <?php
	
	if ( ! empty($ssjp_data) ) 
	{
	
			$totalPosts = count($ssjp_data);
		$slideWidth = 100/$totalPosts;
		$ssjp_count = 0; 
		$totalWidth =$totalPosts*100; $totalWidth .= '%'; 
		$sscode = "";
		foreach ( $ssjp_data as $ssjp_data ) 
		{
		
			$ssjp_path = mysql_real_escape_string(trim($ssjp_data->ssjp_path));
			$ssjp_link = mysql_real_escape_string(trim($ssjp_data->ssjp_link));
			$ssjp_target = mysql_real_escape_string(trim($ssjp_data->ssjp_target));
			$ssjp_button = trim($ssjp_data->ssjp_button);
			$ssjp_desc = $ssjp_data->ssjp_desc;
			$ssjp_xy = $ssjp_data->ssjp_xy; if($ssjp_xy==''){ $ssjp_xy="50|50|250|90";}  
			$ssjp_xy_arr=explode("|",$ssjp_xy);
			$ssjp_xy_style='left: '.$ssjp_xy_arr[0].'px; top: '.$ssjp_xy_arr[1].'px; width: 50%; ';
		
				
			$ssjp_desc= str_replace("\\", "", $ssjp_desc);
			
				$ssjp_countP =$ssjp_count+1;
			

		if($type == "widget" ) {$ssjp_div_opacity = ($ssjp_count==0)?'padding-left:0; ':'padding-left:'.$ssjp_count.'; '; } 
		else { $ssjp_div_opacity = ($ssjp_count==0)?'padding-left:0; ':'padding-left:'.$ssjp_count.'; ';} if($ssjp_count==0) $ssjp_class=" ssjp_first"; else $ssjp_class="";
				$sscode = $sscode . "<div class='ssjp_div ".$ssjp_class."' id='ssjp_div_".$ssjp_countP."' style='position:relative;padding:1px 0px 1px 0px; float:left; max-height:".$s_height."; overflow:hidden; width: ".$slideWidth."%;'>"; 
			
			if($ssjp_count==0){ $ssjp_desc_style=" display:inherit; "; } else { $ssjp_desc_style=" display:none; "; }
			if($ssjp_desc <> "" )
			{
				$sscode = $sscode . '<div class="ssjp_wrap">
									<div class="ssjp_desc slippy_slider_description" id="ssjp_desc_'.$ssjp_countP.'" style="'.$ssjp_desc_style.$ssjp_xy_style.'" >'.$ssjp_desc.'
									<span class="ss_left" id="left-'.$ssjp_xy_arr[0].'"></span><span class="ss_top" id="top-'.$ssjp_xy_arr[1].'"></span></div>
									</div>';	
			
			}
			
			
			
					$sscode .= '<div class="slider-one-image-section" style="position:relative; ">
		<img src="'.$ssjp_path.'" style="width:100%;" />';
		$sscode .= '</div>';	

			
			$sscode = $sscode . "</div>";
			if($ssjp_count==0){ $nav_span_style= ' background:#369; ';} else { $nav_span_style= ' ';}
			$s_nav .='<span onclick="jQuery(\'#ssjp_count'.$slider.'\').val(\''.$ssjp_count.'\');slippy_next(\'none\',\'\',\''.$slider.'\')" style="'.$nav_span_style.'"></span>';
			
			
			$ssjp_x = $ssjp_x . "TP[$ssjp_count] = '<div class=\'ssjp_div\' style=\'padding:1px 0px 1px 0px;\'>$TPjsjs</div>'; ";	
			$ssjp_count++;
		}
		
		
		$s_width = $totalWidth;

		?>
		<div id="slippy-slider-container" class="slippy-slider-<?php echo $slider; ?>">
		  <div class="holder_<?php echo $slider; ?>" style="max-height:<?php echo $s_height; ?>; width:<?php echo $s_width; ?>; text-align:left;vertical-align:middle;text-decoration: none;overflow: hidden; position: relative; margin-left: 3px; " id="s_holder">
			
			 <div id="s_draggable"  class="slippy_draggable" style="position:relative;"><?php echo $sscode; ?>
			
			 </div>
			 </div>
			<div class="ssjp_prev" onclick="slippy_prev('none','','<?php echo $slider; ?>')"></div>
			<div class="ssjp_next" onclick="slippy_next('none','','<?php echo $slider; ?>')"></div>
			
		 
			<div id="s_navigation"><div><?php echo $s_nav; ?></div></div>
		  <input type="hidden" class="ssjp_count" id="ssjp_count<?php echo $slider; ?>" value="1"/> <input type="hidden" id="ssjp_count_all<?php echo $slider; ?>" value="<?php echo $ssjp_count ?>" />
		 
		</div>



<?php
	}
	else
	{
		echo "<div style='padding-bottom:5px;padding-top:5px;'>Nothing found.</div>";
	}
	
}

function slippy_slider_install() 
{
	
	global $wpdb;
	$datetime= date('Y-m-d H:i:s');
	if($wpdb->get_var("show tables like '". WP_ssjp_TABLE . "'") != WP_ssjp_TABLE) 
	{
		$sSql = "CREATE TABLE IF NOT EXISTS `". WP_ssjp_TABLE . "` (";
		$sSql = $sSql . "`ssjp_id` INT NOT NULL AUTO_INCREMENT ,";
		$sSql = $sSql . "`ssjp_path` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,";
		$sSql = $sSql . "`ssjp_link` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,";
		$sSql = $sSql . "`ssjp_target` VARCHAR( 50 ) NOT NULL ,";
		$sSql = $sSql . "`ssjp_button` VARCHAR( 200 ) NOT NULL ,";
		$sSql = $sSql . "`ssjp_desc` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,";
		$sSql = $sSql . "`ssjp_order` INT NOT NULL ,";
		$sSql = $sSql . "`ssjp_status` VARCHAR( 10 ) NOT NULL ,";
		$sSql = $sSql . "`ssjp_category` VARCHAR( 100 ) NOT NULL ,";
		$sSql = $sSql . "`ssjp_xy` VARCHAR( 100 ) NOT NULL ,";
		$sSql = $sSql . "`ssjp_date` DATETIME NOT NULL ,";
		$sSql = $sSql . "PRIMARY KEY ( `ssjp_id` )";
		$sSql = $sSql . ")";
		$wpdb->query($sSql);

	}
	
		$sSqlS = "INSERT INTO `". WP_ssjp_TABLE . "` (`ssjp_path`, `ssjp_link`, `ssjp_target` , `ssjp_button` , `ssjp_desc` , `ssjp_order` , `ssjp_status` , `ssjp_category` , `ssjp_xy`, `ssjp_date`)"; 
		$sSql = $sSqlS . "VALUES ('".plugins_url('images/slide1.jpg', __FILE__)."','http://wpicode.com/store/','_blank','Get Now','<h2 style=\\\"color: black; \\\">Touch Navigation for Mobile and Desktop</h2><br><a href=\\\"http://wpicode.com/\\\" target=\\\"_blank\\\" class=\\\"ssjp_button ssjp_button_blue ssjp_button_large clearfix\\\">Get Now</a>','1', 'YES', 'Homepage','475|52|529|118', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		$sSql = $sSqlS . "VALUES ('".plugins_url('images/slide2.jpg', __FILE__)."','http://wpicode.com/store/','_blank','Small Button','<h2 style=\\\"color: black; \\\">HTML Content</h2><h2 style=\\\"color:#555; font-size: 18px;\\\">with Headlines and Buttons HTML Generators</h2><br><a href=\\\"http://wpicode.com/store/\\\" target=\\\"_blank\\\" class=\\\"ssjp_button ssjp_button_black ssjp_button_small clearfix\\\">Small Button</a>','2', 'YES', 'Homepage','73|66|387|90', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		$sSql = $sSqlS . "VALUES ('".plugins_url('images/slide3.jpg', __FILE__)."','http://wpicode.com/wordpress-plugins/slippy-slider','_blank','Read More','<h2 style=\\\"color: black;\\\">Autoplay Slideshow</h2><h2 style=\\\"color:#555; font-size: 18px;\\\">with other Options and Simple backend</h2><a href=\\\"http://wpicode.com/wordpress-plugins/slippy-slider\\\" target=\\\"_blank\\\" class=\\\"ssjp_button ssjp_button_black ssjp_button_small clearfix\\\">Read More</a>','3', 'YES', 'Homepage','616|68|356|90', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		$sSql = $sSqlS . "VALUES ('".plugins_url('images/fin.jpg', __FILE__)."','http://wpicode.com/wordpress-plugins/slippy-slider','_blank','Learn More','<iframe width=\\\"640\\\" height=\\\"360\\\" src=\\\"http://www.youtube.com/embed/UxxajLWwzqY\\\" frameborder=\\\"0\\\" allowfullscreen ></iframe>','4', 'YES', 'Homepage','71|22|912|246', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
	//add_option('ssjp_button', "What our clients say");


	add_option('ssjp_height', "9999");
	add_option('ssjp_category', "Homepage");
	add_option('ssjp_height_Homepage', "300px");
	add_option('ssjp_width_Homepage', "1024px");
	
	add_option('ssjp_animation', "none");
	add_option('ssjp_autoplay', "15");
}

function slippy_slider_widget($args) 
{
	extract($args);
	echo $before_widget . $before_title;
	echo get_option('ssjp_button');
	echo $after_title;
	slippy_slider_init('all','widget');
	echo $after_widget;
}

function slippy_slider_admin_options() 
{
	?>
<div class="wrap">
  <?php
  	global $wpdb;
    $title = __('Slippy Slider');
    $mainurl = get_option('siteurl')."/wp-admin/admin.php?page=slippy-slider/slippy-slider.php";
    $DID=@$_GET["DID"];
    $AC=@$_GET["AC"];
	$SID=@$_REQUEST["SID"];
	$T=@$_GET["T"];
	$SLIDER=@$_GET["SLIDER"];
    $submittext = "Insert silde";
	$datetime= date('Y-m-d H:i:s');
	if($AC != "DEL" and trim($_POST['ssjp_path']) !=NULL)
    {
		$catSql=($_POST['ssjp_category_new']!='')?mysql_real_escape_string(trim($_POST['ssjp_category_new'])):mysql_real_escape_string(trim($_POST['ssjp_category']));
			if($_POST['ssjp_id'] == "" )
			{
					$sql = "insert into ".WP_ssjp_TABLE.""
					. " set `ssjp_path` = '" . mysql_real_escape_string(trim($_POST['ssjp_path']))
					. "', `ssjp_link` = '" . mysql_real_escape_string(trim($_POST['ssjp_link']))
					. "', `ssjp_target` = '" . mysql_real_escape_string(trim($_POST['ssjp_target']))
					. "', `ssjp_button` = '" . mysql_real_escape_string(trim($_POST['ssjp_button']))
					. "', `ssjp_desc` = '" . mysql_real_escape_string(strip_tags($_POST['ssjp_desc'], '<iframe><p><a><span><br><div><h1><h2><h3><h4><h5><h6><h7><h8>'))
					. "', `ssjp_order` = '" . mysql_real_escape_string(trim($_POST['ssjp_order']))
					. "', `ssjp_status` = '" . mysql_real_escape_string(trim($_POST['ssjp_status']))
					. "', `ssjp_category` = '" . $catSql
					. "', `ssjp_xy` = '" . mysql_real_escape_string(trim($_POST['ssjp_xy']))
					. "', `ssjp_date` = '" . $datetime
					. "'";	
			}
			else
			{
					$sql = "update ".WP_ssjp_TABLE.""
					. " set `ssjp_path` = '" . mysql_real_escape_string(trim($_POST['ssjp_path']))
					. "', `ssjp_link` = '" . mysql_real_escape_string(trim($_POST['ssjp_link']))
					. "', `ssjp_target` = '" . mysql_real_escape_string(trim($_POST['ssjp_target']))
					. "', `ssjp_button` = '" . mysql_real_escape_string(trim($_POST['ssjp_button']))
					. "', `ssjp_desc` = '" .  mysql_real_escape_string(strip_tags($_POST['ssjp_desc'], '<iframe><p><a><span><br><div><h1><h2><h3><h4><h5><h6><h7><h8>'))
					. "', `ssjp_order` = '" . mysql_real_escape_string(trim($_POST['ssjp_order']))
					. "', `ssjp_status` = '" . mysql_real_escape_string(trim($_POST['ssjp_status']))
					. "', `ssjp_category` = '" .$catSql
					. "', `ssjp_xy` = '" . mysql_real_escape_string(trim($_POST['ssjp_xy']))
					. "' where `ssjp_id` = '" . $_POST['ssjp_id'] 
					. "'";	
			}
			$wpdb->get_results($sql);
    }
	
    if($AC=="DEL" && $DID > 0)
    {
        $wpdb->get_results("delete from ".WP_ssjp_TABLE." where ssjp_id=".$DID);
		
    }
     if($AC=="DEL" && $SLIDER != '')
    {
        $wpdb->get_results("delete from ".WP_ssjp_TABLE." where ssjp_category='".$SLIDER."' ");
		
    }
    if($DID<>"" and $AC <> "DEL")
    {
        $data = $wpdb->get_results("select * from ".WP_ssjp_TABLE." where ssjp_id=$DID limit 1");
        if ( empty($data) ) 
        {
           echo "<div id='message' class='error'><p>No data available.</p></div>";
           return;
        }
        $data = $data[0];
        if ( !empty($data) ) $ssjp_id_x = htmlspecialchars(stripslashes($data->ssjp_id)); 
		if ( !empty($data) ) $ssjp_path_x = htmlspecialchars(stripslashes($data->ssjp_path)); 
        if ( !empty($data) ) $ssjp_link_x = htmlspecialchars(stripslashes($data->ssjp_link));
		if ( !empty($data) ) $ssjp_target_x = htmlspecialchars(stripslashes($data->ssjp_target));
        if ( !empty($data) ) $ssjp_button_x = htmlspecialchars(stripslashes($data->ssjp_button));
		if ( !empty($data) ) $ssjp_desc_x = $data->ssjp_desc;
		if ( !empty($data) ) $ssjp_order_x = htmlspecialchars(stripslashes($data->ssjp_order));
		if ( !empty($data) ) $ssjp_status_x = htmlspecialchars(stripslashes($data->ssjp_status));
		if ( !empty($data) ) $ssjp_category_x = htmlspecialchars(stripslashes($data->ssjp_category));
		if ( !empty($data) ) $ssjp_xy_x = htmlspecialchars(stripslashes($data->ssjp_xy)); else $ssjp_xy_x = '50|50|250|90';
		$ssjp_desc_x= str_replace("\\", "", $ssjp_desc_x);
		$ssjp_xy_arr=explode("|",$ssjp_xy_x);
			$ssjp_xy_style='left: '.$ssjp_xy_arr[0].'px; top: '.$ssjp_xy_arr[1].'px; width: '.$ssjp_xy_arr[2].'px; height: '.$ssjp_xy_arr[3].'px; ';
		
        $submittext = "Update silde";
    }
		$sSql1 = "select ssjp_category from ".WP_ssjp_TABLE." GROUP BY ssjp_category"; 
	if($SID=='') $SID=$ssjp_category_x; 
		$ssjp_data1 = $wpdb->get_results($sSql1); $ssjp_category='';
			foreach ( $ssjp_data1 as $ssjp_data1 ) 
		{
			$ssjp_cat=mysql_real_escape_string(trim($ssjp_data1->ssjp_category));	
			$ssjp_catselected=($SID==$ssjp_cat)?'selected="selected"':'';
			$ssjp_category .= '<option value="'.$ssjp_cat.'" '.$ssjp_catselected.'>'.$ssjp_cat.'</option>';	
		}
	
	// SET HEIGHT AND WIDTH
    if($_POST['s_width'] || $_POST['s_height'] || $_POST['autoplay']){

	if(get_option('ssjp_width_'.$SID)!=''){	update_option('ssjp_width_'.$SID, $_POST['s_width'] ); } else { add_option('ssjp_width_'.$SID, $_POST['s_width']); }
	if(get_option('ssjp_height_'.$SID)!=''){update_option('ssjp_height_'.$SID, $_POST['s_height'] ); } else { add_option('ssjp_height_'.$SID, $_POST['s_height']);}
	if(get_option('ssjp_autoplay_'.$SID)!=''){update_option('ssjp_autoplay_'.$SID, $_POST['autoplay'] ); } else { add_option('ssjp_autoplay_'.$SID, $_POST['autoplay']);}
	}
	// GET HEIGHT AND WIDTH

	$s_width='100%'; $s_height='300px'; $autoplay=0;
	$ssjp_width = get_option('ssjp_width_'.$SID);
	if( $ssjp_width!='') {$s_width=$ssjp_width; } 
	$ssjp_height = get_option('ssjp_height_'.$SID); 
	if($ssjp_height!='') {$s_height=$ssjp_height; }	
	$ssjp_autoplay = get_option('ssjp_autoplay_'.$SID); 
	if($ssjp_autoplay!='') {$autoplay=$ssjp_autoplay; }	
	
    ?>
  <h2><?php echo wp_specialchars( $title ); ?></h2>


<ul class="ssjp_menu">
<li><a href="admin.php?page=slippy-slider/slippy-slider.php" >VIEW</a></li>
<li><a href="admin.php?page=slippy-slider/slippy-slider.php&AC=EDIT" >ADD</a></li>

<li><a href="admin.php?page=slippy-slider/slippy-slider.php&AC=INFO" >INFO</a></li>
</ul>

<div style="border:1px solid #CCC; clear:left; padding:7px; ">
	<?php
     
	$dataSid = $wpdb->get_results("select * from ".WP_ssjp_TABLE." group by ssjp_category order by ssjp_category,ssjp_order");
	$data = $wpdb->get_results("select * from ".WP_ssjp_TABLE." where ssjp_category='$SID' order by ssjp_category,ssjp_order");
	
	
	if($AC=="DEL" && $DID > 0){
	echo '<span style="background:darkRed; color:#fff; font-size:12px; padding:5px; font-weight:bold; display:block; ">Silde deleted.</span>';
	}
	if($AC=="DEL" && $SLIDER != ''){
	echo '<span style="background:darkRed; color:#fff; font-size:12px; padding:5px; font-weight:bold; display:block; ">Silder deleted.</span>';
	}
	?>
	<?php  if($AC==NULL && $SID==NULL){ 
	?>
	
	
	  <form name="frm_ssjp_display" method="post" id="frm_ssjp_display"  >
      <h3>View sliders</h3>
	  <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th width="20%" align="left" scope="col">Slider
              </th>
            <th width="50%" align="left" scope="col">Headlines
              </th>
      
            <th width="30%" align="left" scope="col">Change
              </th>
          </tr>
        </thead>
        <?php 
        $i = 0;
        foreach ( $dataSid as $data ) { 
		if($data->ssjp_status=='YES') { $displayisthere="True"; }
        ?>
        <tbody>
          <tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
            <td align="left" valign="middle"><?php echo(stripslashes($data->ssjp_category)); ?></td>
            <td align="left" valign="middle"><?php echo substr(strip_tags(stripslashes($data->ssjp_desc)),0,25); ?>..</td>
			<td align="left" valign="middle"><a href="admin.php?page=slippy-slider/slippy-slider.php&SID=<?php echo($data->ssjp_category); ?>">Edit</a> &nbsp; <a onClick="javascript:ssjp_delete_slider('<?php echo($data->ssjp_category); ?>')" href="javascript:void(0);">Delete</a></td>
          </tr>
        </tbody>
        <?php $i = $i+1; } ?>
        <?php if($displayisthere<>"True") { ?>
        <tr>
          <td colspan="6" align="center" style="color:#FF0000" valign="middle">No silders available! </td>
        </tr>
        <?php } ?>
      </table>
	  <br>
	  <a href="admin.php?page=slippy-slider/slippy-slider.php&AC=EDIT">+ Create new silder</a>
	  <br>
    </form>
	 <?php
	 }  
	 ?>
	 
	 
	 
	 <?php  if($AC==NULL && $SID!=NULL){ ?>
	   <h3><span style="color:#999">Slider:</span> <?php echo $SID; ?></h3>
	     <?php  if($SID!=NULL){ $slide_short = '[slippy-slider slider="'.$SID.'" s_width="'.$s_width.'" s_height="'.$s_height.'"]'; 
	do_shortcode($slide_short);
	 } else {$slide_short = 'Add at least one slide to see the shortcode here..';
	}
	?>
	<h3>Options</h3>
	  <form name="frm_ssjp_display1" method="post" id="frm_ssjp_display1" action="<?php echo $mainurl; ?>&SID=<?php echo $SID; ?>" >
		<label for="s_width">Width: <input name="s_width" id="s_width" type="text" value="<?php echo $s_width; ?>" /></label>
		<label for="s_height">Height: <input name="s_height" id="s_height" type="text" value="<?php echo $s_height; ?>" /></label>
		<label for="autoplay">Autoplay: rotate every <input name="autoplay" style="width:30px;" id="autoplay" type="text" value="<?php echo $autoplay; ?>" /> seconds(0 to remove autoplay).</label>
		<input name="submit_d" id="submit_d" type="submit" value="Save" />
	  </form>
	 
	 <h3>Slides</h3> 
    <form name="frm_ssjp_display" method="post" id="frm_ssjp_display" >	
	  <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
		  <th width="8%" align="left" scope="col">Order
              </th>
            <th width="10%" align="left" scope="col">Slide
              </th>
            <th width="52%" align="left" scope="col">Button
              </th>
            <th width="7%" align="left" scope="col">Visible
              </th>
            <th width="13%" align="left" scope="col">Change
              </th>
          </tr>
        </thead>
        <?php 
        $i = 0;
        foreach ( $data as $data ) { 
		if($data->ssjp_status=='YES') { $displayisthere="True"; }
        ?>
		
        <tbody>
          <tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
		             
            <td align="left" valign="middle"><?php echo(stripslashes($data->ssjp_order)); ?></td>
            <td align="left" valign="middle"><?php echo substr(strip_tags(stripslashes($data->ssjp_desc)),0,25); ?>..</td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->ssjp_button)); ?></td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->ssjp_status)); ?></td>
            <td align="left" valign="middle"><a href="admin.php?page=slippy-slider/slippy-slider.php&DID=<?php echo($data->ssjp_id); ?>&AC=EDIT&T=S">Edit</a> &nbsp; <a onClick="javascript:ssjp_delete('<?php echo($data->ssjp_id); ?>')" href="javascript:void(0);">Delete</a></td>
          </tr>
        </tbody>
        <?php $i = $i+1; } ?>
        <?php if($displayisthere<>"True") { ?>
        <tr>
          <td colspan="6" align="center" style="color:#FF0000" valign="middle">No visible silde available! </td>
        </tr>
        <?php } ?>
      </table>
	  <br>
	  <a href="admin.php?page=slippy-slider/slippy-slider.php&AC=EDIT&T=S&SID=<?php echo $SID; ?>">+ Add silde</a>
	  <br>
    </form>
	<h3>Insert into website</h3>
    <strong>Shortcode:</strong><br>
	<div style="padding:5px; margin:3px; background:#eee; border:1px solid #ddd;"> <?php 
	 echo '<span style="">'.$slide_short.'</span>'; ?></div><br>
	 <strong>PHP:</strong><br>
	<div style="padding:5px; margin:3px; background:#eee; border:1px solid #ddd;"> &#60;?php slippy_slider_init(<?php echo '\''.$SID.'\',\'widget\', \''.$s_width.'\',\''.$s_height.'\''; ?>); ?&#62; </div>
	<?php } ?>
       
  
  <form name="ssjp_form"  id="ssjp_form" method="post" action="<?php echo $mainurl; ?>" onsubmit="return ssjp_submit()" <?php  if($AC=="EDIT"){ ?>style="display:inherit"<?php } else { ?> style="display:none"<?php }?> >
  <input name="SID" type="hidden" id="SID" value="<?php echo $SID; ?>" size="50" />
  <?php if($SID!='') echo '<a href="'.$mainurl.'&SID='.$SID.'" style="float:right; font-size:14px;">Cancel and return to '.$SID.'</a>'; ?>
  <?php if($T!='S'){ ?>
      
       <h3>Create new slider:</h3>
        <input name="ssjp_category_new" type="text" id="ssjp_category_new" value="My Slider" size="50" />
		
		<label for="s_width">Width: <input name="s_width" id="s_width" type="text" onkeydown="jQuery('#slide_image').css('width',this.value)" value="<?php echo $s_width; ?>" /></label>
		<label for="s_height">Height: <input name="s_height" id="s_height" type="text"  onkeydown="jQuery('#slide_image').css('height',this.value)" value="<?php echo $s_height; ?>" /></label>
		<label for="autoplay">Autoplay: rotate every <input name="autoplay" style="width:30px;" id="autoplay" type="text" value="<?php echo $autoplay; ?>" /> seconds(0 to remove autoplay).</label>
		
	
<?php } ?> 
  <h3><?php if($DID==NULL  && $AC=="EDIT") echo 'Enter new silde'; if($DID!=NULL && $AC=="EDIT") echo 'Edit silde';
  if($DID!=NULL && $AC=="DEL") echo ''; ?></h3>
  
  <script>
jQuery(function() {
jQuery('#ssjp_desc').draggable({
	containment: "#slide_image",
	drag: function( event, ui ) {
	var cpleft = jQuery(this).position().left;
		var cptop = jQuery(this).position().top; 
		var ssjp_xy = jQuery('#ssjp_xy').val(); var ssjp_xy_arr = ssjp_xy.split("|"); ssjp_xy_arr[0]=cpleft; ssjp_xy_arr[1]=cptop;
		jQuery('#ssjp_xy').val(ssjp_xy_arr[0]+'|'+ssjp_xy_arr[1]+'|'+ssjp_xy_arr[2]+'|'+ssjp_xy_arr[3]);
	}
	}).resizable({
	resize: function( event, ui ) {
	var cpwidth = jQuery(this).width();
		var cpheight =  jQuery(this).height(); 
		var ssjp_xy = jQuery('#ssjp_xy').val(); var ssjp_xy_arr = ssjp_xy.split("|"); ssjp_xy_arr[2]=cpwidth; ssjp_xy_arr[3]=cpheight;
		jQuery('#ssjp_xy').val(ssjp_xy_arr[0]+'|'+ssjp_xy_arr[1]+'|'+ssjp_xy_arr[2]+'|'+ssjp_xy_arr[3]);
		jQuery('#ssjp_desc_text').css('width',cpwidth+'px'); jQuery('#ssjp_desc_text').css('height',cpheight+'px');
	}
	});
	
});
function createButton(){
	var buttonHTML= '<a href="'+jQuery('#ssjp_link').val()+'" target="'+jQuery('#ssjp_target').val()+'" class="ssjp_button '+jQuery('#ssjp_color').val()+' '+jQuery('#ssjp_size').val()+' clearfix">'+jQuery('#ssjp_button').val()+'</a>';
	 jQuery('#buttonHTML').html('<p>HTML:</p><br><div></div>'); jQuery('#buttonHTML div').text(buttonHTML);
	var descPrev= jQuery('#ssjp_desc_preview').html(); jQuery('#ssjp_desc_preview').html(descPrev+'<br>'+buttonHTML); jQuery('#ssjp_desc_text').val(jQuery('#ssjp_desc_text').val()+'<br>'+buttonHTML);
}
function createHeadline(){
	var headlineHTML= '<h2 style="color: '+jQuery('#ssjp_h_color').val()+'; font-size: '+jQuery('#ssjp_h_size').val()+'px;">'+jQuery('#ssjp_headline').val()+'</h2>';
	jQuery('#headlineHTML').html('<p>HTML:</span></p> <div></div>'); jQuery('#headlineHTML div').text(headlineHTML);
	var descPrev= jQuery('#ssjp_desc_preview').html(); jQuery('#ssjp_desc_preview').html(descPrev+''+headlineHTML); jQuery('#ssjp_desc_text').val(jQuery('#ssjp_desc_text').val()+''+headlineHTML);
}
</script>

<input name="ssjp_xy" type="hidden" id="ssjp_xy" value="<?php echo $ssjp_xy_x; ?>" />

  <div id="slide_image" style="position:relative; border:5px solid #ccc; overflow:hidden; width:<?php echo $s_width;?>; height:<?php echo $s_height;?>" >
	<img src="<?php echo $ssjp_path_x; ?>" border="0" style="width:<?php echo $s_width;?>;" id="slide_image_img"/>
	
	<div id="ssjp_desc" style="<?php echo $ssjp_xy_style; ?>" >
		<div  id="ssjp_desc_preview" ><?php echo $ssjp_desc_x; ?></div>
        <textarea name="ssjp_desc"  style="width: 100%; height:100%; background: transparent; border:none; display:none; " id="ssjp_desc_text" ><?php echo $ssjp_desc_x; ?></textarea>
	    <div class="ssjp_bottom_links"><a href="javascript:void(0)" onclick="jQuery('#ssjp_desc_preview').hide(); jQuery('#ssjp_desc_text').show(); jQuery('.ssjp_bottom_links a').show(); jQuery(this).hide(); jQuery('#ssjp_desc').css('background-color','#fff')" >Edit</a><a href="javascript:void(0)" onclick="jQuery('#ssjp_desc_preview').show(); jQuery('#ssjp_desc_text').hide(); jQuery('#ssjp_desc_preview').html(jQuery('#ssjp_desc_text').val());  jQuery('.ssjp_bottom_links a').show(); jQuery(this).hide();  jQuery('#ssjp_desc').css('background-color','transparent')" style="display:none;" >Done</a></div>
	</div>
  </div>

<div style="clear:both"></div>
  <table width="100%">
  <tr>
  <td valign="top" align="left" style="width:33%">
     <table  width="33%">
	
	
	
        <tr>
        <td colspan="2" align="left" valign="middle"><input id="upload_image_button" style=" z-index:2" type="button" value="Upload Image" /></td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle">
		
Image URL:<br>
<input name="ssjp_path" type="text" id="ssjp_path" value="<?php echo $ssjp_path_x; ?>" size="25"/>
		</td>
      </tr> 
 

	  
<?php if($T=='S'){ ?>
      <tr>
        <td colspan="2" align="left" valign="middle">Include in slider:</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle">
        <select name="ssjp_category" id="ssjp_category" >
	<?php echo $ssjp_category ?>
	</select><br /> OR create new slider:<br />
        <input name="ssjp_category_new" type="text" id="ssjp_category_new" value="" size="50" /></td>
      </tr>
<?php } ?> 
	  
      <tr>
        <td align="left" valign="middle">Visible:</td>
        <td align="left" valign="middle">Order number:</td>
      </tr>
      <tr>
        <td width="22%" align="left" valign="middle"><select name="ssjp_status" id="ssjp_status">
            <option value="">Select</option>
            <option value='YES' <?php echo 'selected'  ?> >Yes</option>
            <option value='NO' >No</option>
          </select></td>
        <td width="78%" align="left" valign="middle"><input name="ssjp_order" type="text" id="ssjp_rder" size="10" value="<?php echo $ssjp_order_x; ?>" maxlength="3" /></td>
      </tr>
      <tr>
        <td height="35" colspan="2" align="left" valign="bottom"><table width="100%">
            <tr>
              <td width="50%" align="left"></td>
              <td width="50%" align="right"></td>
            </tr>
          </table></td>
      </tr>
      <input name="ssjp_id" id="ssjp_id" type="hidden" value="<?php echo $ssjp_id_x; ?>">
    </table>
  </td>
  
  <td  valign="top" align="left"  style="width:33%">
  
  <table   width="33%">
   <tr><td><h3>Headlines</h3></td></tr>
   <tr><td>Text:</td></tr>
  <tr><td><input name="ssjp_headline" type="text" id="ssjp_headline" value="My Headline" size="25" /></td></tr>
     <tr><td>Color:</td></tr>
  <tr><td>  <select name="ssjp_h_color" id="ssjp_h_color"  >
    <option value="white" selected="selected" >White</option>
    <option value="black"  >Black</option>
    <option value="red" >Red</option>
    <option value="blue"  >Blue</option>
    <option value="green"  >Green</option>
  </select></td></tr>
     <tr><td>Size:</td></tr>
  <tr><td> <input name="ssjp_h_size" type="text" id="ssjp_h_size" value="16" size="25" /> pixels</td></tr>
  <tr>
        <td colspan="2" align="left" valign="middle">
		<input type="button" onclick="createHeadline()" value="Add" /><br>
		<div id="headlineHTML" ></div></td>	
      </tr>
  </table>
  
  </td>
  
  <td  valign="top" align="left"  style="width:33%">
  <table   width="33%">
    <tr>
        <td colspan="2" align="left" valign="middle"><h3>Create a button</h3></td>
      </tr>
  	    <tr>
        <td colspan="2" align="left" valign="middle">Button text:</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><input name="ssjp_button" type="text" id="ssjp_button" value="<?php echo $ssjp_button_x; ?>" size="25" /></td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle">Button link:</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><input name="ssjp_link" type="text" id="ssjp_link" value="<?php echo $ssjp_link_x; ?>" size="25" /></td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle">Button link target:</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><input name="ssjp_target" type="text" id="ssjp_target" value="<?php echo $ssjp_target_x; ?>" size="25" />
          <br>( _blank, _parent, _self, _new )</td>
      </tr>
	  
		
		   <tr>
        <td colspan="2" align="left" valign="middle"><label for="color">Color: </label>
  <select name="ssjp_color" id="ssjp_color"  >
    <option value="ssjp_button_white" selected="selected" >White</option>
    <option value="ssjp_button_black"  >Black</option>
    <option value="ssjp_button_red" >Red</option>
    <option value="ssjp_button_blue"  >Blue</option>
    <option value="ssjp_button_green"  >Green</option>
  </select></td>
      </tr>
				   <tr>
        <td colspan="2" align="left" valign="middle"><label for="ssjp_size">Size: </label>
  <select name="ssjp_size" id="ssjp_size"  >
     <option value="ssjp_button_small"  selected="selected" >Small</option>
    <option value="ssjp_button_large">Large</option>
  </select></td>
      </tr>
		<tr>
        <td colspan="2" align="left" valign="middle">
		<input type="button" onclick="createButton()" value="Add" /><br>
		<div id="buttonHTML" ></div></td>
		
      </tr>
  </table>
  </td>
  
  </tr></table>
 <input name="publish" lang="publish" class="button-primary" value="<?php echo $submittext?>" type="submit" />
                <a class="button-primary" href="<?php echo $mainurl.'&SID='.$ssjp_category_x; ?>" >Cancel</a>
  </form>
  
    <div id="ssjp_settings" style="display:none">
    <h3>Settings</h3>

  </div>
  
  <div id="ssjp_about_us"  <?php  if($AC=="INFO"){ ?>style="display:inherit"<?php } else { ?> style="display:none"<?php }?>>  
    <h3>Useful information</h3>
	
	<p style="color:#666">You can add the slider as a shortcode on your posts and pages. Just insert [slippy-slider] anywhere you would like the slides to appear. Check the <a target="_blank" href='http://wpicode.com/slippy-slider'>documentation</a> for the additional attributes.</p>  
	<p style="color:#666">Created by <a target="_blank" href='http://wpicode.com/'>WPICODE</a>.</p>
  </div>
  
  
  <?php ?>
</div>
<h2>Get Free Support, Tips & Updates</h2>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=420111634693034";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div style="float:left">
<div class="fb-like" data-href="https://www.facebook.com/wpicode" data-width="450" data-layout="box_count" data-show-faces="false" data-send="false"></div>
</div>
<div style="float:left; margin-left:10px;">
<a href="https://twitter.com/wpicode" class="twitter-follow-button" data-show-count="false" data-size="large">Follow @wpicode</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
</div>
</div>
<?php
}

function slippy_slider_add_to_menu() 
{
	add_menu_page('Slippy Slider', 'Slippy Slider', 'manage_options', 'slippy-slider/slippy-slider.php', 'slippy_slider_admin_options',plugins_url('images/ss_menu_item.jpg', __FILE__) );
	
}



function slippy_slider_deactivation() 
{
	
}

if (is_admin()) 
{
	add_action('admin_menu', 'slippy_slider_add_to_menu');
}


function ssjp_scripts_method() {
 wp_register_style( 'ss_style', plugins_url('style/ss_style.css', __FILE__) );
    wp_register_script( 'slippy-slider', plugins_url('js/js-functions.js', __FILE__) );
  wp_register_script( 'touchpunch', plugins_url('js/jquery.ui.touch-punch.min', __FILE__) );
	
    wp_enqueue_script( 'slippy-slider' );
 wp_enqueue_style( 'ss_style' );
    wp_enqueue_script( 'jquery' );
	wp_enqueue_script('jquery-ui-draggable');

}    

function ssjp_scripts_admin(){
 wp_register_script( 'slippy-slider-setting', plugins_url('js/slippy-slider-setting.js', __FILE__) );
	wp_register_style( 'ss_style', plugins_url('style/ss_style.css', __FILE__) );
	wp_register_script( 'slippy-slider', plugins_url('js/js-functions.js', __FILE__));
	wp_register_script('slippy-upload', plugins_url('js/uploadmedia.js', __FILE__));
	

  
	 if($_GET['page']=='slippy-slider/slippy-slider.php'){  
	wp_enqueue_script('jquery-ui-draggable');
	wp_enqueue_script('jquery-ui-resizable');
	    wp_enqueue_style( 'ss_style' );
		 	wp_enqueue_script( 'slippy-slider-setting' );
    wp_enqueue_script( 'slippy-slider' );
	wp_enqueue_style('thickbox');
	   wp_enqueue_script('media-upload');
	wp_enqueue_script('slippy-upload');
	}


	} 

add_action('wp_enqueue_scripts', 'ssjp_scripts_method');
add_action('admin_enqueue_scripts', 'ssjp_scripts_admin');

function slippy_slider_shortcodes( $atts ) {
	extract( shortcode_atts( array(
		'slider' => 'Homepage',
		'type' => 'widget',
		's_width' =>'100%',
		's_height' =>''
	), $atts ) );

	slippy_slider_init($slider,$type,$s_width,$s_height);
}
add_shortcode( 'slippy-slider', 'slippy_slider_shortcodes' );

function ssjp_Init(){

}
add_action("plugins_loaded", "ssjp_Init");
register_activation_hook(__FILE__, 'slippy_slider_install');
register_deactivation_hook(__FILE__, 'slippy_slider_deactivation');
add_action('admin_menu', 'slippy_slider_add_to_menu');

?>