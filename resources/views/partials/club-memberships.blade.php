@if(auth()->user()->user_type === 'student')
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">My Club Memberships</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Club Name</th>
                                <th>Position</th>
                                <th>Status</th>
                                <th>Joined Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clubMemberships as $membership)
                                <tr>
                                    <td>{{ $membership->club->name }}</td>
                                    <td>{{ $membership->position ?? 'Member' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $membership->status === 'approved' ? 'success' : ($membership->status === 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($membership->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $membership->joined_at ? $membership->joined_at->format('M d, Y') : 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('clubs.show', $membership->club) }}" class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">You are not a member of any clubs yet</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif 