<x-layout-app page-title="Home">

    @can('user_admin')
        <h3 class="text-center mt-5">Admin is logged</h3>
    @endcan
</x-layout-app>
