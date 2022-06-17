<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Compotition;
use App\Models\Parameter;
use App\Models\Service;
use App\Models\PatientIndification;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $compotition = Compotition::count();
        $service = Service::count();
        $parameter = Parameter::count();
        $patientIndification = PatientIndification::count();
        return view('home', compact('compotition', 'service', 'parameter', 'patientIndification'));
    }
}
