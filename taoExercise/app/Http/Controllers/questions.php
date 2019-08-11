<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Excel;
use App\Imports\questionsImport;
use Stichoza\GoogleTranslate\GoogleTranslate;

class questions extends Controller
{
    public function getQuestions($lang=null) {

        $import= new questionsImport();

        $data=\Excel::toArray($import,"public/questions.csv");

        if (!is_null($lang)) {
            $tr=new GoogleTranslate();
            $tr->setSource();
            $tr->setTarget($lang);}

        $csv_data=[];
        foreach ($data[0] as $i=>$j) {
            $tmp_data=[];
            foreach($data[0][$i] as $k=>$v) {
                $tmp_data[]=!is_null($lang) ? $tr->translate($v) : $v;
            }
        $csv_data[]=$tmp_data;}

        return view("questions",compact("csv_data"));
    }


    public function addQuestion(Request $request) {

        $data = $request->validate([
            'question'=>'bail|required|max:1000',
            'choice1'=>'bail|required|max:250',
            'choice2'=>'bail|required|max:250',
            'choice3'=>'bail|required|max:250'
    ]);

    $addCsv='"'.request('question').'",'.
            '"'.date("Y-m-d 00:00:00").'",'.
            '"'.request('choice1').'",'.
            '"'.request('choice2').'",'.
            '"'.request('choice3').'"';
   Storage::append("public/questions.csv",$addCsv);

    return redirect("/questions")->with("message","Question added successfully!");
    }

}
