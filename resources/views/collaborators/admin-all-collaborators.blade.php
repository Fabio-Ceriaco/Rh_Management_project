<x-layout-app page-title="Colaborators">


        <div class="w-100 p-4">

            <h3>All colaborators</h3>

            <hr>
            @if($collaborators->count() == 0)
                <div class="text-center my-5">
                    <p>No collaborators found.</p>
                </div>
                <hr>
            @else
                <table class="table" id="table">
                    <thead class="table-dark">
                        <th>Name</th>
                        <th>Email</th>
                        <th>Active</th>
                        <th>Department</th>
                        <th>Role</th>
                        <th>Admission date</th>
                        <th>Selary</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach ($collaborators as $collaborator )
                        <tr>
                            <td>{{$collaborator->name }}</td>
                            <td>{{$collaborator->email }}</td>
                            <td>
                                @empty($collaborator->email_verified_at)
                                    <span class="badge bg-danger">No</span>
                                @else
                                    <span class="badge bg-success">Yes</span>
                                @endif
                            </td>
                            <td>{{$collaborator->department->name }}</td>
                            <td>{{$collaborator->role }}</td>
                            <td>{{$collaborator->detail->admission_date }}</td>
                            <td>{{ $collaborator->detail->salary }} €</td>

                            <td>
                                <div class="d-flex gap-3 justify-content-end">
                                        <a href="{{ route('collaborators-details', ['id' => Crypt::encryptString($collaborator->id)])}}" class="btn btn-sm btn-outline-dark ms-3"><i class="fa-solid fa-eye"></i>Details</a>
                                        <a href="{{ route('collaborators-delete', ['id' => Crypt::encryptString($collaborator->id)])}}" class="btn btn-sm btn-outline-dark ms-3"><i class="fa-regular fa-trash-can me-2"></i>Delete</a>
                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

</x-layout-app>

