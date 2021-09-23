<?php if ( ! defined( 'ABSPATH' ) ) exit;?>
<style type="text/css">
	.amp-ext-title{font-size:medium;color:#3a3939;margin:20px 0 15px 20px}.redux-ampforwp-ext-activate{float:right}.amp-ext-act-container{margin:0 40px 20px 20px;background:#fff;box-shadow:0 0 1px #607d8b;height:200px;padding:1px;width:750px}.amp-ext-act-container .ext-block{float:left;height:92%;padding:5px 41px}.amp-ext-act-container .ext-img{margin-top:32px;float:left;margin-left:35px}.amp-ext-act-container .ext-img img{width:200px;height:135px}.amp-ext-act-container .ext-lisence{margin-left:20px;margin-top:15px;float:left;width:450px}.act-msg.desc{font-size:15px;color:#969393;font-style:italic}h2.act-msg{font-size:16px;font-style:italic}.button.button-primary{width:90px;height:35px}.regular-text{height:35px}p.license-tenure{font-style:italic;color:red}
</style>
<?php 
	
	$ext_list_arr = array(
                            'name'=>'Ninja Forms for AMP',
                            'desc'=>'Add Ninja Forms Support in AMP.',
                            'img_src'=>AMPFORWP_NINJA_PLUGIN_DIR_URI . '/assets/images/ninjaforms.png',
                            'price'=>'$79',
                            'url_link'=>'http://ampforwp.com/ninja-forms/#utm_source=options-panel&utm_medium=extension-tab_gf&utm_campaign=AMP%20Plugin',
                            'plugin_active_path'=> 'amp-ninja-forms/amp-ninja-forms.php',
                            'item_name'=>'Ninja Forms for AMP',
                            'store_url'=>'https://accounts.ampforwp.com',
                            'is_activated'=>1,
                        );

    $currentStatus = "";
    $onclickUrl = '<a href="'.$ext_list_arr['url_link'].'" target="_blank">';
    $onclickUrlclose = '</a>';
    $settingPageUrl = $pluginReview = '';
    if(isset($ext_list_arr['is_activated']) && $ext_list_arr['is_activated']!=1){
        $pluginReview = '<div class="extension_btn">From: '.esc_html($ext_list_arr['price']).'</div>';
    }
    if($ext_list_arr['plugin_active_path'] != "" && is_plugin_active($ext_list_arr['plugin_active_path']) ){
        $ampforwp_is_productActivated = true;
        $currentStatus = "not-active invalid";
        $pathExploded = explode("/", $ext_list_arr['plugin_active_path']);
        $pathExploded = $pathExploded[0];
        if(isset($ext_list_arr['settingUrl']) && $ext_list_arr['settingUrl']!=""){

            $settingPageUrl = '<div class="extension-menu-call"><a href="'.$ext_list_arr['settingUrl'].'" class="amp_extension_settings"><i class="dashicons-before dashicons-admin-generic"></i> Settings</a></div>';
        }
        $amplicense = '';
        $onclickUrl = $amp_license_response = $allResponseData = $onclickUrlclose= '';
        $allResponseData = array('success'=>'',
                                'license'=> '',
                                'item_name'=> '',
                                'expires'=> '',
                                'customer_name'=> '',
                                'customer_email'=> '',
                                );
        $selectedOption = (array) get_option('redux_builder_amp',true);
        if(isset($selectedOption['amp-license'][$pathExploded])){
            while ( strlen($selectedOption['amp-license'][$pathExploded]['license']) > 32 ) {
                  $selectedOption['amp-license'][$pathExploded]['license'] = base64_decode($selectedOption['amp-license'][$pathExploded]['license']);
            }
            $amplicense = $selectedOption['amp-license'][$pathExploded]['license'];
        }
        $verify = '<button type="button" id="'.$pathExploded.'" class="button button-primary redux-ampforwp-ext-activate">Activate</button>';
        $license_status = '';
        $enter_license_msg = '<p class="act-msg desc">
				Enter your license key here to activate . After activating you will receive updates &amp; support.
			</p>';
        if(isset($selectedOption['amp-license'][$pathExploded]['status']) && $selectedOption['amp-license'][$pathExploded]['status']==='valid'){
        	$enter_license_msg = '';
            $license_status = $selectedOption['amp-license'][$pathExploded]['status'];
             $currentStatus = 'active valid';
             $verify = '<button type="button" id="'.$pathExploded.'" class="button button-normal redux-ampforwp-ext-deactivate">'.esc_html__('Deactivate', 'accelerated-mobile-pages').'</button> 
             	<button class="ampforwp-ext-refresh button button-normal" id="'.esc_attr($pathExploded).'">'.esc_html__('Refresh', 'accelerated-mobile-pages').'</button>';
             $enter_license_msg = '';
            if(isset($selectedOption['amp-license'][$pathExploded]['all_data']['customer_name'])){
                $ampforwp_nameOfUser = $selectedOption['amp-license'][$pathExploded]['all_data']['customer_name'];
            }

            if(isset($selectedOption['amp-license'][$pathExploded]['all_data']) && $selectedOption['amp-license'][$pathExploded]['all_data']!=""){
                $allResponseData = $selectedOption['amp-license'][$pathExploded]['all_data'];
                $remainingExpiresDays = floor( ( strtotime($allResponseData['expires'] )- time() )/( 60*60*24 ) );
                if($remainingExpiresDays>0){
                    $amp_license_response = "<p class='license-tenure'>".esc_html($remainingExpiresDays)."  ".esc_html__('Days Remaining', 'accelerated-mobile-pages').". <a href='https://accounts.ampforwp.com/order/?edd_license_key=".esc_attr($amplicense)."&download_id=".esc_attr($allResponseData['item_name'])."' class='license-renew-a' target='_blank'>".esc_html__('Renew License', 'accelerated-mobile-pages')."</a></p>";
                }else{ 
                	$amp_license_response = "<p class='license-tenure expire'>".esc_html__('Expired', 'accelerated-mobile-pages')."! <a href='https://accounts.ampforwp.com/order/?edd_license_key=".esc_attr($amplicense)."&download_id=".esc_attr($allResponseData['item_name'])."'  class='license-renew-a'>".esc_html__('Renew your license', 'accelerated-mobile-pages')."</a></p>"; 
                }
            }
        }
        if ( '' == $allResponseData['success'] && '' == $allResponseData['success'] ) {        
        $pluginReview = '<input id="redux_builder_amp_amp-license_'.$pathExploded.'_license" type="text" value="" class="regular-text deact-text">
           <input name="redux_builder_amp[amp-license]['.$pathExploded.'][item_name]" type="hidden" value="'.$ext_list_arr['item_name'].'">';
        }
            if (isset($ext_list_arr['store_url'])){
            $pluginReview .= '<input name="redux_builder_amp[amp-license]['.$pathExploded.'][store_url]" type="hidden" value="'.$ext_list_arr['store_url'].'">'; 
            }
             $pluginReview .= '<input name="redux_builder_amp[amp-license]['.$pathExploded.'][plugin_active_path]" type="hidden" value="'.$ext_list_arr['plugin_active_path'].'">
            <input name="redux_builder_amp[amp-license]['.$pathExploded.'][name]" type="hidden" value="'.$ext_list_arr['name'].'">
            <input name="redux_builder_amp[amp-license]['.$pathExploded.'][status]" type="hidden" value="'.$license_status.'">';
             $pluginReview .= '<input name="redux_builder_amp[amp-license]['.$pathExploded.'][all_data][success]" type="hidden" value="'.$allResponseData['success'].'">
            <input name="redux_builder_amp[amp-license]['.$pathExploded.'][all_data][license]" type="hidden" value="'.$allResponseData['license'].'">
            <input name="redux_builder_amp[amp-license]['.$pathExploded.'][all_data][item_name]" type="hidden" value="'.$allResponseData['item_name'].'">
            <input name="redux_builder_amp[amp-license]['.$pathExploded.'][all_data][expires]" type="hidden" value="'.$allResponseData['expires'].'">
            <input name="redux_builder_amp[amp-license]['.$pathExploded.'][all_data][customer_name]" type="hidden" value="'.$allResponseData['customer_name'].'">
            <input name="redux_builder_amp[amp-license]['.$pathExploded.'][all_data][customer_email]" type="hidden" value="'.$allResponseData['customer_email'].'">
            <input class="amp-ls-solve" name="redux_builder_amp[amp-license]['.$pathExploded.'][license]" type="hidden" value="'. base64_encode($amplicense).'">
            ';
        
        $pluginReview .= $verify. "<br/>".$amp_license_response;
        if(isset($selectedOption['amp-license'][$pathExploded]['message']) && $selectedOption['amp-license'][$pathExploded]['message']!=""){
            $pluginReview .= "<div class='afw-license-response-message'>".$selectedOption['amp-license'][$pathExploded]['message']."</div>";
        }      
    }
    $secondPageClickClass = '';
    if ( isset($ext_list_arr['class']) && $ext_list_arr['class'] && !$currentStatus ) {
        $secondPageClickClass = $secondPageClickClass. ' ' . $ext_list_arr['class'];
    }

$extension_listing = '<h3 class="amp-ext-title">'.esc_attr($ext_list_arr['name']).' License Activation</h3>
<div class="amp-ext-act-container">
	<div class="data_element first '.esc_attr($currentStatus).' '.esc_attr($secondPageClickClass).'" data-ext-details=\''.json_encode($ext_list_arr).'\' data-ext-secure="'.wp_create_nonce('verify_extension').'">
        '.$onclickUrl.'
        <div class="ext-img"><img src="'.esc_url($ext_list_arr['img_src']).'" alt="'.esc_html($ext_list_arr['name']).'"/></div>
        <div class="ext-lisence">
        	<h2 class="act-msg">'.esc_html($ext_list_arr['desc']).'</h2>
        	'.$pluginReview.'
        	'.$enter_license_msg.'
    	</div>
    	'.$onclickUrlclose.' 
    	'.$settingPageUrl.'
    </div>
</div>';
echo $extension_listing;
?>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery(".redux-ampforwp-ext-activate").click(function(){
    var currentThis = jQuery(this);
    var plugin_id = currentThis.attr("id");
    var secure_nonce = jQuery(".data_element").attr('data-ext-secure');
    
    var newlicense = jQuery('#redux_builder_amp_amp-license_'+plugin_id+'_license').val();
    var license = jQuery('input[name="redux_builder_amp[amp-license]['+plugin_id+'][license]"]').val();
    if(newlicense!='' && newlicense.indexOf("**")<0){
        license = window.btoa(newlicense);
        jQuery('input[name="redux_builder_amp[amp-license]['+plugin_id+'][license]"]').val(license);
    }

    var item_name = jQuery('input[name="redux_builder_amp[amp-license]['+plugin_id+'][item_name]"]').val();
    var store_url = jQuery('input[name="redux_builder_amp[amp-license]['+plugin_id+'][store_url]"]').val();
    var plugin_active_path = jQuery('input[name="redux_builder_amp[amp-license]['+plugin_id+'][plugin_active_path]"]').val();
    if(license!=''){
	    currentThis.html("Please wait");
	    var timer_count = 0;
	    var timer = setInterval(function(){
	    	timer_count++;
	    	var msg = "Activating";
	    	var dots = '';
	    	for(var i=0;i<timer_count;i++){
	    		dots+='.';
	    	}
	    	if(timer_count==3){
	    		timer_count = 0;
	    	}
	    	msg = msg+dots;
	    	jQuery(".redux-ampforwp-ext-activate").html(msg);
	    },800);
	    jQuery.ajax({
	        url: ajaxurl,
	        method: 'post',
	        data: {action: 'ampforwp_get_licence_activate_update',
	               ampforwp_license_activate:plugin_id,
	               license:window.atob(license),
	               item_name:item_name,
	               store_url:store_url,
	               plugin_active_path:plugin_active_path,
	               verify_nonce: secure_nonce
	                },
	        dataType: 'json',
	        success: function(response){
	            if(response.status=='200'){
	            	location.reload();
	            }else{
	                alert(response.message);
	                currentThis.html("Activate");
	            }
	        }
	    })
	}
})
	jQuery(".redux-ampforwp-ext-deactivate").click(function(){
	    var currentThis = jQuery(this);
	    var plugin_id = currentThis.attr("id");
	    var secure_nonce = jQuery(".data_element").attr('data-ext-secure');
	    $deactivateConfirm = confirm("Are you sure you want to Deactivate ?");
	    if($deactivateConfirm){
	    	currentThis.html("Please wait");
	    	var timer_count = 0;
	    	var timer = setInterval(function(){
		    	timer_count++;
		    	var msg = "Deactivating";
		    	var dots = '';
		    	for(var i=0;i<timer_count;i++){
		    		dots+='.';
		    	}
		    	if(timer_count==3){
		    		timer_count = 0;
		    	}
		    	msg = msg+dots;
		    	jQuery(".redux-ampforwp-ext-deactivate").html(msg);
		    },800);
	        jQuery.ajax({
	            url: ajaxurl,
	            method: 'post',
	            data: {action: 'ampforwp_deactivate_license', ampforwp_license_deactivate:plugin_id,
	                verify_nonce: secure_nonce
	                },
	            dataType: 'json',
	            success: function(response){
	                if(response.status=='200'){
	                    location.reload();
	                }else{
	                    alert(response.message);
	                }
	            }
	        })
	    }
	});
	 jQuery(".ampforwp-ext-refresh").click(function(){
	    var currentThis = jQuery(this);
	    var plugin_id = currentThis.attr("id");
	    var today = new Date();
	    var lastcheck = AMPforwpreadCookie('plugin_refresh_check');
	    lastcheck = new Date(lastcheck);
	    console.log(lastcheck+ " true");
	    var diffDays = -1;
	    if( typeof lastcheck != undefined){
	        var diffTime = Math.abs(today.getTime() - lastcheck.getTime());
	        var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
	    }
	     var expireDate = new Date(jQuery('[name="redux_builder_amp[amp-license]['+plugin_id+'][all_data][expires]"]').val());
	    var diffTime = Math.abs( expireDate.getTime()-today.getTime() );
	    var expireDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
	    if(diffDays==-1 || diffDays>1 || expireDays<1){
	        currentThis.html("Please wait");
		    var timer_count = 0;
		    var timer = setInterval(function(){
		    	timer_count++;
		    	var msg = "Refreshing";
		    	var dots = '';
		    	for(var i=0;i<timer_count;i++){
		    		dots+='.';
		    	}
		    	if(timer_count==3){
		    		timer_count = 0;
		    	}
		    	msg = msg+dots;
		    	jQuery(".ampforwp-ext-refresh").html(msg);
		    },800);
	        document.cookie = "plugin_refresh_check="+today;
	        var secure_nonce = jQuery(".data_element").attr('data-ext-secure');
	        jQuery.ajax({
                url: ajaxurl,
                method: 'post',
                data: {action: 'ampforwp_get_licence_activate_update',
                        update_check: 'yes',
                       ampforwp_license_activate:plugin_id,
                       verify_nonce: secure_nonce
                        },
                dataType: 'json',
                success: function(response){
                    if(response.status=='200'){
                        location.reload();
                    }else{
                    	alert(response.message);
                    }
                }
            })
	    }else{
	    	alert("You already refreshed your license today. Please try refreshing tomorrow.");
	    }
	});
});
//Deactivate License key
function AMPforwpreadCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(";");
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==" ") c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
</script>