<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gentelella Alela! | </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap -->
    <link href="{{ asset('admin/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('admin/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('admin/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ asset('admin/vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ asset('admin/build/css/custom.min.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs@gh-pages/qrcode.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
</head>

<style>
    @media screen {
        #printSection {
            display: none;
        }
    }

    @media print {
        body * {
            visibility: hidden;
        }

        #printSection,
        #printSection * {
            visibility: visible;
        }

        #printSection {
            position: absolute;
            left: 0;
            top: 0;
        }
    }

    .fa-o {
        color: #fff;
        text-shadow: -2px -2px 0 black,
            2px -2px 0 black,
            -2px 2px 0 black,
            2px 2px 0 black;
    }

    .cardx {
        user-select: none;
        margin-left: 30px;
        width: 7rem;
        padding: 10px;
        transition: transform .1s;
    }

    .cardx:hover {
        background: rgb(215, 215, 215);
        transform: scale(1.1);
    }

    .modal-body p {
        font-size: 18px;
    }

    .p_info {
        color: white;
        background: black;
    }
</style>


<style>
    #video {
        border: 1px solid black;
        box-shadow: 2px 2px 3px black;
        width: 320px;
        height: 240px;
    }

    #photo {
        border: 1px solid black;
        box-shadow: 2px 2px 3px black;
        width: 320px;
        height: 240px;
    }

    #canvas {
        display: none;
    }

    .camera {
        width: 340px;
        display: inline-block;
    }

    .output {
        width: 340px;
        display: inline-block;
        vertical-align: top;
    }

    #startbutton {
        display: block;
        position: relative;
        margin-left: auto;
        margin-right: auto;
        bottom: 32px;
        background-color: rgba(0, 150, 0, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.7);
        box-shadow: 0px 0px 1px 2px rgba(0, 0, 0, 0.2);
        font-size: 14px;
        font-family: "Lucida Grande", "Arial", sans-serif;
        color: rgba(255, 255, 255, 1.0);
    }

    .contentarea {
        font-size: 16px;
        font-family: "Lucida Grande", "Arial", sans-serif;
        width: 760px;
    }
</style>

<script>


    function dangKyVeXeThang(){
        let person = prompt("Nhập địa chỉ email", "Harry Potter");
        let person2 = prompt("Nhập số tháng muốn đăng ký", "Harry Potter");
        if (confirm('Tổng chi phí vé xe cho 2 tháng: 50000đ , đã thu?')) {
        // Save it!
        console.log('Thing was saved to the database.');
        } else {
        // Do nothing!
        console.log('Thing was not saved to the database.');
        }
    }


    var currentSlotID;
    var fileName;
    var giatien1gio = 3000;

    function DateDiff(date1, date2) {
        date1.setHours(0);
        date1.setMinutes(0, 0, 0);
        date2.setHours(0);
        date2.setMinutes(0, 0, 0);
        var datediff = Math.abs(date1.getTime() - date2.getTime()); // difference 
        return parseInt(datediff / (24 * 60 * 60 * 1000), 10); //Convert values days and return value      
    }

    function showDetailSlot(khu_slot_id) {
        $.ajax({
            url: "getSlotDetail/" + khu_slot_id,
            method: 'get',
            dataType: 'json',
            success: function (response) {
                $('#detailModal').modal('toggle');

                $('#p_mathexe').text(response.mathexe);
                $('#p_thoigianvao').text(response.thoigianvao);
                var d1 = new Date(response.thoigianvao); // jan,1 2011
                var d2 = new Date(); // now

                var diff = d2 - d1, sign = diff < 0 ? -1 : 1, milliseconds, seconds, minutes, hours, days;
                diff /= sign; // or diff=Math.abs(diff);
                diff = (diff - (milliseconds = diff % 1000)) / 1000;
                diff = (diff - (seconds = diff % 60)) / 60;
                diff = (diff - (minutes = diff % 60)) / 60;
                days = (diff - (hours = diff % 24)) / 24;
                giatien = giatien1gio * (days * 24) + giatien1gio * hours;
                $("#p_giatien").text(giatien + "đ");
                $("#p_thoigiandatroi").text(days + " ngày, " + hours + " giờ, " + minutes + " phút, " + seconds + " giây");
                $('#p_biensoxe').text(response.biensoxe);
                $("#p_hinhanh").attr("src", "uploadedimages/" + response.hinhanhcuaxe);
                $("#slotNameLabel").text("Chỗ: " + response.ten_ben);
                $("#biensoxe").text(response.biensoxe);
                currentSlotID = response.id;
                currentKhuID = response.khu_slot_id;
            }
        });
    }

    function showDetailSlotUUID(uuid) {
        $.ajax({
            url: "getSlotDetailUUID/" + uuid,
            method: 'get',
            dataType: 'json',
            success: function (response) {
                $('#detailModal').modal('toggle');

                $('#p_mathexe').text(response.mathexe);
                $('#p_thoigianvao').text(response.thoigianvao);
                var d1 = new Date(response.thoigianvao); // jan,1 2011
                var d2 = new Date(); // now

                var diff = d2 - d1, sign = diff < 0 ? -1 : 1, milliseconds, seconds, minutes, hours, days;
                diff /= sign; // or diff=Math.abs(diff);
                diff = (diff - (milliseconds = diff % 1000)) / 1000;
                diff = (diff - (seconds = diff % 60)) / 60;
                diff = (diff - (minutes = diff % 60)) / 60;
                days = (diff - (hours = diff % 24)) / 24;
                giatien = giatien1gio * (days * 24) + giatien1gio * hours;
                $("#p_giatien").text(giatien + "đ");
                $("#p_thoigiandatroi").text(days + " ngày, " + hours + " giờ, " + minutes + " phút, " + seconds + " giây");
                $('#p_biensoxe').text(response.biensoxe);
                $("#p_hinhanh").attr("src", "uploadedimages/" + response.hinhanhcuaxe);
                $("#slotNameLabel").text("Chỗ: " + response.ten_ben);
                $("#biensoxe").text(response.biensoxe);
                currentSlotID = response.id;
                currentKhuID = response.khu_slot_id;
            }
        });
    }

    function xuatBen() {
        $.ajax({
            url: "finishSlot/" + currentSlotID + "/" + currentKhuID,
            method: 'get',
            dataType: 'json',
            success: function (response) {

            }
        });

        setTimeout(function () {
            window.location.reload();
        }, 800);


    }

    function uuidv4() {
        return ([1e7] + -1e3 + -4e3 + -8e3 + -1e11).replace(/[018]/g, c =>
            (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
        );
    }

    function printElement(elem) {
        var domClone = elem.cloneNode(true);

        var $printSection = document.getElementById("printSection");

        if (!$printSection) {
            var $printSection = document.createElement("div");
            $printSection.id = "printSection";
            document.body.appendChild($printSection);
        }

        $printSection.innerHTML = "";
        $printSection.appendChild(domClone);
        window.print();
    }


    function submitNewSlot() {
        if ($("#biensoxe").val()) {
            var uuid = uuidv4();
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            var fd = new FormData();
            fd.append('khu_slot_id', $("#benGiuID").val());
            fd.append('ten_khu', $("#khuName").val());
            fd.append('id_ben', $("#benGiuID").val());
            fd.append('ten_ben', $("#benGiu").val());
            fd.append('biensoxe', $("#biensoxe").val());
            fd.append('mathexe', uuid);
            fd.append('hinhanhcuaxe', fileName);
            fd.append('trangthai', 0);

            fd.append('_token', CSRF_TOKEN);
            $.ajax({
                url: "{{route('uploadNewSlot')}}",
                method: 'post',
                data: fd,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (response) {

                }
            })
            $("#modal1").remove();
            var qrcode = new QRCode("qrcode");
            qrcode.makeCode(uuid);

            setTimeout(function () {
                printElement(document.getElementById("printThis"));
                window.location.reload();
            }, 800);
        }
        else {
            alert("Chưa có biển số , vui lòng thử lại!");
        }

    }


    function getEmptySlot() {


        $("#timeVao").val(new Date().toLocaleString());
        $.ajax({
            url: "{{route('getEmptySlot')}}",
            method: 'get',
            dataType: 'json',
            success: function (response) {
                $("#placeName").text("Bến giữ: " + response.khu_slot.slot_name);
                $("#benGiu").val(response.khu_slot.slot_name);
                $("#benGiuID").val(response.khu_slot.khu_slot_id);
                $("#khuName").val(response.ten_khu);
                $("#khuID").val(response.khu_slot.khu_id);
                $('#addNewModal').modal('toggle');
            },
            error: function (response) {
                alert("Hiện tại đang không còn bến trống!!!");
            }

        });
    }


    (function () {
        // The width and height of the captured photo. We will set the
        // width to the value defined here, but the height will be
        // calculated based on the aspect ratio of the input stream.

        var width = 1080;  // We will scale the photo width to this
        var height = 0;     // This will be computed based on the input stream

        // |streaming| indicates whether or not we're currently streaming
        // video from the camera. Obviously, we start at false.

        var streaming = false;

        // The various HTML elements we need to configure or control. These
        // will be set by the startup() function.

        var video = null;
        var canvas = null;
        var photo = null;
        var startbutton = null;




        function showViewLiveResultButton() {
            if (window.self !== window.top) {
                // Ensure that if our document is in a frame, we get the user
                // to first open it in its own tab or window. Otherwise, it
                // won't be able to request permission for camera access.
                document.querySelector(".contentarea").remove();
                const button = document.createElement("button");
                button.textContent = "View live result of the example code above";
                document.body.append(button);
                button.addEventListener('click', () => window.open(location.href));
                return true;
            }
            return false;
        }

        function startup() {
            if (showViewLiveResultButton()) { return; }
            video = document.getElementById('video');
            canvas = document.getElementById('canvas');
            photo = document.getElementById('photo');
            startbutton = document.getElementById('startbutton');

            navigator.mediaDevices.getUserMedia({ video: true, audio: false })
                .then(function (stream) {
                    video.srcObject = stream;
                    video.play();
                })
                .catch(function (err) {
                    console.log("An error occurred: " + err);
                });

            video.addEventListener('canplay', function (ev) {
                if (!streaming) {
                    height = video.videoHeight / (video.videoWidth / width);

                    // Firefox currently has a bug where the height can't be read from
                    // the video, so we will make assumptions if this happens.

                    if (isNaN(height)) {
                        height = width / (4 / 3);
                    }

                    video.setAttribute('width', width);
                    video.setAttribute('height', height);
                    canvas.setAttribute('width', width);
                    canvas.setAttribute('height', height);
                    streaming = true;
                }
            }, false);

            startbutton.addEventListener('click', function (ev) {
                takepicture();
                ev.preventDefault();
            }, false);

            clearphoto();
        }

        // Fill the photo with an indication that none has been
        // captured.

        function clearphoto() {
            var context = canvas.getContext('2d');
            context.fillStyle = "#AAA";
            context.fillRect(0, 0, canvas.width, canvas.height);

            var data = canvas.toDataURL('image/png');
            photo.setAttribute('src', data);
        }

        // Capture a photo by fetching the current contents of the video
        // and drawing it into a canvas, then converting that to a PNG
        // format data URL. By drawing it on an offscreen canvas and then
        // drawing that to the screen, we can change its size and/or apply
        // other changes before drawing it.

        function takepicture() {
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            var context = canvas.getContext('2d');
            if (width && height) {
                canvas.width = width;
                canvas.height = height;
                context.drawImage(video, 0, 0, width, height);

                var data = canvas.toDataURL('image/png');
                photo.setAttribute('src', data);
                canvas.toBlob((blob) => {
                    let file = new File([blob], "fileName.jpg", { type: "image/jpeg" })
                    var fd = new FormData();
                    fd.append('file', file);
                    fd.append('_token', CSRF_TOKEN);
                    $.ajax({
                        url: "{{route('uploadFile')}}",
                        method: 'post',
                        data: fd,
                        contentType: false,
                        processData: false,
                        dataType: 'html',
                        success: function (response) {
                            fileName = response;
                            $.ajax({
                                url: "detect_plate/" + fileName,
                                method: 'get',
                                dataType: 'html',
                                success: function (response) {
                                    if (response != "error") {
                                        $("#biensoxe").val(response);
                                        console.log(response);
                                    }

                                }
                            });
                        }
                    })


                }, 'image/jpeg');


            } else {
                clearphoto();
            }
        }

        // Set up our event listener to run the startup process
        // once loading is complete.
        window.addEventListener('load', startup, false);
    })();

</script>




<body class="nav-md">



    
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>Hệ thống quản lý</span></a>
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
            
                    <!-- /menu profile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    @include('sidebar')
                    <!-- /sidebar menu -->

                    <!-- /menu footer buttons -->

                    <!-- /menu footer buttons -->
                </div>
            </div>

            
            


            <form method="POST">
                <div class="modal fade" id="addNewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="placeName">Chỗ: </h5>
                                <button type="button" class="btn btn-info" onclick="dangKyVeXeThang()">Đăng ký vé xe tháng</button>
                            </div>

                            <div class="modal-body" id="printThis">

                                <label>Biển số xe</label>
                                <input class="form-control" placeholder="Biển số xe" disabled id="biensoxe">
                                <label>Thời gian vào</label>
                                <input class="form-control" placeholder="Thời gian vào" id="timeVao" disabled>
                                <label>Khu</label>
                                <input class="form-control" hidden id="khuID">
                                <input class="form-control" placeholder="Tên khu" id="khuName" name="ten_khu" disabled>
                                <label>Bến giữ</label>
                                <input class="form-control" placeholder="Bến giữ" id="benGiu" disabled>
                                <input class="form-control" hidden id="benGiuID">
                                <div id="modal1">
                                    <div class="camera">
                                        <video id="video">Video stream not available.</video>
                                        <button id="startbutton">Take photo</button>
                                    </div>

                                    <canvas id="canvas">
                                    </canvas>
                                    <br>
                                    <label>Hình ảnh của xe: </label>
                                    <br>
                                    <div class="output">
                                        <img id="photo" alt="The screen capture will appear in this box.">
                                    </div>


                                </div>

                                <div id="qrcode"></div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-success" onclick="submitNewSlot()">Giữ xe & In
                                    thẻ</button>

                            </div>
                        </div>
                    </div>
                </div>

            </form>
            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>
                    <nav class="nav navbar-nav">
                        <ul class=" navbar-right">
                            <li class="nav-item dropdown open" style="padding-left: 15px;">
                                <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true"
                                    id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                                    Hiếu Phạm
                                </a>
                                <div class="dropdown-menu dropdown-usermenu pull-right"
                                    aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="javascript:;"> Profile</a>
                                    <a class="dropdown-item" href="javascript:;">
                                        <span class="badge bg-red pull-right">50%</span>
                                        <span>Settings</span>
                                    </a>
                                    <a class="dropdown-item" href="javascript:;">Help</a>
                                    <a class="dropdown-item" href="login.html"><i class="fa fa-sign-out pull-right"></i>
                                        Log Out</a>
                                </div>
                            </li>


                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">


                <button class="btn btn-primary" onclick="getEmptySlot()">Thêm</button>
                <button class="btn btn-success" onclick="scanQR()">Quét thẻ</button>
                <div style="width: 500px; width: 500px">
                    <div id="reader"></div>
                </div>
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3>Quản lý ra vào bến</h3>
                        </div>
                    </div>

                    <div class="clearfix"></div>



                    {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        Launch demo modal
                    </button> --}}

                    <!-- Modal -->
                    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="slotNameLabel">Chỗ: A1</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Biển số xe: </p>
                                    <p class="p_info" id="p_biensoxe"></p>
                                    <p>Mã thẻ xe: </p>
                                    <p class="p_info" id="p_mathexe"></p>
                                    <p>Thời gian vào: </p>
                                    <p class="p_info" id="p_thoigianvao"></p>
                                    <p>Thời gian đã trôi qua: </p>
                                    <p class="p_info" id="p_thoigiandatroi"></p>
                                    <p>Giá tiền: </p>
                                    <p class="p_info" id="p_giatien"></p>
                                    <p>Hình ảnh của xe: </p>
                                    <p class="p_info"></p>
                                    <img src="" class="img-responsive" id="p_hinhanh" style="width: 100%">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-warning" onclick="xuatBen()">Xuất bến</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    @foreach ($khu as $khuu)
                    <div class="alert alert-info" role="alert" style="margin-top: 20px">
                        Khu {{$khuu->ten_khu}}
                    </div>

                    <div class="row">
                        @foreach ($khu_slot as $khu_slott)

                        @if ($khu_slott->khu_id == $khuu->id_khu)


                        <div class="card cardx" onclick="{{ $khu_slott->status === 0 ? "" : " showDetailSlot(".
                            $khu_slott->khu_slot_id .")" }}">
                            <i class="fas fa-car {{ $khu_slott->status === 0 ? " fa-o" : "" }}" style="font-size: 40px"
                                data-khuslotid="{{$khu_slott->khu_slot_id}}"></i>
                            <h2>{{$khu_slott->slot_name}}</h2>
                        </div>

                        @endif

                        @endforeach

                    </div>
                    @endforeach


                </div>
            </div>
            <!-- /page content -->

            <!-- footer content -->

            <!-- /footer content -->
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('admin/vendors/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('admin/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('admin/vendors/fastclick/lib/fastclick.js') }}"></script>
    <!-- NProgress -->
    <script src="{{ asset('admin/vendors/nprogress/nprogress.js') }}"></script>
    <!-- iCheck -->
    <script src="{{ asset('admin/vendors/iCheck/icheck.min.js') }}"></script>

    <!-- Custom Theme Scripts -->
    <script src="{{ asset('admin/build/js/custom.min.js') }}"></script>


    <script>
        function scanQR() {
            const html5QrCode = new Html5Qrcode("reader");

            Html5Qrcode.getCameras().then(devices => {
                /**
                 * devices would be an array of objects of type:
                 * { id: "id", label: "label" }
                 */
                if (devices && devices.length) {
                    var cameraId = devices[0].id;
                    console.log(cameraId);
                    html5QrCode.start(
                        cameraId,     // retreived in the previous step.
                        {
                            fps: 10,    // sets the framerate to 10 frame per second
                            qrbox: 250  // sets only 250 X 250 region of viewfinder to
                            // scannable, rest shaded.
                        },
                        qrCodeMessage => {
                            // do something when code is read. For example:
                            console.log(`QR Code detected: ${qrCodeMessage}`);
                            showDetailSlotUUID(qrCodeMessage);
                            html5QrCode.stop().then(ignore => {
                                // QR Code scanning is stopped.
                                console.log("QR Code scanning stopped.");
                            }).catch(err => {
                                // Stop failed, handle it.
                                console.log("Unable to stop scanning.");
                            });
                        },
                        errorMessage => {
                            // parse error, ideally ignore it. For example:
                            console.log(`QR Code no longer in front of camera.`);
                        })
                        .catch(err => {
                            // Start failed, handle it. For example,
                            console.log(`Unable to start scanning, error: ${err}`);
                        });
                    // .. use this to start scanning.
                }
            }).catch(err => {
                console.log(err);
            });


        }




    </script>
</body>

</html>