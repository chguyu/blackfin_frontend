<?php 
function unicodeDecode($unicode_str){
  $json = '{"str":"'.$unicode_str.'"}';
  $arr = json_decode($json,true);
  if(empty($arr)) return '';
  return $arr['str'];
}
//Announcement_API 
$announcement_api_url = "http://34.80.207.185/blackfin/API/main.php?view=annoucement";
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
$announcement_api =json_encode(catchApi("http://34.80.207.185/blackfin/API/main.php?view=annoucement"));
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

    <!-- Google Fonts -->
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
    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <script>
    let firstLoad = true;
    let apireturn = "";
    let announcement_catch_type = "";
    let announcement_catch_title = "";
    let announcement_catch_text = "";
    let announcemntJson = '<?= $announcement_api?>';
    announcemntJson = JSON.parse(announcemntJson);
    let instagramApi = '<?= $instagram_api?>';
    //console.log(instagramApi);
    //instagramApi = instagramApi.replace("\n","");
    //instagramApi = instagramApi.replace("]","");
    //let instagramApiArray = JSON.parse("["+instagramApi+"]");
    instagramApi = JSON.parse(instagramApi);
    console.log(instagramApi);
    function showAnnouncemnt(type) {
        announcement_catch_type = "";
        announcement_catch_title = "";
        announcement_catch_text = "";
        apireturn =
            "<table class=\"table table-hover\"><tr><td><button type=\"button\" class=\"btn btn-danger\" id=\"all_button\">全部</button><button type=\"button\" class=\"btn btn-success\" id=\"ann_button\">公告</button><button type=\"button\" class=\"btn btn-info\" id=\"event_button\">活動</button><button type=\"button\" class=\"btn btn-warning\" id=\"sale_button\">優惠</button></td></tr>";
        for (i = 0; i < announcemntJson.length; i++) {
            announcement_catch_type = announcemntJson[i].announcementType;
            announcement_catch_title = announcemntJson[i].announcementTitle;
            announcement_catch_text = announcemntJson[i].announcementText;
            if (type == "all") {
                apireturn = apireturn + "<tr><td>" + announcement_catch_type + "</td><td>" + announcement_catch_title +
                    "</td><td>" + announcement_catch_text + "</td></tr>";
            } else if (type == "event") {
                if (announcement_catch_type == "活動") {
                    apireturn = apireturn + "<tr><td>" + announcement_catch_type + "</td><td>" +
                        announcement_catch_title + "</td><td>" + announcement_catch_text + "</td></tr>";
                }
            } else if (type == "sale") {
                if (announcement_catch_type == "優惠") {
                    apireturn = apireturn + "<tr><td>" + announcement_catch_type + "</td><td>" +
                        announcement_catch_title + "</td><td>" + announcement_catch_text + "</td></tr>";
                }
            } else if (type == "ann") {
                if (announcement_catch_type == "公告") {
                    apireturn = apireturn + "<tr><td>" + announcement_catch_type + "</td><td>" +
                        announcement_catch_title + "</td><td>" + announcement_catch_text + "</td></tr>";
                }
            }
        }
        apireturn = apireturn + "</table></div>";
        console.log(apireturn);
        document.getElementById('annoucement').innerHTML = apireturn;
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
    }
    let instagram_catch_type = ""; 
    let instagram_catch_mediaurl = "";
    let instagram_catch_caption = "";
    let instagram_catch_time = "";  
    let instagram_return=""; 
    function showInstagram(){
        instagram_return="";
        for (i = 0; i < instagramApi.length; i++) {
            instagram_catch_type = instagramApi[i].media_type;
            instagram_catch_mediaurl = instagramApi[i].media_url;
            instagram_catch_caption = instagramApi[i].caption;
            instagram_catch_time = instagramApi[i].timestamp;
            instagram_return =instagram_return+"<div class=\"col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0\"><div class=\"icon-box\"><img src=\""+instagram_catch_mediaurl+"\" width=\"100%\"><h4><a></a></h4><p>"+instagram_catch_caption+"</p></div></div>" 
        }
        console.log(instagram_return);
        document.getElementById('instagramcontent').innerHTML = instagram_return;
        instagramcontent
        return instagram_return;
    }
    //showInstagram();
    // function showInstagram(){
    //   for(i=0;instagram.length)
    // }
    //document.getElementById('annoucement').innerHTML=showAnnouncemnt("all");
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
                            <li class="active"><a href="index.php">Home</a></li>
                            <li><a href="#about">About</a></li>
                            <li><a href="#services">Services</a></li>
                            <li><a href="#portfolio">Portfolio</a></li>
                            <li><a href="#pricing">Pricing</a></li>
                            <li class="drop-down"><a href="">Drop Down</a>
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
                            </li>
                            <li><a href="#contact">Contact</a></li>

                        </ul>
                    </nav><!-- .nav-menu -->

                    <!-- <a href="#about" class="get-started-btn scrollto">Get Started</a> -->
                </div>
            </div>

        </div>
    </header><!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex flex-column justify-content-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8">
                    <h1>主標題</h1>
                    <h2>副標題</h2>
                    <!-- <a href="https://www.youtube.com/watch?v=jDDaplaOz7Q" class="venobox play-btn mb-4" data-vbtype="video" data-autoplay="true"></a> -->
                </div>
            </div>
        </div>
    </section><!-- End Hero -->
    <main id="main">
        <!-- ======= About Us Section ======= -->
        <section id="about" class="about">
            <div class="container">
                <div class="section-title">
                    <h2>民宿公告</h2>
                    <p>➡️訂房請加LINE：0980097753(電話號碼搜尋)</p>
                    <p>➡️黑鰭訂房現況表：reurl.cc/203vGE</p>
                    <p>✳️包棟享優惠(人數10-14人)無法加床</p>
                    <p>✳️高餐、興大附農（台中高農）享校友優惠😀</p>
                    <p>✳️烏日人、伸港人享曾經的家鄉優惠🤗</p>
                    <p>✳️我的朋友就不用說了，打到骨折😘</p>
                </div>
                <div class="row content">
                    <div class="col-lg-12">
                        <div id="annoucement">
                            <script>
                            showAnnouncemnt("all");
                            </script>
                            <!-- <ul>
              <li><i class="ri-check-double-line"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat</li>
              <li><i class="ri-check-double-line"></i> Duis aute irure dolor in reprehenderit in voluptate velit</li>
              <li><i class="ri-check-double-line"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat</li>
            </ul> -->
                        </div>
                        <!-- <div class="col-lg-6 pt-4 pt-lg-0">
            <p>
              Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
              velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
              culpa qui officia deserunt mollit anim id est laborum.
            </p>
            <a href="#" class="btn-learn-more">Learn More</a>
          </div> -->
                    </div>
                </div>
        </section><!-- End About Us Section -->

        <!-- ======= Services Section ======= -->
        <section id="services" class="services">
            <div class="container">

                <div class="section-title">
                    <h2>民宿介紹</h2>
                    <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit
                        sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias
                        ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
                </div>

                <div class="row" id="instagramcontent">
                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                        <div class="icon-box">
                            <!-- <div class="icon"><i class="bx bxl-dribbble"></i></div> -->
                            <img src="assets/img/info_1.jpg" alt="" width="100%">
                            <h4 style="text-align:center">Lorem Ipsum</h4>
                            <p>Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi</p>
                        </div>
                    </div>
                    <script>showInstagram();</script>
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

                </div>

            </div>
        </section><!-- End Services Section -->

        <!-- ======= Cta Section ======= -->
        <section id="cta" class="cta">
            <div class="container">

                <div class="row">
                    <div class="col-lg-9 text-center text-lg-left">
                        <h3>Call To Action</h3>
                        <p> Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
                            pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                            mollit anim id est laborum.</p>
                    </div>
                    <div class="col-lg-3 cta-btn-container text-center">
                        <a class="cta-btn align-middle" href="#">Call To Action</a>
                    </div>
                </div>

            </div>
        </section><!-- End Cta Section -->

        <!-- ======= Features Section ======= -->
        <section id="features" class="features">
            <div class="container">

                <div class="row">
                    <div class="col-lg-6 order-2 order-lg-1">
                        <div class="icon-box mt-5 mt-lg-0">
                            <i class="bx bx-receipt"></i>
                            <h4>Est labore ad</h4>
                            <p>Consequuntur sunt aut quasi enim aliquam quae harum pariatur laboris nisi ut aliquip</p>
                        </div>
                        <div class="icon-box mt-5">
                            <i class="bx bx-cube-alt"></i>
                            <h4>Harum esse qui</h4>
                            <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt</p>
                        </div>
                        <div class="icon-box mt-5">
                            <i class="bx bx-images"></i>
                            <h4>Aut occaecati</h4>
                            <p>Aut suscipit aut cum nemo deleniti aut omnis. Doloribus ut maiores omnis facere</p>
                        </div>
                        <div class="icon-box mt-5">
                            <i class="bx bx-shield"></i>
                            <h4>Beatae veritatis</h4>
                            <p>Expedita veritatis consequuntur nihil tempore laudantium vitae denat pacta</p>
                        </div>
                    </div>
                    <div class="image col-lg-6 order-1 order-lg-2"
                        style='background-image: url("assets/img/features.jpg");'></div>
                </div>

            </div>
        </section><!-- End Features Section -->

        <!-- ======= Clients Section ======= -->
        <section id="clients" class="clients">
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
        </section><!-- End Clients Section -->

        <!-- ======= Counts Section ======= -->
        <section id="counts" class="counts">
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
        </section><!-- End Counts Section -->

        <!-- ======= Portfolio Section ======= -->
        <section id="portfolio" class="portfolio">
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
        </section><!-- End Portfolio Section -->

        <!-- ======= Pricing Section ======= -->
        <section id="pricing" class="pricing">
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
        </section><!-- End Pricing Section -->

        <!-- ======= Faq Section ======= -->
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
                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621"
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
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.5/waypoints.min.js"></script> -->
    <script src="assets/vendor/counterup/counterup.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/venobox/venobox.min.js"></script>
    <script src="assets/vendor/owl.carousel/owl.carousel.min.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>