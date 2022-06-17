<?php

namespace App\Http\Controllers;

use App\Traits\XIForm;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Models\Session;
use App\Http\Requests\SessionRequest;
use App\Models\Company;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SessionController extends Controller
{
    private $module, $model, $form;
    protected $repository;
    use XIForm;

    public function __construct(Session $repository, FormBuilder $formBuilder)
    {
        $this->module = 'session';
        $this->repository = $repository;
        $this->formBuilder = $formBuilder;
        $this->form = 'App\Forms\SessionForm';

        View::share('module', $this->module);
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
            $data = $this->repository->all();
            return DataTables::of($data)
                ->addColumn('action', function ($data) use ($request) {
                    $buttons[] = ['type' => 'detail', 'route' => route($this->module . '.scan', $data->id), 'label' => 'Scan', 'action' => 'primary', 'icon' => 'scan', 'target' => '_blank'];
                    $buttons[] = ['type' => 'detail', 'route' => route($this->module . '.show', $data->id), 'label' => 'Detail', 'action' => 'primary', 'icon' => 'share'];
                    $buttons[] = ['type' => 'edit', 'route' => route($this->module . '.edit', $data->id), 'label' => 'Edit', 'icon' => 'edit'];
                    $buttons[] = ['type' => 'reject', 'route' => route($this->module . '.destroy', $data->id), 'confirm' => 'Are you sure?', 'label' => 'Delete'];

                    return $this->icon_button($buttons, true);
                })
                ->addColumn('company', function ($data) {
                    return data_get($data, 'company.name');
                })
                ->rawColumns(['action', 'role'])
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
            'url' => route($this->module . '.store')
        ]);

        return view('pages.' . $this->module . '.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SessionRequest $request)
    {
        if (!$request->user()->can($this->module . '.create')) return notPermited();

        try {
            DB::transaction(function () use ($request) {
                $user = Auth::user();
                $data = $request->all();
                if ($user->type == 'user') $data['company_id'] = $user->company_id;

                $post = $this->repository->create($data);
                gilog("Create " . $this->module, $post, $data);
            });
            flash('Success create ' . $this->module)->success();
        } catch (\Exception $ex) {
            flash($ex->getMessage())->error();
        }
        return redirect()->route($this->module . '.index');
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

        $get = $this->repository->find($id);
        $data['detail'] = $get;
        $detail = new Session();
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

        $get = $this->repository->find($id);
        $data['form'] = $this->formBuilder->create($this->form, [
            'method' => 'PUT',
            'url' => route($this->module . '.update', $id),
            'model' => $get
        ]);

        return view('pages.' . $this->module . '.create', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SessionRequest $request, $id)
    {
        if (!$request->user()->can($this->module . '.update')) return notPermited();

        try {
            DB::transaction(function () use ($id, $request) {
                $data = $request->all();
                $post = $this->repository->find($id);
                $post->update($data);
                gilog("Create " . $this->module, $post, $data);
            });
            flash('Success update ' . $this->module)->success();
        } catch (\Exception $ex) {
            flash($ex->getMessage())->error();
        }
        return redirect()->route($this->module . '.index');
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

    public function scan($id)
    {
        try {
            $session = Session::findOrFail($id);
            $client = new Client();
            $response = $client->request('GET', config('app.url_bot') . '/create/' . $session->name);

            $data = json_decode($response->getBody()->getContents(), true);
            if (data_get($data, 'status') == 'connecting') {
                return '<img src="' . data_get($response, 'qrcode') . '"></img>';
            } else {
                return $response;
            }
        } catch (ClientException $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
