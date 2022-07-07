<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiExceptionManager;
use Illuminate\Http\Request;
use App\Http\Requests\TeamStoreRequest;
use App\Models\Team;
use PhpParser\Node\Stmt\TryCatch;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $team = Team::where('user_id',1)->get();
        return response($team, \Illuminate\Http\Response::HTTP_OK, ['success']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TeamStoreRequest $request)
    {
        try {
            $request->merge(['user_id' => 1]);
            Team::create($request->toArray());
            $team = Team::where('user_id',1)->get();
            return response($team, \Illuminate\Http\Response::HTTP_OK, ['success']);
        } catch (\Throwable $th) {
            return ApiExceptionManager::handleException($th, func_get_args(), 'team store error');
        }
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TeamStoreRequest $request, $id)
    {
        try {
            Team::find($id)->update($request->toArray());
            //TODO: change user_id for authenticated user_id.
            $team = Team::where('user_id',1)->get();
            return response($team, \Illuminate\Http\Response::HTTP_OK, ['success']);
        } catch (\Throwable $th) {
            return ApiExceptionManager::handleException($th, func_get_args(), 'team update error');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Team::destroy($id);
            $team = Team::where('user_id',1)->get();
            return response($team, \Illuminate\Http\Response::HTTP_OK, ['success']);
        } catch (\Throwable $th) {
            return ApiExceptionManager::handleException($th, func_get_args(), 'team delete error');
        }
    }
}
