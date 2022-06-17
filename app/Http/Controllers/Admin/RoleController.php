<?php

namespace App\Http\Controllers\Admin;

use App\Traits\XIForm;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Kris\LaravelFormBuilder\FormBuilder;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\RoleRequest;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    private $module, $model, $form, $formRequest;
    protected $repository;
    use XIForm;

    public function __construct(Role $repository, FormBuilder $formBuilder)
    {
        $this->module = 'role';
        $this->route = 'admin.role';
        $this->repository = $repository;
        $this->formBuilder = $formBuilder;
        $this->form = 'App\Forms\RoleForm';
        $this->formRequest = 'App\Http\Requests\RoleRequest';
        View::share(['module' => $this->module, 'formRequest' => $this->formRequest]);
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
                ->addColumn('permission', function ($data) {
                    $collection = $data->permissions();
                    return '<label class="label label-info">' . $collection->pluck('name')->implode('</label> <label class="label label-info">') . '</label>';
                })
                ->rawColumns(['permission', 'action'])
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
        $data['permissions'] = Permission::all();
        return view('pages.' . $this->module . '.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        // if (!$request->user()->can($this->module . '.create')) return notPermited();

        try {
            DB::transaction(function () use ($request) {
                $data['name'] = $request->name;
                $post = $this->repository->create($data);
                $this->assignPermission($post, $data);
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
        $data['data'] = $get;
        $data['permissions'] = Permission::get();
        return view('pages.' . $this->module . '.create', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id)
    {
        // if (!$request->user()->can($this->module . '.update')) return notPermited();

        try {
            DB::transaction(function () use ($id, $request) {
                $input = $request->only(['name']);
                $data = $this->repository->findOrFail($id);
                $data->fill($input)->save();
                $permission = Permission::all();
                $data->revokePermissionTo($permission);
                $this->assignPermission($data, $request->permissions);

                // gilog("Create " . $this->module, $data, $data);
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
                $permission = Permission::get();
                $get->revokePermissionTo($permission);
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

    public function assignPermission($role, $permission)
    {
        $role->givePermissionTo($permission);
    }
}
