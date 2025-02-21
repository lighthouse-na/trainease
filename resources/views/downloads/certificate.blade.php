<html lang="en">
<head>
    <title>Invoice</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Ensure the page is formatted for A4 */
        @page {
            size: A4;
            margin: 0;
        }

        body {
            font-family: Roboto, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }

        .certificate-container {
            padding: 0mm;
            margin: 0 auto;
            box-sizing: border-box;
        }

        .certificate {
            border: 20px solid #0C5280;
            padding: 30px;
            height: 100%;
            position: relative;
            background-color: white;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }



        .certificate-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .certificate-header .logo {
            width: 120px;
            height: 120px;
            margin-bottom: 15px;
        }

        .certificate-title {
            text-align: center;
            font-size: 26px;
            font-weight: bold;
            color: #0C5280;
            margin-bottom: 25px;
        }

        .certificate-body {
            text-align: center;
            margin-bottom: 40px;
        }

        h1 {
            font-weight: 500;
            font-size: 42px;
            color: #0C5280;
            margin: 0;
        }

        .student-name {
            font-size: 28px;
            margin: 10px 0;
            font-weight: 600;
        }

        .certificate-content {
            margin: 0 auto;
            width: 80%;
        }

        .about-certificate {
            font-size: 20px;
            margin: 20px 0;
            font-weight: 400;
        }

        .topic-title {
            font-size: 18px;
            margin-top: 20px;
            font-weight: 500;
        }

        .topic-description {
            display: inline-block;
            margin-right: 12px;
            font-size: 16px;
            color: #333;
            font-weight: 400;
        }

        .certificate-footer {
            margin-top: 40px;
            text-align: center;
            font-size: 16px;
            color: #777;
        }

        .footer-row {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .footer-row div {
            width: 48%;
        }

        .footer-row p {
            text-align: center;
            margin: 10px 0;
        }

    </style>
</head>
<body>

    <div class="certificate-container">
        <div class="certificate">
            <div class="certificate-header">
                <img src="https://i.ytimg.com/vi/TFZfEtiqaqk/maxresdefault.jpg" class="logo" alt="Telecom Namibia Logo">
            </div>

            <div class="certificate-body">
                <p class="certificate-title"><strong>Telecom Namibia TrainEase Online Learning Platform</strong></p>
                <h1>Certificate of Completion</h1>
                <p class="student-name">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</p>

                <div class="certificate-content">
                    <div class="about-certificate">
                        <p>has completed the {{$enrollment->training->title}} Course</p>
                    </div>

                    <p class="topic-title">The Course consisted of the following:</p>
                    <div class="text-center">
                        @foreach ($enrollment->training->materials as $material)
                            <span class="topic-description">{{$material->material_name}},</span>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="certificate-footer">
                <div class="footer-row">
                    <div>
                        <p>Principal: ______________________</p>
                    </div>
                    <div>
                        <p>Accredited by: ______________________</p>
                        <p>Endorsed by: ______________________</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
