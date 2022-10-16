<x-app-layout>
  <x-slot name="header">
    <h2 class="text-center font-bold text-xl text-gray-800 leading-tight">
      {{ $group_id }}
    </h2>
  </x-slot>
            <form class="mb-6" action="{{ route('group.destroy', $group_id) }}" method="POST">
              @method('delete')
              @csrf
            <div class="flex flex-col mb-4">
              <button type="submit" class="w-full py-6 mt-6 font-medium tracking-widest text-white uppercase bg-black shadow-lg focus:outline-none hover:bg-gray-900 hover:shadow-none">
              グループを退会する
              </button>
            </div>
</form>
  <div id='calendar'></div>
</x-app-layout>
