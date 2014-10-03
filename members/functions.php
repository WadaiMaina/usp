<?php class member {
	public $id;
	public $fname;
	public $lname;
	public $department;
	public $email;
	
	function fullName() {
		$name = $this && $this->fname && $this->lname;
		$name = $name ? $this->fname.' '.$this->lname : 'John Doe';
		return $name;
	}
}