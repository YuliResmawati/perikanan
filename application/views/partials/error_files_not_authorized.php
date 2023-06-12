<html>
    <head>
        <title>File Tidak Dapat Diakses - 401</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="//img3.wsimg.com/dps/css/uxcore.css" rel="stylesheet">
        <link href="//img3.wsimg.com/dps/css/customer-comp.css" rel="stylesheet">
        <style type="text/css">
            .backpack.dropzone {
                font-family: 'SF UI Display', 'Segoe UI';
                font-size: 15px;
                text-align: center;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                width: 250px;
                height: 150px;
                font-weight: lighter;
                color: white;
                will-change: right;
                z-index: 2147483647;
                bottom: 20%;
                background: #333;
                position: fixed;
                user-select: none;
                transition: left .5s, right .5s;
                right: 0px;
            }

            .backpack.dropzone .animation {
                height: 80px;
                width: 250px;
            }

            .backpack.dropzone .title::before {
                content: 'Save to';
            }

            .backpack.dropzone.closed {
                right: -250px;
            }

            .backpack.dropzone.hover .animation {
                animation: sxt-play-anim-hover 0.91s steps(21);
                animation-fill-mode: forwards;
            }

            @keyframes sxt-play-anim-hover {
                from {
                    background-position: 0px;
                }

                to {
                    background-position: -5250px;
                }
            }

            .backpack.dropzone.saving .title::before {
                content: 'Saving to';
            }

            .backpack.dropzone.saving .animation {
                animation: sxt-play-anim-saving steps(59) 2.46s infinite;
            }

            @keyframes sxt-play-anim-saving {
                100% {
                    background-position: -14750px;
                }
            }

            .backpack.dropzone.saved .title::before {
                content: 'Saved to';
            }

            .backpack.dropzone.saved .animation {
                animation: sxt-play-anim-saved steps(20) 0.83s forwards;
            }

            @keyframes sxt-play-anim-saved {
                100% {
                    background-position: -5000px;
                }
            }
        </style>
        <style type="text/css">
            .backpack.dropzone {
                font-family: 'SF UI Display', 'Segoe UI';
                font-size: 15px;
                text-align: center;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                width: 250px;
                height: 150px;
                font-weight: lighter;
                color: white;
                will-change: right;
                z-index: 2147483647;
                bottom: 20%;
                background: #333;
                position: fixed;
                user-select: none;
                transition: left .5s, right .5s;
                right: 0px;
            }

            .backpack.dropzone .animation {
                height: 80px;
                width: 250px;
            }

            .backpack.dropzone .title::before {
                content: 'Save to';
            }

            .backpack.dropzone.closed {
                right: -250px;
            }

            .backpack.dropzone.hover .animation {
                animation: sxt-play-anim-hover 0.91s steps(21);
                animation-fill-mode: forwards;
            }

            @keyframes sxt-play-anim-hover {
                from {
                    background-position: 0px;
                }

                to {
                    background-position: -5250px;
                }
            }

            .backpack.dropzone.saving .title::before {
                content: 'Saving to';
            }

            .backpack.dropzone.saving .animation {
                animation: sxt-play-anim-saving steps(59) 2.46s infinite;
            }

            @keyframes sxt-play-anim-saving {
                100% {
                    background-position: -14750px;
                }
            }

            .backpack.dropzone.saved .title::before {
                content: 'Saved to';
            }

            .backpack.dropzone.saved .animation {
                animation: sxt-play-anim-saved steps(20) 0.83s forwards;
            }

            @keyframes sxt-play-anim-saved {
                100% {
                    background-position: -5000px;
                }
            }
        </style>
    </head>
    <body>body&gt; <div id="error-img">
            <img src="//img3.wsimg.com/dps/images/404_background.jpg">
        </div>
        <div class="container text-center" id="error">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-icon text-warning">
                        <span class="uxicon uxicon-alert"></span>
                    </div>
                    <h1>Maaf, anda tidak memiliki akses terhadap file ini.</h1>
                </div>
            </div>
    </body>
</html>