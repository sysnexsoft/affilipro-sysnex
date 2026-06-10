<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return view('frontEnd.home.index');
    }
    public function contactUs(){
        return view('frontEnd.contact-us.index');
    }
    public function aboutUs(){
        return view('frontEnd.about-us.index');
    }
    public function product(){
        return view('frontEnd.product.index');
    }
    public function categories(){
        return view('frontEnd.category.index');
    }
    public function blog(){
        return view('frontEnd.blog.index');
    }
    public function compare(){
        return view('frontEnd.compare.index');
    }
    public function review(){
        return view('frontEnd.review.index');
    }
}
