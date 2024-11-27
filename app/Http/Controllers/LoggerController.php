<?php

namespace App\Http\Controllers;

use App\Models\Logger;

class LoggerController extends Controller
{
    /**
     * Show Logs
     */
    public function logs()
    {
        $logs = Logger::orderBy('created_at', 'desc')->paginate(10);
        return view('dashboard.activity.logs', compact('logs'));
    }
    /**
     * Delete Logs
     */
    public function destroy($id)
    {
        $logs = Logger::find($id);
        if ($logs->delete()) {
            return redirect()->back()->with('success', " Entry Deleted");
        } else {
            return redirect()->back()->with('error', "Error Occurred, Couldn't be deleted");
        }
    }
}
