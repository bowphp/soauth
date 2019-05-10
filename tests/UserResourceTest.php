<?php

use Bow\Soauth\UserResource;

class UserResourceTest extends \PHPUnit\Framework\TestCase
{
	/**
	 * The basic test
	 */
	public function testNullValue()
	{
		$user = new UserResource([]);

		$this->assertNull($user->getName());
		$this->assertNull($user->getEmail());
		$this->assertNull($user->getAvatar());
		$this->assertNull($user->getNickName());
	}
}