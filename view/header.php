<? 
return <<< EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{$title}</title>
    <script type="text/javascript" src="http://apps.bdimg.com/libs/keymaster/1.6.1/keymaster.js"></script>
    <script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <style type="text/css">
        body {
            font: normal 11px auto "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
            color: #4f6b72;
            background: #CBEDDC;
            margin: 0px;
            padding: 10px;
        }
        a {
            color: #c75f3e;
        }
        table {
            width: 100%;
            padding: 0;
            margin: 0;
        }
        th {
            font: bold 20px "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
            color: #F0F4F5;
            border-right: 1px solid #C1DAD7;
            border-bottom: 1px solid #C1DAD7;
            border-top: 1px solid #C1DAD7;
            text-transform: uppercase;
            background: #2E85C3;
            height:40px;
        }
        td {
            border-right: 1px solid #C1DAD7;
            border-bottom: 1px solid #C1DAD7;
            background: #fff;
            font-size: 17px;
            color: #4f6b72;
        }
        tr:hover td {
            background: #eee;
        }
        h3 {
            margin-bottom: 0px;
            padding-left: 10px;
            font-size: 20px;
            font-weight: bold;
        }
        .smallbutton {
            width: 90px;
            line-height: 20px;
            text-align: center;
            font-weight: bold;
            color: #fff;
            text-shadow: 1px 1px 1px #333;
            border-radius: 5px;
            margin: 0 10px 0 0;
            position: relative;
            overflow: hidden;
        }
        .button {
            width: 140px;
            line-height: 38px;
            text-align: center;
            font-weight: bold;
            color: #fff;
            text-shadow: 1px 1px 1px #333;
            border-radius: 5px;
            margin: 0 10px 0 0;
            position: relative;
            overflow: hidden;
        }
        .button {
            border:1px solid #b42323;
            box-shadow: 0 1px 2px #b9ecc4 inset,0 -1px 0 #6c9f76 inset,0 -2px 3px #b9ecc4 inset;
            background: -webkit-linear-gradient(top,#90dfa2,#84d494);
            background: -moz-linear-gradient(top,#90dfa2,#84d494);
            background: linear-gradient(top,#90dfa2,#84d494);
        }
        .button:hover {
            background: -webkit-linear-gradient(top,#aaebb9,#82d392);
            background: -moz-linear-gradient(top,#aaebb9,#82d392);
            background: linear-gradient(top,#aaebb9,#82d392);
        }
        .button:active {
            top:1px;
            box-shadow: 0 1px 3px #4d7254 inset,0 3px 0 #fff;
            background: -webkit-linear-gradient(top,#5eac6e,#72b37e);
            background: -moz-linear-gradient(top,#5eac6e,#72b37e);
            background: linear-gradient(top,#5eac6e,#72b37e);
        }
        .gray {
            color: #8c96a0;
            text-shadow:1px 1px 1px #fff;
            border:1px solid #dce1e6;
            box-shadow: 0 1px 2px #fff inset,0 -1px 0 #a8abae inset;
            background: -webkit-linear-gradient(top,#f2f3f7,#e4e8ec);
            background: -moz-linear-gradient(top,#f2f3f7,#e4e8ec);
            background: linear-gradient(top,#f2f3f7,#e4e8ec);
        }
        .gray:hover {
            background: -webkit-linear-gradient(top,#fefefe,#ebeced);
            background: -moz-linear-gradient(top,#f2f3f7,#ebeced);
            background: linear-gradient(top,#f2f3f7,#ebeced);
        }
        .gray:active {
            top:1px;
            box-shadow: 0 1px 3px #a8abae inset,0 3px 0 #fff;
            background: -webkit-linear-gradient(top,#e4e8ec,#e4e8ec);
            background: -moz-linear-gradient(top,#e4e8ec,#e4e8ec);
            background: linear-gradient(top,#e4e8ec,#e4e8ec);
        }
        .black {
            border:1px solid #333;
            box-shadow: 0 1px 2px #8b8b8b inset,0 -1px 0 #3d3d3d inset,0 -2px 3px #8b8b8b inset;
            background: -webkit-linear-gradient(top,#656565,#4c4c4c);
            background: -moz-linear-gradient(top,#656565,#4a4a4a);
            background: linear-gradient(top,#656565,#4a4a4a);
        }
        .black:hover {
            background: -webkit-linear-gradient(top,#818181,#575757);
            background: -moz-linear-gradient(top,#818181,#575757);
            background: linear-gradient(top,#818181,#575757);
        }
        .black:active {
            top:1px;
            box-shadow: 0 1px 3px #111 inset,0 3px 0 #fff;
            background: -webkit-linear-gradient(top,#424242,#575757);
            background: -moz-linear-gradient(top,#424242,#575757);
            background: linear-gradient(top,#424242,#575757);
        }
        .red {
            border:1px solid #b42323;
            box-shadow: 0 1px 2px #e99494 inset,0 -1px 0 #954b4b inset,0 -2px 3px #e99494 inset;
            background: -webkit-linear-gradient(top,#d53939,#b92929);
            background: -moz-linear-gradient(top,#d53939,#b92929);
            background: linear-gradient(top,#d53939,#b92929);
        }
        .red:hover {
            background: -webkit-linear-gradient(top,#eb6f6f,#c83c3c);
            background: -moz-linear-gradient(top,#eb6f6f,#c83c3c);
            background: linear-gradient(top,#eb6f6f,#c83c3c);
        }
        .red:active {
            top:1px;
            box-shadow: 0 1px 3px #5b0505 inset,0 3px 0 #fff;
            background: -webkit-linear-gradient(top,#b11a1a,#bf2626);
            background: -moz-linear-gradient(top,#b11a1a,#bf2626);
            background: linear-gradient(top,#b11a1a,#bf2626);
        }
        .yellow {
            border:1px solid #d2a000;
            box-shadow: 0 1px 2px #fedd71 inset,0 -1px 0 #a38b39 inset,0 -2px 3px #fedd71 inset;
            background: -webkit-linear-gradient(top,#fece34,#d8a605);
            background: -moz-linear-gradient(top,#fece34,#d8a605);
            background: linear-gradient(top,#fece34,#d8a605);
        }
        .yellow:hover {
            background: -webkit-linear-gradient(top,#ffd859,#e3bb38);
            background: -moz-linear-gradient(top,#ffd859,#e3bb38);
            background: linear-gradient(top,#ffd859,#e3bb38);
        }
        .yellow:active {
            top:1px;
            box-shadow: 0 1px 3px #816b1f inset,0 3px 0 #fff;
            background: -webkit-linear-gradient(top,#d3a203,#dba907);
            background: -moz-linear-gradient(top,#d3a203,#dba907);
            background: linear-gradient(top,#d3a203,#dba907);
        }
        .green {
            border:1px solid #64c878;
            box-shadow: 0 1px 2px #b9ecc4 inset,0 -1px 0 #6c9f76 inset,0 -2px 3px #b9ecc4 inset;
            background: -webkit-linear-gradient(top,#90dfa2,#84d494);
            background: -moz-linear-gradient(top,#90dfa2,#84d494);
            background: linear-gradient(top,#90dfa2,#84d494);
        }
        .green:hover {
            background: -webkit-linear-gradient(top,#aaebb9,#82d392);
            background: -moz-linear-gradient(top,#aaebb9,#82d392);
            background: linear-gradient(top,#aaebb9,#82d392);
        }
        .green:active {
            top:1px;
            box-shadow: 0 1px 3px #4d7254 inset,0 3px 0 #fff;
            background: -webkit-linear-gradient(top,#5eac6e,#72b37e);
            background: -moz-linear-gradient(top,#5eac6e,#72b37e);
            background: linear-gradient(top,#5eac6e,#72b37e);
        }
        .blue {
            border:1px solid #1e7db9;
            box-shadow: 0 1px 2px #8fcaee inset,0 -1px 0 #497897 inset,0 -2px 3px #8fcaee inset;
            background: -webkit-linear-gradient(top,#42a4e0,#2e88c0);
            background: -moz-linear-gradient(top,#42a4e0,#2e88c0);
            background: linear-gradient(top,#42a4e0,#2e88c0);
        }
        .blue:hover {
            background: -webkit-linear-gradient(top,#70bfef,#4097ce);
            background: -moz-linear-gradient(top,#70bfef,#4097ce);
            background: linear-gradient(top,#70bfef,#4097ce);
        }
        .blue:active {
            top:1px;
            box-shadow: 0 1px 3px #114566 inset,0 3px 0 #fff;
            background: -webkit-linear-gradient(top,#1a71a8,#1976b1);
            background: -moz-linear-gradient(top,#1a71a8,#1976b1);
            background: linear-gradient(top,#1a71a8,#1976b1);
        }
        .mi {
            text-align: center;
        }
        .alert {
            font-size: 18px;
            font-weight: bold;
            color: red;
        }
        .ta {
            width: 1000px;
            height: 500px;
        }
        #title .t {
            font-size: 14px;
            font-weight: bold;
        }
        #title span {
            margin: 0px 10px 0px 10px;
        }
        #title form {
            display: inherit;
        }
        body, ul, ol, li {
            margin:0;
            padding:0;
        }
        img {
            vertical-align:middle;
        }
        em {
            font-style:normal;
        }
        a img, :link img, :visited img {
            border:0;
        }
        a:link, a:visited {
            text-decoration:none;
            color:#666666;
        }
        a:hover,a:focus {
            text-decoration:underline;
            color:#0573bd;
            text-decoration:none;
        }
        ul, ul li {
            list-style-type:none;
        }
        #top_bg {
            height:40px;
            width:100%;
            background:#333;
            box-shadow:1px 1px 7px #999;
            position:fixed;
            z-index:999;
            left:0;
            border-bottom:#C6C6C6 solid 1px;
        }
        .top {
            width:1640px;
            height:40px;
            margin:0 auto;
        }
        .top .logo_l {
            width:145px;
            height:40px;
            float:left;
        }
        .nav_z {
            width:auto!important;
            height:40px;
            float:left;
            position:relative;
            z-index:999 ;
        }
        #navul li {
            float:left;
            width:120px;
            height:40px;
            position:relative;
            text-align:center;
            line-height:40px;
        }
        #navul li a:link, #navul li a:visited {
            color:#FFF;
            font-weight:500;
            letter-spacing:2px;
        }
        #navul li ul {
            display:none;
            position:absolute;
            z-index:999;
            background:#e6e6e6;
            border:#c6c6c6 1px solid;
            border-bottom:none;
            left:-1px;
        }
        #navul li ul li {
            display:block;
            width:118px;
            float:none;
            height:35px;
            position:relative;
            line-height:35px;
            border-bottom:#C6C6C6 1px solid;
            font-size:12px;
            overflow:hidden
        }
        #navul li.navmoon {
            background:#E6E6E6;
            border:#C6C6C6 1px solid;
            width:118px;
            height:38px;
            line-height:38px;
        }
        #navul li.navmoon a {
            color:#404a58;
        }
        #navul li.navhome a:hover {
            color:#FCFF00;
        }
        #navul li.navmoon ul {
            display:block;
        }
        #navul li.navmoon ul a {
            display:block;
            width:118px;
            height:35px;
            line-height:35px;
        }
        #navul li.navmoon ul a:hover {
            color:#0573bd;
            background:#FFF;
        }
    </style>
</head>
<body>
EOF;
?>