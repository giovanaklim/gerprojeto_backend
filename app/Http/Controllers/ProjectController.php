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
        //
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
                $request->merge(['start' => $request->dates['from']]);
                $request->merge(['end' => $request->dates['to']]);
            }

            $project = Project::updateOrCreate(
                ['id' => $request->id],
                $request->toArray()
            );
            if ($request->stages) {
                $this->storeStages($request->stages, $project);
            }
            DB::commit();
            return Response::getJsonResponse('success', $project, \Illuminate\Http\Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiExceptionManager::handleException($e, func_get_args(), 'store project error');
        }
    }

    public function storeStages($stages, $project): void
    {
        try {
            foreach ($stages as $stage) {
                $stage['project_id'] = $project->id;

                $data = Stage::create($stage);

                if (!isset($stage->item)) {
                    continue;
                }

                $stage->each(function ($item) use ($data) {
                    $item['stage_id'] = $data->id;
                    Item::create($item);
                });
            }

            return;
        } catch (\Exception $e) {
            ApiExceptionManager::handleException($e, 'store Project', func_get_args());
        }
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
        //
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
