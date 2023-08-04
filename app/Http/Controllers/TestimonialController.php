<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Factory;
// use Kreait\Firebase\ServiceAccount;


class TestimonialController extends Controller
{
    public function __construct()
    {
        $this->database = Firebase::database();
        $this->testimonials = 'testimonials';
    }

    public function index()
    {
        return response()->json('wew');
    }

    public function getTestimonials()
    {
        $services = $this->database->getReference($this->testimonials)->getValue();

        return response()->json(compact('services'), 200);
    }

    public function getTestimonial($testimonialId)
    {
        $service = $this->database->getReference($this->testimonials.'/'.$testimonialId)->getValue();

        return response()->json(compact('service'), 200);
    }

    public function postTestimonial(Request $request)
    {
        // $requiredFields = ['name', 'image', 'comment', 'rating'];

        // foreach ($requiredFields as $field) {
        //     if (!$request->has($field) || empty($request->input($field))) {
        //         return response()->json(['message' => "The field '{$field}' is required."], 400);
        //     }
        // }

        //         return response()->json(['message' => "The field '{$field}' is required."], 400);


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

        $factory = (new Factory())->withServiceAccount(__DIR__.'/plumbingservices-creds.json');

        $database = $factory->createDatabase();

        $image = $request->file('image');

        if ($image) {
            $storage = $database;
            $imagePath = 'images/testimonials/' . $image->getClientOriginalName();
            $imageStream = fopen($image->getRealPath(), 'r');

            $storage->getBucket()->upload($imageStream, [
                'name' => $imagePath,
            ]);

            $imageUrl = $storage->getBucket()->object($imagePath)->signedUrl(now()->addMinutes(60));

            // return response()->json(['imageUrl' => $imageUrl]);
        }

        $postData = [
            'name' => $request->name,
            'image' => $imageUrl,
            'comment' => $request->comment,
            'rating' => $request->rating,
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

        $service = $this->database->getReference($this->testimonials)->push($postData);

        // Save the data to the 'apiHistory' reference
        // $historyRef = $this->database->getReference($this->apiHistorytable)->push($postDataHistory);

        if ($service) {
            return response()->json('success', 200);
        } else {
            return response()->json('fail', 500);
        }
    }

    public function putTestimonial(Request $request, $testimonialId)
    {
        $requiredFields = ['name', 'image', 'comment', 'rating'];
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
            'image' => $request->image,
            'comment' => $request->comment,
            'rating' => $request->rating,
            'updatedAt' => time(),
        ];


        $service = $this->database->getReference($this->testimonials.'/'.$testimonialId)->update($postData);


        if ($service) {
            return response()->json('success', 200);
        } else {
            return response()->json('fail', 500);
        }
    }

    public function deleteTestimonial($testimonialId)
    {
        $service = $this->database->getReference($this->testimonials.'/'.$testimonialId)->remove();

        if ($service) {
            return response()->json('success', 200);
        } else {
            return response()->json('fail', 500);
        }
    }
}
