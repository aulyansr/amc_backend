<?php

namespace App\Http\Controllers\Master;

use App\Enums\OrderStatus;
use App\Enums\TeamStatus;
use App\Http\Controllers\Controller;

use App\Models\Master_skill;
use App\Models\Team;
use App\Http\Requests\TeamRequest;
use App\Models\Order;
use App\Models\Branch;
use App\Models\Shift;
use App\Models\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeamsController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:teams-list|teams-create|teams-edit|teams-delete', ['only' => ['index','show']]);
         $this->middleware('permission:teams-create', ['only' => ['create','store']]);
         $this->middleware('permission:teams-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:teams-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */

    public function index(Request $request)
    {
        $date = $request->input('date');

        // Initialize the query to retrieve all teams
        $query = Team::query();


        if ($date) {
            // Subquery to retrieve team_ids with orders on the specified date
            $teamIdsWithOrders = Team::whereHas('orders', function ($query) use ($date) {
                $query->whereDate('booked_date', '=', $date);
            })->pluck('id');


            // Filter teams that do not have orders on the specified date
            $query->whereNotIn('id', $teamIdsWithOrders);
        }
        if(isset($request->status)){
            $query->where('status', $request->input('status'));
        }

        // toDO: filter by status (active, occupied, etc)

        // Retrieve the teams
        $teams = $query->get();

        $data = [
            'teams' => $teams,
            'filter' => [
                'date' => $date,
                'status' => $request->input('status'),
            ],
            'status_team' => TeamStatus::getOnlyStatus(),
            'most_order' => Team::mostOrderTeamThisMonth(),
            'fewest_order' => Team::fewestOrderTeamThisMonth(),
            'order_this_month'=>Order::totalOrderThisMonth(),
            'total_order'=>Order::totalAllOrder(),
        ];
        return view('teams.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $data['shifts']=Shift::pluck('name', 'id');
        $data['branches']=Branch::pluck('name', 'id');
        $data['technicians']=Technician::pluck('technicians.fullname as name', 'technicians.id as id');
        $data['skills']=Master_skill::pluck('skill_name as name', 'id');
        return view('teams.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TeamRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TeamRequest $request)
    {
        try {
            DB::beginTransaction();
            $team = new Team;
            $team->branch_id = $request->input('branch_id');
            $team->shift_id = $request->input('shift_id');
            $team->nama = $request->input('nama');
            $team->is_active = $request->input('is_active');
            $team->save();
            $team->technician()->attach($request->input('team_lead'),['status'=>'lead']);
            $team->technician()->attach($request->input('technician_id'));
            $team->skill()->attach($request->input('skill_id'));
            DB::commit();
            return to_route('master.teams.index')->with('toast_success','Berhasil Menambahkan Data Team');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $team = Team::findOrFail($id);
        $statusorder=OrderStatus::getDescriptionArray();
        return view('teams.show',['team'=>$team,'statusorder'=>$statusorder]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $data['team'] = Team::findOrFail($id);
        $data['shifts']=Shift::pluck('name', 'id');
        $data['branches']=Branch::pluck('name', 'id');
        $data['technicians'] = Technician::whereDoesntHave('teams', function ($query) use ($id) {
            $query->where('team_id', '!=', $id);
        })->orWhereHas('teams', function ($query) use ($id) {
            $query->where('team_id', $id);
        })->pluck('fullname as name', 'id');
        $data['skills']=Master_skill::pluck('skill_name as name', 'id');
        return view('teams.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TeamRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TeamRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $team = Team::find($id);
            $team->branch_id = $request->input('branch_id');
            $team->shift_id = $request->input('shift_id');
            $team->nama = $request->input('nama');
            $team->is_active = $request->input('is_active');
            $team->save();
            $team->technician()->detach();
            $team->technician()->attach($request->input('team_lead'),['status'=>'lead']);
            $team->technician()->attach($request->input('technician_id'));
            $team->skill()->detach();
            $team->skill()->attach($request->input('skill_id'));
            DB::commit();
            return to_route('master.teams.index')->with('toast_success','Berhasil Mengubah Data Team');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $team = Team::findOrFail($id);
        $team->delete();

        return to_route('master.teams.index')->with('toast_success','Berhasil Menghapus Data Team');
    }
}
