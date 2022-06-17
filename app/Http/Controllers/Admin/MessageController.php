<?php

namespace App\Http\Controllers;

use App\Traits\XIForm;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Http\Requests\MessageRequest;
use App\Models\Group;
use App\Models\Message;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    private $module, $model, $form;
    protected $repository;
    use XIForm;

    public function __construct(Message $repository, FormBuilder $formBuilder)
    {
        $this->module = 'message';
        $this->repository = $repository;
        $this->formBuilder = $formBuilder;
        $this->form = 'App\Forms\MessageForm';

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
            $data = $this->repository;
            if ($request->user()->type == 'user') $data = $data->whereCompanyId(Auth::user()->company_id);
            $data = $data->orderBy('created_at', 'DESC');

            return DataTables::of($data)
                ->addColumn('file', function ($data) {
                    if (data_get($data, 'file')) {
                        return '<a href="' . data_get($data, 'file') . '" target="_blank">Load More</a>';
                    }
                    return '';
                })
                ->addColumn('status', function ($data) {
                    return data_get(config('status.message'), $data->status);
                })
                ->addColumn('action', function ($data) {
                    $buttons[] = ['type' => 'detail', 'route' => route($this->module . '.show', $data->id), 'label' => 'Detail', 'action' => 'primary', 'icon' => 'share'];

                    return $this->icon_button($buttons);
                })
                ->rawColumns(['file', 'status', 'action'])
                ->make();
        }

        $buttons[] = [
            'label' => 'Resend Pending',
            'route' => route($this->module . '.resend'),
            'confirm' => 'Are you sure?',
            'class'  => 'btn-lg',
            'method' => 'POST',
            'action' => 'primary'
        ];
        $button = $this->icon_button($buttons);

        return view('pages.' . $this->module . '.index', ['button' => $button]);
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
    public function store(MessageRequest $request)
    {
        if (!$request->user()->can($this->module . '.create')) return notPermited();

        DB::beginTransaction();
        try {
            $data = [];
            $user = Auth::user();
            $group = Group::with('phones')->find(data_get($request, 'group_id'));

            $url = null;
            if ($request->hasFile('file')) {
                $path = 'uploads/file/' . Auth::user()->id;
                $storage = Storage::putFile($path, $request->file, 'public');
                $url =  Storage::url($storage);
            }

            if ($group) {
                foreach (data_get($group, 'phones', []) as $value) {
                    array_push($data, [
                        'company_id' => $user->company_id,
                        'user_id' => $user->id,
                        'session_id' => data_get($request, 'session_id'),
                        'group_id' => data_get($request, 'group_id'),
                        'group_phone_id' => data_get($value, 'id'),
                        'code' => null,
                        'price' => data_get($user, 'company.price'),
                        'phone' => data_get($value, 'phone'),
                        'text' => data_get($request, 'text'),
                        'file' => $url,
                        'status' => -10,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                }
            } else {
                $phones = explode(",", rtrim($request->phones, ','));
                foreach ($phones as $phone) {
                    array_push($data, [
                        'company_id' => $user->company_id,
                        'user_id' => $user->id,
                        'session_id' => data_get($request, 'session_id'),
                        'group_id' => null,
                        'group_phone_id' => null,
                        'code' => null,
                        'price' => data_get($user, 'company.price'),
                        'phone' => trim($phone),
                        'text' => data_get($request, 'text'),
                        'file' => $url,
                        'status' => -10,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                }
            }

            $this->repository->insert($data);
            gilog("Create " . $this->module, $user, $data);
            DB::commit();

            $client = new Client();
            $client->request('GET', config('app.url_bot') . '/send-message/' . $user->company_id);

            flash('Success create ' . $this->module)->success();
        } catch (ClientException $ce) {
            DB::rollBack();
            flash($ce->getMessage())->error();
        } catch (\Exception $ex) {
            DB::rollBack();
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
        $detail = new Message();
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
    public function update(MessageRequest $request, $id)
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

    public function resend(Request $request)
    {
        try {
            $client = new Client();
            $client->request('GET', config('app.url_bot') . '/send-message/' . $request->user()->company_id);

            $data['message'] = 'Resend Pending in progress';
            $status = 200;
        } catch (\Exception $ex) {
            $data['message'] = $ex->getMessage();
            $status = 500;
        }
        return response()->json($data, $status);
    }
}
