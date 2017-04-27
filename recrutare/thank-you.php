<?PHP

/*

    Contact Form from HTML Form Guide

    This program is free software published under the

    terms of the GNU Lesser General Public License.

    See this page for more info:

    http://www.html-form-guide.com/contact-form/php-contact-form-tutorial.html

*/

require_once("./include/fgcontactform.php");

require_once("./include/captcha-creator.php");



$formproc = new FGContactForm();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">

<head>

      <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>

      <title>Manga-Kids &#9829; Mul&#355;umim</title>

      <link rel="STYLESHEET" type="text/css" href="contact.css" />

      <script type='text/javascript' src='scripts/gen_validatorv31.js'></script>

      <script type='text/javascript' src='scripts/fg_captcha_validator.js'></script>

</head>

<body>
<script language=JavaScript>
<!--

//Disable right click script III- By Renigade (renigade@mediaone.net)
//For full source code, visit http://www.dynamicdrive.com

var message="";
///////////////////////////////////
function clickIE() {if (document.all) {(message);return false;}}
function clickNS(e) {if 
(document.layers||(document.getElementById&&!document.all)) {
if (e.which==2||e.which==3) {(message);return false;}}}
if (document.layers) 
{document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}

document.oncontextmenu=new Function("return false")
// --> 
</script>
<center>

<img src="images/banner_thanks.png" alt="Banner Multumire">
<!-- Form Code Start -->

<form id='contactus' action='<?php echo $formproc->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'>

<fieldset >

<legend><i><img src="images/bafta.png"></i></legend>
<font face="Comic Sans MS" color="blue">Cererea ta a fost trimis&#259; &#351;i va fi verificat&#259; &#238;n cel mai scurt timp, p&#226;n&#259; atunci te invit&#259;m pe MangaKids.</font>
<br><br>
<a href="http://www.manga-kids.com"><img src="images/catre_manga-kids.png"></a>

</fieldset>

</form>

<!-- client-side Form Validations:

Uses the excellent form validation script from JavaScript-coder.com-->







</body>

</html>