<x-layout-app page-title="Edit Collaborator">

    <div class="w-100 p-4">

        <h3>Edit Collaborator</h3>

        <hr>

        <form action="{{ route('rhcollaborators.updateCollaborator') }}" method="post">

            @csrf
            @method('put')
            <div class="d-flex gap-5">
                <p>Collaborator Name: <strong>{{ $collaborator->name}}</strong></p>
                <p>Collaborator Email: <strong>{{ $collaborator->email}}</strong></p>
            </div>
            <hr>
            <input type="hidden" name="user_id" value="{{ $collaborator->id }}">

            <div class="container-fluid">
                <div class="row gap-3">

                    {{-- user --}}
                    <div class="col border border-black p-4">
                        <div class="col">
                            <div class="mb-3">
                            <label for="salary" class="form-label">Salary</label>
                            <input type="number" class="form-control" id="salary" name="salary" step=".01" placeholder="0,00" value="{{ old('salary', $collaborator->detail->salary) }}">
                            @error('salary')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                        <div class="col">
                            <div class="mb-3">
                            <label for="admission_date" class="form-label">Admission Date</label>
                            <input type="text" class="form-control" id="admission_date" name="admission_date" placeholder="YYYY-mm-dd" value="{{ old('admission_date', $collaborator->detail->admission_date) }}">
                            @error('admission_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="select_department">Departement</label>
                            <select class="form-select" name="select_department" id="select_department">
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id}}" {{ $collaborator->department_id == $department->id ? 'selected' : ''}}>{{ $department->name}}</option>
                                @endforeach
                            </select>
                            @error('select_department')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    </div>
                </div>

                <div class="mt-3">
                    <a href="{{ route('rhcollaborators.managementHome')}}" class="btn btn-outline-danger me-3">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update colaborator</button>
                </div>

            </div>

        </form>

    </div>

</x-layout-app>
