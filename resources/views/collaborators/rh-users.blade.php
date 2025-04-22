<x-layout-app page-title="Human resources">
    <div class="w-100 p-4">

        <h3>Human Resources Collaboratores</h3>

        <hr>
        @if($collaborators->count() == 0)
            <div class="text-center my-5">
                <p>No collaborators found.</p>
                <a href="{{ route('rhcollaborators.new-collaborator')}}" class="btn btn-primary">Create a new colaborator</a>
            </div>
            <hr>
        @else
            <div class="mb-3">
                <a href="{{ route('rhcollaborators.new-collaborator')}}" class="btn btn-primary">Create a new colaborator</a>
            </div>

            <table class="table w-100" id="table">
                <thead class="table-dark">
                    <th>Name</th>
                    <th>Email/th>
                    <th>Permissions</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach ($collaborators as $collaborator )
                    <tr>
                        <td>{{$collaborator->name }}</td>
                        <td>{{$collaborator->email }}</td>
                        @php
                            $permissions = json_decode($collaborator->permissions);
                        @endphp
                        <td>{{ implode(",", $permissions)}}</td>
                        <td>
                            <div class="d-flex gap-3 justify-content-end">
                                    <a href="#" class="btn btn-sm btn-outline-dark"><i class="fa-regular fa-pen-to-square me-2"></i>Edit</a>
                                    <a href="#" class="btn btn-sm btn-outline-dark"><i class="fa-regular fa-trash-can me-2"></i>Delete</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-layout-app>
