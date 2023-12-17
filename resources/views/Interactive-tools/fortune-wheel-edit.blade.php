@extends('Layout/interactive_tools_master')
<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- <link rel="stylesheet" href="{{ asset('css/interactive_tools_style.css') }}"> --}}

<script type="text/javascript" src="{{ asset('js/Winwheel.js') }}"></script>


<script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js"></script>


@section('content')
    <style scoped>
        .the_wheel {
            position: relative;
            width: max-content;
        }

        .pointer {
            width: 0;
            height: 0;
            border-left: 10px solid transparent;
            border-right: 10px solid transparent;
            border-top: 50px solid black;
            position: absolute;
            top: 20px;
            left: calc(50% - 10px);
            z-index: 999;
            transform-origin: bottom center;
        }

        .head-fw-1 {
            align-items: center;
            justify-content: space-between;
        }

        .head-fw-1 #modeSelectorContainer {
            font-size: 18px;
            margin: 10px 20px;
        }
    </style>

    <div class="save-btn-container">
        <button id="save-wheel-button" class="btn btn-dark">Save & Exit</button>
    </div>

    <!-- Add this hidden input field to store the Fortune Wheel's ID -->
    <input type="hidden" id="fortune-wheel-id" name="fortuneWheel[id]" value="{{ $fortuneWheel->id ?? '' }}">


    <div class="container ">
        <div class="input-group head-fw-1">
            <span class="edit-icon" style="cursor: pointer;">
                <div style="display: flex; align-items: center; justify-content: center; gap:20px;">
                    <input type="text" class="form-control" id="fortune-wheel-title" name="fortuneWheel[title]"
                        placeholder="Fortune Wheel Title" value="{{ $fortuneWheel->title ?? '' }}" readonly required>
                    <button class="btn btn-dark" style="font-size: 18px; padding: 10px" type="button"
                        data-bs-toggle="modal" data-bs-target="#editModal"><i class="fa fa-edit"></i></button>
                </div>
            </span>

            <div id="modeSelectorContainer">
                <label for="modeSelector"><b>Type:</b>
                    <select id="modeSelector" class="" onchange="changeMode()">
                        <option value="standard">Standard</option>
                        <option value="wheel" selected>Wheel</option>
                    </select>
                </label>
            </div>
        </div>

        <div class="row">


            <div class="col-md-6 col-xl-7 container-style" id="standard" style="display: none;">
                <div id="result-box" class="box">Press "Spin" to start</div>
                <button class="btn btn-dark interactive_btn" id="spin-button" type="button"
                    style="padding: 10px 50px;">Spin</button>
            </div>

            <div class="col-xl-7 container-style" id="wheel"
                style="display: flex;flex-direction:column;justify-content:center;align-items:center;">
                <div class="the_wheel">
                    <div class="pointer"></div>
                    <canvas id="canvas" width="500" height="500"></canvas>

                </div>
                <button type="button" id="spinBtn" class="btn btn-dark" style="width:200px;"
                    onclick="startSpin();">Spin</button>
            </div>

            {{-- <div class="col-md-6 col-xl-5 container-style"> --}}
            <div class="col-xl-5 container-style">
                <div class="card fortune_wheel_card"></div>
                <div>
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation"><a class="nav-link active" role="tab"
                                data-bs-toggle="tab" href="#tab-1" style="font-size:16px; color: rgb(33, 37, 41);">Entries
                                (<span id="entries_count" style="color: rgb(33, 37, 41);"></span>)</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" role="tab" data-bs-toggle="tab"
                                href="#tab-2" style="font-size:16px;"><span style="color: rgb(33, 37, 41);">Results (<span
                                        id="results_count"></span>)</span></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" role="tabpanel" id="tab-1">
                            <div class="btn-group d-flex justify-content-center" role="group" id="roulette_action_btn">
                                <button id="shuffle-button" class="btn" type="button">
                                    <img src="{{ asset('img/shuffle.png') }}">Shuffle</button>
                                <button id="sort-button" class="btn" type="button">
                                    <img src="{{ asset('img/sort.png') }}">Sort</button>
                            </div>
                            <form>
                                <label for="entries_contentholder"></label>
                                <textarea class="contentholder form-control" id="entries_contentholder" name="fortuneWheel[entries]">{{ implode("\n", $fortuneWheel->entries ?? []) }}</textarea>
                            </form>
                        </div>
                        <div class="tab-pane fade" role="tabpanel" id="tab-2">
                            <form>
                                <label for="results_contentholder"></label>
                                <textarea class="contentholder form-control" id="results_contentholder" name="fortuneWheel[results]">{{ implode("\n", $fortuneWheel->results ?? []) }}</textarea>
                            </form>
                        </div>
                    </div>


                    <div class="input_container">
                        <input type="file" id="excel_file_input" class="form-control" accept=".xlsx"
                            title="Only XLSX files are supported">
                    </div>

                    <button id="help-button" class="btn" type="button">Not sure how to use it?</button>
                    <div id="usage-instructions">
                        Currently this program support 2 types of input <br>
                        1. Direct copy <br>
                        1.1 You may direct copy and paste the entries into the Entries tab. <br>
                        1.2 It also support single line data input, where the data is being saperated using "," or "|"
                        as delimiters. <br>
                        1.3 It will be processed automatically, and display as individual entry. <br>
                        <br>
                        2. File upload - Excel <br>
                        2.1. Create a XLSX or Excel file.<br>
                        2.2. Make sure you entered the data under the "Name" column.<br>
                        2.3. Upload the file.
                    </div>

                </div>
                <button id="import-button" class="btn btn-dark interactive_btn" style="display: none;" type="button">
                    <i class="fas fa-upload" style="margin-right: 20px;"></i>Import Data</button>
            </div>
        </div>
    </div>


    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="padding: 25px;">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Fortune Wheel Title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="m-0"><b class="required">Title</b></p>
                    <input type="text" class="form-control" id="editFortuneWheelTitle"
                        placeholder="Fortune Wheel Title">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveChanges">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        const fw = @json($fortuneWheel);
        let ori_fw = @json($fortuneWheel);
    </script>
    <script src="{{ asset('js/fortune_wheel.js') }}"></script>
@endsection
