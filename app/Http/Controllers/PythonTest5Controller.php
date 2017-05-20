<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;
use App\Http\Domains\SubmissionManagement\Checker;

/**
*source code
* def quadcube (x):
*     return x**2, x**3
* 
* a, b = quadcube(3)
* print a
*result
* 9
*source code
* def quadcube (x):
*     return x**2, x**3
* 
* a, b = quadcube(3)
* print b
*result
* 27
*/

class PythonTest5Controller extends Controller
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
def quadcube (x):
  return x**2, x**3
  
a, b = quadcube(3)
print a
";
    private $sourceCode2 = "
def quadcube (x):
  return x**2, x**3
  
a, b = quadcube(3)
print b
";
    
    public function compileRequest(Request $request)
    {
        $result = $this->compile();
        
        return $this->respond(Response::HTTP_OK, $result);
    }
    
    public function runRequest(Request $request)
    {
        $case = $request->input('case');
        if ($case == '1') {
            $result = $this->run_1();
        } else if ($case == '2') {
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
        $output = '9';
        $result = $this->testCase($this->sourceCode, $input, $output);
        
        return $result;
    }
    
    private function run_2()
    {
        $input = '';
        $result = $this->run($this->sourceCode, $input);
        
        return $result;
    }
    
    private function testCase_2()
    {
        $input = '';
        $output = '27';
        $result = $this->testCase($this->sourceCode, $input, $output);
        
        return $result;
    }
}
