<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Laravel\Firebase\Facades\Firebase;

class InquiryController extends Controller
{
    private $database;

    public function __construct()
    {
        $this->database = Firebase::database();
        $this->inquiries = 'inquiries';
    }



    public function index(Request $request){


        return response()->json('wew');
    }

    public function getInquiries(){
        $inquiries = $this->database->getReference($this->inquiries)->getValue();

        return response()->json($inquiries);
    }

    public function postthreaddata()
    {
        // $requiredFields = ['categoryId', 'title', 'slug', 'content', 'userId', 'createdAt', 'updatedAt'];

        // foreach ($requiredFields as $field) {
        //     if (!$request->has($field) || empty($request->input($field))) {
        //         return response()->json(['message' => "The field '{$field}' is required."], 400);
        //     }
        // }

        // $url = 'api/thread';
        // $method = 'post';

        // $postData = [
        //     'categoryId' => $request->categoryId,
        //     'title' => $request->title,
        //     'slug' => $request->slug,
        //     'content' => $request->content,
        //     'userId' => $request->userId,
        //     'createdAt' => $request->createdAt,
        //     'updatedAt' => $request->updatedAt,
        // ];

        // $postDataHistory = [
        //     'userId' => $request->userId,
        //     'url' => $url,
        //     'method' => $method,
        //     'createdAt' => time(),
        // ];

        // Save the data to the 'threads' reference
        $postData = [
            'title' => 'sample title',
            'slug' => 'sample slug',
            'content' => 'sample content',
            'createdAt' => time(),
            'updatedAt' => time(),
        ];
        $inquiry = $this->database->getReference($this->inquiries)->push($postData);

        // Save the data to the 'apiHistory' reference
        // $historyRef = $this->database->getReference($this->apiHistorytable)->push($postDataHistory);

        if ($inquiry) {
            return response()->json('success');
        } else {
            return response()->json('fail', 500);
        }
    }
}
