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

        // Check if already a member or has pending application
        $existingMembership = ClubMember::where('user_id', Auth::id())
            ->where('club_id', $club->id)
            ->first();

        if ($existingMembership) {
            return back()->with('error', 'You have already applied to or are a member of this club.');
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
        $clubAdminRoles = ['general_member', 'executive', 'director'];
        $adminRoles = ['president', 'vice_president', 'general_secretary', 'treasurer'];

        $request->validate([
            'position' => 'required|string',
        ]);

        $newPosition = $request->position;

        if ($user->isAdmin()) {
            if (!in_array($newPosition, $adminRoles)) {
                return back()->with('error', 'Admins can only assign top-level positions.');
            }
        } elseif ($user->user_type === 'club' && $user->email === $member->club->email) {
            if (!in_array($newPosition, $clubAdminRoles)) {
                return back()->with('error', 'Club admins can only assign member, executive, or director.');
            }
        } else {
            return back()->with('error', 'Unauthorized action.');
        }

        $member->update(['position' => $newPosition]);
        return back()->with('success', 'Member promoted to ' . ucfirst(str_replace('_', ' ', $newPosition)) . '.');
    }
} 