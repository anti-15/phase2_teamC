<x-app-layout>
  <x-slot name="header">
    <h2 class=" text-xl text-gray-800 leading-tight text-center font-bold">
      {{ __('Crate or Join') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:w-8/12 md:w-1/2 lg:w-5/12">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          @include('common.errors')
          <a class="mb-6" href="{{ route('group.create') }}" method="POST">
            <div class="flex flex-col mb-4">
              <button type="submit" class="w-full py-3 mt-6 font-medium tracking-widest text-white uppercase bg-black shadow-lg focus:outline-none hover:bg-gray-900 hover:shadow-none">
              Create
              </button>
            </div>
          </a>

          <a class="mb-6" href="{{ route('group.join') }}" method="GET">
            <div class="hover:flex flex-col mb-4">
              <button type="submit" class="w-full py-3 mt-6 font-medium tracking-widest text-white uppercase bg-black shadow-lg focus:outline-none hover:bg-gray-900 hover:shadow-none">
              JOIN
              </button>
            </div>
          </a>
          <table class="text-center w-full border-collapse">
            <thead>
              <tr>
                <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-lg text-grey-dark border-b border-grey-light">Groups</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($groups as $group)
              <tr class="hover:bg-grey-lighter">
                <td class="py-4 px-6 border-b border-grey-light">
                  <h3 class="text-left font-bold text-lg text-grey-dark">
                    <a href="{{ route('group.show',$group->group_id) }}">
                    {{$group->group_id}}
                    </a>
                  </h3>
                  <div class="flex">
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          
        </div>
      </div>
    </div>
  </div>
  <div class='hidden'><div id='calendar'></div></div>
</x-app-layout>