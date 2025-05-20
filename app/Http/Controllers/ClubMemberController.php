<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\ClubMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClubMemberController extends Controller
{
    public function apply(Request $request, Club $club)
    {
        // Check if user is a student
        if (Auth::user()->user_type !== 'student') {
            return back()->with('error', 'Only students can apply to join clubs.');
        }

        // Check if already a member
        $existingMembership = ClubMember::where('user_id', Auth::id())
            ->where('club_id', $club->id)
            ->where('status', 'approved')
            ->first();

        if ($existingMembership) {
            return back()->with('error', 'You are already a member of this club.');
        }

        // Check if there's a pending application
        $pendingApplication = ClubMember::where('user_id', Auth::id())
            ->where('club_id', $club->id)
            ->where('status', 'pending')
            ->first();

        if ($pendingApplication) {
            return back()->with('error', 'You already have a pending application for this club.');
        }

        // If there's a rejected application, delete it
        $rejectedApplication = ClubMember::where('user_id', Auth::id())
            ->where('club_id', $club->id)
            ->where('status', 'rejected')
            ->first();

        if ($rejectedApplication) {
            $rejectedApplication->delete();
        }

        // Create new membership application
        ClubMember::create([
            'user_id' => Auth::id(),
            'club_id' => $club->id,
            'status' => 'pending',
            'application_note' => $request->application_note
        ]);

        return back()->with('success', 'Your application has been submitted successfully.');
    }

    public function approve(ClubMember $member)
    {
        // Check if the current user is the club admin
        if (Auth::user()->user_type !== 'club' || Auth::user()->email !== $member->club->email) {
            return back()->with('error', 'Unauthorized action.');
        }

        $member->update([
            'status' => 'approved',
            'joined_at' => now()
        ]);

        return back()->with('success', 'Member application approved successfully.');
    }

    public function reject(ClubMember $member)
    {
        // Check if the current user is the club admin
        if (Auth::user()->user_type !== 'club' || Auth::user()->email !== $member->club->email) {
            return back()->with('error', 'Unauthorized action.');
        }

        $member->update([
            'status' => 'rejected'
        ]);

        return back()->with('success', 'Member application rejected.');
    }

    public function myApplications()
    {
        $applications = ClubMember::where('user_id', Auth::id())
            ->with('club')
            ->latest()
            ->get();

        return view('club-members.my-applications', compact('applications'));
    }

    public function pendingApplications()
    {
        // Get pending applications for the current club
        $applications = ClubMember::whereHas('club', function ($query) {
            $query->where('email', Auth::user()->email);
        })
        ->where('status', 'pending')
        ->with('user')
        ->latest()
        ->get();

        return view('club-members.pending-applications', compact('applications'));
    }

    /**
     * Promote a club member to a new position.
     */
    public function promote(Request $request, ClubMember $member)
    {
        $user = Auth::user();
        $adminPositions = ['president', 'vice_president', 'general_secretary', 'treasurer'];
        $clubPositions = ['director', 'executive', 'general_member'];

        $request->validate([
            'position' => 'required|string',
        ]);
        $newPosition = $request->position;

        // Get the club associated with the member
        $club = $member->club;

        if ($user->isAdmin()) {
            // Admin can promote to any position
            if (!in_array($newPosition, array_merge($adminPositions, $clubPositions))) {
                return back()->with('error', 'Invalid position selected.');
            }

            // Check if the position is already filled (only for admin positions)
            if (in_array($newPosition, $adminPositions)) {
                $exists = ClubMember::where('club_id', $member->club_id)
                    ->where('position', $newPosition)
                    ->where('id', '!=', $member->id)
                    ->exists();
                if ($exists) {
                    return back()->with('error', 'This position is already filled in the club.');
                }
            }
        } elseif ($user->user_type === 'club') {
            // Verify that the current user is the club admin
            if ($user->email !== $club->email) {
                return back()->with('error', 'Unauthorized action.');
            }
            
            // Club admins can only assign club positions
            if (!in_array($newPosition, $clubPositions)) {
                return back()->with('error', 'Club admins can only assign Director, Executive, or General Member positions.');
            }
        } else {
            return back()->with('error', 'Unauthorized action.');
        }

        // Update the member's position
        $member->update(['position' => $newPosition]);
        return back()->with('success', 'Member promoted to ' . ucfirst(str_replace('_', ' ', $newPosition)) . '.');
    }

    /**
     * Remove a member from the club.
     */
    public function remove(ClubMember $member)
    {
        $user = Auth::user();
        $topPositions = ['president', 'vice_president', 'general_secretary', 'treasurer'];

        if ($user->isAdmin()) {
            $member->delete();
            return back()->with('success', 'Member removed.');
        } elseif ($user->user_type === 'club') {
            $club = \App\Models\Club::where('email', $user->email)->first();
            if (!$club || $member->club_id !== $club->id) {
                return back()->with('error', 'Unauthorized action.');
            }
            if (in_array($member->position, $topPositions)) {
                return back()->with('error', 'Cannot remove top position members. Please demote them first.');
            }
            $member->delete();
            return back()->with('success', 'Member removed.');
        } else {
            return back()->with('error', 'Unauthorized action.');
        }
    }

    public function myClubs()
    {
        if (!auth()->user()->isStudent()) {
            return redirect()->route('dashboard');
        }

        $clubMemberships = ClubMember::where('user_id', auth()->id())
            ->where('status', 'approved')
            ->with(['club', 'club.members' => function($query) {
                $query->where('status', 'approved')
                    ->with('user')
                    ->orderBy('position', 'asc');
            }])
            ->get();

        return view('clubs.my-clubs', compact('clubMemberships'));
    }

    /**
     * Show all club members for admin management.
     */
    public function adminManageMembers()
    {
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }

        $clubs = Club::with(['members' => function($query) {
            $query->where('status', 'approved')
                ->with('user')
                ->orderBy('position', 'asc');
        }])->get();

        return view('admin.club-members.index', compact('clubs'));
    }
} 