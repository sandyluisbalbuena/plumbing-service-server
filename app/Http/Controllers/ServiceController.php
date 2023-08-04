<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Laravel\Firebase\Facades\Firebase;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->database = Firebase::database();
        $this->serviceCategories = 'serviceCategories';
        $this->services = 'services';
    }

    public function index()
    {
        return response()->json('wew');
    }

    public function getServiceCategories()
    {
        $services = $this->database->getReference($this->serviceCategories)->getValue();

        return response()->json($services, 200);
    }

    public function getServiceCategory($serviceId)
    {
        $service = $this->database->getReference($this->serviceCategories.'/'.$serviceId)->getValue();

        return response()->json($service, 200);
    }

    public function postServiceCategory(Request $request)
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

        $service = $this->database->getReference($this->serviceCategories)->push($postData);

        // Save the data to the 'apiHistory' reference
        // $historyRef = $this->database->getReference($this->apiHistorytable)->push($postDataHistory);

        if ($service) {
            return response()->json('success', 200);
        } else {
            return response()->json('fail', 500);
        }
    }

    public function putServiceCategory(Request $request, $serviceId)
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


        $service = $this->database->getReference($this->serviceCategories.'/'.$serviceId)->update($postData);


        if ($service) {
            return response()->json('success', 200);
        } else {
            return response()->json('fail', 500);
        }
    }

    public function deleteServiceCategory($serviceId)
    {
        $service = $this->database->getReference($this->serviceCategories.'/'.$serviceId)->remove();

        if ($service) {
            return response()->json('success', 200);
        } else {
            return response()->json('fail', 500);
        }
    }
}
