<x-app-layout>
  <x-slot name="header">
    <h2 class=" text-xl text-gray-800 leading-tight text-center font-bold">
    {{ $group_id->group_id }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:w-8/12 md:w-1/2 lg:w-5/12">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">

          @include('common.errors')
          <!-- データを取り出しやすいように下を記述しています-->
          
          <a href="{{ route('schedule.create') }}">create</a>
          @foreach ($members as $member )
          <p>
          {{ $member->member_id }}  
          </p>
          @endforeach          
        </div>
      </div>
    </div>
  </div>
</x-app-layout>