<?php
namespace content\home;

class controller extends \mvc\controller
{
	function _route()
	{
		// route sample
		// $this->route("/^hasan\/you\/any\/time$/")
		// $this->route(array("url|=>array("hasan", "you", "any", "time"))
		// $this->route("hasan/you/any/time")
		// $this->route(array("url|=> "hasan/you/any/time")

		$this->route("/^$/", function(){
			$this->redirector()->set_url("login")->redirect();
		});

		$this->route("/^(login|signup|recovery|smsdelivery|smscallback)$/", function(){

			$module	= \lib\router::get_real_url();
			$this->model_name	= 'content\\'.$module.'\model';
			$this->display_name	= 'content_account\\'.$module.'\display.html';
			$this->post($module)->ALL($module);
		});

		$this->route("/^(verification|changepass)$/", function(){
			$module	= \lib\router::get_real_url();
			$this->model_name	= 'content\\'.$module.'\model';
			$this->display_name	= 'content_account\\'.$module.'\display.html';
			$this->put($module)->ALL($module);
		});

		// handel user for search in db and verify user
		$this->route("verification/send", function(){
			$module	= 'verification\send';
			$this->model_name	= 'content\\'.$module.'\model';
			$this->display_name	= 'content_account\\'.$module.'\display.html';
			$this->get('verificationsend')->ALL($module);
		});

		// manage sms inputs and filter addresses without uid
		$this->route("/^(smsdelivery|smscallback)$/", function(){
			if(\lib\utility::get('uid')==201500001)
			{
				$module	= \lib\router::get_real_url();
				$this->model_name	= 'content\sms\model';
				$this->display_name	= 'content_account\sms\display.html';
				$this->post($module)->ALL($module);
				$this->get($module)->ALL($module);
				// var_dump("expression");
			}
			else
			{
				\lib\http::access("smsdelivery");
			}

		});

		// logout user from system
		$this->route("/^logout$/", function(){
			// redirect to ermile
			session_unset();
			session_destroy();
			\lib\debug::true("Logout successfully");
			$this->redirector()->set_domain()->set_url();
			header("location: http://".\lib\router::get_root_domain());
			exit();
		});		
	}
}
?>