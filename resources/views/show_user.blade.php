@extends('base')

@section('content')

<!-- User Details Table -->
<div class="container my-4">
    <!-- back button -->
    <div class="d-flex justify-content-start my-3">
        <a href="{{ route('home') }}" class="btn btn-outline-dark btn-lg rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
            <
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger text-center">
            {{ session('error') }}
        </div>
    @endif

    @if (session('messages'))
        <div class="alert p-3 rounded" style="max-height: 200px; overflow-y: auto; background-color: #f8d7da; color: #842029;">
            <ul class="mb-0">
                @foreach (session('messages') as $message)
                    @if ($message['type'] === 'success')
                        <li class="text-success">
                             {{ $message['message'] }}
                        </li>
                    @else
                        <li class="text-danger">
                            {{ $message['message'] }}
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    @endif   

    <div class="row">
        <div class="col-md-6">
            <!-- Import CSV Form -->
           <div class="card shadow mb-4">
               <div class="card-header bg-primary text-white">
                   <h2 class="h5 mb-0">Import user data from CSV</h2>
               </div>
               <div class="card-body">
                   <form action="{{ route('import.csv') }}" method="POST" enctype="multipart/form-data">
                       @csrf
                       <div class="mb-3">
                           <label for="csv_file" class="form-label">Upload CSV File:</label>
                           <input type="file" class="form-control" name="csv_file" accept=".csv" required>
                       </div>
                       <div class="text-center">
                            <button type="submit" class="btn btn-primary">Import CSV</button>
                       </div>
                   </form>
               </div>
           </div>
       </div>
       <div class="col-md-6">
           <div class="card shadow mb-4">
               <div class="card-header bg-primary text-white">
                   <h2 class="h5 mb-0">Export user Data</h2>
               </div>
               <div class="text-center my-4">
                   <a href="{{ route('export.csv') }}" class="btn btn-warning">Export to CSV</a>
               </div>
           </div>
       </div>
    </div>


    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h2 class="h5 mb-0">User Details</h2>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered" id="myTable" style="font-size:14px">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Street Address</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Country</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $counter = 1; @endphp
                    @foreach ($users as $user)
                    <tr>
                        <td class="text-start">{{ $counter }}</td>
                        <td class="text-start">{{ $user->id }}</td>
                        <td class="text-start"><img src="{{ ($user->profile_image) ? asset('storage/' . $user->profile_image) : asset('not-image-available.png') }}" width="50" class="img-thumbnail"></td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->street_address }}</td>
                        <td>{{ $user->city }}</td>
                        <td>{{ $user->state }}</td>
                        <td>{{ $user->country }}</td>
                        <td>
                            <a href="{{ route('edit', ['id' => $user->id]) }}" class="badge bg-primary p-2 text-decoration-none border-0">Edit</a>
                            <a href="{{ route('delete', ['id' => $user->id]) }}" class="badge bg-danger p-2 text-decoration-none">Delete</a>
                        </td>
                    </tr>
                    @php $counter++; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
    
@endsection