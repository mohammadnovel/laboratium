<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\XIForm;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;
use Proengsoft\JsValidation\Facades\JsValidatorFacade as JsValidator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    use XIForm;
    public function __construct(User $user, FormBuilder $formBuilder)
    {
        $this->repository = $user;
        $this->formBuilder = $formBuilder;
        $this->module = 'user';
        $this->route = 'admin.user';
        $this->permissions = ["view", "create", "update", "delete"];
        $this->formRequest = 'App\Http\Requests\UserRequest';
        $this->form = "App\Forms\UserForm";
        View::share(['module' => $this->module]);
        View::share(['route' => $this->route]);
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
                    $buttons[] = ['type' => 'detail', 'route' => route($this->route . '.show', $data->id), 'label' => 'Detail', 'action' => 'primary', 'icon' => 'share'];
                    $buttons[] = ['type' => 'edit', 'route' => route($this->route . '.edit', $data->id), 'label' => 'Edit', 'icon' => 'edit'];
                    $buttons[] = ['type' => 'reject', 'route' => route($this->route . '.destroy', $data->id), 'confirm' => 'Are you sure?', 'label' => 'Delete'];

                    if ($request->user()->type == 'super-admin') {
                        $buttons[] = [
                            'label' => 'Login sebagai ' . $data->name,
                            'route' => route($this->route . '.login-as', $data->id),
                            'confirm' => 'Are you sure?',
                            'form' => [],
                            'method' => 'PATCH',
                            'action' => 'info'
                        ];
                    }

                    return $this->icon_button($buttons, true);
                })
                ->addColumn('role', function ($data) {
                    return '<label class="label label-info">' . $data->roles()->pluck('name')->implode('</label> <label class="label label-info">') . '</label>';
                })
                // ->addColumn('company', function ($data) {
                //     return data_get($data, 'company.name');
                // })
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
            'url' => route($this->route . '.store')
        ]);
        $data['validator'] = JsValidator::formRequest($this->formRequest);
        return view('pages.' . $this->module . '.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        if (!$request->user()->can($this->module . '.create')) return notPermited();

        try {
            DB::transaction(function () use ($request) {
                $input = $request->all();
                $input['type'] = Str::lower(data_get(config('status.type'), $request->type));
                if ($input['password']) $input['password'] = Hash::make($input['password']);

                $post = $this->repository->create($input);
                return $this->assignRole($post, $input['type']);
                gilog("Create " . $this->module, $post, $input);
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
    public function show(Request $request, $id)
    {
        if (!$request->user()->can($this->module . '.view')) return notPermited();

        $get = $this->repository->find($id);
        $data['detail'] = $get;
        $detail = new User();
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
        $get->password = "";
        $data['form'] = $this->formBuilder->create($this->form, [
            'method' => 'PUT',
            'url' => route($this->route . '.update', $id),
            'model' => $get
        ]);
        $data['detail'] = $get;

        return view('pages.' . $this->module . '.create', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        if (!$request->user()->can($this->module . '.update')) return notPermited();

        try {
            DB::transaction(function () use ($request, $id) {
                $input = $request->all();
                if ($input['password']) {
                    $input['password'] = Hash::make($input['password']);
                } else {
                    unset($input['password']);
                }
                $input['type'] = Str::lower(data_get(config('status.type'), $request->type));

                $post = $this->repository->update($input, $id);
                $this->assignRole($post, $input['type']);
                gilog("Create " . $this->module, $post, $input);
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
        if (!$request->user()->can($this->module . '.delete')) return notPermited();

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

    public function assignRole($model, $roles = '')
    {
        foreach ($model->roles as $key => $value) {
            $model->removeRole($value);
        }
        if (isset($roles)) {
            $model->assignRole($roles);
        }
    }

    public function loginAs(Request $request, $id)
    {
        if (Auth::user()->type == 0) {
            $request->session()->put('admin_login', Auth::user()->id);
        } else {
            $request->session()->forget('admin_login');
        }
        Auth::loginUsingId($id);
        $data['status'] = 1;
        $data['redirect'] = url('/');
        return response()->json($data, 200);
    }
}
