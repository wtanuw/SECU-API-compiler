<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;
use App\Http\Domains\SubmissionManagement\Checker;

/**
*source code
* str = "foo";
*   for char in str:
*   print char
*
*result
* f
* o
* o
*
*source code
* lst = ["abra", 2038, "cadabra"]
* for elem in lst:
*   print elem
*
*result
* abra
* 2038
* cadabra
*/

class PythonTest3Controller extends Controller
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
str = 'foo';
for char in str:
    print char
";
    private $sourceCode2 = "
lst = ['abra', 2038, 'cadabra']
for elem in lst:
    print elem
";
    
    public function compileRequest(Request $request)
    {
        $result = compile();
        
        return $this->respond(Response::HTTP_OK, $result);
    }
    
    public function runRequest(Request $request)
    {
        $case = $request->input('case');
        if ($case == '1') {
            $result = $this->run_1();
        } else  if ($case == '2') {
            $result = $this->run_2();
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
        }
        
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
        $input = '';
        $result = $this->run($this->sourceCode, $input);
        
        return $result;
    }
    
    private function testCase_1()
    {
        $input = '';
        $output = 'f
o
o';
        $result = $this->testCase($this->sourceCode, $input, $output);
        
        return $result;
    }
    
    private function run_2()
    {
        $input = '';
        $result = $this->run($this->sourceCode2, $input);
        
        return $result;
    }
    
    private function testCase_2()
    {
        $input = '';
        $output = 'abra
2038
cadabra';
        $result = $this->testCase($this->sourceCode2, $input, $output);
        
        return $result;
    }
}
