@extends('layouts.app')

@push('name')
User Management
@endpush

@section('content')
<div class="container-fluid">
  <div class="card">
    <div class="card-header">
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal"><i
          class="material-icons">add</i>Add User</button>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-hover">
        <thead class="text-rose">
          <th>Name</th>
          <th>Access Level</th>
          <th>Date Created</th>
          <th>Date Updated</th>
          <th colspan="2"></th>
        </thead>
        <tbody>
          @if (count($users) > 0)
          @foreach ($users as $user)
          <tr>
            <td>{{ $user->name }}</td>
            <td>{{ getAccessLevel($user->access_level) }}</td>
            <td>{{ $user->date_created }}</td>
            <td>{{ $user->date_updated }}</td>
            <td><button type="button" class="btn btn-warning" data-target="#userModal{{ $user->id }}"
                data-toggle="modal">Edit</button></td>
            <td>
              <form action="/admin/user/{{ $user->id }}/delete" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
              </form>
            </td>
          </tr>
          @endforeach
          @else
          <tr class="text-center">
            <td colspan="4">There are no accounts enlisted.</td>
          </tr>
          @endif
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('admin.create.user') }}" method="POST">
          @csrf
          <div class="form-group">
            <label for="recipient-name">Name:</label>
            <input type="text" class="form-control" name="name" required>
          </div>
          <div class="form-group">
            <label for="message-text">Username:</label>
            <input type="text" class="form-control" name="username" required>
          </div>
          <div class="form-group">
            <label for="message-text">Password:</label>
            <input type="text" class="form-control" name="password" required>
          </div>
          <div class="form-group">
            <select name="access_level" class="form-control" required>
              <option value selected disabled>Select Access Level</option>
              <option value="1">Employee</option>
              <option value="2">Administrator</option>
            </select>
          </div>
          <div class="form-group float-right">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" onclick="addUser()">Create</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@if (count($users) > 0)
@foreach ($users as $user)
<div class="modal fade" id="userModal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="userModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/admin/user/{{ $user->id }}/edit" method="POST">
          @csrf
          @method('PUT')
          <div class="form-group">
            <label for="recipient-name">Name:</label>
            <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
          </div>
          <div class="form-group">
            <label for="message-text">Username:</label>
            <input type="text" class="form-control" name="username" value="{{ $user->username }}" required>
          </div>
          <div class="form-group">
            <label for="message-text">New Password:</label>
            <input type="text" class="form-control" name="password" required>
          </div>
          <div class="form-group">
            <select name="access_level" class="form-control" required>
              <option value selected disabled>Select Access Level</option>
              <option value="1">Employee</option>
              <option value="2">Administrator</option>
            </select>
          </div>
          <div class="form-group float-right">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Create</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endforeach
@endif

@endsection

@push('custom')
<style>
  .main-panel>.content {
    margin-top: 0px;
  }
</style>
@if(session('success'))
<script>
  Swal.fire({
      icon: 'success',
      title: 'Success',
      text: '{{ session("success") }}'
    })
</script>
@endif
@endpush

<?php

function getAccessLevel($access_level) {
  $levels = [
    1 => 'Employee',
    2 => 'Admin'
  ];

  return $levels[$access_level];
}

?>
