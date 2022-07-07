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
        $project = Project::where('user_id',1)->get();
        return response($project, \Illuminate\Http\Response::HTTP_OK, ['success']);
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
            $request->merge(['user_id' => 1]);//Auth::user()->id]);

            if ($request->dates) {
                $request->merge(['start' => Carbon::createFromFormat('d/m/Y', $request->dates['from'])]);
                $request->merge(['end' => Carbon::createFromFormat('d/m/Y', $request->dates['to'])]);
            }
            $project = Project::updateOrCreate(
                ['id' => $request->id],
                $request->toArray()
            );
            if (isset($request->stages)) {
                $this->storeStages($request->stages, $project);
            }
            DB::commit();
            return Response::getJsonResponse('success', $project, \Illuminate\Http\Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiExceptionManager::handleException($e, func_get_args(), 'store project error');
        }
    }

    public function storeStages($stage, $project): void
    {
        try {
            $stage['project_id'] = $project->id;
                return $stage;
                // $stage['dates'] = project->start

                // if ($stage->dates) {
                //     $request->merge(['start' => Carbon::createFromFormat('d/m/Y', $request->dates['from'])]);
                //     $request->merge(['end' => Carbon::createFromFormat('d/m/Y', $request->dates['to'])]);
                // }

                $data = Stage::create($stage);

                // if (!isset($stage->item)) {
                //     return;
                // }

                // $stage->each(function ($item) use ($data) {
                //     $item['stage_id'] = $data->id;
                //     Item::create($item);
                // });
        } catch (\Exception $e) {
            ApiExceptionManager::handleException($e, 'store Project', func_get_args());
        }
    }

    public function getStages($project_id)
    {
        $stage = Stage::where('project_id', $project_id)->get();
        return response($stage, \Illuminate\Http\Response::HTTP_OK, ['success']);
    }

    public function storeItems($data, $project)
    {
        # code...
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
    public function update(Request $request, $id)
    {
        // try {
        //     Project::find($id)->update($request->toArray());
        //     //TODO: change user_id for authenticated user_id.
        //     $project = Project::where('user_id',1)->get();
        //     return response($project, \Illuminate\Http\Response::HTTP_OK, ['success']);
        // } catch (\Throwable $th) {
        //     return ApiExceptionManager::handleException($th, func_get_args(), 'project update error');
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
