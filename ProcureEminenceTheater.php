<?php
/*
Plugin Name: Procure Eminence Theater
Plugin URI: http://www.procureeminence.com
Description: A better way to view YouTube videos on WordPress!
Version: 2.5.2013
Author: Procure Eminence
Author URI: http://www.procureeminence.com
License: GPL2
*/

/*
Copyright 2012  Procure Eminence  (email : procureeminence@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//Set up database table at plugin activation
register_activation_hook( __FILE__, 'youTubeTheaterInitialSetup' );
function youTubeTheaterInitialSetup(){
	if(!get_option('YouTubeTheaterAnimation')){
		update_option('YouTubeTheaterChannel', '');
		update_option('YouTubeTheaterAnimation', '1');
		update_option('YouTubeTheaterSuggVid', '');
		update_option('YouTubeTheaterHttps', '');
		update_option('YouTubeTheaterPrivacyMode', '');
		update_option('YouTubeTheaterBackgroundOpacity', '0.9');
		update_option('YouTubeTheaterVideoTitlesArray', 'Dan Pink: The puzzle of motivation;;;;;;;;;;;;;');
		update_option('YouTubeTheaterVideoLinksArray', 'rrkrvAUbU9Y;;;;;;;;;;;;;');
		update_option('YouTubeTheaterVideoAutoPlay', '');
		$YouTubeTheaterChannel = "";
		$YouTubeTheaterAnimation = "false";
		$YouTubeTheaterVideoAutoPlay = "false";
		$YouTubeTheaterSuggVid = "false";
		$YouTubeTheaterHttps = "false";
		$YouTubeTheaterPrivacyMode = "false";
		$YouTubeTheaterBackgroundOpacity = "0.9";
		$YouTubeTheaterVideoTitlesArray = "Dan Pink: The puzzle of motivation;;;;;;;;;;;;;";
		$YouTubeTheaterVideoLinks = "rrkrvAUbU9Y;;;;;;;;;;;;;";		
	}
}

//Create shortcode
add_shortcode('ProcureEminenceTheater','ProcureEminenceTheaterShortcode');
function ProcureEminenceTheaterShortcode(){
	$LaunchButton1 = "<input type='button' value='Open Theater' class='button-primary' onclick='openTheater()'/>";
	return $LaunchButton1;
}

//Start Main Functions
add_action('wp_head','youTubeTheaterCSSLoad');
add_action('wp_footer','youTubeTheaterScriptLoad');

function youTubeTheaterCSSLoad(){
	$YouTubeTheaterCSS = "
<style type='text/css'>
#shader{
	display:none;
	opacity:0.00;
	z-index:100000;
	border:none;
	cursor:pointer;
	}
#settings{
	display:none;
	height:45px;
	width:0px;
	position:fixed;
	top:35px;
	z-index:100002;
	left:0px;
	border-color:#DDDDDD;
	border-width:2px 2px 2px 0px;
	border-style:solid;
	border-top-right-radius:5px;
	border-bottom-right-radius:5px;
	padding-right:5px;
	background-color:#222222;
	color:#FFFFFF;
	overflow-x:hidden;
	}
#closeTheaterControlBox{
	text-align:center;
	font: bold 18px/100% Times New Roman !important;
	overflow-x:hidden;
	overflow-y:hidden;
	top:10px;
	position:relative;
	height:22px;
	margin-top:3px;
	cursor:pointer;
	line-height:100% !important;
	}
#video{
	display:none;
	padding:30px;
	margin:0px;
	color:white;
	text-align:center;
	font-size:25px;
	}
#controller{
	display:none;
	text-decoration:none !important;
	height:75px;
	width:0px;
	position:fixed;
	top:35px;
	z-index:100002;
	right:0px;
	border-color:#DDDDDD;
	border-width:2px 0px 2px 2px;
	border-style:solid;
	border-top-left-radius:5px;
	border-bottom-left-radius:5px;
	padding-left:5px;
	background-color:#222222;
	color:#FFFFFF;
	overflow-x:hidden;
	}
#controllerTitle{
	text-align:center;
	font: bold 18px/100% Times New Roman !important;
	overflow:hidden;
	margin-top:9px;
	position:relative;
	margin-bottom:2px;
	line-height:100% !important;
	}
#controllerInnerBox{
	text-align:center;
	overflow:hidden;
	position:relative;
	padding:0px;
	margin:0px;
	line-height:100%;
	}
#videoselector{
	position:relative;
	top:0px;
	margin-top:6px;
	padding-top:0px;
	font: 16px/100% Times New Roman !important;
	border-radius:2px;
	border-color:#444444;
	line-height:100% !important;
	width:150px;
	}
</style>";
	echo $YouTubeTheaterCSS;
}

function youTubeTheaterScriptLoad(){
	//Load variables from WordPress database or create them if they don't exist
	if(get_option('YouTubeTheaterAnimation')){
		$YouTubeTheaterChannel = get_option('YouTubeTheaterChannel');
		$YouTubeTheaterAnimation = get_option('YouTubeTheaterAnimation');
		$YouTubeTheaterSuggVid = get_option('YouTubeTheaterSuggVid');
		$YouTubeTheaterHttps = get_option('YouTubeTheaterHttps');
		$YouTubeTheaterPrivacyMode = get_option('YouTubeTheaterPrivacyMode');
		$YouTubeTheaterBackgroundOpacity = get_option('YouTubeTheaterBackgroundOpacity');
		$YouTubeTheaterVideoTitlesArray = get_option('YouTubeTheaterVideoTitlesArray');
		$YouTubeTheaterVideoLinksArray = get_option('YouTubeTheaterVideoLinksArray');
		$YouTubeTheaterVideoAutoPlay = get_option('YouTubeTheaterVideoAutoPlay');
	}
	else{
		$YouTubeTheaterChannel = "";
		$YouTubeTheaterAnimation = "false";
		$YouTubeTheaterVideoAutoPlay = "false";
		$YouTubeTheaterSuggVid = "false";
		$YouTubeTheaterHttps = "false";
		$YouTubeTheaterPrivacyMode = "false";
		$YouTubeTheaterBackgroundOpacity = "0.9";
		$YouTubeTheaterVideoTitlesArray = "Dan Pink: The puzzle of motivation;;;;;;;;;;;;;";
		$YouTubeTheaterVideoLinks = "rrkrvAUbU9Y;;;;;;;;;;;;;";		
	}
	if($YouTubeTheaterAnimation == "true"){
		$YtTaO='checked="checked"';
		$YouTubeTheaterAnimation=1;
	}else{
		$YtTaO='';
		$YouTubeTheaterAnimation=0;
	}
	if($YouTubeTheaterVideoAutoPlay == "true"){$YtTaP='?autoplay=1';}else{$YtTaP='';}
	if($YouTubeTheaterSuggVid == "true"){$YtTsV='';}else{$YtTsV='?rel=0';}
	if($YouTubeTheaterVideoAutoPlay == "true" && $YouTubeTheaterSuggVid == "false"){
		$YtTsV_YtTaP = "?rel=0&autoplay=1";
	}else{
		$YtTsV_YtTaP = $YtTsV . $YtTaP;
	}
	if($YouTubeTheaterHttps == "true"){$YtThS='s';}else{$YtThS='';}
	if($YouTubeTheaterPrivacyMode == "true"){$YtTpM='-nocookie';}else{$YtTpM='';}
	
	$YtTvTa = explode(";",$YouTubeTheaterVideoTitlesArray);
	$YtTvLa = explode(";",$YouTubeTheaterVideoLinksArray);
	
	echo "<!-- Theater App Begins -->
<div id='shader' onclick='closeTheater()'></div>
<div id='settings'>
	<div id='closeTheaterControlBox' onclick='closeTheater()'>Close<span style='color:#222222;'>_</span>App</div>
</div>
<div id='video'></div>
<div id='controller'>
	<div id='controllerTitle'>Videos</div>
	<div id='controllerInnerBox'>
		<select id='videoselector' onchange='changeVideo(this.value)'>
	";		
	$VidArraySize = count($YtTvTa);
	for($t=0; $t<$VidArraySize; $t++){
		if($YtTvLa[$t] != ""){
			echo "
			<option value='$YtTvLa[$t]'>$YtTvTa[$t]</option><!-- This will be your default video -->
			";
		}
	}
	echo "
		</select>
	</div>
</div>
<!-- Theater App Ends -->";

	


	echo "
	<script type='text/javascript'>
	//Theater App for YouTube Videos
//Version 1.1

var blacken=$YouTubeTheaterBackgroundOpacity;
var sidePanelWidth = 0;
var sidePanelWidth2 = 120;
var animation = $YouTubeTheaterAnimation; //Open/Close animation. 1=on, 2=0ff

function openTheater(){//Prep theater for initialization
	//var userAgent = navigator.userAgent.toLowerCase(); //Code to disable Google Chrome Support
	//if(userAgent.indexOf('chrome') > -1){
		//alert('Google Chrome is currently not supported. Please use IE9, FireFox, Safari or Opera.');
		//return;
	//}
	var userWidth = window.innerWidth;
	var bodyWidth = document.body.offsetWidth;
	var shaderLeftPosition = (bodyWidth/2) - userWidth;
	var shader = document.getElementById('shader');
	shader.style.position='fixed';
	shader.style.width='100%';
	shader.style.height='100%';
	shader.style.display='block';
	shader.style.backgroundColor='#010101';
	shader.style.color='#FFFFFF';
	shader.style.zIndex='100000';
	shader.style.left='0px';
	shader.style.top='0px';
	//Hide all flash objects and iframes to prevent overlap in Chrome, IE8 and IE9
	var iframeLength = document.getElementsByTagName('iframe').length;
	var embedLength = document.getElementsByTagName('embed').length;
	var objectLength = document.getElementsByTagName('object').length;
	if(iframeLength != 0){
		for(T=0; T<iframeLength; T++){
			document.getElementsByTagName('iframe')[T].style.display='none';
		}
	}
	if(embedLength != 0){
		for(T=0; T<embedLength; T++){
			document.getElementsByTagName('embed')[T].style.display='none';
		}
	}
	if(objectLength != 0){
		for(T=0; T<objectLength; T++){
			document.getElementsByTagName('object')[T].style.display='none';
		}
	}
	fadeToBlack();
	} //end openTheater
function fadeToBlack(){//Fade users screen to black and call initializeApp
	var shader = document.getElementById('shader');
	shader.style.opacity=blacken;
	initializeApp();
	}//end fadeToBlack
function initializeApp(){//Initialize app, call openControls() and call changeVideo()
	var video = document.getElementById('video');
	var controller = document.getElementById('controller');
	var settings = document.getElementById('settings');
	var videoWidth = window.innerWidth || document.documentElement.clientWidth;//Patch for IE8 window width
	videoWidth = Math.round(videoWidth * .55);//Calculates video container width based on %55 of viewable area in browser
	if(videoWidth < 250){videoWidth=250;}//Ensures video container width and height are within YouTube required specifications
	var videoHeight = Math.round(videoWidth * .8235);//Calculates video container height based on YouTube recommended aspect ratio
	var videoOffset = Math.round(videoWidth/2);//Centers video based on current browser width
	video.style.display='block';
	video.style.zIndex='100002';
	video.style.position='fixed';
	video.style.top='10px';
	video.style.left='50%';
	videoOffset+=30;//Compensate for 30px of padding on 'video' div
	video.style.marginLeft='-' + videoOffset + 'px';
	controller.style.display='block';
	settings.style.display='block';
	openControls(animation);
	if (window.addEventListener){//Detects window resize and calls autoResize() to adjust viewing area
			window.addEventListener('resize',autoResize,false); 
		} else if (window.attachEvent){//IE version
			window.attachEvent('resize',autoResize);
		}
	}//end initializeApp
function openControls(OpenAnim){//Opens YouTube video selection controls
	sidePanelWidth+=1;
	document.getElementById('controller').style.width=sidePanelWidth + 'px';
	document.getElementById('settings').style.width=sidePanelWidth + 'px';
	var timer=setTimeout(function(){openControls(OpenAnim);},10);
	if(sidePanelWidth>=160 || OpenAnim == 0){ //Stop openControls() loop when complete side panel width is at full width
		clearTimeout(timer);
		sidePanelWidth2=160;
		if(OpenAnim == 0){//No animation open
			document.getElementById('controller').style.width=sidePanelWidth2 + 'px';
			document.getElementById('settings').style.width=sidePanelWidth2 + 'px';
		}
		var defaultVideoSelect=document.getElementById('videoselector').value;
		defaultVideoSelect=defaultVideoSelect.replace(/ /g,'');
		changeVideo(defaultVideoSelect);
		}//'Open' loop ended
	}//end openControls
function closeTheater(){
	closeControls(animation);
	var video = document.getElementById('video');
	video.style.display='none';
	video.innerHTML='<div id=\"YouTube\" style=\"display:none;\"></div>';//Removes currently loaded/loading YouTube video to prevent background bandwidth usage
	}
function closeControls(CloseAnim){
	sidePanelWidth2 = sidePanelWidth2-1;
	var controller = document.getElementById('controller');
	var settings = document.getElementById('settings');
	controller.style.width=sidePanelWidth2 + 'px';
	settings.style.width=sidePanelWidth2 + 'px';
	timer=setTimeout(function(){closeControls(CloseAnim);},1);
	if(sidePanelWidth2<=0 || CloseAnim == 0){ //Stop 'close' loop when complete
		clearTimeout(timer);
		sidePanelWidth=0;
		if(CloseAnim == 0){//No animation close
			document.getElementById('controller').style.width=sidePanelWidth + 'px';
			document.getElementById('settings').style.width=sidePanelWidth + 'px';
		}
		controller.style.display='none';
		settings.style.display='none';
		fadeToClear();
		//Restore flash content contained within iframe or embed tags
		var iframeLength = document.getElementsByTagName('iframe').length;
		var embedLength = document.getElementsByTagName('embed').length;
		var objectLength = document.getElementsByTagName('object').length;
		if(iframeLength != 0){
			for(T=0; T<iframeLength; T++){
				document.getElementsByTagName('iframe')[T].style.display='block';
			}
		}
		if(embedLength != 0){
			for(T=0; T<embedLength; T++){
				document.getElementsByTagName('embed')[T].style.display='block';
			}
		}
		if(objectLength != 0){
			for(T=0; T<objectLength; T++){
				document.getElementsByTagName('object')[T].style.display='block';
			}
		}
		}//'Close' loop ended
	}
function changeVideo(ID){
	var videoSelect=document.getElementById('videoselector').value;
	videoSelect=videoSelect.replace(/ /g,'');
	//Extract video ID
		//New Links 2012 = http://youtu.be/BuAacVsPwSc
		//Old Links = http://www.youtube.com/watch?v=BuAacVsPwSc
	var videoSelectLength = videoSelect.length;
	var charRemoveInt = videoSelect.lastIndexOf('/');
	charRemoveInt++; //Accounts for 0 index array
	if(videoSelect.lastIndexOf('v=') != -1){ //Check if long 'watch' link is used
		charRemoveInt = videoSelect.lastIndexOf('v=');
		charRemoveInt+=2; //Accounts for 0 index array
		videoSelect = videoSelect.substr(charRemoveInt,11);
	}else{
		videoSelect = videoSelect.substr(charRemoveInt,11);
	}
	
	if(ID!='void' && videoSelect!='' && videoSelect.length == 11){
		var videoWidth = window.innerWidth || document.documentElement.clientWidth;//Patch for IE8 window width
		videoWidth = Math.round(videoWidth * .55);//Calculates video container width based on %55 of viewable area in browser
		if(videoWidth < 250){videoWidth=250;}//Matches video container size
		var videoHeight = Math.round(videoWidth * .8235);//Matches video container size
		var videoCode1 = '<iframe width=\"'+ videoWidth +'\" height=\"'+ videoHeight +'\" id=\"YouTube\" src=\"http$YtThS://www.youtube$YtTpM.com/embed/';
		var videoCode2 =  '$YtTsV_YtTaP\" frameborder=\"0\" allowfullscreen></iframe>';
		document.getElementById('video').innerHTML=videoCode1 + videoSelect + videoCode2;
		}
	else if(videoSelect.length != 11 && videoSelect!=''){
		var videoWidth = window.innerWidth || document.documentElement.clientWidth;//Patch for IE8 window width
		videoWidth = Math.round(videoWidth * .55);//Calculates video container width based on %55 of viewable area in browser
		if(videoWidth < 250){videoWidth=250;}//Matches video container size
		var videoHeight = Math.round(videoWidth * .8235);//Matches video container size
		var videoCode1 = 'Video ID is invalid.<br/><iframe width=\"'+ videoWidth +'\" height=\"'+ videoHeight +'\" id=\"YouTube\"';
		var videoCode2 =  'frameborder=\"0\" allowfullscreen></iframe>';
		document.getElementById('video').innerHTML=videoCode1 + videoCode2;
		}
	else{
		var videoWidth = window.innerWidth || document.documentElement.clientWidth;//Patch for IE8 window width
		videoWidth = Math.round(videoWidth * .55);//Calculates video container width based on %55 of viewable area in browser
		if(videoWidth < 250){videoWidth=250;}//Matches video container size
		var videoHeight = Math.round(videoWidth * .8235);//Matches video container size
		var videoCode1 = 'Video is not available.<br/><iframe width=\"'+ videoWidth +'\" height=\"'+ videoHeight +'\" id=\"YouTube\"';
		var videoCode2 =  'frameborder=\"0\" allowfullscreen></iframe>';
		document.getElementById('video').innerHTML=videoCode1 + videoCode2;
		}
	}
function autoResize(){//Called when viewer resizes browser window
		var videoWidth = window.innerWidth || document.documentElement.clientWidth;//Patch for IE8 window width
		videoWidth = Math.round(videoWidth * .55);//Calculates video container width based on %55 of viewable area in browser
		if(videoWidth < 250){videoWidth=250;}//Ensures video width and height are within YouTube required specifications
		var videoHeight = Math.round(videoWidth * .8235);//Calculates video height based on YouTube recommended aspect ratio
		var youTubeVideo = document.getElementById('YouTube');
		var videoContainer = document.getElementById('video');
		videoContainer.style.width=videoWidth + 'px';
		videoContainer.style.height=videoHeight + 'px';
		youTubeVideo.style.width=videoWidth + 'px';
		youTubeVideo.style.height=videoHeight + 'px';
		var videoOffset = Math.round(videoWidth/2);//Calculate videoContainer center position
		videoOffset+=30;//Compensate for 30px of padding on 'video' div
		videoOffset = videoOffset.toString();
		videoContainer.style.marginLeft='-'+ videoOffset +'px';//Apply new center location to the video container DIV
	}
function fadeToClear(){
	var shader = document.getElementById('shader');
	shader.style.opacity=0.00;
	shader.style.display='none';
	}
	//End of Theater App for YouTube videos
	</script>";
}
//End Main Functions


//Start Admin Options
add_action( 'admin_menu', 'youTubeTheaterSettingsMenu' );

function youTubeTheaterSettingsMenu() {
	//add_options_page(Page Title, Menu Link Title, WordPress API , Unique Title Not Displayed, Function Call);
	add_options_page( 'Procure Eminence Theater Settings', 'Procure Eminence Theater', 'manage_options', 'ProcureEminenceTheaterSettingsTitle', 'youTubeTheaterOptions' );
}

function youTubeTheaterOptions() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	
	//Load variables from WordPress database or create them if they don't exist
	if(get_option('YouTubeTheaterAnimation')){
		$YouTubeTheaterChannel = get_option('YouTubeTheaterChannel');
		$YouTubeTheaterAnimation = get_option('YouTubeTheaterAnimation');
		$YouTubeTheaterSuggVid = get_option('YouTubeTheaterSuggVid');
		$YouTubeTheaterHttps = get_option('YouTubeTheaterHttps');
		$YouTubeTheaterPrivacyMode = get_option('YouTubeTheaterPrivacyMode');
		$YouTubeTheaterBackgroundOpacity = get_option('YouTubeTheaterBackgroundOpacity');
		$YouTubeTheaterVideoTitlesArray = get_option('YouTubeTheaterVideoTitlesArray');
		$YouTubeTheaterVideoLinksArray = get_option('YouTubeTheaterVideoLinksArray');
		$YouTubeTheaterVideoAutoPlay = get_option('YouTubeTheaterVideoAutoPlay');
	}
	else{
		$YouTubeTheaterChannel = "";
		$YouTubeTheaterAnimation = "false";
		$YouTubeTheaterVideoAutoPlay = "false";
		$YouTubeTheaterSuggVid = "false";
		$YouTubeTheaterHttps = "false";
		$YouTubeTheaterPrivacyMode = "false";
		$YouTubeTheaterBackgroundOpacity = "0.9";
		$YouTubeTheaterVideoTitlesArray = "Dan Pink: The puzzle of motivation;;;;;;;;;;;;;";
		$YouTubeTheaterVideoLinks = "rrkrvAUbU9Y;;;;;;;;;;;;;";	
	}
	if($YouTubeTheaterAnimation == "true"){$YtTaO='checked="checked"';}else{$YtTaO='';}
	if($YouTubeTheaterVideoAutoPlay == "true"){$YtTaP='checked="checked"';}else{$YtTaP='';}
	if($YouTubeTheaterSuggVid == "true"){$YtTsV='checked="checked"';}else{$YtTsV='';}
	if($YouTubeTheaterHttps == "true"){$YtThS='checked="checked"';}else{$YtThS='';}
	if($YouTubeTheaterPrivacyMode == "true"){$YtTpM='checked="checked"';}else{$YtTpM='';}
	$ColorOption1 = '';
	$ColorOption2 = '';
	$ColorOption3 = '';
	if($YouTubeTheaterBackgroundOpacity == "1"){
		$ColorOption1 = 'selected="selected"';
	}
	else if($YouTubeTheaterBackgroundOpacity == "0.9"){
		$ColorOption2 = 'selected="selected"';
	}
	else{
		$ColorOption3 = 'selected="selected"';
	}
	
	$YtTvTa = explode(";",$YouTubeTheaterVideoTitlesArray);
	$YtTvLa = explode(";",$YouTubeTheaterVideoLinksArray);
	
	//Remove style display=none from first row after YouTubeChannel is integrated with the front-end Theater.
	echo "<div class='wrap'>
		<div id='icon-options-general' class='icon32'></div>
		<h2>Procure Eminence Theater Settings</h2>
		<table class='form-table'>
		<tr valign='top' style='display:none;'>
			<th scope='row'><label for='YouTubeChannel'>YouTube Channel Address (URL)</label></th>
			<td><input name='YouTubeChannel' type='text' id='YouTubeChannel' value='$YouTubeTheaterChannel' class='regular-text ltr' /></td>
		</tr>
		<tr valign='top'>
			<th scope='row'>Animation</th>
			<td> <fieldset><legend class='screen-reader-text'><span>Animation</span></legend><label for='TheaterAnimation'>
			<input name='TheaterAnimation' type='checkbox' id='TheaterAnimation' value='YouTubeTheaterAnimation' $YtTaO class='ChkBoxOpt' />
			Turn on opening/closing animation.</label>
			</fieldset></td>
		</tr>
		<tr valign='top'>
			<th scope='row'>Video AutoPlay</th>
			<td> <fieldset><legend class='screen-reader-text'><span>Video AutoPlay</span></legend><label for='VidAutoPlay'>
			<input name='VidAutoPlay' type='checkbox' id='VidAutoPlay' value='VidAutoPlay' $YtTaP class='ChkBoxOpt' /> Play videos as soon as they load.</label>
			</fieldset></td>
		</tr>
		<tr valign='top'>
			<th scope='row'>Suggested Videos</th>
			<td> <fieldset><legend class='screen-reader-text'><span>Suggested Videos</span></legend><label for='SuggestedVideos'>
			<input name='SuggestedVideos' type='checkbox' id='SuggestedVideos' value='YouTubeTheaterSuggVid' $YtTsV class='ChkBoxOpt' /> Show suggested videos when the current video finishes.</label>
			</fieldset></td>
		</tr>
		<tr valign='top'>
			<th scope='row'>HTTPS [<a href='http://support.google.com/youtube/bin/answer.py?hl=en&answer=171780&expand=UseHTTPS#HTTPS' target='_blank'>?</a>]</th>
			<td> <fieldset><legend class='screen-reader-text'><span>Use HTTPS</span></legend><label for='UseHTTPS'>
			<input name='UseHTTPS' type='checkbox' id='UseHTTPS' value='YouTubeTheaterHttps' $YtThS class='ChkBoxOpt' /> Encryption of data to prevent \"Mixed Content\" warnings on HTTPS enabled websites.</label>
			</fieldset></td>
		</tr>
		<tr valign='top'>
			<th scope='row'>Privacy-Enhanced Mode [<a href='http://support.google.com/youtube/bin/answer.py?hl=en&answer=171780&expand=PrivacyEnhancedMode#privacy' target='_blank'>?</a>]</th>
			<td> <fieldset><legend class='screen-reader-text'><span>Privacy-Enhanced Mode</span></legend><label for='PrivacyMode'>
			<input name='PrivacyMode' type='checkbox' id='PrivacyMode' value='YouTubeTheaterPrivacyMode' $YtTpM class='ChkBoxOpt' /> Restrict YouTube's ability to set cookies for your viewers.</label>
			</fieldset></td>
		</tr>
		<tr valign='top'>
			<th scope='row'><label for='ShaderOpacity'>Theater Background Opacity</label></th>
			<td>
			<select name='ShaderOpacity' id='ShaderOpacity'>
				<option value='1.0' $ColorOption1>Solid Black</option>
				<option value='0.9' $ColorOption2>Dark</option>
				<option value='0.7' $ColorOption3>Light</option>
			</select>
		</td>
		</tr>
		</table>
		<br/>
		<style>
		#YouTubeTheaterVideoTable{
			border:1px solid gray;
			border-spacing:10px;
			text-align:center;
		}
		.YouTubeTheaterTextInput{
			width:250px;
		}
		</style>
		<table id='YouTubeTheaterVideoTable' >
		<tr>
			<th>YouTube Video Title</th><th>YouTube Video Link</th>
		</tr>";
		
		$VidArraySize = count($YtTvTa);
		for($t=0; $t<$VidArraySize; $t++){
			//if($YtTvApA[$t] == "true"){$YtTvApA[$t] = 'checked="checked"';}else{$YtTvApA[$t] = '';} //Fill in appropriate AutoPlay checkboxes. Not currently used. All videos are set to "on" or "off"
			echo "<tr>
			<td><input type='text' value='$YtTvTa[$t]' class='YouTubeTheaterTextInput VidTitle'/></td>
			<td><input type='text' value='$YtTvLa[$t]' class='YouTubeTheaterTextInput VidLink'/></td>
		</tr>";
		}
		echo "</table><br/>
		<input type='button' name='submit' id='ProcureEminenceTheaterSubmit' class='button-primary' value='Save Changes'  onclick='return updateProcureEminenceTheaterSettings()'/>
		</div>";

	
	//Ajax script
	echo "
	<script type='text/javascript'>
		function updateProcureEminenceTheaterSettings(){
			//Get current settings
			\$YouTubeChannel = document.getElementById('YouTubeChannel').value;
			
			/* This section will be used for automation in a future release
			\$ChkBoxLeng = document.querySelectorAll('.ChkBoxOpt').length; //Get upper checkboxes
			for(\$i=0; \$i<\$ChkBoxLeng; \$i++){
				if(document.querySelectorAll('.ChkBoxOpt')[\$i].checked){
					\$ResultOut = document.querySelectorAll('.ChkBoxOpt')[\$i].value;
					\$ResultOut = \$ResultOut + ' is checked';
					alert(\$ResultOut);
				}else{
					\$ResultOut = document.querySelectorAll('.ChkBoxOpt')[\$i].value;
					\$ResultOut = \$ResultOut + ' is not checked';
					alert(\$ResultOut);
				}
			}
			*/
			
			\$VidTitle = document.querySelectorAll('.VidTitle'); //Get video title array
			\$VidTitleLength = \$VidTitle.length; //Get video title array length
			\$LastArrayItem = \$VidTitleLength - 1;
			\$VidLink = document.querySelectorAll('.VidLink'); //Get video title array
			\$VidTitleArray = '';
			\$VidLinkArray = '';
			for(\$z=0; \$z<\$VidTitleLength; \$z++){
				if(\$z == \$LastArrayItem){
					\$VidTitleArray = \$VidTitleArray + \$VidTitle[\$z].value;
					\$VidLinkArray = \$VidLinkArray + \$VidLink[\$z].value;
				}else{
					\$VidTitleArray = \$VidTitleArray + \$VidTitle[\$z].value + ';';
					\$VidLinkArray = \$VidLinkArray + \$VidLink[\$z].value + ';';
				}
			}
			
			
			\$TheaterAnimation = document.getElementById('TheaterAnimation').checked;//true || false
			\$VidAutoPlay = document.getElementById('VidAutoPlay').checked; //true || false
			\$SuggestedVideos = document.getElementById('SuggestedVideos').checked;//true || false
			\$UseHTTPS = document.getElementById('UseHTTPS').checked;//true || false
			\$PrivacyMode = document.getElementById('PrivacyMode').checked;//true || false
			\$ShaderOpacity = document.getElementById('ShaderOpacity').value;
			
			document.getElementById('ProcureEminenceTheaterSubmit').value = 'Saving...';
						
			setTimeout(function(){runDelayQuery()},200);
			function runDelayQuery(){
					jQuery(document).ready(function($) {
						var data = {
							action: 'youTubeTheaterAjaxUpdate',
							YouTubeChannel: \$YouTubeChannel,
							TheaterAnimation: \$TheaterAnimation,
							VidAutoPlay: \$VidAutoPlay,
							SuggestedVideos: \$SuggestedVideos,
							UseHTTPS: \$UseHTTPS,
							PrivacyMode: \$PrivacyMode,
							ShaderOpacity: \$ShaderOpacity,
							VidTitleArray: \$VidTitleArray,
							VidLinkArray: \$VidLinkArray
						};
						// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
						$.post('" . admin_url('admin-ajax.php') . "', data, function(response) {
						document.getElementById('ProcureEminenceTheaterSubmit').value = 'Changes Saved';
						setTimeout(function(){document.getElementById('ProcureEminenceTheaterSubmit').value = 'Save Changes';},2500);
						});
					});
			}
			return false;
		}
	</script>
	";
}
//End Admin Options



//Ajax Updater
add_action('wp_ajax_nopriv_youTubeTheaterAjaxUpdate','youTubeTheaterAjaxUpdate');
add_action('wp_ajax_youTubeTheaterAjaxUpdate','youTubeTheaterAjaxUpdate');

function youTubeTheaterAjaxUpdate(){
	//Get new data from post
	
	
	//Update database
	$YouTubeChannel = mysql_real_escape_string($_POST[YouTubeChannel]);
	$TheaterAnimation = mysql_real_escape_string($_POST[TheaterAnimation]);
	$VidAutoPlay = mysql_real_escape_string($_POST[VidAutoPlay]);
	$SuggestedVideos = mysql_real_escape_string($_POST[SuggestedVideos]);
	$UseHTTPS = mysql_real_escape_string($_POST[UseHTTPS]);
	$PrivacyMode = mysql_real_escape_string($_POST[PrivacyMode]);
	$ShaderOpacity = mysql_real_escape_string($_POST[ShaderOpacity]);
	$VidTitleArray = mysql_real_escape_string($_POST[VidTitleArray]);
	$VidLinkArray = mysql_real_escape_string($_POST[VidLinkArray]);
	
	update_option('YouTubeTheaterChannel', $YouTubeChannel);
	update_option('YouTubeTheaterAnimation', $TheaterAnimation);
	update_option('YouTubeTheaterVideoAutoPlay', $VidAutoPlay);
	update_option('YouTubeTheaterSuggVid', $SuggestedVideos);
	update_option('YouTubeTheaterHttps', $UseHTTPS);
	update_option('YouTubeTheaterPrivacyMode', $PrivacyMode);
	update_option('YouTubeTheaterBackgroundOpacity', $ShaderOpacity);
	update_option('YouTubeTheaterVideoTitlesArray', $VidTitleArray);
	update_option('YouTubeTheaterVideoLinksArray', $VidLinkArray);
	
	/*
	//Loop to add addtional video data
	for($i=0; $i<$_POST.length; $i++){
		$_POST[$i]
	}
	*/
}
?>