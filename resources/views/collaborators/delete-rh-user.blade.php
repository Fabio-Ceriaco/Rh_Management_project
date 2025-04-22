<x-layout-app page-title="Delete collaborator">
    <div class="w-50 p-4">

        <h3>Delete collaborator</h3>

        <hr>

        <p>Are you sure you want to delete this department?</p>

        <div class="text-center">
            <h3 class="my-5">{{ $collaborator->name }}</h3>
            <a href="{{ route('rhcollaborators')}}" class="btn btn-secondary px-5">No</a>
            <a href="{{ route('rhcollaborators.delete-collaborator-confirm', ['id' => Crypt::encryptString($collaborator->id)])}}" class="btn btn-danger px-5">Yes</a>
        </div>

    </div>
</x-layout-app>
