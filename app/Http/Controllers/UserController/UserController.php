<?php

namespace App\Http\Controllers\UserController;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Transformers\UserTransformer;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Controller\TraceableControllerResolver;

class UserController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(20);

        return $this->response->paginator($users, new UserTransformer());
    }


    /**
     * Store a newly created resource in storage.
     * @param UserCreateRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
        $user = $this->userService->create($request->all());
        return $this->response->item($user, new UserTransformer());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->userService->find($id);
        return $this->response->item($user, new UserTransformer());
    }



    /**
     * Update the specified resource in storage.
     *
     * param UserUpdateRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $user = $this->userService->find($id);
        $user = $this->userService->update($user, $request->all());
        return $this->response->item($user, new UserTransformer());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->userService->find($id);
        $this->userService->delete($user);

        return $this->success();
    }
}
