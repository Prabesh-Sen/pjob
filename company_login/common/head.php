<head>
    <meta charset='utf-8'>
    <title>PINJOB-Company</title>
    <meta content='width=device-width, initial-scale=1.0' name='viewport'>
    <meta content='' name='keywords'>
    <meta content='' name='description'>

    <!-- Favicon -->
    <link href='img/favicon.ico' rel='icon'>

    <!-- Google Web Fonts -->
    <link rel='preconnect' href='https://fonts.googleapis.com'>
    <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
    <link href='https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap'
        rel='stylesheet'>

    <!-- Icon Font Stylesheet -->
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css' rel='stylesheet'>

    <!-- Libraries Stylesheet -->
    <link href='lib/animate/animate.min.css' rel='stylesheet'>
    <link href='lib/owlcarousel/assets/owl.carousel.min.css' rel='stylesheet'>

    <!-- Customized Bootstrap Stylesheet -->
    <link href='css/bootstrap.min.css' rel='stylesheet'>

    <!-- Template Stylesheet -->
    <link href='../css/sty.css' rel='stylesheet'>
    <script>
        // Initialize Bootstrap Tabs component
        var tabs = new bootstrap.TabPane(document.getElementById('myTabs'))
        // Activate the default tab
        tabs.show('tab-1')
    </script>

    <script>
        function showContent() {
            let content = document.getElementById("contentShowing");
            if (content.style.display === "none") {
                content.style.display = "block";
            } else {
                content.style.display = "none";
            }
        }
    </script>
    <style>
        #userIcon svg {
            height: 40px;
            width: 40px;
            padding: 5px;
            background-color: #00B074;
            fill: white;
            border-radius: 50%;
            cursor: pointer;
        }

        #contentShowing {
        position: absolute;
        content: "";
        top: 80px;
        right: 18px;
        min-height: 110px;
        width: 200px;
        color: black;
        text-align: left;
        text-decoration: none;
        font-size: 13px;
        cursor: pointer;
        padding: 10px 15px;
        border-radius: 9px;
        box-shadow: 0px 1px 2px 1px rgba(0, 0, 1, 0.8);
        background-color: #fff;
        line-height: 20px;
        letter-spacing: 1px;
        font-family: Arial;
        font-weight: 400;
    }

        #name {
            font-size: 14px;
            text-transform: capitalize;
        }

        #head {
            font-weight: 400;
            font-size: 13px;
            color: rgba(0, 0, 0, 0.7);
        }

        #logout-btn {
            border: none;
            padding: 5px 8px;
            font-size: 14px;
            font-weight: 600;
            background-color: #00B074;
            width: 100%;
            margin-top: 5px;
            cursor: pointer;
            border-radius: 2px;
            transition: 0.2s;
            letter-spacing: 1px;
        }

        #logout-btn:hover,
        #showContentButton:hover {
            background-color: #00B074;
            color: white;
        }

        
    </style>
</head>
