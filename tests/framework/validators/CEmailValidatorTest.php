<?php
require_once('ValidatorTestModel.php');

class CEmailValidatorTest extends CTestCase
{
	public function testEmpty()
	{
		$model = new ValidatorTestModel('CEmailValidatorTest');
		$model->validate(array('email'));
		$this->assertArrayHasKey('email', $model->getErrors());
	}

	public function testNumericEmail()
	{
		$emailValidator = new CEmailValidator();
		$result = $emailValidator->validateValue("5011@gmail.com");
		$this->assertTrue($result);
	}

	public function providerIDNEmail()
	{
		return array(
			// IDN validation enabled
			array('test@президент.рф', true, true),
			array('test@bücher.de', true, true),
			array('test@检查域.cn', true, true),
			array('☃-⌘@mañana.com', true, true),
			array('test@google.com', true, true),
			array('test@yiiframework.com', true, true),
			// IDN validation disabled
			array('test@президент.рф', false, false),
			array('test@bücher.de', false, false),
			array('test@检查域.cn', false, false),
			array('☃-⌘@mañana.com', false, false),
			array('test@google.com', false, true),
			array('test@yiiframework.com', false, true),
		);
	}

	/**
	 * @dataProvider providerIDNEmail
	 *
	 * @param string $email
	 * @param boolean $validateIDN
	 * @param string $assertion
	 */
	public function testIDNUrl($email, $validateIDN, $assertion)
	{
		$emailValidator = new CEmailValidator();
		$emailValidator->validateIDN = $validateIDN;
		$result = $emailValidator->validateValue($email);
		$this->assertEquals($assertion, $result);
	}
}
