<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\API\APIBaseController as APIBaseController;
use Validator;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Imports\questionsImport;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Storage;


class PostAPIController extends APIBaseController

{

    public $fileType="csv";

    public function index(Request $request)

    {

        $lang = $request->query('lang');
        if (!is_null($lang)) {
            $tr=new GoogleTranslate();
            $tr->setSource();
            $tr->setTarget($lang);}

        if ($this->fileType=="csv") {

            $import= new questionsImport();
            $data=\Excel::toArray($import,"public/questions.csv");

            $newData=[];
            foreach ($data[0] as $i=>$j) {
                $tmp_data=[];
                foreach($data[0][$i] as $k=>$v) {
                    if (strpos($k,"question")!==false) $newData[0][$i]["text"]=!is_null($lang) ? $tr->translate($v) : $v;
                    else if (strpos($k,"creat")!==false) $newData[0][$i]["createdAt"]=!is_null($lang) ? $tr->translate($v) : $v;
                        else {
                            $tmp_data[]=!is_null($lang) ? $tr->translate($v) : $v;
                    }
                }
                $newData[0][$i]["choices"]=$tmp_data;
            }

        }

        else {

            $json = Storage::get('public/questions.json');
            $data = json_decode($json, true);

            foreach ($data as $i=>$j) {
                foreach($data[$i] as $k=>$v) {
                    if (!is_array($data[$i][$k])) {
                        $newData[$i][$k] =!is_null($lang) ? $tr->translate($v) : $v;
                    }
                    else {
                        foreach($data[$i][$k] as $t=>$p)
                        $newData[$i][$k][$t] =!is_null($lang) ? $tr->translate($p["text"]) : $p["text"];
                    }
                }
            }
        }

        return $this->sendResponse($newData, 'Questions retrieved successfully.');

    }


    public function store(Request $request)

    {

        $input = $request->all();

        $validator = Validator::make($input, [
            'question'=>'bail|required|max:1000',
            'choice1'=>'bail|required|max:250',
            'choice2'=>'bail|required|max:250',
            'choice3'=>'bail|required|max:250'
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if ($this->fileType=="csv") {

            $addCsv='"'.request('question').'",'.
                '"'.date("Y-m-d 00:00:00").'",'.
                '"'.request('choice1').'",'.
                '"'.request('choice2').'",'.
                '"'.request('choice3').'"';

            Storage::append("public/questions.csv",$addCsv);
        }

        else {


            $addJSON = $request->only(['question', 'choice1', 'choice2','choice3']);

            $addJSON=array_merge(array_slice($addJSON,0,1),array('createdAt' => date('Y-m-d H:i:s')),array_slice($addJSON,1));

            $json = Storage::get('public/questions.json');

            $data = json_decode($json, true);

            array_push($data,$addJSON);

            Storage::put("public/questions.json",json_encode($data));
        }

        return $this->sendResponse($input, 'Question added successfully.');

    }

}
