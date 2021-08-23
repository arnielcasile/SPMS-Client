<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Delivery Receipt</title>
    <style>
        @page {
            margin: 22;
        }
        @font-face {
        font-family: 'sbarc39A';
            src: url({{storage_path('fonts/sbarc39A.ttf')}})  format('truetype');
        }
        @font-face {
        font-family: ' sbarc39v';
            src: url({{storage_path('fonts/sbarc39v.ttf')}})  format('truetype');
        }
        header {
            position: fixed;
        }
        .header-style {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 17;
            font-weight: bold;
        }
        .header2-style {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 8;
            font-weight: bold;
        }
        .header-barcode-style {
            font-family: 'sbarc39A';
            font-size: 20;
            font-weight: normal;
        }
        .subheader-style {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12;
            font-weight: bold;
        }
        .line-style {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13;
        }
        .thead-style {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            font-size: 6; 
            text-align:center;
            horizontal-align:middle;
            vertical-align:middle;
            background-color: #e6e6e6;
            border: 1px solid black;
        }
        .tbody-style {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 6; 
            text-align:center;
            horizontal-align:middle;
            vertical-align:middle;
            border: 1px solid black;
        }
        table {
            border-collapse: collapse;
        }
        footer {
            position: fixed;
        }
        .footer-style {
            font-family: Arial, Helvetica, sans-serif;
            font-style: italic;
            font-size: 8;
        }
        .page-break {
            page-break-after: always;
        }
        .total-style {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            font-size: 7;
            text-align: center;
            horizontal-align: middle;
            vertical-align: middle;
            background-color: #e6e6e6;
            border: 1px solid black;
        }
        .checker-style {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            font-size: 7;
            text-align: center;
            horizontal-align: middle;
            vertical-align: middle;
            border: 1px solid black;
        }
        .signatories-style {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            font-size: 7.5;
            text-align: center;
            horizontal-align: middle;
            vertical-align: middle;
        }
        .prepared-style {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            font-size: 7.5;
            text-align: left;
            horizontal-align: middle;
            vertical-align: middle;
        }
        .approved-style {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            font-size: 7.5;
            text-align: right;
            horizontal-align: middle;
            vertical-align: middle;
            padding-right: 5px;
        }
        .received-style {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            font-size: 7.5;
            text-align: right;
            horizontal-align: middle;
            vertical-align: middle;
            padding-right: 5px;
        }
        .tbg {
            background-color: #e6e6e6;
        }
        .total-style {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            font-size: 7; 
            text-align:center;
            horizontal-align:middle;
            vertical-align:middle;
            background-color: #e6e6e6;
            border: 1px solid black;
        }
      
       

    </style>

</head>

<body>
    <div style="position:absolute;top:1.52in;left:0.16in;width:8in;line-height:0.10in;">
        
    </div>
    
</body>
</html>
