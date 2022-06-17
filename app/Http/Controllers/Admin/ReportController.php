<?php

namespace App\Http\Controllers\Admin;

use App\Traits\XIForm;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Http\Requests\ReportRequest;
use App\Models\Report;
use App\Models\Service;
use App\Models\General;
use App\Models\MutuIndicator;
use App\Models\Parameter;
use App\Models\Compotition;
use App\Models\PatientIndification;
use App\Models\DetailReportCompotition;
use App\Models\DetailReportParameter;
use App\Models\DetailReportPatientIndification;
use App\Models\DetailReportService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use PDF;
class ReportController extends Controller
{
    private $module, $model, $form;
    protected $repository;
    use XIForm;

    public function __construct(Report $repository, FormBuilder $formBuilder)
    {
        $this->module = 'report';
        $this->route = 'admin.report';
        $this->repository = $repository;
        $this->formBuilder = $formBuilder;
        $this->form = 'App\Forms\ReportForm';
        $this->path = 'lab/Report';

        View::share('module', $this->module);
        View::share('route', $this->route);
        View::share('services', Service::pluck('name', 'id'));
        View::share('parameters', Parameter::pluck('name', 'id'));
        View::share('compotitions', Compotition::pluck('name', 'id'));
        View::share('patient_indifications', PatientIndification::pluck('name', 'id'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->user()->can($this->module . '.view')) return notPermited();

        if ($request->ajax()) {
            $data = $this->repository->orderBy('created_at', 'DESC');

            return DataTables::of($data)

                ->addColumn('description', function ($data) {
                    return  Str::limit(data_get($data, 'description'), 100, ' (...)');
                })
                ->addColumn('action', function ($data) use ($request) {
                    $buttons[] = ['type' => 'report', 'route' => route('report-download', $data->id), 'label' => 'Download', 'icon' => 'download'];
                    $buttons[] = ['type' => 'detail', 'route' => route($this->route . '.show', $data->id), 'label' => 'Detail', 'action' => 'primary', 'icon' => 'share'];
                    $buttons[] = ['type' => 'edit', 'route' => route($this->route . '.edit', $data->id), 'label' => 'Edit', 'icon' => 'edit'];
                    $buttons[] = ['type' => 'delete', 'label' => 'Delete', 'confirm' => 'Are you sure?', 'route' => route($this->route . '.destroy', $data->id)];

                    return $this->icon_button($buttons, true);
                })
                ->rawColumns(['action'])
                ->make();
        }
        return view('pages.' . $this->module . '.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!$request->user()->can($this->module . '.create')) return notPermited();

        $data['form'] = $this->formBuilder->create($this->form, [
            'method' => 'POST',
            'url' => route($this->route . '.store'),
            'enctype' => 'multipart/form-data'
        ]);

        return view('pages.' . $this->module . '.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReportRequest $request)
    {
        if (!$request->user()->can($this->module . '.create')) return notPermited();

        DB::beginTransaction();
        try {
            $data = $request->all();

            $data['user_id'] = Auth::user()->id;
            $post = $this->repository->create($data);
            
            // insert to detail report service
            if (!empty($data['service_id'])) {
                foreach ($data['service_id'] as $key => $value) {
                    $data_service = [
                        'report_id' => $post->id,
                        'service_id' => $value,
                        'user_id' => $post->user_id,
                        'qty' => $data['qty_service'][$key]
                    ];
                    DetailReportService::create($data_service);
                }
            }

            // insert to detail report parameter
            if (!empty($data['parameter_id'])) {
                foreach ($data['parameter_id'] as $key => $value) {
                    $data_parameter = [
                        'report_id' => $post->id,
                        'parameter_id' => $value,
                        'user_id' => $post->user_id,
                        'qty' => $data['qty_parameter'][$key]
                    ];
                    DetailReportParameter::create($data_parameter);
                }
            }

            // insert to detail report compotition
            if (!empty($data['compotition_id'])) {
                foreach ($data['compotition_id'] as $key => $value) {
                    $data_compotition = [
                        'report_id' => $post->id,
                        'compotition_id' => $value,
                        'user_id' => $post->user_id,
                        'qty' => $data['qty_compotition'][$key]
                    ];
                    DetailReportCompotition::create($data_compotition);
                }
            }

            // insert to detail report patient indification
            if (!empty($data['patient_indification_id'])) {
                foreach ($data['patient_indification_id'] as $key => $value) {
                    $data_patient_indification = [
                        'report_id' => $post->id,
                        'patient_indification_id' => $value,
                        'user_id' => $post->user_id,
                        'qty' => $data['qty_patient_indification'][$key]
                    ];
                    DetailReportPatientIndification::create($data_patient_indification);
                }
            }



            

            gilog("Create " . $this->module, $post, $data);
            DB::commit();
            flash('Success create ' . $this->module)->success();
        } catch (\Exception $ex) {
            DB::rollBack();
            flash($ex->getMessage())->error();
        }
        return redirect()->route($this->route . '.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if (!$request->user()->can($this->module . '.view')) return notPermited();

        $get = $this->repository->with('Report_marketplaces')->find($id);
        $data['detail'] = $get;
        $detail = new Report();
        $data['shows'] = $detail->getFillable();
        return view('pages.' . $this->module . '.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        if (!$request->user()->can($this->module . '.update')) return notPermited();

        $get = $this->repository->with('Report_marketplaces')->find($id);
        $data['form'] = $this->formBuilder->create($this->form, [
            'method' => 'PUT',
            'url' => route($this->route . '.update', $id),
            'enctype' => 'multipart/form-data',
            'model' => $get
        ]);
        $data['data'] = $get;
        $data['isEdit'] = true;
        // dd($data);

        return view('pages.' . $this->module . '.create', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReportRequest $request, $id)
    {
        if (!$request->user()->can($this->module . '.update')) return notPermited();

        DB::beginTransaction();
        try {
            $data = $request->all();
            // dd($data);
            $post = $this->repository->find($id);
            if ($request->hasFile('image')) {
                $path = Storage::disk('spaces')->putFile($this->path, $request->image, 'public');
                $data['image'] = str_replace('https://', 'https://' . env('DO_SPACES_BUCKET') . '.', env('DO_SPACES_ENDPOINT')) . '/' . $path;
            }
            if ($request->hasFile('thumbnail')) {
                $path = Storage::disk('spaces')->putFile($this->path, $request->thumbnail, 'public');
                $data['thumbnail'] = str_replace('https://', 'https://' . env('DO_SPACES_BUCKET') . '.', env('DO_SPACES_ENDPOINT')) . '/' . $path;
            }

            if ($request->hasFile('brochure')) {
                $path = Storage::disk('spaces')->putFile($this->path, $request->brochure, 'public');
                $data['brochure'] = str_replace('https://', 'https://' . env('DO_SPACES_BUCKET') . '.', env('DO_SPACES_ENDPOINT')) . '/' . $path;
            }

            if (!empty($data['marketplace_id'])) {
                ReportMarketplace::whereReportId($id)->forceDelete();

                foreach ($data['marketplace_id'] as $key => $value) {
                    $data_marketplace = [
                        'Report_id' => $post->id,
                        'marketplace_id' => $value,
                        'link' => $data['link'][$key]
                    ];
                    ReportMarketplace::create($data_marketplace);
                }
            }
            
            if (!empty($data['Report_image'])) {
                ReportImage::whereReportId($id)->forceDelete();
                foreach ($data['Report_image'] as $key => $value) {
                    $storage = Storage::disk('spaces')->putFile($this->path, $value, 'public');
    
                    $data_image = [
                        'Report_id' => $post->id,
                        'path' => str_replace('https://', 'https://' . env('DO_SPACES_BUCKET') . '.', env('DO_SPACES_ENDPOINT')) . '/' . $storage
                    ];
                    ReportImage::create($data_image);
                }
            }

            $post->update($data);

            gilog("Create " . $this->module, $post, $data);
            DB::commit();
            flash('Success update ' . $this->module)->success();
        } catch (\Exception $ex) {
            DB::rollBack();
            flash($ex->getMessage())->error();
        }
        return redirect()->route($this->route . '.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if (!$request->user()->can($this->module . '.delete')) return notPermited('json');

        try {
            DB::transaction(function () use ($id) {
                $get = $this->repository->find($id);
                if (count($get->Report_marketplaces) > 0) $get->Report_marketplaces()->delete();
                $get->delete($id);
                gilog("Delete " . $this->module, $get, ['notes' => @request('notes')]);
            });
            $data['message'] = 'Success delete ' . $this->module;
            $status = 200;
        } catch (\Exception $ex) {
            $data['message'] = $ex->getMessage();
            $status = 500;
        }
        return response()->json($data, $status);
    }

    public function GenerateReport($id)
    {
        $report = Report::query()
        ->with([
            'report_service',
            'report_service.service',
            'report_parameter',
            'report_parameter.parameter',
            'report_patient_indification',
            'report_patient_indification.patient_indification',
            'report_compotition',
            'report_compotition.compotition'
        ])
        ->whereId($id)
        ->first();
        $general = General::whereId(1)->first();
        $indicator_mutu = MutuIndicator::all();
// dd($general);

        $data = [
            'report' => $report,
            'general' => $general,
            'indicator_mutu' => $indicator_mutu,
        ];
        
        $pdf = PDF::loadView('report', $data);
        $name = "Report-lab_".$report->from_date."-".$report->to_date;
        return $pdf->download($name.'.pdf');
        // return view('report', compact('report','general','indicator_mutu'));
        
    }
}
