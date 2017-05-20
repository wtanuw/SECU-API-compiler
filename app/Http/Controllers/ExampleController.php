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

    public function update(Request $request)
    {   
        $lang = 'python';
        $sourceCode = "print 'Hello, world!'";

        $output = $this->fncUpdateResult(1, 
                                         2, 
                                         3, 
                                         4, 
                                         4, 
                                         "message");

        return $this->respond(Response::HTTP_OK, $output);
    }

    public function fncUpdateResult($user_id, $question_id, $script, $result, $score, $message){
    $objStudentAnswer = Answer::updateOrCreate(
    ['user_id' => $user_id,
    'question_id' => $question_id],
    ['script' => $script,
    'result' => $result,
    'score' => $score,
    'message' => $message]
    );
    $objStudentAnswer->save();
    
    
    $result = App\StudentAnswer::where('user_id', $user_id)
  ->where('question_id', $question_id)
  ->update(['result' => $result, 'score' => $score, 'message' => $message]);


    return response()->json(["result"=>$result,"message"=>$message]);
    }
}
