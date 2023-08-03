<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Laravel\Firebase\Facades\Firebase;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->database = Firebase::database();
        $this->services = 'services';
    }

    public function index()
    {
        return response()->json('wew');
    }

    public function getServices()
    {
        $services = $this->database->getReference($this->services)->getValue();

        return response()->json($services, 200);
    }

    public function postService(Request $request)
    {
        $requiredFields = ['name'];

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
            'name' => $request->name,
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

        $service = $this->database->getReference($this->services)->push($postData);

        // Save the data to the 'apiHistory' reference
        // $historyRef = $this->database->getReference($this->apiHistorytable)->push($postDataHistory);

        if ($service) {
            return response()->json('success', 200);
        } else {
            return response()->json('fail', 500);
        }
    }

    public function putService(Request $request, $serviceId)
    {
        $requiredFields = ['name'];

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
            'name' => $request->name,
            'updatedAt' => time(),
        ];


        $service = $this->database->getReference($this->services.'/'.$serviceId)->update($postData);


        if ($service) {
            return response()->json('success', 200);
        } else {
            return response()->json('fail', 500);
        }
    }

    public function deleteService($serviceId)
    {
        $service = $this->database->getReference($this->services.'/'.$serviceId)->remove();

        if ($service) {
            return response()->json('success', 200);
        } else {
            return response()->json('fail', 500);
        }
    }
}
