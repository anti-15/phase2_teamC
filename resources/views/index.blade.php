<x-app-layout>
  <a href="{{ route('schedule.create') }}">create</a>
  <p><h1>{{ $group_id }}</h1></p>
  {{ $users[0]}}
  <div id='calendar'></div>
</x-app-layout>
