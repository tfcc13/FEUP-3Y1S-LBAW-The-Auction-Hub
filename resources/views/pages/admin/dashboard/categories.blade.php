@extends('layouts.admin.dashboard')

@section('Display')
    <!-- Main Content -->

    @if (session('error'))
        <div class="alert alert-danger text-red-500 bg-red-100 border border-red-400 rounded p-4">
            {{ session('error') }}
        </div>
    @endif
    <div class="flex flex-col space-y-6 w-full" id="admin-categories">
        <div class="flex justify-between items-center pr-4">
            <h3 class="text-2xl font-semibold text-gray-800">Manage Categories</h3>
            <x-toast.confirm :buttonText="'Create Category'" :route="'admin.category.store'" :method="'POST'" :id="'createCategory'" :modalTitle="'Creater new Category?'"
                :modalMessage="'Are you sure you want to create a new Category? '" :textFlag="true" />
        </div>

        <ul class="mt-4 space-y-2">
            @forelse ($categories as $category)
                <li style="list-style: none"
                    class="flex justify-between items-center p-4 border border-gray-200 rounded shadow-sm">
                    <p class="text-gray-800">Category Name:
                        <span class="ml-2 text-lg font-semibold">{{ $category->name }}</span>
                    </p>
                    <x-toast.confirm :buttonText="'Delete Category'" :route="'admin.category.destroy'" :method="'DELETE'" :id="'deleteCategory' . $category->id"
                        :modalTitle="'Delete new Category?'" :modalMessage="'Are you sure you want to delete a Category? '" :object="$category"
                        class="px-4 py-2 text-white rounded-lg bg-red-700" s />
                </li>
            @empty
                <li class="text-gray-500">You have no reports.</li>
            @endforelse
        </ul>
    </div>
@endsection
