<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Side Nav</title>
        <style type="text/css">

            * {
                margin: 0;
                padding: 0;
            }

            body {
                font-family: Open Sans, Arial, sans-serif;
                overflow-x: hidden;
            }

            nav {
                position: fixed;
                z-index: 1000;
                top: 0;
                bottom: 0;
                width: 200px;
                background-color: #036;
                transform: translate3d(-200px, 0, 0);
                transition: transform 0.4s ease;
            }
            .active-nav nav {
                transform: translate3d(0, 0, 0);
            }
            nav ul {
                list-style: none;
                margin-top: 100px;
            }
            nav ul li {
                border: 1px solid #fff;
            }
            nav ul li a {
                text-decoration: none;
                display: block;
                text-align: center;
                color: #fff;
                padding: 10px 0;
            }

            .nav-toggle-btn {
                display: block;
                position: absolute;
                left: 200px;
                width: 40px;
                height: 40px;
                background-color: #fff;
            }
            .nav-toggle-btn img {
               display: block;
               margin: auto;
               margin-top: 5px;
               margin-bottom: 10px;
               font-weight: 20px;
            }
            .content {
                padding-top: 200px;
                height: 860px;
                background-color: #ccf;
                text-align: center;
                transition: transform 0.4s ease;
            }
            .active-nav .content {
                transform: translate3d(200px, 0, 0);
            }



        </style>
    </head>
    <body>

        <nav>
            <a href="#" class="nav-toggle-btn"><img src="../image/menus.png"></a>

            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Contact</a></li>
            </ul>

        </nav>


        <div class="content">
            <h1>This is content</h1>
        </div>







    <script src="../public/js/jquery.js"></script>
    <script type="text/javascript">

        (function() {

            var bodyEl = $('body'),
                navToggleBtn = bodyEl.find('.nav-toggle-btn');

            navToggleBtn.on('click', function(e) {
                bodyEl.toggleClass('active-nav');
                e.preventDefault();
            });



        })();


    </script>

    </body>
</html>
