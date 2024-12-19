@extends('layouts.admin.dashboard')

@section('Display')
<!-- Main Content -->

@if(session('error'))
<div class="alert alert-danger text-red-500 bg-red-100 border border-red-400 rounded p-4">
  {{ session('error') }}
</div>
@endif
<div class="flex-1 p-8 bg-white">
  <h3 class="text-2xl font-semibold text-[rgb(19,93,59)]">Welcome to Your Dashboard</h3>
  <p class="mt-2 text-gray-600">Select an option from the menu to view details or perform actions.</p>

  <!-- Reports Section -->
  <div class="mt-8">
    <h4 class="text-xl font-semibold text-gray-800">Your Reports</h4>
    <ul class="mt-4 space-y-2">
      @forelse ($categories as $category)
      <li class="p-4 border border-gray-200 rounded shadow-sm">
        <p class="font-medium text-gray-700">Category Name: {{ $category->name }}</p>
        <x-toast.confirm
          :buttonText="'Delete Category'"
          :route="'admin.category.destroy'"
          :method="'DELETE'"
          :id="'deleteCategory'. $category->id "
          :modalTitle="'Delete new Category?'"
          :modalMessage="'Are you sure you want to delete a Category? '"
          :object="$category"
          />
      </li>
      @empty
      <li class="text-gray-500">You have no reports.</li>
      @endforelse
    </ul>
  </div>
  <x-toast.confirm
    :buttonText="'Create Category'"
    :route="'admin.category.store'"
    :method="'POST'"
    :id="'createCategory' "
    :modalTitle="'Creater new Category?'"
    :modalMessage="'Are you sure you want to create a new Category? '"
    :textFlag="true" />
</div>
@endsection
