<?php namespace JF;
/**
Copyright 2017 JQueryForm.com
License: http://www.jqueryform.com/license.php
*/

require_once( __DIR__ . '/../phpmailer.php' );
require_once( __DIR__ . '/../form.lib.php' );
require_once( __DIR__ . '/PaypalIPN.php' );

use JF\Form;
use JF\Mailer;
use JF\Config;
use JF\PayPalIPN;

class IpnHandler {

	private static $paymentConfig;
	private static $ipn_data;

	public static function handle(){
		Form::setDataDir( __DIR__ . '/../data/' ); // set data dir for mail log file
		$config = Config::getConfig();

		self::$paymentConfig = self::getPaymentFieldConfig();
		self::$ipn_data = $_POST;
		self::log( self::$ipn_data );

		$ipn = new PayPalIPN();
		$ipn->useSandbox( !self::$paymentConfig['payments']['paypal']['isLive'] );
		$verified = $ipn->verifyIPN(); // data REALLY is posted from paypal.com
		self::$ipn_data = $ipn->paypal_post;
		if( !$verified ){
			$err = 'data is not verified by paypal.com';
			self::log( $err );
			self::log( self::$ipn_data );
			die( $err );
		};

		self::$ipn_data = $ipn->paypal_post;
		self::mailToMerchant();
		self::mailToBuyer();
	}

	public static function mailToMerchant(){
		$pp       = self::$paymentConfig['payments']['paypal'];
		$ipn      = $pp['ipn'];
		$subject  = $ipn['subject'];
		$template = $ipn['template'];

		if( !$ipn['emailToMerchant'] || empty($subject) || empty($template) ){
			return ;
		};

	    $mailer   = new Mailer();
		$to       = self::$ipn_data['receiver_email'];
		$from     = self::$ipn_data['payer_email'];
		$fromName = '';
		$message  = Form::replaceTags( $template, self::$ipn_data );
		$mailer->mail( $to , $subject , $message, $from, $fromName );
	}

	public static function mailToBuyer(){
		$pp       = self::$paymentConfig['payments']['paypal'];
		$ipn      = $pp['ipn'];
		$subject  = $ipn['buyerSubject'];
		$template = $ipn['buyerTemplate'];

		if( !$ipn['emailToBuyer'] || empty($subject) || empty($template) ){
			return ;
		};

	    $mailer   = new Mailer();
		$to       = self::$ipn_data['payer_email'];
		$from     = self::$ipn_data['receiver_email'];
		$fromName = self::$ipn_data['first_name'] . ' ' . self::$ipn_data['last_name'];
		$message  = Form::replaceTags( $template, self::$ipn_data );
		$mailer->mail( $to , $subject , $message, $from, $fromName );
	}

	public static function getPaymentFieldConfig(){
		$config = Config::getConfig();
		foreach( $config['fields'] as $field ){
			if( 'payment' == $field['field_type'] ){
				self::$paymentConfig = $field;
				return self::$paymentConfig;
			}; // if
		}; // foreach

		return false;
	}

	private static function log( $s ){
		$logFile = Form::getDataDir() . '/ipn-log.php';
		Form::secureFile( $logFile );
		$line = is_string($s) ? $s : var_export($s,true);
		file_put_contents( $logFile, date("Y-m-d H:i:s") . "\n" . $line . "\n", FILE_APPEND );
	}

}
// end of class IpnHandler


IpnHandler::handle();
