<?php 
global $redux_builder_amp;
if(isset($redux_builder_amp['ampforwp-ninja-forms-recaptcha']) && $redux_builder_amp['ampforwp-ninja-forms-recaptcha'] == 1) {
       $post_response = $_POST['ninja-forms-recaptcha-response'];
       $gglcptch_remote_addr = filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP );
       $ninja_form_secretkey = $redux_builder_amp['ampforwp-ninja-forms-recaptcha-secerete']; 
        $args = array(
          'body' => array(
            'secret'   => $ninja_form_secretkey,
            'response' => stripslashes( esc_html( $post_response ) ),
            'remoteip' => $gglcptch_remote_addr,
          ),
          'sslverify' => false
        );
       $resp = wp_remote_post( 'https://www.google.com/recaptcha/api/siteverify', $args );


       $response =  json_decode( wp_remote_retrieve_body( $resp ), true );
       
       $expected_Response_Msg = array(
        'missing-input-secret' => 'The secret parameter is missing.',
        'invalid-input-secret'=> 'The secret parameter is invalid or malformed.',
        'missing-input-response'=> 'The response parameter is missing.',
        'invalid-input-response'=> 'The response parameter is invalid or malformed.',
        'bad-request'=> 'The request is invalid or malformed.',
        'timeout-or-duplicate'=> 'The response is no longer valid: either is too old or has been used previously.',

          );

     $result = array(
              'response' => false,
              'reason' => 'My changes'
          );

     if ( isset( $response['success'] ) ) {
        if ($response['score'] > 0.5 ) {
                    $result = array(
                        'response' => true,
                        'reason' => 'RECAPTCHA_SUCCESS'
                    );
        }
     }else {
        $result = array(
              'response' => false,
              'reason' => $response['error-codes']
          );
       }

       if( $result['response'] == false){

      //return new WP_Error('RECAPCTHA_INVALID', 'invalid recaptcha value',403 );
      header("access-control-allow-credentials:true");
      header("access-control-allow-headers:Content-Type, Content-Length, Accept-Encoding, X-CSRF-Token");
      header("Access-Control-Allow-Origin:".$_SERVER['HTTP_ORIGIN']);
      $siteUrl = parse_url(  get_site_url() );
      header("AMP-Access-Control-Allow-Source-Origin:".$siteUrl['scheme'] . '://' . $siteUrl['host']);
      header("access-control-expose-headers:AMP-Access-Control-Allow-Source-Origin");
      header("Content-Type:application/json;charset=utf-8");
      $comment_status = array("status"=>500,'message' => $expected_Response_Msg[$response['error-codes'][0]] );
      if($comment_status) {
        echo json_encode($comment_status);
      }
      $sapi_type = php_sapi_name();
      if (substr($sapi_type, 0, 3) == 'cgi')
        header("Status: 404 Not Found");
      else
        header("HTTP/1.1 404 Not Found");
      die;
      }
  }
?>