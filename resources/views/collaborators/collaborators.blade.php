<x-layout-app page-title="Collaborators">


        <div class="w-100 p-4">

            <h3>All colaborators</h3>

            <hr>
            @if($collaborators->count() == 0)
                <div class="text-center my-5">
                    <p>No collaborators found.</p>
                    <a href="{{ route('rhcollaborators.newCollaborator')}}" class="btn btn-primary">Create a new Collaborator</a>
                </div>
                <hr>
            @else
            <div class="mb-3">
                <a href="{{ route('rhcollaborators.newCollaborator')}}" class="btn btn-primary">Create a new Collaborator</a>
            </div>
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

                                        @empty($collaborator->deleted_at)

                                            <a href="{{ route('rhcollaborators.editCollaborator', ['id' => Crypt::encryptString($collaborator->id)])}}" class="btn btn-sm btn-outline-dark ms-3"><i class="fa-solid fa-pen-to-square me-2"></i>Edit</a>
                                            <a href="{{ route('rhcollaborators.deleteCollaborator', ['id' => Crypt::encryptString($collaborator->id)])}}" class="btn btn-sm btn-outline-dark ms-3"><i class="fa-solid fa-trash-can me-2"></i>Delete</a>
                                            <a href="{{ route('rhcollaborators.showCollaboratorDetails', ['id' => Crypt::encryptString($collaborator->id)])}}" class="btn btn-sm btn-outline-dark ms-3"><i class="fa-solid fa-eye me-2"></i>Details</a>
                                        @else
                                            <a href="{{ route('rhcollaborators.restoreCollaborator', ['id' => Crypt::encryptString($collaborator->id)])}}" class="btn btn-sm btn-outline-dark ms-3"><i class="fa-solid fa-trash-arrow-up me-2"></i>Restore</a>
                                        @endif
                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

</x-layout-app>

