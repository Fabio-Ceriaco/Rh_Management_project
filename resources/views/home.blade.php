<x-layout-app page-title="Home">

    <div class="w-100 p-4">
        <h3>Home</h3>
        <hr>
        <div class="d-flex">
            <x-info-title-value item-title="Total Collaborators" :item-value="$data['total_collaborators']"/>
            <x-info-title-value item-title="Total Deleted Collaborators" :item-value="$data['total_collaborators_deleted']"/>
            <x-info-title-value item-title="Total Salary" :item-value="$data['total_salary']"/>
        </div>
        <hr>
        <div class="d-flex">
            <x-info-title-collection item-title="Collaborators by Department" :collection="$data['total_collaborators_by_department']"/>
            <x-info-title-collection item-title="Salary by Department" :collection="$data['total_salary_by_department']"/>
        </div>

    </div>
</x-layout-app>
