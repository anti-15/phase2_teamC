<x-app-layout>
  <x-slot name="header">
    <h2 class=" text-xl text-gray-800 leading-tight text-center font-bold">
      {{ __('index') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:w-8/12 md:w-1/2 lg:w-5/12">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          @include('common.errors')
        </div>
      </div>
    </div>
  </div>
</x-app-layout>