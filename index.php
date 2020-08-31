<?php 
function unicodeDecode($unicode_str){
  $json = '{"str":"'.$unicode_str.'"}';
  $arr = json_decode($json,true);
  if(empty($arr)) return '';
  return $arr['str'];
}
//Announcement_API 
// $announcement_api_url = "http://34.80.207.185/blackfin/API/main.php?view=annoucement";
function catchApi($showWho){
$curl = curl_init();
$url = $showWho;
curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_CUSTOMREQUEST => "GET", 
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json"
  ),
  CURLOPT_RETURNTRANSFER => 1,
));
//curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
$response = curl_exec($curl);
curl_close($curl);
return json_decode($response);
}
$announcement_api =json_encode(catchApi("http://34.80.56.1/blackfin/API/main.php?view=annoucement&type=get"));
//print_r($announcement_api);

//Instagram_API 
$access_token = "IGQVJYcEpZAbEQ5akktNDZA3M3UwN2ZAzU1ZAsUFlKeUtwY0Fyd0V3VTZAGR1RaLWxGV2FraHN5M1pReUFsWXFSZAXk0Sk5GREkxSmhCaTlKeHc4aVR4TmJvZAkZAUVTBnT1dBQ0tEN3gxYUhJakE1NnJDUTJGTAZDZD...";
$instagram_api = catchApi("https://graph.instagram.com/me/media?fields=id,media_type,media_url,permalink,timestamp,media,caption&access_token=".$access_token);
$instagram_api = $instagram_api->data;
function json_stringify($json) {
    if (is_array($json)) $json = json_encode($json);
    $search = array('\\', "\n", "\r", "\f", "\t", "\b", "'") ;
    $replace = array('\\\\', "\\n", "\\r","\\f","\\t","\\b", "'");
    return str_replace($search, $replace, $json);
}
$instagram_api = json_stringify($instagram_api);
//print_r($instagram_api);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>KnightOne Bootstrap Template - Index</title>
    <meta content="" name="descriptison">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- <link rel="stylesheet" href="/resources/demos/style.css">    Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/venobox/venobox.css" rel="stylesheet">
    <link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> <!-- Template Main CSS File -->
    <script src="assets/js/InstagramFeed.min.js"></script>
    <link href="assets/css/style.css" rel="stylesheet">
    <script>
    var $j = jQuery.noConflict();
    let firstLoad = true;
    let apireturn = "";
    let announcement_catch_type = "";
    let announcement_catch_title = "";
    let announcement_catch_text = "";
    let announcemntJson = '<?= $announcement_api?>';
    announcemntJson = JSON.parse(announcemntJson);
    let instagramApi = '<?= $instagram_api?>';
    instagramApi = JSON.parse(instagramApi);
    //console.log(instagramApi);

    function showAnnouncemnt(type) {
        announcement_catch_type = "";
        announcement_catch_title = "";
        announcement_catch_text = "";
        apireturn = "<ul class=\"timeline\">";
        //apireturn ="<table class=\"table table-hover\"><tr><td><button type=\"button\" class=\"btn btn-danger\" id=\"all_button\">全部</button><button type=\"button\" class=\"btn btn-success\" id=\"ann_button\">公告</button><button type=\"button\" class=\"btn btn-info\" id=\"event_button\">活動</button><button type=\"button\" class=\"btn btn-warning\" id=\"sale_button\">優惠</button></td></tr>";
        for (i = 0; i < announcemntJson.length; i++) {
            announcement_catch_type = announcemntJson[i].announcementType;
            announcement_catch_title = announcemntJson[i].announcementTitle;
            announcement_catch_text = announcemntJson[i].announcementText;
            announcement_catch_time = announcemntJson[i].announcementTime;
            // if (type == "all") {
            //     apireturn = apireturn + "<tr><td>" + announcement_catch_type + "</td><td>" + announcement_catch_title +
            //         "</td><td>" + announcement_catch_text + "</td></tr>";
            // } else if (type == "event") {
            //     if (announcement_catch_type == "活動") {
            //         apireturn = apireturn + "<tr><td>" + announcement_catch_type + "</td><td>" +
            //             announcement_catch_title + "</td><td>" + announcement_catch_text + "</td></tr>";
            //     }
            // } else if (type == "sale") {
            //     if (announcement_catch_type == "優惠") {
            //         apireturn = apireturn + "<tr><td>" + announcement_catch_type + "</td><td>" +
            //             announcement_catch_title + "</td><td>" + announcement_catch_text + "</td></tr>";
            //     }
            // } else if (type == "ann") {
            //     if (announcement_catch_type == "公告") {
            //         apireturn = apireturn + "<tr><td>" + announcement_catch_type + "</td><td>" +
            //             announcement_catch_title + "</td><td>" + announcement_catch_text + "</td></tr>";
            //     }
            // }
            if (type == "all") {
                apireturn = apireturn + "<li><a target=\"_blank\" href=\"#\">" + announcement_catch_title +
                    "</a><a href=\"#\" class=\"float-right\">" + announcement_catch_time + "</a><p>" +
                    announcement_catch_text +
                    "</p></li>";
            } else if (type == "event") {
                if (announcement_catch_type == "活動") {
                    apireturn = apireturn + "<li><a target=\"_blank\" href=\"#\">" + announcement_catch_title +
                        "</a><a href=\"#\" class=\"float-right\">" + announcement_catch_time + "</a><p>" +
                        announcement_catch_text +
                        "</p></li>";
                }
            } else if (type == "sale") {
                if (announcement_catch_type == "優惠") {
                    apireturn = apireturn + "<li><a target=\"_blank\" href=\"#\">" + announcement_catch_title +
                        "</a><a href=\"#\" class=\"float-right\">" + announcement_catch_time + "</a><p>" +
                        announcement_catch_text +
                        "</p></li>";
                }
            } else if (type == "ann") {
                if (announcement_catch_type == "公告") {
                    apireturn = apireturn + "<li><a target=\"_blank\" href=\"#\">" + announcement_catch_title +
                        "</a><a href=\"#\" class=\"float-right\">" + announcement_catch_time + "</a><p>" +
                        announcement_catch_text +
                        "</p></li>";
                }
            }




        }
        // <li>
        //                 <!--"_blank" tıklanan linkin yeni sekmede açılmasını sağlar.-->
        //                 <a target="_blank" href="#">News Headline</a>
        //                 <a href="#" class="float-right">09 Ocak, 2019</a>
        //                 <p>Haberler burada gözükecek..Haberler burada gözükecek..Haberler burada
        //                   gözükecek..Haberler burada gözükecek..Haberler burada gözükecek..</p>
        //               </li>
        // apireturn = apireturn + "</table></div>";
        //console.log(apireturn);
        apireturn = apireturn + "</ul>";
        console.log(apireturn);
        document.getElementById('annoucement').innerHTML = apireturn;
        // document.getElementById("all_button").addEventListener("click", function() {
        //     showAnnouncemnt("all");
        // });

        // document.getElementById("ann_button").addEventListener("click", function() {
        //     showAnnouncemnt("ann");
        // });

        // document.getElementById("event_button").addEventListener("click", function() {
        //     showAnnouncemnt("event");
        // });

        // document.getElementById("sale_button").addEventListener("click", function() {
        //     showAnnouncemnt("sale");
        // });
    }
    let instagram_catch_type = "";
    let instagram_catch_mediaurl = "";
    let instagram_catch_caption = "";
    let instagram_catch_time = "";
    let instagram_return = "";
    let windowsWidth = 0;

    function showInstagram() {
        instagram_return = "";
        windowsWidth = document.body.clientWidth;
        //console.log(windowsWidth);
        for (i = 0; i < instagramApi.length; i++) {
            instagram_catch_type = instagramApi[i].media_type;
            instagram_catch_mediaurl = instagramApi[i].media_url;
            instagram_catch_caption = instagramApi[i].caption;
            instagram_catch_time = instagramApi[i].timestamp;
            //console.log(instagram_catch_caption.length);
            if (instagram_catch_caption.length > 50) {
                instagram_catch_caption = instagram_catch_caption.substring(0, 50) + "...";
            }
            instagram_return = instagram_return +
                "<div class=\"col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0\"><div class=\"icon-box\"><img src=\"" +
                instagram_catch_mediaurl + "\" width=\"100%\"><h4><a></a></h4><p>" + instagram_catch_caption +
                "</p></div></div>"
        }
        //console.log(instagram_return);
        document.getElementById('instagramcontent').innerHTML = instagram_return;
        //instagramcontent
        return instagram_return;
    }

    //showInstagram();
    // function showInstagram(){
    //   for(i=0;instagram.length)
    // }
    //document.getElementById('annoucement').innerHTML=showAnnouncemnt("all");


    $j(function() {
        $j("#datepicker").datepicker();
    });
    </script>
    <!-- =======================================================
  * Template Name: KnightOne - v2.1.0
  * Template URL: https://bootstrapmade.com/knight-simple-one-page-bootstrap-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->

</head>

<body>
    <!-- <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0">
                        <div class="icon-box">
                            <img src="assets/img/info_1.jpg" alt="" width="100%">
                            <h4><a href="">Sed ut perspiciatis</a></h4>
                            <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore</p>
                        </div>
                    </div> -->
    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top ">
        <div class="container-fluid">

            <div class="row justify-content-center">
                <div class="col-xl-9 d-flex align-items-center justify-content-between">
                    <h1 class="logo"><a href="index.php"><img src="assets/img/LOGO2.png" alt=""
                                class="img-fluid">黑鰭飲冰宿</a></h1>
                    <!-- Uncomment below if you prefer to use an image logo -->


                    <nav class="nav-menu d-none d-lg-block">
                        <ul>
                            <li class="active"><a href="index.php">首頁</a></li>
                            <li><a href="#about">公告</a></li>
                            <li><a href="#roomIntro">房間介紹</a></li>
                            <li><a href="#check">房間預訂</a></li>
                            <li><a href="#insta">IG官方帳號</a></li>
                            <!-- <li class="drop-down"><a href="">Drop Down</a>
                                <ul>
                                    <li><a href="#">Drop Down 1</a></li>
                                    <li class="drop-down"><a href="#">Deep Drop Down</a>
                                        <ul>
                                            <li><a href="#">Deep Drop Down 1</a></li>
                                            <li><a href="#">Deep Drop Down 2</a></li>
                                            <li><a href="#">Deep Drop Down 3</a></li>
                                            <li><a href="#">Deep Drop Down 4</a></li>
                                            <li><a href="#">Deep Drop Down 5</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Drop Down 2</a></li>
                                    <li><a href="#">Drop Down 3</a></li>
                                    <li><a href="#">Drop Down 4</a></li>
                                </ul>
                            </li> -->
                            <li><a href="#contact">Contact</a></li>

                        </ul>
                    </nav><!-- .nav-menu -->

                    <!-- <a href="#about" class="get-started-btn scrollto">Get Started</a> -->
                </div>
            </div>

        </div>
    </header><!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <!-- <section id="hero" class="d-flex flex-column justify-content-center"> -->
    <section class="d-flex flex-column justify-content-center" id="hero">
        <div class="container">
            <div class="row justify-content-center" id="mainVideo">

                <script>
                let video_PC =
                    "<video id=\"myvideo\" class=\"video-fluid\" autoplay muted fill><source src=\"assets/video/MAIN(TINY).mp4\" type=\"video/mp4\"/></video>"
                let video_MB = "<img src=\"assets/img/MAIN_MB.gif\" id=\"video_MB\" class=\"img-fluid\"alt=\"\">";
                let PIC_MB = "<img src=\"assets/img/MAIN_MB.png\" id=\"video_MB\" class=\"img-fluid\"alt=\"\">";
                if (document.body.clientWidth > 850) {
                    document.getElementById('mainVideo').innerHTML = video_PC;
                } else {
                    document.getElementById('mainVideo').innerHTML = video_MB;
                    setTimeout(function(){document.getElementById('mainVideo').innerHTML=PIC_MB}, 5000);
                }
                </script>
                <!-- <div class="col-xl-8">
                    <h1>主標題</h1>
                    <h2>副標題</h2>
                    <a href="https://www.youtube.com/watch?v=jDDaplaOz7Q" class="venobox play-btn mb-4" data-vbtype="video" data-autoplay="true"></a>
                </div> -->
            </div>
        </div>
    </section>
    <!-- <script>
    let videoheight = document.getElementById('myvideo').offsetHeight;
    document.getElementById('videocontainer').style = "height:" + videoheight;
    </script> -->
    <!-- </section>End Hero -->
    <main id="main">
        <!-- ======= About Us Section ======= -->
        <section id="about" class="about">
            <div class="container">



                <div class="container" style="width:100%">
                    <div class="row" style="margin:0px auto">
                        <div class="card border golge" style="width:100%">
                            <div class="card-header"><a href="javascript:void(0)" class="isteColor">
                                    <h5 class="text-center m-2" style="font-weight: bold">最新消息</h5>
                                </a></div>
                            <h5 class="text-center m-2" style="font-weight: bold">
                                <a href="javascript:void(0)" class="badge badge-primary" id="all_button">全部</a>
                                <a href="javascript:void(0)" class="badge badge-secondary" id="ann_button">公告</a>
                                <a href="javascript:void(0)" class="badge badge-success" id="event_button">活動</a>
                                <a href="javascript:void(0)" class="badge badge-danger" id="sale_button">優惠</a>
                            </h5>
                            <div class="card-body" style="height:500px;overflow:auto">
                                <div class="carousel vert slide" data-ride="carousel" data-interval="2000">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active" id="annoucement">

                                            <ul class="timeline">
                                                <li>
                                                    <a target="_blank" href="#">News Headline</a>
                                                    <a href="#" class="float-right">09 Ocak, 2019</a>
                                                    <p>1</p>
                                                </li>
                                                <hr>
                                                <li>
                                                    <a href="#">News Headline</a>
                                                    <a href="#" class="float-right">4 Temmuz, 2018</a>
                                                    <p>2</p>
                                                </li>
                                                <hr>
                                                <li>
                                                    <a href="#">News Headline</a>
                                                    <a href="#" class="float-right">4 Temmuz, 2018</a>
                                                    <p>3</p>
                                                </li>
                                            </ul>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                showAnnouncemnt("all");
                document.getElementById("all_button").addEventListener("click", function() {
                    showAnnouncemnt("all");
                });

                document.getElementById("ann_button").addEventListener("click", function() {
                    showAnnouncemnt("ann");
                });

                document.getElementById("event_button").addEventListener("click", function() {
                    showAnnouncemnt("event");
                });

                document.getElementById("sale_button").addEventListener("click", function() {
                    showAnnouncemnt("sale");
                });
                </script>






        </section><!-- End About Us Section -->




        <!-- <section id="services" class="services">
            <div class="container">

                <div class="section-title">
                    <h2>民宿介紹</h2>
                    <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit
                        sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias
                        ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
                </div>

                <div class="row" id="instagramcontent">
                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                        <div class="icon-box"> -->
        <!-- <div class="icon"><i class="bx bxl-dribbble"></i></div> -->
        <!-- <img src="assets/img/info_1.jpg" alt="" width="100%">
                            <h4 style="text-align:center">Lorem Ipsum</h4>
                            <p>Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi</p>
                        </div>
                    </div> -->
        <script>
        //showInstagram();
        </script>
        <!-- <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0">
                        <div class="icon-box">
                            <img src="assets/img/info_1.jpg" alt="" width="100%">
                            <h4><a href="">Sed ut perspiciatis</a></h4>
                            <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-lg-0">
                        <div class="icon-box">
                            <img src="assets/img/info_1.jpg" alt="" width="100%">
                            <h4><a href="">Magni Dolores</a></h4>
                            <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
                        <div class="icon-box">
                            <img src="assets/img/info_1.jpg" alt="" width="100%">
                            <h4><a href="">Nemo Enim</a></h4>
                            <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
                        <div class="icon-box">
                            <img src="assets/img/info_1.jpg" alt="" width="100%">
                            <h4><a href="">Dele cardo</a></h4>
                            <p>Quis consequatur saepe eligendi voluptatem consequatur dolor consequuntur</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
                        <div class="icon-box">
                            <img src="assets/img/info_1.jpg" alt="" width="100%">
                            <h4><a href="">Divera don</a></h4>
                            <p>Modi nostrum vel laborum. Porro fugit error sit minus sapiente sit aspernatur</p>
                        </div>
                    </div> -->
        <!-- 
                </div>

            </div>
        </section>End Services Section -->



        <!-- ======= Features Section ======= -->
        <!-- <section id="features" class="features">
            <div class="container">
                <div class="col-log-12">
                    <ul class="nav nav-tabs" style="font-size:0.5rem">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">豪華四人房</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">標準四人房</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">豪華雙人房</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#">標準雙人房</a>
                        </li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-lg-6 order-1 order-lg-1">
                        <div class="icon-box mt-5 mt-lg-0">
                            <i class="bx bx-receipt"></i>
                            <h4 style="line-height:48px" id="roomName">豪華四人房</h4>
                            <div class="facilitiesChecklistSection" data-section-id="5" style="float:left;margin:5%">
                                <h5>
                                    <span class="facilityGroupIcon">
                                        <svg class="bk-icon -iconset-bath hp__facility_group_icon" fill="#333333"
                                            height="20" width="20" viewBox="0 0 128 128" role="presentation"
                                            aria-hidden="true" focusable="false">
                                            <path
                                                d="M32 44a8 8 0 1 0-8-8 8 8 0 0 0 8 8zm80 41.9V94c0 7.7-5.3 14.4-12 17l2.7 2a4.2 4.2 0 0 1 .3 5.7 4 4 0 0 1-5.8.1L90 112H38l-7 6.7a4.2 4.2 0 0 1-5.7.3 4 4 0 0 1-.1-5.8L28 111c-6.8-2.6-12-9.3-12-17v-8.1A16.2 16.2 0 0 1 8 72a16 16 0 0 1 16-16h26a16.2 16.2 0 0 1 14-8 9.8 9.8 0 0 1 4 1 20 20 0 0 1 16-9 20 20 0 0 1 19.6 16c11.6 0 16.4 7.7 16.4 16 0 6.6-2.8 10.8-8 13.9zM32 52a16 16 0 1 1 16-16 16 16 0 0 1-16 16zm28-20a12 12 0 1 1 12-12 12 12 0 0 1-12 12zm0-8a4 4 0 1 0-4-4 4 4 0 0 0 4 4zm-5.3 40H24a8 8 0 1 0 0 16h80a8 8 0 0 0 0-16h-8s1-16-12-16a13.3 13.3 0 0 0-13 9 22 22 0 0 0-7-1c-7.8 0-9.3 8-9.3 8z">
                                            </path>
                                        </svg>
                                    </span>
                                    衛浴
                                </h5>
                                <ul>
                                    <li><span data-name-en="Toilet paper" class="  ">衛生紙</span></li>
                                    <li><span data-name-en="Towels" class="  ">毛巾</span></li>
                                    <li><span data-name-en="fan" class="  ">吹風機</span></li>
                                    <li><span data-name-en="shower" class="  ">沐浴乳</span></li>
                                </ul>
                            </div>
                            <div class="facilitiesChecklistSection" data-section-id="5" style="float:left;margin:5%">
                                <h5>
                                    <span class="facilityGroupIcon">
                                        <svg class="bk-icon -iconset-bath hp__facility_group_icon" fill="#333333"
                                            height="20" width="20" viewBox="0 0 128 128" role="presentation"
                                            aria-hidden="true" focusable="false">
                                            <path
                                                d="M32 44a8 8 0 1 0-8-8 8 8 0 0 0 8 8zm80 41.9V94c0 7.7-5.3 14.4-12 17l2.7 2a4.2 4.2 0 0 1 .3 5.7 4 4 0 0 1-5.8.1L90 112H38l-7 6.7a4.2 4.2 0 0 1-5.7.3 4 4 0 0 1-.1-5.8L28 111c-6.8-2.6-12-9.3-12-17v-8.1A16.2 16.2 0 0 1 8 72a16 16 0 0 1 16-16h26a16.2 16.2 0 0 1 14-8 9.8 9.8 0 0 1 4 1 20 20 0 0 1 16-9 20 20 0 0 1 19.6 16c11.6 0 16.4 7.7 16.4 16 0 6.6-2.8 10.8-8 13.9zM32 52a16 16 0 1 1 16-16 16 16 0 0 1-16 16zm28-20a12 12 0 1 1 12-12 12 12 0 0 1-12 12zm0-8a4 4 0 1 0-4-4 4 4 0 0 0 4 4zm-5.3 40H24a8 8 0 1 0 0 16h80a8 8 0 0 0 0-16h-8s1-16-12-16a13.3 13.3 0 0 0-13 9 22 22 0 0 0-7-1c-7.8 0-9.3 8-9.3 8z">
                                            </path>
                                        </svg>
                                    </span>
                                    衛浴
                                </h5>
                                <ul>
                                    <li><span data-name-en="Toilet paper" class="  ">衛生紙</span></li>
                                    <li><span data-name-en="Towels" class="  ">毛巾</span></li>
                                    <li><span data-name-en="fan" class="  ">吹風機</span></li>
                                    <li><span data-name-en="shower" class="  ">沐浴乳</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="image col-lg-6 order-2 order-lg-2">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img class="d-block w-100" src="assets/img/hotel1.jpg" alt="First slide">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100" src="assets/img/hotel2.jpg" alt="Second slide">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100" src="assets/img/hotel3.jpg" alt="Third slide">
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                                data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                                data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>




                    </div>
                </div>

            </div>
        </section>
         -->



        <section class="clients" id="roomIntro">
            <div class="container" style="width:100%">
                <h2>房間介紹</h2>
                <div class="col-lg-12" style="width:100%" id="roomNameDiv">
                    <ul class="nav nav-tabs" style="font-size:90%" id="roomName">
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0)">豪華四人房</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0)">標準四人房</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0)">豪華雙人房</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0)">標準雙人房</a>
                        </li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img class="d-block w-100" src="assets/img/hotel1.jpg" alt="First slide">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100" src="assets/img/hotel2.jpg" alt="Second slide">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100" src="assets/img/hotel3.jpg" alt="Third slide">
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                                data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                                data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="product-dtl" style="padding-top:10px">
                            <div class="product-info">
                                <div class="product-name"><a href="javascript:void(0)">豪華四人房</a></div>
                                <!-- <div class="reviews-counter">
                                <div class="rate">
                                    <input type="radio" id="star5" name="rate" value="5" checked />
                                    <label for="star5" title="text">5 stars</label>
                                    <input type="radio" id="star4" name="rate" value="4" checked />
                                    <label for="star4" title="text">4 stars</label>
                                    <input type="radio" id="star3" name="rate" value="3" checked />
                                    <label for="star3" title="text">3 stars</label>
                                    <input type="radio" id="star2" name="rate" value="2" />
                                    <label for="star2" title="text">2 stars</label>
                                    <input type="radio" id="star1" name="rate" value="1" />
                                    <label for="star1" title="text">1 star</label>
                                </div>
                                <span>3 Reviews</span>
                            </div> -->
                                <div class="product-price-discount"><span>$2390.00</span><span
                                        class="line-through">$2990.00</span></div>
                                <div class="table-responsive-lg">
                                    <table class="table table-borderless table-hover" style="font-size:85%;">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <svg width="2em" height="2em" viewBox="0 0 16 16"
                                                        class="bi bi-check text-success" fill="currentColor"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z" />
                                                    </svg>
                                                    桌子
                                                </td>
                                                <td>
                                                    <svg width="2em" height="2em" viewBox="0 0 16 16"
                                                        class="bi bi-x text-danger" fill="currentColor"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                                    </svg>
                                                    椅子
                                                </td>
                                                <td>
                                                    <svg width="2em" height="2em" viewBox="0 0 16 16"
                                                        class="bi bi-check text-success" fill="currentColor"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z" />
                                                    </svg>
                                                    電視
                                                </td>
                                                <td>
                                                    <svg width="2em" height="2em" viewBox="0 0 16 16"
                                                        class="bi bi-check text-success" fill="currentColor"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z" />
                                                    </svg>
                                                    第四台
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                <svg width="2em" height="2em" viewBox="0 0 16 16"
                                                        class="bi bi-check text-success" fill="currentColor"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z" />
                                                    </svg>
                                                    浴巾
                                                </td>
                                                <td>
                                                <svg width="2em" height="2em" viewBox="0 0 16 16"
                                                        class="bi bi-check text-success" fill="currentColor"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z" />
                                                    </svg>
                                                    盥洗用具
                                                </td>
                                                <td>
                                                <svg width="2em" height="2em" viewBox="0 0 16 16"
                                                        class="bi bi-check text-success" fill="currentColor"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z" />
                                                    </svg>    
                                                吹風機
                                                </td>
                                                <td>
                                                <svg width="2em" height="2em" viewBox="0 0 16 16"
                                                        class="bi bi-check text-success" fill="currentColor"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z" />
                                                    </svg>
                                                    衣櫃
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><svg width="2em" height="2em" viewBox="0 0 16 16"
                                                        class="bi bi-x text-danger" fill="currentColor"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                                    </svg>
                                                    浴缸
                                                </td>
                                                <td>
                                                <svg width="2em" height="2em" viewBox="0 0 16 16"
                                                        class="bi bi-check text-success" fill="currentColor"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z" />
                                                    </svg>
                                                    熱水壺
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <p style="clear:both">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                                eiusmod
                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                                nostrud
                                exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        </div>
                    </div>
                </div>

            </div>
            </div>
        </section>





        <!-- End Features Section -->
        <!-- ======= Clients Section ======= -->
        <!-- <section id="clients" class="clients">
            <div class="container">
                <div class="row no-gutters clients-wrap clearfix wow fadeInUp">
                    <div class="col-lg-3 col-md-4 col-xs-6">
                        <div class="client-logo">
                            <img src="assets/img/clients/client-1.png" class="img-fluid" alt="">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-xs-6">
                        <div class="client-logo">
                            <img src="assets/img/clients/client-2.png" class="img-fluid" alt="">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-xs-6">
                        <div class="client-logo">
                            <img src="assets/img/clients/client-3.png" class="img-fluid" alt="">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-xs-6">
                        <div class="client-logo">
                            <img src="assets/img/clients/client-4.png" class="img-fluid" alt="">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-xs-6">
                        <div class="client-logo">
                            <img src="assets/img/clients/client-5.png" class="img-fluid" alt="">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-xs-6">
                        <div class="client-logo">
                            <img src="assets/img/clients/client-6.png" class="img-fluid" alt="">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-xs-6">
                        <div class="client-logo">
                            <img src="assets/img/clients/client-7.png" class="img-fluid" alt="">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-xs-6">
                        <div class="client-logo">
                            <img src="assets/img/clients/client-8.png" class="img-fluid" alt="">
                        </div>
                    </div>

                </div>

            </div>
        </section>End Clients Section -->
        <section id="check" class="clients">
            <!-- <div class="contianer">
    <div class="col-lg-12">
    <table class="checkTime">
    <tr>
    <td>日期：</td><td><input type="text" id="datepicker"></td>
    </tr>
    </table>
    </div>
    </div> -->

            <div id="booking" class="section">
                <div class="section-center">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-7 col-md-push-5">
                                <div class="booking-cta">
                                    <h1>立即查詢!</h1>
                                    <!-- <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Animi facere, soluta magnam consectetur molestias itaque
								ad sint fugit architecto incidunt iste culpa perspiciatis possimus voluptates aliquid consequuntur cumque quasi.
								Perspiciatis.
							</p> -->
                                </div>
                            </div>
                            <div class="col-md-4 col-md-pull-7">
                                <div class="booking-form">
                                    <form>
                                        <!-- <div class="form-group">
									<span class="form-label">Your Destination</span>
									<input class="form-control" type="text" placeholder="Enter a destination or hotel name">
								</div> -->
                                        <div class="row no-margin">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <span class="form-label">入住日期</span>
                                                    <input class="form-control" type="date" required>
                                                </div>
                                                <span class="in-out hidden-xs">&#8652;</span>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <span class="form-label">退房日期</span>
                                                    <input class="form-control" type="date" required>
                                                </div>
                                            </div>
                                            <!-- <div class="col-sm-4">
										<div class="form-group">
											<span class="form-label">Guests</span>
											<select class="form-control">
												<option>1</option>
												<option>2</option>
												<option>3</option>
											</select>
											<span class="select-arrow"></span>
										</div>
									</div> -->
                                        </div>
                                        <div class="form-btn">
                                            <button class="submit-btn">查詢</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>


        <!-- ======= Cta Section ======= -->
        <section id="cta" class="cta">
            <div class="container">

                <div class="row">
                    <div class="col-lg-9 text-center text-lg-left">
                        <h3>立即預約</h3>
                        <p> BOOK</p>
                    </div>
                    <div class="col-lg-3 cta-btn-container text-center">
                        <a class="cta-btn align-middle" href="#">Booking.com</a>
                    </div>
                </div>

            </div>
        </section><!-- End Cta Section -->




        <!-- ======= Counts Section ======= -->
        <!-- <section id="counts" class="counts">
            <div class="container">

                <div class="text-center title">
                    <h3>What we have achieved so far</h3>
                    <p>Iusto et labore modi qui sapiente xpedita tempora et aut non ipsum consequatur illo.</p>
                </div>

                <div class="row counters">

                    <div class="col-lg-3 col-6 text-center">
                        <span data-toggle="counter-up">232</span>
                        <p>Clients</p>
                    </div>

                    <div class="col-lg-3 col-6 text-center">
                        <span data-toggle="counter-up">521</span>
                        <p>Projects</p>
                    </div>

                    <div class="col-lg-3 col-6 text-center">
                        <span data-toggle="counter-up">1,463</span>
                        <p>Hours Of Support</p>
                    </div>

                    <div class="col-lg-3 col-6 text-center">
                        <span data-toggle="counter-up">15</span>
                        <p>Hard Workers</p>
                    </div>

                </div>

            </div>
        </section>End Counts Section -->

        <!-- ======= Portfolio Section ======= -->
        <!-- <section id="portfolio" class="portfolio">
            <div class="container">

                <div class="section-title">
                    <h2>Portfolio</h2>
                    <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit
                        sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias
                        ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
                </div>

                <div class="row">
                    <div class="col-lg-12 d-flex justify-content-center">
                        <ul id="portfolio-flters">
                            <li data-filter="*" class="filter-active">All</li>
                            <li data-filter=".filter-app">App</li>
                            <li data-filter=".filter-card">Card</li>
                            <li data-filter=".filter-web">Web</li>
                        </ul>
                    </div>
                </div>

                <div class="row portfolio-container">

                    <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                        <img src="assets/img/portfolio/portfolio-1.jpg" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>App 1</h4>
                            <p>App</p>
                            <a href="assets/img/portfolio/portfolio-1.jpg" data-gall="portfolioGallery"
                                class="venobox preview-link" title="App 1"><i class="bx bx-plus"></i></a>
                            <a href="portfolio-details.html" class="details-link" title="More Details"><i
                                    class="bx bx-link"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-web">
                        <img src="assets/img/portfolio/portfolio-2.jpg" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>Web 3</h4>
                            <p>Web</p>
                            <a href="assets/img/portfolio/portfolio-2.jpg" data-gall="portfolioGallery"
                                class="venobox preview-link" title="Web 3"><i class="bx bx-plus"></i></a>
                            <a href="portfolio-details.html" class="details-link" title="More Details"><i
                                    class="bx bx-link"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                        <img src="assets/img/portfolio/portfolio-3.jpg" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>App 2</h4>
                            <p>App</p>
                            <a href="assets/img/portfolio/portfolio-3.jpg" data-gall="portfolioGallery"
                                class="venobox preview-link" title="App 2"><i class="bx bx-plus"></i></a>
                            <a href="portfolio-details.html" class="details-link" title="More Details"><i
                                    class="bx bx-link"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                        <img src="assets/img/portfolio/portfolio-4.jpg" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>Card 2</h4>
                            <p>Card</p>
                            <a href="assets/img/portfolio/portfolio-4.jpg" data-gall="portfolioGallery"
                                class="venobox preview-link" title="Card 2"><i class="bx bx-plus"></i></a>
                            <a href="portfolio-details.html" class="details-link" title="More Details"><i
                                    class="bx bx-link"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-web">
                        <img src="assets/img/portfolio/portfolio-5.jpg" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>Web 2</h4>
                            <p>Web</p>
                            <a href="assets/img/portfolio/portfolio-5.jpg" data-gall="portfolioGallery"
                                class="venobox preview-link" title="Web 2"><i class="bx bx-plus"></i></a>
                            <a href="portfolio-details.html" class="details-link" title="More Details"><i
                                    class="bx bx-link"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                        <img src="assets/img/portfolio/portfolio-6.jpg" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>App 3</h4>
                            <p>App</p>
                            <a href="assets/img/portfolio/portfolio-6.jpg" data-gall="portfolioGallery"
                                class="venobox preview-link" title="App 3"><i class="bx bx-plus"></i></a>
                            <a href="portfolio-details.html" class="details-link" title="More Details"><i
                                    class="bx bx-link"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                        <img src="assets/img/portfolio/portfolio-7.jpg" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>Card 1</h4>
                            <p>Card</p>
                            <a href="assets/img/portfolio/portfolio-7.jpg" data-gall="portfolioGallery"
                                class="venobox preview-link" title="Card 1"><i class="bx bx-plus"></i></a>
                            <a href="portfolio-details.html" class="details-link" title="More Details"><i
                                    class="bx bx-link"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                        <img src="assets/img/portfolio/portfolio-8.jpg" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>Card 3</h4>
                            <p>Card</p>
                            <a href="assets/img/portfolio/portfolio-8.jpg" data-gall="portfolioGallery"
                                class="venobox preview-link" title="Card 3"><i class="bx bx-plus"></i></a>
                            <a href="portfolio-details.html" class="details-link" title="More Details"><i
                                    class="bx bx-link"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-web">
                        <img src="assets/img/portfolio/portfolio-9.jpg" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>Web 3</h4>
                            <p>Web</p>
                            <a href="assets/img/portfolio/portfolio-9.jpg" data-gall="portfolioGallery"
                                class="venobox preview-link" title="Web 3"><i class="bx bx-plus"></i></a>
                            <a href="portfolio-details.html" class="details-link" title="More Details"><i
                                    class="bx bx-link"></i></a>
                        </div>
                    </div>

                </div>

            </div>
        </section>End Portfolio Section -->

        <!-- ======= Pricing Section ======= -->
        <!-- <section id="pricing" class="pricing">
            <div class="container">

                <div class="section-title">
                    <h2>Pricing</h2>
                    <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit
                        sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias
                        ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
                </div>

                <div class="row">

                    <div class="col-lg-4 col-md-6">
                        <div class="box">
                            <h3>Free</h3>
                            <h4><sup>$</sup>0<span> / month</span></h4>
                            <ul>
                                <li>Aida dere</li>
                                <li>Nec feugiat nisl</li>
                                <li>Nulla at volutpat dola</li>
                                <li class="na">Pharetra massa</li>
                                <li class="na">Massa ultricies mi</li>
                            </ul>
                            <div class="btn-wrap">
                                <a href="#" class="btn-buy">Buy Now</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mt-4 mt-md-0">
                        <div class="box recommended">
                            <span class="recommended-badge">Recommended</span>
                            <h3>Business</h3>
                            <h4><sup>$</sup>19<span> / month</span></h4>
                            <ul>
                                <li>Aida dere</li>
                                <li>Nec feugiat nisl</li>
                                <li>Nulla at volutpat dola</li>
                                <li>Pharetra massa</li>
                                <li class="na">Massa ultricies mi</li>
                            </ul>
                            <div class="btn-wrap">
                                <a href="#" class="btn-buy">Buy Now</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mt-4 mt-lg-0">
                        <div class="box">
                            <h3>Developer</h3>
                            <h4><sup>$</sup>29<span> / month</span></h4>
                            <ul>
                                <li>Aida dere</li>
                                <li>Nec feugiat nisl</li>
                                <li>Nulla at volutpat dola</li>
                                <li>Pharetra massa</li>
                                <li>Massa ultricies mi</li>
                            </ul>
                            <div class="btn-wrap">
                                <a href="#" class="btn-buy">Buy Now</a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section>End Pricing Section -->

        <!-- ======= Faq Section ======= -->

        <!-- ======= Services Section ======= -->

        <section id="insta" class="services">
            <div id="instagram-feed1" class="instagram_feed"></div>
            <script>
            (function() {
                new InstagramFeed({
                    'username': 'hirozzzz',
                    'container': document.getElementById("instagram-feed1"),
                    'display_profile': true,
                    'display_biography': true,
                    'display_gallery': true,
                    'callback': null,
                    'styling': true,
                    'items': 9,
                    'items_per_row': 3,
                    'margin': 1,
                    'lazy_load': true,
                    'on_error': console.error
                });
            })();
            </script>
        </section>

        <section id="faq" class="faq">
            <div class="container-fluid">

                <div class="row">

                    <div
                        class="col-lg-7 d-flex flex-column justify-content-center align-items-stretch  order-2 order-lg-1">

                        <div class="content">
                            <h3>Frequently Asked <strong>Questions</strong></h3>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Duis aute irure dolor in reprehenderit
                            </p>
                        </div>

                        <div class="accordion-list">
                            <ul>
                                <li>
                                    <a data-toggle="collapse" class="collapse" href="#accordion-list-1">Non consectetur
                                        a erat nam at lectus urna duis? <i class="bx bx-chevron-down icon-show"></i><i
                                            class="bx bx-chevron-up icon-close"></i></a>
                                    <div id="accordion-list-1" class="collapse show" data-parent=".accordion-list">
                                        <p>
                                            Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus
                                            laoreet non curabitur gravida. Venenatis lectus magna fringilla urna
                                            porttitor rhoncus dolor purus non.
                                        </p>
                                    </div>
                                </li>

                                <li>
                                    <a data-toggle="collapse" href="#accordion-list-2" class="collapsed">Feugiat
                                        scelerisque varius morbi enim nunc? <i
                                            class="bx bx-chevron-down icon-show"></i><i
                                            class="bx bx-chevron-up icon-close"></i></a>
                                    <div id="accordion-list-2" class="collapse" data-parent=".accordion-list">
                                        <p>
                                            Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id
                                            interdum velit laoreet id donec ultrices. Fringilla phasellus faucibus
                                            scelerisque eleifend donec pretium. Est pellentesque elit ullamcorper
                                            dignissim. Mauris ultrices eros in cursus turpis massa tincidunt dui.
                                        </p>
                                    </div>
                                </li>

                                <li>
                                    <a data-toggle="collapse" href="#accordion-list-3" class="collapsed">Dolor sit amet
                                        consectetur adipiscing elit? <i class="bx bx-chevron-down icon-show"></i><i
                                            class="bx bx-chevron-up icon-close"></i></a>
                                    <div id="accordion-list-3" class="collapse" data-parent=".accordion-list">
                                        <p>
                                            Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci.
                                            Faucibus pulvinar elementum integer enim. Sem nulla pharetra diam sit amet
                                            nisl suscipit. Rutrum tellus pellentesque eu tincidunt. Lectus urna duis
                                            convallis convallis tellus. Urna molestie at elementum eu facilisis sed odio
                                            morbi quis
                                        </p>
                                    </div>
                                </li>

                            </ul>
                        </div>

                    </div>

                    <div class="col-lg-5 align-items-stretch order-1 order-lg-2 img"
                        style='background-image: url("assets/img/faq.jpg");'>&nbsp;</div>
                </div>

            </div>
        </section><!-- End Faq Section -->






        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container">

                <div class="section-title">
                    <h2>Contact</h2>
                    <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit
                        sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias
                        ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
                </div>
            </div>

            <div>
                <iframe style="border:0; width: 100%; height: 350px;"
                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14794.40471941432!2d121.5412652!3d22.0265872!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x6e38a133ab715496!2z6buR6bCt6aOy5Yaw5a6_wrfomK3ltrwgQidGaW4gSG9zdGVs!5e0!3m2!1szh-TW!2stw!4v1598606158301!5m2!1szh-TW!2stw"
                    frameborder="0" allowfullscreen></iframe>
            </div>
            <div class="container">

                <div class="row mt-5">

                    <div class="col-lg-4">
                        <div class="info">
                            <div class="address">
                                <i class="ri-map-pin-line"></i>
                                <h4>Location:</h4>
                                <p>A108 Adam Street, New York, NY 535022</p>
                            </div>

                            <div class="email">
                                <i class="ri-mail-line"></i>
                                <h4>Email:</h4>
                                <p>info@example.com</p>
                            </div>

                            <div class="phone">
                                <i class="ri-phone-line"></i>
                                <h4>Call:</h4>
                                <p>+1 5589 55488 55s</p>
                            </div>

                        </div>

                    </div>

                    <div class="col-lg-8 mt-5 mt-lg-0">

                        <form action="forms/contact.php" method="post" role="form" class="php-email-form">
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <input type="text" name="name" class="form-control" id="name"
                                        placeholder="Your Name" data-rule="minlen:4"
                                        data-msg="Please enter at least 4 chars" />
                                    <div class="validate"></div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <input type="email" class="form-control" name="email" id="email"
                                        placeholder="Your Email" data-rule="email"
                                        data-msg="Please enter a valid email" />
                                    <div class="validate"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="subject" id="subject"
                                    placeholder="Subject" data-rule="minlen:4"
                                    data-msg="Please enter at least 8 chars of subject" />
                                <div class="validate"></div>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="message" rows="5" data-rule="required"
                                    data-msg="Please write something for us" placeholder="Message"></textarea>
                                <div class="validate"></div>
                            </div>
                            <div class="mb-3">
                                <div class="loading">Loading</div>
                                <div class="error-message"></div>
                                <div class="sent-message">Your message has been sent. Thank you!</div>
                            </div>
                            <div class="text-center"><button type="submit">Send Message</button></div>
                        </form>

                    </div>

                </div>

            </div>
        </section><!-- End Contact Section -->

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="container">
            <h3>KnightOne</h3>
            <p>Et aut eum quis fuga eos sunt ipsa nihil. Labore corporis magni eligendi fuga maxime saepe commodi
                placeat.</p>
            <div class="social-links">
                <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
            </div>
            <div class="copyright">
                &copy; Copyright <strong><span>KnightOne</span></strong>. All Rights Reserved
            </div>
            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/knight-simple-one-page-bootstrap-template/ -->
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div>
        </div>
    </footer><!-- End Footer -->

    <div id="preloader"></div>
    <a href="#" class="back-to-top"><i class="ri-arrow-up-line"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/jquery.easing/jquery.easing.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/waypoints/jquery.waypoints.min.js"></script>
    <script src="assets/js/my.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.5/waypoints.min.js"></script> -->
    <script src="assets/vendor/counterup/counterup.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/venobox/venobox.min.js"></script>
    <script src="assets/vendor/owl.carousel/owl.carousel.min.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>