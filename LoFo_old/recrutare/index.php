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

$captcha = new FGCaptchaCreator('scaptcha');



$formproc->EnableCaptcha($captcha);



//1. Add your email address here.

//You can add more than one receipients.

$formproc->AddRecipient('alyssri06@gmail.com'); //<<---Put your email address here





//2. For better security. Get a random tring from this link: http://tinyurl.com/randstr

// and put it here

$formproc->SetFormRandomKey('gf07a2Kt5ORGXWz');



//3. Set Conditional field and conditional receipients

//Update the destination email addresses

$formproc->SetConditionalField('query_type');

$formproc->AddConditionalReceipent('1','mst_marik@yahoo.com');

$formproc->AddConditionalReceipent('2','mst_marik@yahoo.com');

$formproc->AddConditionalReceipent('3','mst_marik@yahoo.com');

$formproc->AddConditionalReceipent('4','mst_marik@yahoo.com');

$formproc->AddConditionalReceipent('5','mst_marik@yahoo.com');





if(isset($_POST['submitted']))

{

   if($formproc->ProcessForm())

   {

        $formproc->RedirectToURL("thank-you.php");

   }

}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">

<head>

      <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>

      <title>Manga-Kids &#9829; Recrutare</title>

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

<img src="images/banner.png" alt="Banner Proba Traducator">
<!-- Form Code Start -->

<form id='contactus' action='<?php echo $formproc->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'>

<fieldset >

<legend><i><img src="images/proba_traducator.png"></i></legend>

<script type="text/javascript">
<!--
 var imlocation = "probe/";
 var currentdate = 0;
 var image_number = 0;
 function ImageArray (n) {
   this.length = n;
   for (var i =1; i <= n; i++) {
     this[i] = ' '
   }
 }
 image = new ImageArray(5)
 image[0] = 'proba_01.png'
 image[1] = 'proba_02.png'
 image[2] = 'proba_03.png'
 image[3] = 'proba_04.png'
 image[4] = 'proba_05.png'
 var rand = 60/image.length
 function randomimage() {
 	currentdate = new Date()
 	image_number = currentdate.getSeconds()
 	image_number = Math.floor(image_number/rand)
 	return(image[image_number])
 }
 document.write("<img src='" + imlocation + randomimage()+ "'>");
//-->
</script>

<hr>

<input type='hidden' name='submitted' id='submitted' value='1'/>

<input type='hidden' name='<?php echo $formproc->GetFormIDInputName(); ?>' value='<?php echo $formproc->GetFormIDInputValue(); ?>'/>

<input type='text'  class='spmhidip' name='<?php echo $formproc->GetSpamTrapInputName(); ?>' />



<div class='short_explanation'>Toate c&#226;mpurile sunt obligatorii.</div>



<div><span class='error'><?php echo $formproc->GetErrorMessage(); ?></span></div>

<div class='container'>

    <label for='name' >Nickname<font color="red"><b>*</b></font>: </label><br>

    <input type='text' name='name' id='name' placeholder="Numele cu care vrei sa apari in creditele din episoade." value='<?php echo $formproc->SafeDisplay('name') ?>' maxlength="50" /><br/>

    <span id='contactus_name_errorloc' class='error'></span>

</div>
<hr>
<div class='container'>

    <label for='email' >Email<font color="red"><b>*</b></font>: </label><br/>

    <input type='text' name='email' id='email'placeholder='Important pentru a putea fi contactat in vederea raspunsului.' value='<?php echo $formproc->SafeDisplay('email') ?>' maxlength="50" /><br/>

    <span id='contactus_email_errorloc' class='error'></span>

</div>
<hr>
<div class='container'>

    <label for='query_type' >Num&#259;rul probei<font color="red"><b>*</b></font>: </label>

    <select name='query_type'>

        <option>1</option>

        <option>2</option>

        <option>3</option>

        <option>4</option>

        <option>5</option>

    </select>

    <span id='contactus_email_errorloc' class='error'></span>

</div>

<hr>

<div class='container'>

    <label for='message' >Mai jos, te rug&#259;m s&#259; traduci replicile pe care le-ai primit la &#238;nceputul probei:<font color="red"><b>*</b></font>:</label><br/>

    <span id='contactus_message_errorloc' class='error'></span>

    <textarea rows="10" cols="50" name='message' id='message' placeholder="(1) Replicile pot sau nu s&#259; aib&#259; leg&#259;tur&#259; &#238;ntre ele. (2) Nu &#238;ncerca&#355;i s&#259; folosi&#355;i translate.google, odat&#259; ce-a&#355;i accesat aceast&#259; pagin&#259; v&#259; sunt num&#259;rate acces&#259;rile c&#259;tre translate.google, acces&#259;ri ce vor fi trimise odat&#259; cu cererea de recrutare :). (3) Dac&#259; email-ul introdus este gre&#351;it, noi nu vom avea sub nicio form&#259; cum s&#259; v&#259; contact&#259;m. (4) Replicile traduse de voi trebuie s&#259; fie numerotate asemenea probei pe care a&#355;i primit-o. (5) Nu uita&#355;i s&#259; selecta&#355;i num&#259;rul probei. (6) Dac&#259; limba ta rom&#226;n&#259; las&#259; de dorit, am dori s&#259; nu aplici ca traduc&#259;tor deoarece este doar o pierdere de timp. (7) Dac&#259; a&#355;i picat o dat&#259; testul, &#238;nceta&#355;i s&#259;-l mai da&#355;i &#238;nc&#259; o dat&#259; &#238;ntr-un interval scurt de timp; l-a&#355;i picat pentru c&#259; nivelul traducerii pe care a&#355;i trimis-o nu era suficient." ><?php echo $formproc->SafeDisplay('message') ?></textarea>

</div>
<hr>
<div class='container'>

    <div><img alt='Captcha image' src='show-captcha.php?rand=1' id='scaptcha_img' /></div>

    <label for='scaptcha' >Introdu codul de mai sus: </label>

    <input type='text' name='scaptcha' id='scaptcha' maxlength="10" /><br/>

    <span id='contactus_scaptcha_errorloc' class='error'></span>

    <div class='short_explanation'>E&#351;ti chior?

    <a href='javascript: refresh_captcha_img();'>Apas&#259; <b>aici</b> pentru a schimba codul, chiorule</a>.</div>

</div>



<hr>

<div class='container'>

    <input type='submit' name='Submit' value='Doamne ajut&#259;' />

</div>



</fieldset>

</form>

<!-- client-side Form Validations:

Uses the excellent form validation script from JavaScript-coder.com-->



<script type='text/javascript'>

// <![CDATA[



    var frmvalidator  = new Validator("contactus");

    frmvalidator.EnableOnPageErrorDisplay();

    frmvalidator.EnableMsgsTogether();

    frmvalidator.addValidation("name","req","Ai uitat s&#259; introduci nickname-ul.");



    frmvalidator.addValidation("email","req","Cum pana mea vrei s&#259; te contact&#259;m dac&#259; nu ai pus un email?!");



    frmvalidator.addValidation("email","email","Emailul pe care l-ai introdus nu este valid.");



    frmvalidator.addValidation("message","maxlen=2048","Mesajul este prea mare!!");



    frmvalidator.addValidation("scaptcha","req","Tu clar e&#351;ti chior... bag&#259; omule CODU DE MAI SUS &#206;N SPA&#354;IUL DE MAI JOS.");



    document.forms['contactus'].scaptcha.validator

      = new FG_CaptchaValidator(document.forms['contactus'].scaptcha,

                    document.images['scaptcha_img']);



    function SCaptcha_Validate()

    {

        return document.forms['contactus'].scaptcha.validator.validate();

    }



    frmvalidator.setAddnlValidationFunction("SCaptcha_Validate");



    function refresh_captcha_img()

    {

        var img = document.images['scaptcha_img'];

        img.src = img.src.substring(0,img.src.lastIndexOf("?")) + "?rand="+Math.random()*1000;

    }



// ]]>

</script>





</body>

</html>