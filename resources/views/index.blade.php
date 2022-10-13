<x-app-layout>
  <x-slot name="header">
    <h2 class=" text-xl text-gray-800 leading-tight text-center font-bold">
    </h2>
  </x-slot>
        <script>
          $(document).ready(function () {
              $.ajaxSetup({
              headers:{
                  'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
              }
          });
        </script>
          <a href="{{ route('schedule.create') }}">create</a>
          <head>
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        </head>
        <div id='calendar'></div>
</x-app-layout>
