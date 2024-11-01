jQuery(document).ready(function() {
 
jQuery('#upload_image_button').click(function() {
 formfield = jQuery('#ssjp_path').attr('name');
 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
 return false;
});
 
window.send_to_editor = function(html) {
 imgurl = jQuery('img',html).attr('src');
 jQuery('#ssjp_path').val(imgurl);
 jQuery('#slide_image_img').attr('src',imgurl);
 tb_remove();
}
 
});