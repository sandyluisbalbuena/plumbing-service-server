<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Laravel\Firebase\Facades\Firebase;

class InquiryController extends Controller
{
    public function __construct()
    {
        $this->database = Firebase::database();
        $this->inquiries = 'inquiries';
    }

    public function index()
    {
        return response()->json('wew');
    }

    public function getInquiries()
    {
        $inquiries = $this->database->getReference($this->inquiries)->getValue();

        return response()->json($inquiries, 200);
    }

    public function postInquiry(Request $request)
    {
        $requiredFields = [
            'firstName', 
            'lastName', 
            'email', 
            'phoneNumber', 
            'street1', 
            'city',
            'province',
            'postalCode',
            'serviceDetails',
            'serviceRequire'
        ];

        foreach ($requiredFields as $field) {
            if (!$request->has($field) || empty($request->input($field))) {
                return response()->json(['message' => "The field '{$field}' is required."], 400);
            }
        }

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

        $postData = [
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'phoneNumber' => $request->phoneNumber,
            'street1' => $request->street1,
            'city' => $request->city,
            'province' => $request->province,
            'postalCode' => $request->postalCode,
            'serviceDetails' => $request->serviceDetails,
            'serviceRequire' => $request->serviceRequire,
            'createdAt' => time(),
            'updatedAt' => time(),
        ];

        // Save the data to the 'threads' reference
        // $postData = [
        //     'title' => 'sample title',
        //     'slug' => 'sample slug',
        //     'content' => 'sample content',
        //     'createdAt' => time(),
        //     'updatedAt' => time(),
        // ];

        $inquiry = $this->database->getReference($this->inquiries)->push($postData);

        // Save the data to the 'apiHistory' reference
        // $historyRef = $this->database->getReference($this->apiHistorytable)->push($postDataHistory);

        if ($inquiry) {
            return response()->json('success', 200);
        } else {
            return response()->json('fail', 500);
        }
    }

    public function putInquiry(Request $request, $inquiryId)
    {
        $requiredFields = [
            'firstName', 
            'lastName', 
            'email', 
            'phoneNumber', 
            'street1', 
            'city',
            'province',
            'postalCode',
            'serviceDetails',
            'serviceRequire'
        ];

        // return response()->json($request, 200);


        foreach ($requiredFields as $field) {
            if (!$request->has($field) || empty($request->input($field))) {
                return response()->json(['message' => "The field '{$field}' is required."], 400);
            }
        }

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

        $postData = [
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'phoneNumber' => $request->phoneNumber,
            'street1' => $request->street1,
            'city' => $request->city,
            'province' => $request->province,
            'postalCode' => $request->postalCode,
            'serviceDetails' => $request->serviceDetails,
            'serviceRequire' => $request->serviceRequire,
            'updatedAt' => time(),
        ];


        $inquiry = $this->database->getReference($this->inquiries.'/'.$inquiryId)->update($postData);


        if ($inquiry) {
            return response()->json('success', 200);
        } else {
            return response()->json('fail', 500);
        }
    }

    public function deleteInquiry($inquiryId)
    {
        $inquiry = $this->database->getReference($this->inquiries.'/'.$inquiryId)->remove();

        if ($inquiry) {
            return response()->json('success', 200);
        } else {
            return response()->json('fail', 500);
        }
    }
}