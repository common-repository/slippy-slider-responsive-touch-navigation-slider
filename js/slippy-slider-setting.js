function ssjp_submit()
{
	if(jQuery('#SID').val()==''){ jQuery('#SID').val(jQuery('#ssjp_category_new').val()); }
	if(document.ssjp_form.ssjp_path.value=="")
	{
		alert("Please upload an image, then click insert into post to continue.");
		document.ssjp_form.ssjp_desc.focus();
		return false;
	}

	else if(document.ssjp_form.ssjp_status.value=="")
	{
		alert("Please select the visibility status.");
		document.ssjp_form.ssjp_status.focus();
		return false;
	}
	else if(document.ssjp_form.ssjp_order.value=="")
	{
		alert("Please enter the order number.");
		document.ssjp_form.ssjp_order.focus();
		return false;
	}
	else if(isNaN(document.ssjp_form.ssjp_order.value))
	{
		alert("Please enter the order number.");
		document.ssjp_form.ssjp_order.focus();
		return false;
	}
}

function ssjp_delete(id)
{
	if(confirm("Do you want to delete this slide?"))
	{
		document.frm_ssjp_display.action="admin.php?page=slippy-slider/slippy-slider.php&AC=DEL&DID="+id;
		document.frm_ssjp_display.submit();
	}
}	
function ssjp_delete_slider(slider)
{
	if(confirm("Do you want to delete this slider and all slides within?"))
	{
		document.frm_ssjp_display.action="admin.php?page=slippy-slider/slippy-slider.php&AC=DEL&SLIDER="+slider;
		document.frm_ssjp_display.submit();
	}
}

function ssjp_redirect()
{
	window.location = "admin.php?page=slippy-slider/slippy-slider.php";
}
