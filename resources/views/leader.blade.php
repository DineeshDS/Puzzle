@extends('layouts.app')

@section('contents')
    <div class="content ">

        <div class="card">
            <div class="card-body">
                <div class="table-responsive" tabindex="1" style="overflow: hidden; outline: none;">
                    <table id="users" class="table table-custom table-lg">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Words</th>
                            <th>Score</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($lists as $list)
                            <tr>
                                <td>{{ $list['name'] ?? '-' }}</td>
                                <td>{{ $list['email'] ?? '-' }}</td>
                                <td>{{ $list['words'] ?? '-' }}</td>
                                <td>{{ $list['score'] ?? '0'}}</td>
                            </tr>
                        @empty
                            <h4>No submission found</h4>
                        @endforelse

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('script')

@endpush