<?php
 $send_mail = 'sales@ecomedhtm.com';

 include("form.lib.php");
    $fields1 = array(
        array(
            "alias" => 'NAME',
            "req" => '1',
            "test" => '[^\s]+',
            "id" => "firstName",
            "test_msg" => "Please, enter your Name!"),
        array(
            "alias" => "E-MAIL",
            "id" => "email",
            "req" => "1",
            "test" => '\b[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}\b',
            "test_msg" => "Please, enter your email!"),
        array(
            "alias" => 'PHONE',
            "req" => '0',
            "test" => '[^\s]+',
            "id" => "phone",
            "test_msg" => "Please, enter your phone!"),
        array(
            "alias" => 'SUBJECT',
            "req" => '0',
            "test" => '[^\s]+',
            "id" => "subject",
            "test_msg" => "Please, enter subject!"),
        array(
            "alias" => "MESSAGE",
            "req" => '1',
            "type" => "textarea",
            "id" => "mess",
            "test" => '[^\s]+',
            "test_msg" => "Please, enter your message!",
            "height" => "100")
    );

// process form

$curMsg = "";
$errMsg = "";
$request = $_POST;
$formType = '';
if (isset($request['posted'])){
    $r = $request;
    //check capture data
        $text = genLetter($fields1,0,$request);
    $errMsg = send_mail($request['firstName'],$send_mail,$_POST['email'],"Contact",$text);
    $curMsg = 'Message was sent. Thank you!';

	}
$defaults = array();
if ($errMsg == "") {
    $curMsg = "<div><i>" . $curMsg . "</i></div>";
} else {
    $curMsg = '<div><i>' . $errMsg . '</i></div>';
    $defaults = $request;
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title></title>
	<meta name="description" content="">
	<meta name="keywords" content="">
	<link href="css/reset.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
	<link href="css/main.css" rel="stylesheet" type="text/css">
<!--[if IE 7]>
	<link href="css/ie7.css" rel="stylesheet" type="text/css" >
<![endif]-->
    <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="js/general.js"></script>
</head>
<body>
	<div class="main">
        <div class="header">
            <div class="logo">
                <a href="/"><img src="/images/logo.png" alt=""></a>
            </div>
            <div class="top_menu">
                <a href="/"><i class="icon-home"></i></a>
                <a href="about_us.html">about US</a>
                <a href="why_choose_us.html">why choose us?</a>
                <a href="shop.html">SHOP</a>
                <a href="contact_us.php" class="act">CONTACT US</a>
            </div>
        </div>
        <div class="header_pic">
            <img src="images/pix-header_contacts.jpg" alt="">
        </div>
        <div class="content">
            <h1>CONTACT us</h1>
            <div class="columns">
                <div class="column">
                    <p>Please contact us today to learn how your facility can benefit from our services. </p>
                    <p>We monitor emails daily and respond promptly. </p>
                    <p>EcoMed Healthcare Technology Management, LLC<br>
					3687 Commercial Ave<br>
					Northbrook, IL 60062<br><br>
					Phone: 847.901.ECO1 [3261]<br>
					Fax: 847.901.3268<br>
					Email: <a href="mailto:sales@ecomedhtm.com">sales@ecomedhtm.com</a><br>
					Web: <a href="http://www.ecomedhtm.com">www.ecomedhtm.com</a></p>
                </div>
                <div class="column">
                    <form id="contactform" method="post" onSubmit="return chk(this)">
                        <input type="hidden" name="posted" value="1">
                        <table class="form1">
                            <?php $script = parseSmallFormFields($fields1, 0, $defaults); ?>

                            <tr>
                                <td colspan="2">
                                    <input type="submit" class="send-form" value="">
                                </td>
                            </tr>
                        </table>
                    </form>
                    <? =$curMsg?>
                    <script>
                        function chk(it) {
                        <? =$script?>
                            return true;
                        }
                    </script>
                </div>
                <div class="clear"></div>
            </div>
        </div>
		<div class="main-rez"></div>
	</div>
	<div class="footer">
        <div class="logo_footer">
            <a href="/"><img src="images/logo_footer.png" alt=""></a>
        </div>
        <div class="socials">
            <a href="http://facebook.com/ecomedhtm"><img src="images/icon-fb.png" alt=""></a>
            <a href="http://twitter.com/ecomedhtm"><img src="images/icon-tw.png" alt=""></a>
            <a href="#"><img src="images/icon-gp.png" alt=""></a>
        </div>
        <div class="everStudio">
            <table><tr>
                <td>
                    <a href="http://www.4everstudio.com" target="_blank" title="Chicago Web Design">Chicago Web Design</a> -
                    <a href="http://www.4everstudio.com" target="_blank" title="Chicago Web Design">www.4everstudio.com</a>
                </td>
                <th>
                    <a href="http://www.4everstudio.com" target="_blank" title="Chicago Web Design"><img src="images/everlogo.png" alt="Chicago Web Design" /></a>
                </th>
            </tr></table>
        </div>
	</div>
</body>
</html>
