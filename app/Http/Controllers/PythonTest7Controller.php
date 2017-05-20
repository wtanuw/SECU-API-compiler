<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;
use App\Http\Domains\SubmissionManagement\Checker;

/**
*source code
* y = 0
* for x in raw_input().split(' '):
*     x = int(x);
*     y = x+y;
* print y
*result
* 1 2 3
* 6
*
* 4 5 6
* 15
*/

class PythonTest7Controller extends Controller
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
    private $sourceCode = "
y = 0
try:
    input = raw_input()
    for x in input.split(' '):
        x = int(x);
        y = x+y;
    print y
except :
    print 'error.'
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
        $input = '1 2 3';
        $result = $this->run($this->sourceCode, $input);
        
        return $result;
    }
    
    private function testCase_1()
    {
        $input = '1 2 3';
        $output = '6';
        $result = $this->testCase($this->sourceCode, $input, $output);
        
        return $result;
    }
    
    private function run_2()
    {
        $input = '4 5 6';
        $result = $this->run($this->sourceCode, $input);
        
        return $result;
    }
    
    private function testCase_2()
    {
        $input = '4 5 6';
        $output = '15';
        $result = $this->testCase($this->sourceCode, $input, $output);
        
        return $result;
    }
}
