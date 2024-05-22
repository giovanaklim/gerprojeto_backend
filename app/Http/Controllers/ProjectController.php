<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiExceptionManager;
use App\Helpers\Response;
use App\Http\Requests\NewProjectRequest;
use App\Models\Item;
use App\Models\Project;
use App\Models\Stage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        DB::beginTransaction();
        try {
            $project = Project::where('user_id', Auth::user()->id)
                ->with('stages')
                ->get();
            DB::commit();
            return response($project, \Illuminate\Http\Response::HTTP_OK, ['success']);
        }catch (\Exception $e) {
            DB::rollBack();
            return ApiExceptionManager::handleException($e, func_get_args(), 'store project error');
        }
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
    public function store(NewProjectRequest $request)
    {
        DB::beginTransaction();
        try {
            $request->merge(['user_id' => Auth::user()->id]);

            if ($request->dates) {
                $request->merge(['start' => Carbon::createFromFormat('d/m/Y', $request->dates['from'])]);
                $request->merge(['end' => Carbon::createFromFormat('d/m/Y', $request->dates['to'])]);
            }
            $project = Project::updateOrCreate(
                ['id' => $request->id],
                $request->toArray()
            );
            DB::commit();
            return Response::getJsonResponse('success', $project, \Illuminate\Http\Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiExceptionManager::handleException($e, func_get_args(), 'store project error');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            Project::where('id', $request->id)->update([
                'status' => $request->status
            ]);
            DB::commit();
            return response([], \Illuminate\Http\Response::HTTP_OK, ['success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return ApiExceptionManager::handleException($th, func_get_args(), 'project update error');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
}
