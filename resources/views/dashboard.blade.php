@extends('layouts.app')

@section('contents')
    <div class="content ">

        <div class="card">
            <div class="card-body">
                <h3 class="mb-0">
                    Your Score
                    <span class="badge bg-success badge-pill ms-1">{{ $puzzle['status'] ? $puzzle->total_score : 0 }}</span>
                </h3>
                <div class="d-flex align-items-center my-4">
                </div>
                <div class="mb-4">
                    <p>
                        <strong>Greetings 😃</strong>
                    </p>
                    <p>Can you find real words hidden in a jumble of random letters? Imagine given string, how many
                        English words can you create using only the letters in that string? <br>Each letter can be used
                        only once, and every valid word earns you points. </p>
                    <p>The challenge is to think quickly, choose wisely, and see how high you can score before you run
                        out of letters. Ready to test your vocabulary skills?</p>
                    <p>
                        <strong>Letter Pool</strong>
                    </p>
                    <h3 class="mb-3"
                        style="color: red">{{ (strlen($puzzle->current_string) == 0 || $puzzle['status'])  ? $puzzle->original_string : $puzzle->current_string }}</h3>
                </div>
                <h6 class="mb-3">Your Answers</h6>
                <ul class="list-unstyled mb-4">

                    @foreach($puzzle['submissions'] as $answer)
                        <li class="mb-2">
                            <a href="#">
                                <i class="bi bi-star-fill me-1"></i>
                                {{ optional($answer)->word }}
                            </a>
                        </li>
                    @endforeach

                </ul>
                @if($puzzle['status'])
                    <h3 style="color: #0f5132"> Best of luck, you've already participated and completed your puzzle, see
                        you next time. Thanks a lot</h3>
                @else
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Enter Your word here</label>
                        <input type="text" class="form-control" id="answer" placeholder="Enter your word here" required>
                    </div>
                    <button id="btn-submit" class="btn btn-success">Submit</button>
                    <button id="btn-end" class="btn btn-danger">End Game</button>
                @endif

            </div>
        </div>

    </div>
@endsection

@push('script')
    <script type="text/javascript">
        $(document).ready(function () {

            $(document).on('click', '#btn-submit', function () {
                swal({
                    title: "Are you sure want to submit?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((confirm) => {
                    if (confirm) {
                        $("#btn-submit").prop("disabled", true);
                        var answer = $("#answer").val();
                        ajax_process(answer);
                    }
                });
            });

            $(document).on('click', '#btn-end', function () {
                swal({
                    title: "Are you sure want to Quit?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((confirm) => {
                    if (confirm) {
                        $("#btn-end").prop("disabled", true);
                        ajax_process('end');
                    }
                });
            })
        });


        function ajax_process(data) {
            if (data === 'end') {
                var url = "{{ route('puzzle.end') }}";
            } else {
                var url = "{{ route('puzzle.store') }}";
            }

            $.ajax({
                url: url,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "answer": data
                },
                type: 'POST',
                success: function (response) {
                    if (response.status === 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            html: response.message,
                            showConfirmButton: false
                        });
                        refresh(3000);
                    } else {
                        $("#btn-submit").prop("disabled", false);

                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            html: response.message,
                            showConfirmButton: false,
                            timerProgressBar: true
                        });
                    }
                },
            });
        }

        function refresh(time) {
            setTimeout(function () {
                window.location.reload();
            }, time);
        }
    </script>
@endpush