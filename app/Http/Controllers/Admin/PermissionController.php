<?php

namespace App\Http\Controllers\Admin;

use App\Traits\XIForm;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Kris\LaravelFormBuilder\FormBuilder;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\PermissionRequest;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    private $module, $model, $form;
    protected $repository;
    use XIForm;

    public function __construct(Permission $repository, FormBuilder $formBuilder)
    {
        $this->module = 'permission';
        $this->route = 'admin.permission';
        $this->repository = $repository;
        $this->formBuilder = $formBuilder;
        $this->form = 'App\Forms\PermissionForm';

        View::share('module', $this->module);
        View::share('route', $this->route);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // if (!$request->user()->can($this->module . '.view')) return notPermited();

        if ($request->ajax()) {
            $data = $this->repository->all();
            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    $buttons[] = ['type' => 'edit', 'route' => route($this->route . '.edit', $data->id), 'label' => 'Edit', 'icon' => 'edit'];
                    $buttons[] = ['type' => 'delete', 'label' => 'Delete', 'confirm' => 'Are you sure?', 'route' => route($this->route . '.destroy', $data->id)];

                    return $this->icon_button($buttons);
                })
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
        // if (!$request->user()->can($this->module . '.create')) return notPermited();

        $data['form'] = $this->formBuilder->create($this->form, [
            'method' => 'POST',
            'url' => route($this->route . '.store')
        ]);

        return view('pages.' . $this->module . '.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
        // if (!$request->user()->can($this->module . '.create')) return notPermited();

        try {
            DB::transaction(function () use ($request) {
                $data['name'] = $request->name;
                $post = $this->repository->create($data);
                // gilog("Create " . $this->module, $post, $data);
            });
            flash('Success create ' . $this->module)->success();
        } catch (\Exception $ex) {
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        // if (!$request->user()->can($this->module . '.update')) return notPermited();

        $get = $this->repository->find($id);
        $data['form'] = $this->formBuilder->create($this->form, [
            'method' => 'PUT',
            'url' => route($this->route . '.update', $id),
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
    public function update(PermissionRequest $request, $id)
    {
        // if (!$request->user()->can($this->module . '.update')) return notPermited();

        try {
            DB::transaction(function () use ($id, $request) {
                $data['name'] = $request->name;
                $post = $this->repository->find($id);
                $post->update($data);
                // gilog("Create " . $this->module, $post, $data);
            });
            flash('Success update ' . $this->module)->success();
        } catch (\Exception $ex) {
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
        // if (!$request->user()->can($this->module . '.delete')) return notPermited('json');

        try {
            DB::transaction(function () use ($id) {
                $get = $this->repository->find($id);
                $get->delete($id);
                // gilog("Delete " . $this->module, $get, ['notes' => @request('notes')]);
            });
            $data['message'] = 'Success delete ' . $this->module;
            $status = 200;
        } catch (\Exception $ex) {
            $data['message'] = $ex->getMessage();
            $status = 500;
        }
        return response()->json($data, $status);
    }
}
