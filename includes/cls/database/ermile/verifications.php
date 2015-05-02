<?php
namespace database\ermile;
class verifications 
{
	public $id                      = array('null' =>'NO',  'show' =>'NO',  'label'=>'id',            'type' => 'smallint@5',                                                                                  );
	public $verification_type       = array('null' =>'NO',  'show' =>'YES', 'label'=>'type',          'type' => 'enum@emailsignup,emailchangepass,emailrecovery,mobilesignup,mobilechangepass,mobilerecovery', );
	public $verification_value      = array('null' =>'NO',  'show' =>'YES', 'label'=>'value',         'type' => 'varchar@50',                                                                                  );
	public $verification_code       = array('null' =>'NO',  'show' =>'YES', 'label'=>'code',          'type' => 'varchar@32',                                                                                  );
	public $verification_url        = array('null' =>'YES', 'show' =>'YES', 'label'=>'url',           'type' => 'varchar@100',                                                                                 );
	public $user_id                 = array('null' =>'NO',  'show' =>'NO',  'label'=>'user',          'type' => 'int@10',                                                                                      'foreign'=>'users@id!user_nickname');
	public $verification_verified   = array('null' =>'NO',  'show' =>'YES', 'label'=>'verified',      'type' => 'enum@yes,no!no',                                                                              );
	public $verification_status     = array('null' =>'NO',  'show' =>'YES', 'label'=>'status',        'type' => 'enum@enable,disable,expire!enable',                                                           );
	public $verification_createdate = array('null' =>'YES', 'show' =>'YES', 'label'=>'createdate',    'type' => 'datetime@',                                                                                   );
	public $date_modified           = array('null' =>'YES', 'show' =>'NO',  'label'=>'modified',      'type' => 'timestamp@',                                                                                  );


	//------------------------------------------------------------------ id
	public function id() {$this->validate()->id();}

	//------------------------------------------------------------------ select button
	public function verification_type() 
	{
		$this->form("select")->name("type")->type("select")->required()->validate();
		$this->setChild();
	}
	public function verification_value() 
	{
		$this->form("text")->name("value")->maxlength(50)->required()->type('text');
	}
	public function verification_code() 
	{
		$this->form("text")->name("code")->maxlength(32)->required()->type('text');
	}
	public function verification_url() 
	{
		$this->form("text")->name("url")->maxlength(100)->type('text');
	}

	//------------------------------------------------------------------ user_id
	public function user_id() {$this->validate()->id();}

	//------------------------------------------------------------------ radio button
	public function verification_verified() 
	{
		$this->form("radio")->name("verified")->type("radio")->required();
		$this->setChild();
	}

	//------------------------------------------------------------------ select button
	public function verification_status() 
	{
		$this->form("select")->name("status")->type("select")->required()->validate();
		$this->setChild();
	}
	public function verification_createdate() 
	{
		$this->form("text")->name("createdate")->type('text');
	}
	public function date_modified() {}
}
?>