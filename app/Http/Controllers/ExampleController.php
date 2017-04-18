<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;
use App\Http\Domains\SubmissionManagement\Checker;

class ExampleController extends Controller
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

    public function complie(Request $request)
    {   
        /**
         *  Params
         *
         *  $lang String (require)
         *  $sourceCode String (require)
         *  $input String (optional) 
         */
        $output = Checker::complie($request->input('lang'), 
                                   $request->input('sourceCode'), 
                                   $request->input('input'));

        return $this->respond(Response::HTTP_OK, $output);
    }

    public function checkTestCase(Request $request)
    {   
        /**
         *  Params
         *
         *  $lang String (require)
         *  $sourceCode String (require)
         *  $input String (require) 
         *  $output String (require) 
         */

        $output = Checker::checkTestCase($request->input('lang'), 
                                         $request->input('sourceCode'), 
                                         $request->input('input'), 
                                         $request->input('output'));

        return $this->respond(Response::HTTP_OK, $output);
    }

    public function compile1(Request $request)
    {   
        $lang = 'python';
        $sourceCode = "
friends = ['john', 'pat', 'gary', 'michael']
for i, name in enumerate(friends):
    print 'iteration {iteration} is {name}'.format(iteration=i, name=name)";

        $output = Checker::complie($lang, 
                                   $sourceCode, 
                                   $request->input('input'));

        return $this->respond(Response::HTTP_OK, $output);
    }

    public function testCase1(Request $request)
    {   
        $lang = 'python';
        $sourceCode = "print 'Hello, world!'";

        $output = Checker::checkTestCase($lang, 
                                         $sourceCode, 
                                         $request->input('input'), 
                                         $request->input('output'));

        return $this->respond(Response::HTTP_OK, $output);
    }


}
