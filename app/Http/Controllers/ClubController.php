<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\ClubMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clubs = Club::all();
        return view('clubs.index', compact('clubs'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Club $club)
    {
        $pendingApplications = null;
        
        if (Auth::check() && Auth::user()->user_type === 'club' && Auth::user()->email === $club->email) {
            $pendingApplications = ClubMember::where('club_id', $club->id)
                ->where('status', 'pending')
                ->with('user')
                ->get();
        }

        return view('clubs.show', compact('club', 'pendingApplications'));
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

    public function dashboard()
    {
        if (Auth::user()->user_type !== 'club') {
            return redirect()->route('dashboard');
        }

        $club = Club::where('email', Auth::user()->email)->first();
        
        if (!$club) {
            return redirect()->route('dashboard')->with('error', 'Club profile not found.');
        }

        $pendingApplications = ClubMember::where('club_id', $club->id)
            ->where('status', 'pending')
            ->with('user')
            ->latest()
            ->get();

        $approvedMembers = ClubMember::where('club_id', $club->id)
            ->where('status', 'approved')
            ->with('user')
            ->latest()
            ->get();

        return view('clubs.dashboard', compact('club', 'pendingApplications', 'approvedMembers'));
    }
}
