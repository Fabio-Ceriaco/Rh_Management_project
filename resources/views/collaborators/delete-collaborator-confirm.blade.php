<x-layout-app page-title="Delete colaborator">

    <div class="p-4">

        <h3>Delete colaborator</h3>

        <hr>

        <p>Are you sure you want to delete this colaborator?</p>

        <div class="text-center">
            <h3 class="my-5">{{ $collaborator->name }}</h3>
            <p>{{ $collaborator->email}}</p>
            <a href="{{ route('all-collaborators')}}" class="btn btn-secondary px-5">No</a>
            <a href="{{ route('collaborators-delete-confirm', ['id' => Crypt::encryptString($collaborator->id)]) }}" class="btn btn-danger px-5">Yes</a>
        </div>

    </div>

</x-layout-app>
