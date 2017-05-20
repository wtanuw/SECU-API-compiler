<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;
use App\Http\Domains\SubmissionManagement\Checker;

/**
*source code
* str(n) == str(n)[::-1]
*
*result
* abcba
* True
*
* 1234567890
* False
*/

class PythonTest8Controller extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    private $lang = 'python';

    private $sourceCode1 = "
def is_palindrome(word):

    letters = list(word)    
    is_palindrome = True
    i = 0

    while len(letters) > 0 and is_palindrome:       
        if letters[0] != letters[(len(letters) - 1)]:
            is_palindrome = False
        else:
            letters.pop(0)
            if len(letters) > 0:
                letters.pop((len(letters) - 1))

    return is_palindrome

try:
    input = raw_input()
except :
    print 'error.'
finally:
    print is_palindrome(str(input))
";

    private $sourceCode2 = "
try:
    input = raw_input()
except :
    print 'error.'
finally:
    print str(input)==str(input)[::-1]
";

    private $sourceCode3 = "
def isPalindrome(S):
    pali = True
    for i in range (0, len(S) // 2):
        if S[i] == S[(i * -1) - 1] and pali is True:
            pali = True
        else:
            pali = False
    return pali
try:
    input = raw_input()
except :
    print 'error.'
finally:
    print isPalindrome(input)
";
    
    public function compileRequest(Request $request)
    {
        $result = $this->compile($this->sourceCode);
        
        return $this->respond(Response::HTTP_OK, $result);
    }
    
    public function runRequest(Request $request)
    {
        $case = $request->input('case');
        if ($case == '1') {
            $result = $this->run_1();
        } else if ($case == '2') {
            $result = $this->run_2();
        } else {
            $result = "case 1: ".$this->run_1()."case2: ".$this->run_2();
        }
        
        return $this->respond(Response::HTTP_OK, $result);
    }
    
    public function testCaseRequest(Request $request)
    {
        $case = $request->input('case');
        if ($case == '1') {
            $result = $this->testCase_1();
        } else if ($case == '2') {
            $result = $this->testCase_2();
        } else {
            $result = $this->testCase_1()." ".$this->testCase_2();
        }
        
        return $this->respond(Response::HTTP_OK, $result);
    }

    public function testCaseScoreRequest(Request $request)
    {
        $number = 2;
        $score = 0;
        if ($this->testCase_1()) {
            $score+=1;
        }
        if ($this->testCase_2()) {
            $score+=1;
        }
        $result = $score." / ".$number;
        return $this->respond(Response::HTTP_OK, $result);
    }
    
    private function compile(String $sourceCode)
    {
        $result = Checker::complie($this->lang, 
                                   $sourceCode, 
                                   "");

        return $result;
    }
    
    private function run(String $sourceCode, String $input)
    {
        $result = Checker::complie($this->lang, 
                                   $sourceCode, 
                                   $input);

        return $result;
    }
    
    private function testCase(String $sourceCode, String $input, String $output)
    {
        $result = Checker::checkTestCase($this->lang, 
                                         $sourceCode, 
                                         $input, 
                                         $output);

        return $result;
    }
    
    private function run_1()
    {
        $input = 'abcba';
        $result = $this->run($this->sourceCode, $input);
        
        return $result;
    }
    
    private function testCase_1()
    {
        $input = 'abcba';
        $output = 'abcba';
        $result = $this->testCase($this->sourceCode, $input, $output);
        
        return $result;
    }
    
    private function run_2()
    {
        $input = '1234567890';
        $result = $this->run($this->sourceCode, $input);
        
        return $result;
    }
    
    private function testCase_2()
    {
        $input = '1234567890';
        $output = '0987654321';
        $result = $this->testCase($this->sourceCode, $input, $output);
        
        return $result;
    }
}
