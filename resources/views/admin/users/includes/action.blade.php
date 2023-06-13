<form action="{{route('users.destroy', $user->id)}}" method="POST">
    <a class="btn btn-primary" href="{{route('users.edit', $user->id)}}">Edit</a>
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Delete</button>
</form>
