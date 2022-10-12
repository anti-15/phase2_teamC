<x-app-layout>
    <x-slot name="header">
      <h2 class=" text-xl text-gray-800 leading-tight text-center font-bold">
      </h2>
    </x-slot>
    <head>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <div id='calendar'></div>
</x-app-layout>