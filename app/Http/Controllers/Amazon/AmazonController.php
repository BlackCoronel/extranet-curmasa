<?php


namespace App\Http\Controllers\Amazon;


use App\Http\Controllers\Controller;

class AmazonController extends Controller
{

    /**
     * AmazonController constructor.
     */
    public function __construct()
    {
    }

    public function index()
    {
        return view('amazon.index');
    }
}
