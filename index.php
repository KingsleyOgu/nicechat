<?php

session_start();

if(empty($_SESSION['id_user'])) {
  header("Location: login.php");
  exit();
}

require_once("db.php");

$name = $designation = $profileimage = "";

$sql = "SELECT * FROM users WHERE id_user='$_SESSION[id_user]'";
$result = $conn->query($sql);

if($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $name = $row['name'];
    $designation = $row['designation'];
    $profileimage = $row['profileimage'];
  }
}

$_SESSION['callFrom'] = "index.php";

?>

<!DOCTYPE html>
<html class=''>
<head>
  <title>NiceChat</title>
  <meta charset='UTF-8'><meta name="robots" content="noindex">
  <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <link rel="shortcut icon" type="image/x-icon" href="//production-assets.codepen.io/assets/favicon/favicon-8ea04875e70c4b0bb41da869e81236e54394d63638a1ef12fa558a4a835f1164.ico" />
  <link rel="mask-icon" type="" href="//production-assets.codepen.io/assets/favicon/logo-pin-f2d2b6d2c61838f7e76325261b7195c27224080bc099486ddd6dccb469b8e8e6.svg" color="#111" />
  <link rel="canonical" href="https://codepen.io/emilcarlsson/pen/ZOQZaV?limit=all&page=74&q=contact+" />
  <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,300' rel='stylesheet' type='text/css'>
  <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css'>
  <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css'>
  <link rel="stylesheet" type=text/css href="dist/css/chatui.css" />
  <style class="cp-pen-styles">
      body {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        /* background: linear-gradient(to right,#4b189c,#fc115c,#4665fe)!important; */
        background: #c1c0bd;
        font-family: "proxima-nova", "Source Sans Pro", sans-serif;
        font-size: 1em;
        letter-spacing: 0.1px;
        color: #32465a;
        text-rendering: optimizeLegibility;
        text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.004);
        -webkit-font-smoothing: antialiased;
      }

      #frame {
        width: 95%;
        min-width: 360px;
        max-width: 1000px;
        height: 92vh;
        min-height: 300px;
        max-height: 720px;
        background: #E6EAEA;
      }
      @media screen and (max-width: 360px) {
        #frame {
          width: 100%;
          height: 100vh;
        }
      }
      #frame #sidepanel {
        float: left;
        min-width: 280px;
        max-width: 340px;
        width: 40%;
        height: 100%;
        background: #2c3e50;
        color: #f5f5f5;
        overflow: hidden;
        position: relative;
      }
      @media screen and (max-width: 735px) {
        #frame #sidepanel {
          width: 58px;
          min-width: 58px;
        }
      }
      #frame #sidepanel #profile {
        width: 80%;
        margin: 25px auto;
      }
      @media screen and (max-width: 735px) {
        #frame #sidepanel #profile {
          width: 100%;
          margin: 0 auto;
          padding: 5px 0 0 0;
          background: #32465a;
        }
      }
      #frame #sidepanel #profile.expanded .wrap {
        height: 210px;
        line-height: initial;
      }
      #frame #sidepanel #profile.expanded .wrap p {
        margin-top: 20px;
      }
      #frame #sidepanel #profile.expanded .wrap i.expand-button {
        -moz-transform: scaleY(-1);
        -o-transform: scaleY(-1);
        -webkit-transform: scaleY(-1);
        transform: scaleY(-1);
        filter: FlipH;
        -ms-filter: "FlipH";
      }
      #frame #sidepanel #profile .wrap {
        height: 60px;
        line-height: 60px;
        overflow: hidden;
        -moz-transition: 0.3s height ease;
        -o-transition: 0.3s height ease;
        -webkit-transition: 0.3s height ease;
        transition: 0.3s height ease;
      }
      @media screen and (max-width: 735px) {
        #frame #sidepanel #profile .wrap {
          height: 55px;
        }
      }
      #frame #sidepanel #profile .wrap img {
        width: 50px;
        border-radius: 50%;
        padding: 3px;
        border: 2px solid #e74c3c;
        height: auto;
        float: left;
        cursor: pointer;
        -moz-transition: 0.3s border ease;
        -o-transition: 0.3s border ease;
        -webkit-transition: 0.3s border ease;
        transition: 0.3s border ease;
      }
      @media screen and (max-width: 735px) {
        #frame #sidepanel #profile .wrap img {
          width: 40px;
          margin-left: 4px;
        }
      }
      #frame #sidepanel #profile .wrap img.online {
        border: 2px solid #2ecc71;
      }
      #frame #sidepanel #profile .wrap img.away {
        border: 2px solid #f1c40f;
      }
      #frame #sidepanel #profile .wrap img.busy {
        border: 2px solid #e74c3c;
      }
      #frame #sidepanel #profile .wrap img.offline {
        border: 2px solid #95a5a6;
      }
      #frame #sidepanel #profile .wrap p {
        float: left;
        margin-left: 15px;
      }
      @media screen and (max-width: 735px) {
        #frame #sidepanel #profile .wrap p {
          display: none;
        }
      }
      #frame #sidepanel #profile .wrap i.expand-button {
        float: right;
        margin-top: 23px;
        font-size: 0.8em;
        cursor: pointer;
        color: #435f7a;
      }
      @media screen and (max-width: 735px) {
        #frame #sidepanel #profile .wrap i.expand-button {
          display: none;
        }
      }
      #frame #sidepanel #profile .wrap #status-options {
        position: absolute;
        opacity: 0;
        visibility: hidden;
        width: 150px;
        margin: 70px 0 0 0;
        border-radius: 6px;
        z-index: 99;
        line-height: initial;
        background: #435f7a;
        -moz-transition: 0.3s all ease;
        -o-transition: 0.3s all ease;
        -webkit-transition: 0.3s all ease;
        transition: 0.3s all ease;
      }
      @media screen and (max-width: 735px) {
        #frame #sidepanel #profile .wrap #status-options {
          width: 58px;
          margin-top: 57px;
        }
      }
      #frame #sidepanel #profile .wrap #status-options.active {
        opacity: 1;
        visibility: visible;
        margin: 75px 0 0 0;
      }
      @media screen and (max-width: 735px) {
        #frame #sidepanel #profile .wrap #status-options.active {
          margin-top: 62px;
        }
      }
      #frame #sidepanel #profile .wrap #status-options:before {
        content: '';
        position: absolute;
        width: 0;
        height: 0;
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-bottom: 8px solid #435f7a;
        margin: -8px 0 0 24px;
      }
      @media screen and (max-width: 735px) {
        #frame #sidepanel #profile .wrap #status-options:before {
          margin-left: 23px;
        }
      }
      #frame #sidepanel #profile .wrap #status-options ul {
        overflow: hidden;
        border-radius: 6px;
      }
      #frame #sidepanel #profile .wrap #status-options ul li {
        padding: 15px 0 30px 18px;
        display: block;
        cursor: pointer;
      }
      @media screen and (max-width: 735px) {
        #frame #sidepanel #profile .wrap #status-options ul li {
          padding: 15px 0 35px 22px;
        }
      }
      #frame #sidepanel #profile .wrap #status-options ul li:hover {
        background: #496886;
      }
      #frame #sidepanel #profile .wrap #status-options ul li span.status-circle {
        position: absolute;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin: 5px 0 0 0;
      }
      @media screen and (max-width: 735px) {
        #frame #sidepanel #profile .wrap #status-options ul li span.status-circle {
          width: 14px;
          height: 14px;
        }
      }
      #frame #sidepanel #profile .wrap #status-options ul li span.status-circle:before {
        content: '';
        position: absolute;
        width: 14px;
        height: 14px;
        margin: -3px 0 0 -3px;
        background: transparent;
        border-radius: 50%;
        z-index: 0;
      }
      @media screen and (max-width: 735px) {
        #frame #sidepanel #profile .wrap #status-options ul li span.status-circle:before {
          height: 18px;
          width: 18px;
        }
      }
      #frame #sidepanel #profile .wrap #status-options ul li p {
        padding-left: 12px;
      }
      @media screen and (max-width: 735px) {
        #frame #sidepanel #profile .wrap #status-options ul li p {
          display: none;
        }
      }
      #frame #sidepanel #profile .wrap #status-options ul li#status-online span.status-circle {
        background: #2ecc71;
      }
      #frame #sidepanel #profile .wrap #status-options ul li#status-online.active span.status-circle:before {
        border: 1px solid #2ecc71;
      }
      #frame #sidepanel #profile .wrap #status-options ul li#status-away span.status-circle {
        background: #f1c40f;
      }
      #frame #sidepanel #profile .wrap #status-options ul li#status-away.active span.status-circle:before {
        border: 1px solid #f1c40f;
      }
      #frame #sidepanel #profile .wrap #status-options ul li#status-busy span.status-circle {
        background: #e74c3c;
      }
      #frame #sidepanel #profile .wrap #status-options ul li#status-busy.active span.status-circle:before {
        border: 1px solid #e74c3c;
      }
      #frame #sidepanel #profile .wrap #status-options ul li#status-offline span.status-circle {
        background: #95a5a6;
      }
      #frame #sidepanel #profile .wrap #status-options ul li#status-offline.active span.status-circle:before {
        border: 1px solid #95a5a6;
      }
      #frame #sidepanel #profile .wrap #expanded {
        padding: 100px 0 0 0;
        display: block;
        line-height: initial !important;
      }
      #frame #sidepanel #profile .wrap #expanded label {
        float: left;
        clear: both;
        margin: 0 8px 5px 0;
        padding: 5px 0;
      }
      #frame #sidepanel #profile .wrap #expanded input {
        border: none;
        margin-bottom: 6px;
        background: #32465a;
        border-radius: 3px;
        color: #f5f5f5;
        padding: 7px;
        width: calc(100% - 43px);
      }
      #frame #sidepanel #profile .wrap #expanded input:focus {
        outline: none;
        background: #435f7a;
      }
      #frame #sidepanel #search {
        border-top: 1px solid #32465a;
        border-bottom: 1px solid #32465a;
        font-weight: 300;
      }
      @media screen and (max-width: 735px) {
        #frame #sidepanel #search {
          display: none;
        }
      }
      #frame #sidepanel #search label {
        position: absolute;
        margin: 10px 0 0 20px;
      }
      #frame #sidepanel #search input {
        font-family: "proxima-nova",  "Source Sans Pro", sans-serif;
        padding: 10px 0 10px 46px;
        width: calc(100% - 25px);
        border: none;
        background: #32465a;
        color: #f5f5f5;
      }
      #frame #sidepanel #search input:focus {
        outline: none;
        background: #435f7a;
      }
      #frame #sidepanel #search input::-webkit-input-placeholder {
        color: #f5f5f5;
      }
      #frame #sidepanel #search input::-moz-placeholder {
        color: #f5f5f5;
      }
      #frame #sidepanel #search input:-ms-input-placeholder {
        color: #f5f5f5;
      }
      #frame #sidepanel #search input:-moz-placeholder {
        color: #f5f5f5;
      }
      #frame #sidepanel #contacts {
        height: calc(100% - 177px);
        overflow-y: scroll;
        overflow-x: hidden;
      }
      @media screen and (max-width: 735px) {
        #frame #sidepanel #contacts {
          height: calc(100% - 149px);
          overflow-y: scroll;
          overflow-x: hidden;
        }
        #frame #sidepanel #contacts::-webkit-scrollbar {
          display: none;
        }
      }
      #frame #sidepanel #contacts.expanded {
        height: calc(100% - 334px);
      }
      #frame #sidepanel #contacts::-webkit-scrollbar {
        width: 8px;
        background: #2c3e50;
      }
      #frame #sidepanel #contacts::-webkit-scrollbar-thumb {
        background-color: #243140;
      }
      #frame #sidepanel #contacts ul li.contact {
        position: relative;
        padding: 10px 0 15px 0;
        font-size: 0.9em;
        cursor: pointer;
      }
      @media screen and (max-width: 735px) {
        #frame #sidepanel #contacts ul li.contact {
          padding: 6px 0 46px 8px;
        }
      }
      #frame #sidepanel #contacts ul li.contact:hover {
        background: #32465a;
      }
      #frame #sidepanel #contacts ul li.contact.active {
        background: #32465a;
        border-right: 5px solid #435f7a;
      }
      #frame #sidepanel #contacts ul li.contact.active span.contact-status {
        border: 2px solid #32465a !important;
      }
      #frame #sidepanel #contacts ul li.contact .wrap {
        width: 88%;
        margin: 0 auto;
        position: relative;
      }
      @media screen and (max-width: 735px) {
        #frame #sidepanel #contacts ul li.contact .wrap {
          width: 100%;
        }
      }
      #frame #sidepanel #contacts ul li.contact .wrap span {
        position: absolute;
        left: 0;
        margin: -2px 0 0 -2px;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        border: 2px solid #2c3e50;
        background: #95a5a6;
      }
      #frame #sidepanel #contacts ul li.contact .wrap span.online {
        background: #2ecc71;
      }
      #frame #sidepanel #contacts ul li.contact .wrap span.away {
        background: #f1c40f;
      }
      #frame #sidepanel #contacts ul li.contact .wrap span.busy {
        background: #e74c3c;
      }
      #frame #sidepanel #contacts ul li.contact .wrap img {
        width: 40px;
        border-radius: 50%;
        float: left;
        margin-right: 10px;
      }
      @media screen and (max-width: 735px) {
        #frame #sidepanel #contacts ul li.contact .wrap img {
          margin-right: 0px;
        }
      }
      #frame #sidepanel #contacts ul li.contact .wrap .meta {
        padding: 5px 0 0 0;
      }
      @media screen and (max-width: 735px) {
        #frame #sidepanel #contacts ul li.contact .wrap .meta {
          display: none;
        }
      }
      #frame #sidepanel #contacts ul li.contact .wrap .meta .name {
        font-weight: 600;
      }
      #frame #sidepanel #contacts ul li.contact .wrap .meta .preview {
        margin: 5px 0 0 0;
        padding: 0 0 1px;
        font-weight: 400;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        -moz-transition: 1s all ease;
        -o-transition: 1s all ease;
        -webkit-transition: 1s all ease;
        transition: 1s all ease;
      }
      #frame #sidepanel #contacts ul li.contact .wrap .meta .preview span {
        position: initial;
        border-radius: initial;
        background: none;
        border: none;
        padding: 0 2px 0 0;
        margin: 0 0 0 1px;
        opacity: .5;
      }
      #frame #sidepanel #bottom-bar {
        position: absolute;
        width: 100%;
        bottom: 0;
      }
      #frame #sidepanel #bottom-bar button {
        float: left;
        border: none;
        width: 25%;
        padding: 10px 0;
        background: #32465a;
        color: #f5f5f5;
        cursor: pointer;
        font-size: 0.85em;
        font-family: "proxima-nova",  "Source Sans Pro", sans-serif;
      }
      @media screen and (max-width: 735px) {
        #frame #sidepanel #bottom-bar button {
          float: none;
          width: 100%;
          padding: 15px 0;
        }
      }
      #frame #sidepanel #bottom-bar button:focus {
        outline: none;
      }
      #frame #sidepanel #bottom-bar button:nth-child(1) {
        border-right: 1px solid #2c3e50;
      }
      @media screen and (max-width: 735px) {
        #frame #sidepanel #bottom-bar button:nth-child(1) {
          border-right: none;
          border-bottom: 1px solid #2c3e50;
        }
      }
      #frame #sidepanel #bottom-bar button:hover {
        background: #435f7a;
      }
      #frame #sidepanel #bottom-bar button i {
        margin-right: 3px;
        font-size: 1em;
      }
      @media screen and (max-width: 735px) {
        #frame #sidepanel #bottom-bar button i {
          font-size: 1.3em;
        }
      }
      @media screen and (max-width: 735px) {
        #frame #sidepanel #bottom-bar button span {
          display: none;
        }
      }
      #frame .content {
        float: right;
        width: 60%;
        height: 100%;
        overflow: hidden;
        position: relative;
      }
      @media screen and (max-width: 735px) {
        #frame .content {
          width: calc(100% - 58px);
          min-width: 300px !important;
        }
      }
      @media screen and (min-width: 900px) {
        #frame .content {
          width: calc(100% - 340px);
        }
      }
      #frame .content .contact-profile {
        width: 100%;
        height: 60px;
        line-height: 60px;
        background: #f5f5f5;
      }
      #frame .content .contact-profile img {
        width: 40px;
        border-radius: 50%;
        float: left;
        margin: 9px 12px 0 9px;
      }
      #frame .content .contact-profile p {
        float: left;
      }
      #frame .content .contact-profile .social-media {
        float: right;
      }
      #frame .content .contact-profile .social-media i {
        margin-left: 14px;
        cursor: pointer;
      }
      #frame .content .contact-profile .social-media i:nth-last-child(1) {
        margin-right: 20px;
      }
      #frame .content .contact-profile .social-media i:hover {
        color: #435f7a;
      }
      #frame .content .messages {
        height: auto;
        min-height: calc(100% - 93px);
        max-height: calc(100% - 93px);
        overflow-y: scroll;
        overflow-x: hidden;
      }
      @media screen and (max-width: 735px) {
        #frame .content .messages {
          max-height: calc(100% - 105px);
        }
      }
      #frame .content .messages::-webkit-scrollbar {
        width: 8px;
        background: transparent;
      }
      #frame .content .messages::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.3);
      }
      #frame .content .messages ul li {
        display: inline-block;
        clear: both;
        float: left;
        margin: 15px 15px 5px 15px;
        width: calc(100% - 25px);
        font-size: 0.9em;
      }
      #frame .content .messages ul li:nth-last-child(1) {
        margin-bottom: 20px;
      }
      #frame .content .messages ul li.sent img {
        margin: 6px 8px 0 0;
      }
      #frame .content .messages ul li.sent p {
        background: #435f7a;
        color: #f5f5f5;
      }
      #frame .content .messages ul li.replies img {
        float: right;
        margin: 6px 0 0 8px;
      }
      #frame .content .messages ul li.replies p {
        background: #f5f5f5;
        float: right;
      }
      #frame .content .messages ul li img {
        width: 22px;
        border-radius: 50%;
        float: left;
      }
      #frame .content .messages ul li p {
        display: inline-block;
        padding: 10px 15px;
        border-radius: 20px; 
        max-width: 205px;
        line-height: 130%;
      }

      @media screen and (min-width: 735px) {
        #frame .content .messages ul li p {
          max-width: 300px;
        }
      }
      #frame .content .message-input {
        position: absolute;
        bottom: 0;
        width: 100%;
        z-index: 99;
      }
      #frame .content .message-input .wrap {
        position: relative;
      }
      #frame .content .message-input .wrap input {
        font-family: "proxima-nova",  "Source Sans Pro", sans-serif;
        float: left;
        border: none;
        width: calc(100% - 90px);
        padding: 11px 32px 10px 8px;
        font-size: 0.8em;
        color: #32465a;
      }
      @media screen and (max-width: 735px) {
        #frame .content .message-input .wrap input {
          padding: 15px 32px 16px 8px;
        }
      }
      #frame .content .message-input .wrap input:focus {
        outline: none;
      }
      #frame .content .message-input .wrap .attachment {
        position: absolute;
        right: 60px;
        z-index: 4;
        margin-top: 10px;
        font-size: 1.1em;
        color: #435f7a;
        opacity: .5;
        cursor: pointer;
      }
      @media screen and (max-width: 735px) {
        #frame .content .message-input .wrap .attachment {
          margin-top: 17px;
          right: 65px;
        }
      }
      #frame .content .message-input .wrap .attachment:hover {
        opacity: 1;
      }
      #frame .content .message-input .wrap button {
        float: right;
        border: none;
        width: 50px;
        padding: 12px 0;
        cursor: pointer;
        background: #32465a;
        color: #f5f5f5;
      }
      @media screen and (max-width: 735px) {
        #frame .content .message-input .wrap button {
          padding: 16px 0;
        }
      }
      #frame .content .message-input .wrap button:hover {
        background: #435f7a;
      }
      #frame .content .message-input .wrap button:focus {
        outline: none;
      }
      /* #frame {
        -webkit-box-shadow: 0 8px 17px 0 rgb(0, 153, 153),0 6px 20px 0 rgb(0, 153, 153);
        box-shadow: 0 8px 17px 0  rgb(0, 153, 153),0 6px 20px 0 rgb(0, 153, 153);
      } */
      #frame {
        box-shadow: 0 17px 50px 0 rgba(0, 0, 0, 0.19), 0 12px 15px 0 rgba(0, 0, 0, 0.24);
      }

      /* Center the loader */
      /* preloader */
      #loader {
        position: absolute;
        left: 50%;
        top: 50%;
        z-index: 1;
        width: 150px;
        height: 150px;
        margin: -75px 0 0 -75px;
        border: 5px solid transparent/* #f3f3f3 */;
        border-radius: 50%;
        border-top: 5px solid #3498db;
        width: 120px;
        height: 120px;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
      }

      @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
      }

      @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
      }

      /* Add animation to "page content" */
      .animate-bottom {
        position: relative;
        -webkit-animation-name: animatebottom;
        -webkit-animation-duration: 1s;
        animation-name: animatebottom;
        animation-duration: 1s
      }

      @-webkit-keyframes animatebottom {
        from { bottom:-100px; opacity:0 }
        to { bottom:0px; opacity:1 }
      }

      @keyframes animatebottom {
        from{ bottom:-100px; opacity:0 }
        to{ bottom:0; opacity:1 }
      }

      #myDiv {
        display: none;
        text-align: center;
      }

      .time-right {
        float: right;
        color: #aaa;
      }

      .time-left {
        float: left;
        color: #999;
      }

      .dropbtn {
    /*background-color: #4CAF50;
    color: white;
    padding: 16px;
    font-size: 16px;
    border: none; */
    cursor: pointer;
}

.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {background-color: #f1f1f1}

.dropdown:hover .dropdown-content {
    display: block;
}

.dropdown:hover .dropbtn {
    background-color: #e0e0e0;
}

    .communicate {
      position: relative;
      display: inline-block;
    }

    .communicate:hover .dropbtn {
    background-color: #e0e0e0;
}


      </style>
      </head>
      <body onload="myFunction()" style="margin:0;">

      <!--  circular Preloader -->
      <div id="loader"></div>



<div id="frame" style="display:none;" class="animate-bottom">

<!-- sidepanel -->
<?php include_once("sidepanel.php"); ?>


	</div>
	<div class="content">
		<div class="contact-profile">
			<a href="view-profile.php"></span><img src="dist/img/avatar33.png" alt="" />
			<p>Harvey Specter</p></a> <!-- wrap contact image and name inside view profile link -->
			<div class="social-media">
        <div class="communicate">
        <div class="dropbtn"><i class="fa fa-phone" aria-hidden="true"></i></div>
        </div>
				<div class="communicate">
        <div class="dropbtn"><i class="fa fa-video-camera" aria-hidden="true"></i></div>
        </div>

        <div class="dropdown">
        <div class="dropbtn"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></div>

        <div class="dropdown-content" style="line-height: 2; font-size: 15px;">
        <a href="view-profile.php">View Contact</a>
        <a href="#">Media</a>
          <a href="#">Archive Chat</a>
          <a href="#">Delete Chat</a>
          <a href="#">Add File</a>
        </div>
      </div>

			</div>
		</div>
		<div class="messages">
			<ul>
				<li class="sent">
					<img src="dist/img/avatar33.png" alt="" />
					<p class="sending">How the hell am I supposed to get a jury to believe you when I am not even sure that I do?!</p>
				</li>
				<li class="replies">
					<img src="dist/img/avatar33.png" alt="" />
					<p class="reply">When you're backed against the wall, break the god damn thing down.</p>
				</li>
				<li class="replies">
					<img src="dist/img/avatar33.png" alt="" />
					<p class="reply">Excuses don't win championships.</p>
				</li>
				<li class="sent">
					<img src="dist/img/avatar33.png" alt="" />
					<p class="sending">Oh yeah, did Michael Jordan tell you that?</p>
				</li>
				<li class="replies">
					<img src="dist/img/avatar33.png" alt="" />
					<p class="reply">No, I told him that.</p>
				</li>
				<li class="replies">
					<img src="dist/img/avatar33.png" alt="" />
					<p class="reply">What are your choices when someone puts a gun to your head?</p>
				</li>
				<li class="sent">
					<img src="dist/img/avatar33.png" alt="" />
					<p class="sending">What are you talking about? You do what they say or they shoot you.</p>
				</li>
				<li class="replies">
					<img src="dist/img/avatar33.png" alt="" />
					<p class="reply">Wrong. You take the gun, or you pull out a bigger one. Or, you call their bluff. Or, you do any one of a hundred and forty six other things.</p>
				</li>
			</ul>
		</div>
		<div class="message-input">
			<div class="wrap">
			<input type="text" placeholder="Write your message..." />
			<i class="fa fa-paperclip attachment" aria-hidden="true"></i>
			<button class="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
			</div>
		</div>
	</div>
</div>



<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="https://use.typekit.net/hoy3lrg.js"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script>
<script src='//production-assets.codepen.io/assets/common/stopExecutionOnTimeout-b2a7b3fe212eaa732349046d8416e00a9dec26eb7fd347590fbced3ab38af52e.js'></script>
<script src='//production-assets.codepen.io/assets/editor/live/console_runner-079c09a0e3b9ff743e39ee2d5637b9216b3545af0de366d4b9aad9dc87e26bfd.js'></script>
<script src='//production-assets.codepen.io/assets/editor/live/events_runner-73716630c22bbc8cff4bd0f07b135f00a0bdc5d14629260c3ec49e5606f98fdd.js'></script>
<script src='//production-assets.codepen.io/assets/editor/live/css_live_reload_init-2c0dc5167d60a5af3ee189d570b1835129687ea2a61bee3513dee3a50c115a77.js'></script>

<!-- script for circular preloader -->
<script>
var myVar;

function myFunction() {
    myVar = setTimeout(showPage, 3000);
}

function showPage() {
  document.getElementById("loader").style.display = "none";
  document.getElementById("frame").style.display = "block";
}
</script>


<script >$(".messages").animate({ scrollTop: $(document).height() }, "fast");

$("#profile-img").click(function() {
	$("#status-options").toggleClass("active");
});

$(".expand-button").click(function() {
  $("#profile").toggleClass("expanded");
	$("#contacts").toggleClass("expanded");
});

$("#status-options ul li").click(function() {
	$("#profile-img").removeClass();
	$("#status-online").removeClass("active");
	$("#status-away").removeClass("active");
	$("#status-busy").removeClass("active");
	$("#status-offline").removeClass("active");
	$(this).addClass("active");

	if($("#status-online").hasClass("active")) {
		$("#profile-img").addClass("online");
	} else if ($("#status-away").hasClass("active")) {
		$("#profile-img").addClass("away");
	} else if ($("#status-busy").hasClass("active")) {
		$("#profile-img").addClass("busy");
	} else if ($("#status-offline").hasClass("active")) {
		$("#profile-img").addClass("offline");
	} else {
		$("#profile-img").removeClass();
	};

	$("#status-options").removeClass("active");
});

function newMessage() {
	message = $(".message-input input").val();
	if($.trim(message) == '') {
		return false;
	}
	$('<li class="sent"><img src="dist/img/avatar33.png" alt="" /><p>' + message + '</p></li>').appendTo($('.messages ul'));
	$('.message-input input').val(null);
	$('.contact.active .preview').html('<span>You: </span>' + message);
	$(".messages").animate({ scrollTop: $(document).height() }, "fast");
};

$('.submit').click(function() {
  newMessage();
});

$(window).on('keydown', function(e) {
  if (e.which == 13) {
    newMessage();
    return false;
  }
});
//# sourceURL=pen.js
</script>
</body></html>
