<?php
declare(strict_types=1);

namespace SoftSmart\SMSPortal\Tests;

use SoftSmart\SMSPortal\EmptyPhoneNumberException;
use SoftSmart\SMSPortal\LimitExceededException;
use SoftSmart\SMSPortal\ReplacementsException;
use SoftSmart\SMSPortal\EmptyMessageException;
use SoftSmart\SMSPortal\SMSPortal;
use SoftSmart\SMSPortal\SMSPortalServiceProvider;


use Tests\TestCase;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [SMSPortalServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function check_for_exception_if_phonenumber_count_not_equals_replacements_count_if_phone_number_is_array()
    {

        $this->expectException(ReplacementsException::class);

        $phoneNumber = ["0000000000"];
        $message = "testing";
        $replacement = [
            ["key" => "key", "value" => "value"],
            ["key" => "key", "value" => "value"]
        ];

        $smsportal = new SMSPortal();
        $smsportal->sendMessage($phoneNumber, $message, $replacement);
    
    }

    /**
     * @test
     */
    public function check_for_exception_if_replacements_given_with_single_string_phonenumber()
    {
        $this->expectException(ReplacementsException::class);

        $phoneNumber = "0000000000";
        $message = "testing";
        $replacement = [
            ["key" => "key", "value" => "value"],
            ["key" => "key", "value" => "value"]
        ];

        $smsportal = new SMSPortal();
        $smsportal->sendMessage($phoneNumber, $message, $replacement);
    
    }


    /**
     * @test
     */
    public function check_for_exception_if_phonenumber_array_larger_than_100_items()
    {
        $this->expectException(LimitExceededException::class);


        $phoneNumber = [];

        for ($x =0; $x < 101; $x++) {
            $phoneNumber[] = "000000".str_pad((string)$x, 4, "0", STR_PAD_LEFT);
        }

        $message = "testing";
 

        $smsportal = new SMSPortal();
        $smsportal->sendMessage($phoneNumber, $message);
    
    }


    /**
     * @test
     */
    public function check_for_exception_if_phonenumber_array_is_empty()
    {
        
        $this->expectException(EmptyPhoneNumberException::class);

        $phoneNumber = [];
        $message = "testing";

        $smsportal = new SMSPortal();
        $smsportal->sendMessage($phoneNumber, $message);
    
    }



    /**
     * @test
     */
    public function check_for_exception_if_message_is_empty()
    {
        
        $this->expectException(EmptyMessageException::class);

        $phoneNumber = "0000000000";
        $message = "";

        $smsportal = new SMSPortal();
        $smsportal->sendMessage($phoneNumber, $message);
    
    }


    /**
     * @test
     */
    public function check_for_exception_if_phonenumber_string_is_empty()
    {
        
        $this->expectException(EmptyPhoneNumberException::class);

        $phoneNumber = "";
        $message = "testing";

        $smsportal = new SMSPortal();
        $smsportal->sendMessage($phoneNumber, $message);
    
    }


    /**
     * @test
     */
    public function check_for_exception_if_message_string_is_empty()
    {
        
        $this->expectException(EmptyPhoneNumberException::class);

        $phoneNumber = "";
        $message = "testing";

        $smsportal = new SMSPortal();
        $smsportal->sendMessage($phoneNumber, $message);
    
    }


    /**
     * @test
     */
    public function send_message_to_single_string_number()
    {

        if (config("smsportal.testMode") === false) {
            throw new \Exception("To run tests please put SMS portal to test mode in the .env file (SMSPORTAL_TEST_MODE=true)");
        }

        $message = "hello, world";
        $smsportal = new SMSPortal();
        $result = $smsportal->sendMessage("0000000000", $message);
    

        $this->assertTrue((int)$result["cost"] == 1 && empty($result["faults"]));
        
    }    



    /**
     * @test
     */
    public function send_message_to_single_number_in_array()
    {

        if (config("smsportal.testMode") === false) {
            throw new \Exception("To run tests please put SMS portal to test mode in the .env file (SMSPORTAL_TEST_MODE=true)");
        }

        $message = "hello, world";
        $smsportal = new SMSPortal();
        $result = $smsportal->sendMessage(["0000000000"], $message);
    

        $this->assertTrue((int)$result["cost"] == 1 && empty($result["faults"]));
        
    } 
    
    

    /**
     * @test
     */
    public function send_message_to_multiple_numbers()
    {

        if (config("smsportal.testMode") === false) {
            throw new \Exception("To run tests please put SMS portal to test mode in the .env file (SMSPORTAL_TEST_MODE=true)");
        }

        $message = "hello, world";
        $smsportal = new SMSPortal();
        $result = $smsportal->sendMessage(["0000000000", "0000000001"], $message);
    

        $this->assertTrue((int)$result["cost"] == 2 && empty($result["faults"]));
        
    } 


    /**
     * @test
     */
    public function test_single_string_replacements()
    {

        if (config("smsportal.testMode") === false) {
            throw new \Exception("To run tests please put SMS portal to test mode in the .env file (SMSPORTAL_TEST_MODE=true)");
        }

        $smsportal = new SMSPortal();

        $message = "hello, ::who::";
        $replacements = [
            [
                [
                    "key"   => "::who::",
                    "value" => "world"
                ]
            ]
        ];

        $result = $smsportal->sendMessage(["0000000000", "0000000001"], "hello, world");
    

        $this->assertTrue($result["sample"] == "hello, world");
        
    } 



    /**
     * @test
     */
    public function test_multiple_string_replacements()
    {

        if (config("smsportal.testMode") === false) {
            throw new \Exception("To run tests please put SMS portal to test mode in the .env file (SMSPORTAL_TEST_MODE=true)");
        }

        $smsportal = new SMSPortal();

        $message = "::greeting::, ::who::";
        $replacements = [
            [
                [
                    "key"   => "::greeting::",
                    "value" => "hello"
                ],
                [
                    "key"   => "::who::",
                    "value" => "world"
                ]
            ]
        ];

        $result = $smsportal->sendMessage(["0000000000", "0000000001"], "hello, world");
    

        $this->assertTrue($result["sample"] == "hello, world");
        
    } 


}


