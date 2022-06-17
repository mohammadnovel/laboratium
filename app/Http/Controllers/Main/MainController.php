<?php

namespace App\Http\Controllers\Main;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Video;
use App\Models\Product;
use App\Models\Location;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $products = Product::all();
        // $videos = Video::all();
        // $events = Event::orderBy('event_date', 'asc')->limit(3)->get();
        // // $activities = Article::orderBy('id', 'desc')->limit(3)->get();
        // $galleries = Gallery::orderBy('id', 'desc')->limit(3)->get();
        // $locations = Location::select('id', 'name', 'latitude as lat', 'longitude as lng', 'description', 'url')->orderBy('id', 'desc')->get();
        // $locations = collect($locations->toArray())->keyBy('id');
        return view('main.index');
    }

    // public function aboutGi()
    // {
    //     return view('main.about-gi');
    // }

    // public function photoGallery()
    // {
    //     $galleries = Gallery::orderBy('id', 'desc')->get();
    //     return view('main.gallery', compact('galleries'));
    // }

    // public function video()
    // {
    //     $videos = Video::orderBy('id', 'desc')->get();
    //     return view('main.video', compact('videos'));
    // }
}
