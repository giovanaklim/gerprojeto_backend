<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiExceptionManager;
use App\Helpers\Response;
use App\Http\Requests\StageRequest;
use App\Models\Project;
use App\Models\Stage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StageController extends Controller
{

    public function index()
    {

    }
     public function show()
    {

    }

    public function showStages($projectId)
    {
        $stages = Stage::where('project_id', $projectId)->get();
        return Response::getJsonResponse('success', $stages, \Illuminate\Http\Response::HTTP_OK);
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
    public function store(StageRequest $request)
    {
        DB::beginTransaction();
        try {
            $project = Project::firstWhere('id', $request->project_id);
            if (!$project) {
                throw new \Exception("Projeto ainda nao cadastrado", 406);
            }
            if ($request->dates) {
                $request->merge(['start' => Carbon::createFromFormat('d/m/Y', $request->dates['from'])]);
                $request->merge(['end' => Carbon::createFromFormat('d/m/Y', $request->dates['to'])]);
            }
            Stage::updateOrCreate(
                ['id' => $request->id],
                $request->toArray()
            );
            $stages = Stage::where('project_id', $project->id)->with(['headUser'])->get();
            DB::commit();
            return Response::getJsonResponse('success', $stages, \Illuminate\Http\Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiExceptionManager::handleException($e, func_get_args(), 'store stage error');
        }
    }

}
