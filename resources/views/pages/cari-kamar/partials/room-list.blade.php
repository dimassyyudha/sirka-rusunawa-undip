@foreach ($rooms as $room)
    <x-room.card :room="$room" />
@endforeach
