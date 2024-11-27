<?php

namespace Modules\Logger\Http\Controllers;
use Modules\Logger\Entities\Logger;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class LoggerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
     
        $logs = Logger::orderBy('created_at', 'desc')->get();
        return view('logger::index', compact('logs'));
    }

    /**
     * Delete Logs
     */
    public function destroy($id)
    {
        $logs = Logger::find($id);
        if ($logs->delete()) {
            return redirect()->back()->with('success', "Log deleted successfully");
        } else {
            return redirect()->back()->with('error', "Error Occurred, Log couldn't be deleted");
        }
    }
    /*
    *Delete Entries older than 30 days
    *
    */
    public function delete()
    {
        DB::table('error_logs')->where('AppDate', '<', 'NOW() - INTERVAL 30 DAY')->delete();
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('logger::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('logger::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('logger::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

}
