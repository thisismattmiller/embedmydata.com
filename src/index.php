<?php

error_reporting(0);


	function embedData($xmpmeta,$field,$valArray){
		
		
		if (sizeof($valArray)==0){
			
			//notthing to embed
			
		}elseif (sizeof($valArray)==1){
			
			//only one value, set it as text
			$xmpmeta->SetProperty(SXMPMeta::kXMP_NS_DC, $field, $valArray[0]);
			
			
		}elseif (sizeof($valArray)>1){
			
			//multiple values, embed it as an array.
			
			//kind of confusing, but it embeded its backwards unless we loop throught it backwards.
			
			$xmpIndexCounter=1;
			
			for($i = sizeof($valArray)-1; $i > -1; $i=$i-1)
			{
				
				//echo "embeding " . $valArray[$i] . "<br />";
				 
				$xmpmeta->AppendArrayItem(SXMPMeta::kXMP_NS_DC, $field, SXMPMeta::kXMP_PropValueIsArray, $valArray[$i]);
 				//set the lang value otherwise it will complain 				
				$xmpmeta->SetQualifier(SXMPMeta::kXMP_NS_DC, $field . '['. $xmpIndexCounter .']', SXMPMeta::kXMP_NS_XML, 'lang', 'x-default');
				
				$xmpIndexCounter=$xmpIndexCounter+1;
				
			}			

			
		}
		
		
		return $xmpmeta;
		
	}



	$error = "";
	
	
	if (isset($_REQUEST['download'])){	
	
	
		 $file = urldecode($_REQUEST['download']);
		 
		 $file=str_replace('..','',$file);
		 $file=str_replace('/','',$file);		 
		
		 $filename= $file; 
		 $file="/var/www/embedmydata.com/web/tmp/$file";
		 
		 
		 if(!is_file($file))
		 {
			 // File doesn't exist, output error
			 $error='Could not find that! Sorry.';
		 }
		 else
		 {
			 // Set headers
			 header("Cache-Control: public");
			 header("Content-Description: File Transfer");
			 header("Content-Disposition: attachment; filename=$filename");
			 //header("Content-Type: image/jpg");
			 header("Content-Transfer-Encoding: binary");
			
			 // Read the file from disk
			 readfile($file);
		 }		
			
	
	
	}


	
	
	

	if (isset($_REQUEST['embed'])){	

		
		$img = '/var/www/embedmydata.com/web/tmp/' . $_SERVER['REMOTE_ADDR'] . $_REQUEST['idTag'] . "." . $_REQUEST['analyze'] ;
				
		SXMPFiles::Initialize();
		
		$xmpfiles = new SXMPFiles();
		$xmpmeta = new SXMPMeta();		
		$xmpfiles->OpenFile($img);
		$xmpfiles->GetXMP( $xmpmeta );
		
		
		$xmpmeta->SetLocalizedText(SXMPMeta::kXMP_NS_DC, "description", '', "fr-FR", "Une description française" );
	
	 
		//whipe out the data
		$xmpmeta->DeleteProperty(SXMPMeta::kXMP_NS_DC, "title");		
		$xmpmeta->DeleteProperty(SXMPMeta::kXMP_NS_DC, "subject");		
		$xmpmeta->DeleteProperty(SXMPMeta::kXMP_NS_DC, "creator");		
		$xmpmeta->DeleteProperty(SXMPMeta::kXMP_NS_DC, "description");		
		$xmpmeta->DeleteProperty(SXMPMeta::kXMP_NS_DC, "publisher");		
		$xmpmeta->DeleteProperty(SXMPMeta::kXMP_NS_DC, "contributor");
		$xmpmeta->DeleteProperty(SXMPMeta::kXMP_NS_DC, "date");				
		$xmpmeta->DeleteProperty(SXMPMeta::kXMP_NS_DC, "format");		
		$xmpmeta->DeleteProperty(SXMPMeta::kXMP_NS_DC, "type");		
		$xmpmeta->DeleteProperty(SXMPMeta::kXMP_NS_DC, "identifier");		
		$xmpmeta->DeleteProperty(SXMPMeta::kXMP_NS_DC, "source");		
		$xmpmeta->DeleteProperty(SXMPMeta::kXMP_NS_DC, "language");		
		$xmpmeta->DeleteProperty(SXMPMeta::kXMP_NS_DC, "relation");		
		$xmpmeta->DeleteProperty(SXMPMeta::kXMP_NS_DC, "coverage");		
		$xmpmeta->DeleteProperty(SXMPMeta::kXMP_NS_DC, "rights");																										
			
		$dcTitle = array();
		$dcCreator = array();
		$dcSubject = array();
		$dcDescription = array();
		$dcPublisher = array();
		$dcContributor = array();
		$dcDate = array();
		$dcType = array();
		$dcFormat = array();
		$dcIdentifier = array();
		$dcSource = array();
		$dcLanguage = array();
		$dcRelation = array();
		$dcCoverage = array();			
		$dcRights = array();				
				
		foreach($_POST as $name => $value) {

			//echo "looking at $name<br />";


																																																																			 
			 if (strpos(strtolower($name),"title")!==false){  array_push($dcTitle, $value); }
			 if (strpos(strtolower($name),"subject")!==false){  array_push($dcSubject, $value); }					 
			 if (strpos(strtolower($name),"creator")!==false){  array_push($dcCreator, $value); }					 
			 if (strpos(strtolower($name),"description")!==false){  array_push($dcDescription, $value); }					 
			 if (strpos(strtolower($name),"publisher")!==false){  array_push($dcPublisher, $value); }					 
			 if (strpos(strtolower($name),"contributor")!==false){  array_push($dcContributor, $value); }					 
			 if (strpos(strtolower($name),"type")!==false){  array_push($dcType, $value); }					 
			 if (strpos(strtolower($name),"date")!==false){  array_push($dcDate, $value); }					 					 
			 if (strpos(strtolower($name),"identifier")!==false){  array_push($dcIdentifier, $value); }					 
			 if (strpos(strtolower($name),"source")!==false){  array_push($dcSource, $value); }					 
			 if (strpos(strtolower($name),"format")!==false){  array_push($dcFormat, $value); }					 					 
			 if (strpos(strtolower($name),"language")!==false){  array_push($dcLanguage, $value); }					 
			 if (strpos(strtolower($name),"relation")!==false){  array_push($dcRelation, $value); }					 
			 if (strpos(strtolower($name),"coverage")!==false){  array_push($dcCoverage, $value); }					 
			 if (strpos(strtolower($name),"rights")!==false){  array_push($dcRights, $value); }	
			 
			 
			 /*	 


			 if (strpos(strtolower($name),"title")!==false){  $xmpmeta->SetProperty(SXMPMeta::kXMP_NS_DC, "title", $value ); }
			 if (strpos(strtolower($name),"subject")!==false){  $xmpmeta->SetProperty(SXMPMeta::kXMP_NS_DC, "subject",   $value );}					 
			 if (strpos(strtolower($name),"creator")!==false){  $xmpmeta->SetProperty(SXMPMeta::kXMP_NS_DC, "creator",  $value ); }					 
			 if (strpos(strtolower($name),"description")!==false){  $xmpmeta->SetProperty(SXMPMeta::kXMP_NS_DC, "description", $value );}					 
			 if (strpos(strtolower($name),"publisher")!==false){  $xmpmeta->SetProperty(SXMPMeta::kXMP_NS_DC, "publisher",  $value );}					 
			 if (strpos(strtolower($name),"contributor")!==false){  $xmpmeta->SetProperty(SXMPMeta::kXMP_NS_DC, "contributor",  $value ); }					 
			 if (strpos(strtolower($name),"type")!==false){ $xmpmeta->SetProperty(SXMPMeta::kXMP_NS_DC, "type",   $value ); }					 
			 if (strpos(strtolower($name),"identifier")!==false){  $xmpmeta->SetProperty(SXMPMeta::kXMP_NS_DC, "identifier",   $value ); }					 
			 if (strpos(strtolower($name),"source")!==false){ $xmpmeta->SetProperty(SXMPMeta::kXMP_NS_DC, "source",   $value );}					 
			 if (strpos(strtolower($name),"language")!==false){ $xmpmeta->SetProperty(SXMPMeta::kXMP_NS_DC, "language",  $value ); }					 
			 if (strpos(strtolower($name),"relation")!==false){  $xmpmeta->SetProperty(SXMPMeta::kXMP_NS_DC, "relation",   $value );}					 
			 if (strpos(strtolower($name),"coverage")!==false){ $xmpmeta->SetProperty(SXMPMeta::kXMP_NS_DC, "coverage",  $value ); }					 
			 if (strpos(strtolower($name),"rights")!==false){  $xmpmeta->SetProperty(SXMPMeta::kXMP_NS_DC, "rights",   $value );}	
			
			*/
			

		}		
		
		
		//if i is a single value embed it as a text but otherwise we need to set it up as an array
		
		
		$xmpmeta = embedData($xmpmeta,'title',$dcTitle);
		$xmpmeta = embedData($xmpmeta,'subject',$dcSubject);
		$xmpmeta = embedData($xmpmeta,'creator',$dcCreator);
		$xmpmeta = embedData($xmpmeta,'description',$dcDescription);
		$xmpmeta = embedData($xmpmeta,'publisher',$dcPublisher);
		$xmpmeta = embedData($xmpmeta,'contributor',$dcContributor);
		$xmpmeta = embedData($xmpmeta,'type',$dcType);
		$xmpmeta = embedData($xmpmeta,'date',$dcDate);
		$xmpmeta = embedData($xmpmeta,'identifier',$dcIdentifier);
		$xmpmeta = embedData($xmpmeta,'source',$dcSource);
		$xmpmeta = embedData($xmpmeta,'format',$dcFormat);
		$xmpmeta = embedData($xmpmeta,'language',$dcLanguage);
		$xmpmeta = embedData($xmpmeta,'relation',$dcRelation);
		$xmpmeta = embedData($xmpmeta,'coverage',$dcCoverage);
		$xmpmeta = embedData($xmpmeta,'rights',$dcRights); 				

		
		
		
		
		 
	  //$xmpmeta->AppendArrayItem( SXMPMeta::kXMP_NS_DC, string $ArrayName, long $arrayOption, int $ArrayItem, string $itemValue , long $itemOptions=0 )
		

		//$xmpmeta->SetLocalizedText(SXMPMeta::kXMP_NS_DC, "description", '', "x-default", "MATTTTTTT" );
		//$xmpmeta->DeleteProperty(SXMPMeta::kXMP_NS_DC, "description");
			
		//$xmpfiles->PutXMP($xmpmeta);
		
		//$xmpmeta->SetProperty(SXMPMeta::kXMP_NS_DC, "rights",   "testorg", 0 );
		//$xmpmeta->SetArrayItem( SXMPMeta::kXMP_NS_DC, 'rights', 1, 'test1');
		//$xmpmeta->SetArrayItem( SXMPMeta::kXMP_NS_DC, 'rights', 2, 'test1');
		
		//$xmpmeta->SetProperty(SXMPMeta::kXMP_NS_DC, "description",   "testorg");
		//$/xmpmeta->SetLocalizedText(SXMPMeta::kXMP_NS_DC, "description", '', "x-default", "MATTTTTTT" );

		
		
		
		
		

		$xmpfiles->PutXMP($xmpmeta);
		
		$xmpfiles->CloseFile();


		//?analyze=jpg&idTag=ezbepj4xeu
 
	}
	
	


	if (isset($_REQUEST['analyze'])){		

		
		//if we are doing a things here...
		if (isset($_REQUEST['url'])){			
		
			$url = urldecode($_REQUEST['url']);
			$ext = end(explode('.', $url));
			
			if ($ext!='jpg'&&$ext!='jpge'&&$ext!='png'&&$ext!='tif'&&$ext!='tiff'&&$ext!='gif'&&$ext!='pdf'&&$ext!='gif'){
				die('that is not the right kind of file');				
			}
			 
			$img = '/var/www/embedmydata.com/web/tmp/' . $_SERVER['REMOTE_ADDR'] . $_REQUEST['idTag'] . "." . $_REQUEST['analyze'] ;
			$downloadTest = file_put_contents($img, file_get_contents($url));			
			
			
			if ($downloadTest==0){
				
				$error	= "Sorry we could not download that file!";
				
			}else{
								
				$finfo = finfo_open(FILEINFO_MIME);
				

				//check to see if the mime-type starts with 'text'
				if (substr(finfo_file($finfo, $img),0,4) == 'text'){
				
					$error	= "The file does not look like a image or PDF!";
					
				}
				
			}
			 
			 
			 
		
		
		}
		
		
		
		
		
		
		
		
		
		
		if ($error==""){
			
	
	
			$nameSpaces =       Array('http://www.vraweb.org/vracore/4.0/essential/'  , 'http://www.loc.gov/standards/vracore4/xmp/1.0/', 'http://www.vraweb.org/vracore/4.0/', 'http://iptc.org/std/Iptc4xmpExt/2008-02-29/', 'http://iptc.org/std/Iptc4xmpCore/1.0/xmlns/', 'http://ns.microsoft.com/photo/1.0','http://purl.org/dc/elements/1.1/','http://ns.adobe.com/exif/1.0/','http://ns.adobe.com/photoshop/1.0/','http://ns.adobe.com/tiff/1.0/','http://ns.adobe.com/xap/1.0/','http://ns.adobe.com/xap/1.0/mm/','http://ns.adobe.com/xap/1.0/rights/','http://ns.adobe.com/pdf/1.3/', 'http://ns.adobe.com/camera-raw-settings/1.0/', 'http://www.artstor.org/ARTstorCore/', 'http://ns.useplus.org/ldf/xmp/1.0/', 'http://purl.org/dc/terms/');
			$nameSpacesTitles = Array('VRA Core 4.0 Essential'                        , 'VRA Core 4.0'                     , 'VRA Core 4.0'                      , 'IPCT4 Core'                                 , 'IPCT4 Core'                                 , 'Microsoft Photo'                  ,'Dublin Core'                     ,'EXIF'                         ,'Photoshop'                         ,'TIFF'                         ,'XMP Base'                   ,'XMP Media<br />Management'           ,'XMP Rights<br />Management'              ,'Adobe PDF'                   , 'Camera Raw<br />Settings'                         , 'ArtStor Core'         ,  'PLUS Data'                        , 'DC Terms');		
			$nameSpacesLogos = Array('logos_vra.png'                                  , 'logos_vra.png'                    , 'logos_vra.png'                     , 'logos_iptc.png'                             , 'logos_iptc.png'                             , 'logos_msphoto.png'                ,'logos_dublin.png'                ,'logos_exif.png'               ,'logos_photoshop.png'               ,'logos_tiff.png'               ,'logos_xmpbase.png'          ,'logos_xmpmm.png'           	  ,'logos_xmprm.png'             		,'logos_pdf.png'               , 'logos_rawcamera.png'                         , 'logos_artstor.png'                 ,  'logos_plus.png'                   , 'logos_dublin.png');				 
	
			$nameSpacesFound = array();
			$nameSpaceLogosHTML = '';
			$nameSpacesFoundMsg = '';
			
			/*$nameSpaces = Array();
			
			$nameSpaces['http://www.vraweb.org/vracore/4.0/']['title']='VRA Core 4.0';
			$nameSpaces['http://www.vraweb.org/vracore/4.0/']['img']='logos_vra.png';
			
			echo $nameSpaces[1]['title'];
			*/
			
			
	
			//YEAHHGHHHHHHAAAA
			$dcTitle = array();
			$dcCreator = array();
			$dcSubject = array();
			$dcDescription = array();
			$dcPublisher = array();
			$dcContributor = array();
			$dcDate = array();
			$dcType = array();
			$dcFormat = array();
			$dcIdentifier = array();
			$dcSource = array();
			$dcLanguage = array();
			$dcRelation = array();
			$dcCoverage = array();			
			$dcRights = array();						
			
			
			
			SXMPFiles::Initialize();
			$xmpfile = new SXMPFiles();
			$xmpmeta = new SXMPMeta();
			
			
			$xmpfile->OpenFile('/var/www/embedmydata.com/web/tmp/' . $_SERVER['REMOTE_ADDR'] . $_REQUEST['idTag'] . "." . $_REQUEST['analyze']);
			$xmpfile->GetXMP( $xmpmeta );		
			
			$xmpmetaData=$xmpmeta;
			
			$xmpmeta->Sort();
			
			$a = $b = $c = $o = "";
			$oldnameSpace = '';
			
			$iterator = new SXMPIterator(&$xmpmeta );	
			while($iterator->Next(&$a, &$b, &$c, &$o) == TRUE){
			  
			  //if (strcmp($a, SXMPMeta::kXMP_NS_EXIF)==0) {
			  //  printf("Skipping %s ... </br>",SXMPMeta::kXMP_NS_EXIF);
			  //  $iterator->Skip(SXMPIterator::kXMP_IterSkipSubtree );
			  //} else {
	 			// printf("%s | %s | %s | %x </br>", $a, $b, $c, $o);    
			  //}
			  
			  
			  if (strcmp($a, SXMPMeta::kXMP_NS_DC)==0) {
				  
				  
				  if ($c!=''){
					  
					 if (strpos(strtolower($b),"title")!==false){  array_push($dcTitle, $c); }
					 if (strpos(strtolower($b),"subject")!==false){  array_push($dcSubject, $c); }					 
					 if (strpos(strtolower($b),"creator")!==false){  array_push($dcCreator, $c); }					 
					 if (strpos(strtolower($b),"description")!==false){  array_push($dcDescription, $c); }					 
					 if (strpos(strtolower($b),"publisher")!==false){  array_push($dcPublisher, $c); }					 
					 if (strpos(strtolower($b),"contributor")!==false){  array_push($dcContributor, $c); }					 
					 if (strpos(strtolower($b),"type")!==false){  array_push($dcType, $c); }					 
					 if (strpos(strtolower($b),"date")!==false){  array_push($dcDate, $c); }					 					 
					 if (strpos(strtolower($b),"identifier")!==false){  array_push($dcIdentifier, $c); }					 
					 if (strpos(strtolower($b),"source")!==false){  array_push($dcSource, $c); }					 
					 if (strpos(strtolower($b),"format")!==false){  array_push($dcFormat, $c); }					 					 
					 if (strpos(strtolower($b),"language")!==false){  array_push($dcLanguage, $c); }					 
					 if (strpos(strtolower($b),"relation")!==false){  array_push($dcRelation, $c); }					 
					 if (strpos(strtolower($b),"coverage")!==false){  array_push($dcCoverage, $c); }					 
					 if (strpos(strtolower($b),"rights")!==false){  array_push($dcRights, $c); }	
					 				 					 					 					 					 					 					 					 					 					 					 					 					 
			 
					 
					
				  }
				  				  
				  
			  }
			  
			  
			  if ($oldnameSpace!=$a){
				
				
				if (!in_array($a,$nameSpacesFound)){
					
					$counter = 0;
					$useIndex = -1;
					
					foreach ($nameSpaces as $aSpace) {
						if ($aSpace==$a){
							$useIndex = $counter;	
						}
						$counter=$counter+1;
					}				
					
					if ($useIndex==-1){
					//echo "<br /><br /><br /><br /><br /><br /><br />" . $a . "<br /><br /><br /><br /><br /><br /><br />";
						$nameSpaceLogosHTML .= "<div class=\"logoGroupHolder\" id=\"NSIcon$useIndex\"><img class=\"logoGroup\" src=\"logos_unkown.png\" title=\"Unknown Type\" alt=\"" . $nameSpacesTitles[$useIndex] . "\"><br /><span>Uknown Type</span></div>";
		
						
					}else{
					
						$nameSpaceLogosHTML .= "<div class=\"logoGroupHolder\" id=\"NSIcon$useIndex\"><img class=\"logoGroup\" src=\"" . $nameSpacesLogos[$useIndex] . "\" title=\"" . $nameSpacesTitles[$useIndex] . "\" alt=\"" . $nameSpacesTitles[$useIndex] . "\"><br /><span>" . $nameSpacesTitles[$useIndex] . "</span></div>";	
						
					}
					
					
					array_push($nameSpacesFound, $a);
					
					
					
					
				}		  
				  
			  }  
			  
			  
			}
			
					
			$nameSpacesFoundMsg = "We found: " . count($nameSpacesFound)  . " types of embedded data.";
			
			$xmpfile->CloseFile();
			
		} //end error test
	}		
	
	function genRandomString() {
		$length = 10;
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$string = '';    
		for ($p = 0; $p < $length; $p++) {
			$string .= $characters[mt_rand(0, strlen($characters))];
		}
		return $string;
	}





?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Embedded MetaData Explorer</title>



<link  href="http://fonts.googleapis.com/css?family=Arimo:regular,italic,bold,bolditalic" rel="stylesheet" type="text/css" >
<link  href="fileuploader.css" rel="stylesheet" type="text/css" >
<script type="text/javascript" src="fileuploader.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>



<style type="text/css">

	
	html{color:#333;background:#D9CEB2; height:100%;}body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,code,form,fieldset,legend,input,button,textarea,p,blockquote,th,td{margin:0;padding:0;}table{border-collapse:collapse;border-spacing:0;}fieldset,img{border:0;}address,caption,cite,code,dfn,em,strong,th,var,optgroup{font-style:inherit;font-weight:inherit;}del,ins{text-decoration:none;}li{list-style:none;}caption,th{text-align:left;}h1,h2,h3,h4,h5,h6{font-size:100%;font-weight:normal;}q:before,q:after{content:'';}abbr,acronym{border:0;font-variant:normal;}sup{vertical-align:baseline;}sub{vertical-align:baseline;}legend{color:#000;}input,button,textarea,select,optgroup,option{font-family:inherit;font-size:inherit;font-style:inherit;font-weight:inherit;}input,button,textarea,select{*font-size:100%;}

	body{
 
		height: 100%;
		
			
		font-family: 'Arimo', serif;font-size: 12px;font-style: normal;font-weight: 400;text-shadow: none;text-decoration: none;text-transform: none;letter-spacing: 0em;word-spacing: 0em;line-height: 1.2;
		
	}	


	#header{
		
		width:100%;
		height:75px;
		background-color:#99B2B7;

		
		
		-moz-box-shadow:0 5px 4px #948C75;
		-webkit-box-shadow:0 5px 4px #948C75;

		
		box-shadow: 0 5px 4px #948C75;
		
		/* For IE 8 */
		-ms-filter: "progid:DXImageTransform.Microsoft.Shadow(Strength=5, Direction=200, Color='#948C75')";
		/* For IE 5.5 - 7 */
		filter: progid:DXImageTransform.Microsoft.Shadow(Strength=5, Direction=200, Color='#948C75');
		 
	}

	#footer{
		width:100%;
		height:75px;
		background-color:#7A6A53;		
		
	}

	#content{
		
		width:1000px;
		max-width:1000px;
		margin-left:auto;
		margin-right:auto;
		display:block;
		margin-top:40px;
		position:relative;
				
	}

	#headerContent{
		width:1000px;
		max-width:1000px;
		margin-left:auto;
		margin-right:auto;
		display:block;
		height:75px;
		position:relative;
		background-image:url(embedlogo.png);
		background-repeat:no-repeat;
		background-position:left center;		
		
	}
	
	#linkDiv{
		position:absolute;
		width:600px;
		left:0px;
		height:75px;
		
		
		
	}
	
	
	#pratt{
		font-weight:900;
		font-size:20px;
	}

	
	#creditBox{
		text-align:center;
		position:absolute;
		right:0px;
		top:18px;

		
	}

	#uploadPhotoBox{
		width:355px;
		height:235px;
		margin-left:auto;
		margin-right:auto;
		background-image:url(box.png);
		background-repeat:no-repeat;
		padding-top:155px;		
		
			
		
		
	}

	a{text-decoration:none;}
	a:link {color: #516C73;}
	a:visited {color: #516C73;}
	a:hover {color: #99B2B7;} 
	a:active {color: #99B2B7;}
	
	
	.titleHeader{
		margin-left:10px;

		
	}
	 
	#resultsBox{
		width:1000px;
		padding:20px;		
		
	}
	#resultsBox .previewImage{
		float:left;
		width:200px;		
	}
	#metaDataTypes{
		float:right;
		width:740px;
		padding-top:25px;
		position:relative;
	}
	


	
	.logoGroupHolder{
		text-align:center;
		float:left;
		cursor:pointer;
		margin:5px;
		
		
	}
	
	#weFoundText{
		font-size:16px;
		margin-bottom:10px;
		
		
	}
	
	table{
		margin:5px;
		
	}
	table td{
		padding:3px;
		font-size:14px;
		
	}
	.dataTable tr:hover{
		background-color:#D5DED9;
		
	}
	
	.tableFieldName{
		
		width:190px;
		
		
		
	}
	.tableData{
		width:790px;
		
	}
	 
	.headerTitle{
		font-size:22px;
		font-weight:bold;

		height:50px;
		
		
	}
	.headerTitle span{
		line-height:50px;

	}
	.headerTitle img{
		margin-right:10px;
		
		
	}
	#urlHolder{
		float:left;
		width:600px;
		margin-left:20px;
		position:relative;
		
		
	}
	#urlTextHolder{
		position:absolute;
		left:0px;
		
	}
	#urlHolder input{
		height:28px;
		border:none;

		width:547px;
		background-color:transparent;
		background-image:url(textinput.png);
		background-repeat:no-repeat;
		padding-left:5px;
		padding-top:2px;
		font-size:14px;
		

	}
	
	input:focus {
	  outline-width:0;
	}	 
	
	#errorMsg{
		font-size:24px;
		
	}
	
	
	
	#okayGo {
		display:block; /* or inline-block */
		width: 95px; 
		height:45px;
		background-image:url(okaygo.png);
		background-position:0px -7px;
		background-repeat:no-repeat;
 		cursor:pointer;
		position:absolute;
		left:550px;
		top:-7px;


		

	
	}
	#okayGo:hover {background-position:0px -53px;}
		
		
	#dublinBox{
		width:900px;
		margin-left:100px;
		display:none;



		
	}
	#dublinBox table{
		float:right;
		
	}
	#dublinBox td input{
		width:700px;
		
	}
		
	#dublinBox div input{

		font-size:16px;
		font-weight:bold;

		padding:10px;


		
	}		
	
	#dublinBox table td{
		margin:5px;
		font-size:14px;
		
	}
	
	
	#editDublinLink{
		margin-top:10px;
		
		font-size:18px;
		
		
	}
	
	
	.addNewDCField:link, .removeDCField:link, .addNewDCField:visited, .removeDCField:visited{
		color:#333;
		
		
	}
	.addNewDCField img, .removeDCField img{
		height:12px;
		width:12px;
		margin-left:5px;
 		vertical-align:middle;
		
	}
	

	#actionBoxFrontPage{
		
		
		border-style:solid;
		border-width:2px;
		text-align:center;
		font-size:14px;
		border-color:#7A6A53;
		background-color:#7A6A53;
		color:#FFF;
		-webkit-border-radius: 6px; -moz-border-radius: 6px; border-radius: 6px;
		padding:10px;
		width:200px;
		max-width:200px;
		position:absolute;
		right:0px;
		
	}	
	
	
</style>



<script type="text/javascript">

 

	$(document).ready(function() {
		
		
		
		
			var idTag = '<?=genRandomString()?>';
		 
					
			$("#urlTextBox").focus(function(){
				// Select input field contents
				this.select();
			});
			
			
			
			
			$("#neverMindButton").click(function(event){

				$('#dublinBox').fadeOut('slow');
				event.preventDefault();		
				return false;
				
			});			
			
			
			attachRemoveDCEvent();
			attachNewFieldDCEvent();
			
  
  			
			$("#linkEditDC").click(function(event){
				
				 
				$('html, body').animate({scrollTop:$('#editDublinLink').attr('offsetTop')-20}, 'slow');
				$("#editDublinLink").click();
				event.preventDefault();		
				return false;
				
			});
			  

			$(".logoGroupHolder").click(function(event){

				
				
				
				var useId = $(this).attr('id').replace('NSIcon','');
				$('html, body').animate({scrollTop:$('#NSTable'+useId).attr('offsetTop')-60}, 'slow', function() {
					
					 
					 

  				});

				
				
				
				
				
				
				
				event.preventDefault();		
				return false;
				
			});			
			
			$("#editDublinLink").click(function(event){

				$('#dublinBox').fadeIn('slow');
				event.preventDefault();		
				return false;
				
			});
			
			$("#okayGo").click(function(){
			
				var url=$("#urlTextBox").val();
				
				var ext=url.split('.').pop();
				
				ext = ext.toLowerCase();
				
				if (ext!='jpg'&&ext!='jpge'&&ext!='png'&&ext!='tif'&&ext!='tiff'&&ext!='gif'&&ext!='pdf'&&ext!='gif'){
					alert("That URL doesn't look like the right kind of file.");
					return false;					
				}
				
				
				url = encodeURI(url);
				
				//alert(idTag);
				
				window.location = "?analyze=" + ext + "&idTag=" + idTag + "&url="+url;
				
			
			});			
			
		 

			<? if (!isset($_REQUEST['analyze'])){ ?>
	
				//uploaders
				var uploader = new qq.FileUploader({
					element: document.getElementById('upload'),
					action: 'uploadDang.php',
					debug: false,
					params: {
						idTag: idTag
					},					
					onComplete: function(id, fileName, responseJSON){
						
						
						
						urlFileName=encodeURIComponent(fileName);
						
						window.location = "?analyze=" + fileName.split('.').pop() + '&org='+ urlFileName + "&idTag=" + idTag;
						
							
						
						
					},								
				});  				
				
			<? } ?>

			

	});
	
	function attachNewFieldDCEvent(){
		
		$('.addNewDCField').unbind('click');
		
		$(".addNewDCField").click(function(event){
				

			var useField = $(this).attr('href').replace('#','');
			var useFieldHuman = $(this).attr('href').replace('#','').replace('dc','');
			
			var useNumber = $("." + useField + 'Row').length+1;		 
						
			$(this).parent().parent().after('<tr class="' + useField + 'Row"><td>' + useField.replace(/dc/,'') + '</td><td><input type="text" id="' + useField + useNumber + '" name="' + useField + useNumber + '" /><a class="addNewDCField" title="Add another '+useFieldHuman+' field." href="#'+useField+'"><img src="fieldAdd.png"/></a>&nbsp;<a class=\"removeDCField\" title=\"Remove this '+useFieldHuman+' field.\" href=\"#'+useField+'\"><img src="fieldRemove.png"/></a></td></td></tr>');


			attachRemoveDCEvent();

			event.preventDefault();		
			return false;					
			
		});		
	
		
		
		
	}
	
	function attachRemoveDCEvent(){
		
			$('.removeDCField').unbind('click');
			
			$(".removeDCField").click(function(event){
				
				var useField = $(this).attr('href').replace('#','');
				var useFieldHuman = $(this).attr('href').replace('#','').replace('dc','');
				
				if($("." + useField + 'Row').length!=1){
				
					$(this).parent().parent().remove();
					
				}

				event.preventDefault();		
				return false;					
				
			});
			attachNewFieldDCEvent();
					
		
	}


</script>

</head>



<body>


	<div id="header">
    
    	<div id="headerContent">
        
            <a href="/"><div id="linkDiv"></div></a>
            
            
            <div id="creditBox"><span id="pratt"><a href="http://www.pratt.edu" style="color:#f1b215">Pratt</a><span>:<a style="color:#333" href="http://www.pratt.edu/academics/information_and_library_sciences/">SILS</a></span></span> Project by<br /><a style="color:#333" href="mailto:thisismattmiller@gmail.com">Matt Miller</a> &amp; <a style="color:#333" href="mailto:c.mullin1217@gmail.com">Chris Mullin</a></div>
            
        </div>
    
    
    </div>

	<div id="content">
    
    	<? if (isset($_REQUEST['analyze'])){	 ?>

			
            <? if ($error!=''){ ?>
				
                
                <div id="errorMsg">Sorry, we ran into a problem: <?=$error?> Please try again.</div>
				
                
				
			<? }else{ ?>	
			
            
            	<div class="titleHeader"><img src="results.png" /></div>
            	<div id="resultsBox">
                
                
                	<? 
					
						$usePath = "/tmp/".$_SERVER['REMOTE_ADDR'] . $_REQUEST['idTag'] . "." . $_REQUEST['analyze'];

						if (strtolower($_REQUEST['analyze'])=='pdf'){
							$usePath = "pdf.png";
						}
						if (strtolower($_REQUEST['analyze'])=='tif'){
							$usePath = "tiff.png";
						}						
						if (strtolower($_REQUEST['analyze'])=='tiff'){
							$usePath = "tiff.png";
						}						
 
					?>
                
                	<img class="previewImage" src="<?=$usePath?>" />

                	<div id="metaDataTypes">
	                           <div id="weFoundText"><?=$nameSpacesFoundMsg?></div>
                     

                        	<?=$nameSpaceLogosHTML?> 
                            


                    
                    </div>        
					<br style="clear:both" />  
                    
					<br />

					<?php if (isset($_REQUEST['embed'])){	
					?>
                    	
	                   	<a id="downloadFile" title="Click To download the image with new embedded metadata" href="?download=<? echo $_SERVER['REMOTE_ADDR'] . $_REQUEST['idTag'] . "." . $_REQUEST['analyze']?>&org=<?=$_REQUEST['org'];?>"><img src="download.png" /></a><br />

                        
                    
					<?
					}
					?>
                   	<a id="editDublinLink" title="Click To Embed/Edit a Dublin Core Record Into This File" href="#"><img src="embeddc.png" /></a>                                      
                    
					
                    
                    
                    
                    <div id="dublinBox">
                    



                    	<form action="?embed=true<? echo "&idTag=" . $_REQUEST['idTag'] . "&analyze=" . $_REQUEST['analyze']  ?>&org=<?=$_REQUEST['org'];?>" method="post" name="dublinForm">
                        
                        
                        	<table>
                            <? $rowData = '';  ?>

                            
                            
                            
                            <? if (count($dcTitle)==0)
								{
								
									$rowData = "<tr class=\"dcTitleRow\"><td>Title</td><td><input type=\"text\" id=\"dcTitle\" name=\"dcTitle\" /><a class=\"addNewDCField\" title=\"Add another Title field.\" href=\"#dcTitle\"><img src=\"fieldAdd.png\"/></a>&nbsp;<a class=\"removeDCField\" title=\"Remove this Title field.\" href=\"#dcTitle\"><img src=\"fieldRemove.png\"/></a></td></tr>";
										
								}else{
									
									$counter = 0; 									
									foreach ($dcTitle as $aDc) {
										if ($aDc=='x-default'){continue;}
										if (trim($aDc)==''){continue;}																				
										$rowData .= "<tr class=\"dcTitleRow\"><td>Title</td><td><input type=\"text\" id=\"dcTitle$counter\" name=\"dcTitle$counter\" value=\"$aDc\" /><a class=\"addNewDCField\" title=\"Add another Title field.\" href=\"#dcTitle\"><img src=\"fieldAdd.png\"/></a>&nbsp;<a class=\"removeDCField\" title=\"Remove this Title field.\" href=\"#dcTitle\"><img src=\"fieldRemove.png\"/></a></td></tr>";										
										
										
									//<a class=\"addNewDCField\" title=\"dcTitle\" href=\"#\">[+]</a>
									
										$counter=$counter+1;
									}																			
								}
								
								
								
								echo $rowData;
								$rowData='';
							?>
                            
                            


                            <? if (count($dcCreator)==0)
								{
								
									$rowData = "<tr class=\"dcCreatorRow\"><td>Creator</td><td><input type=\"text\" id=\"dcCreator\" name=\"dcCreator\" /><a class=\"addNewDCField\" title=\"Add another Creator field.\" href=\"#dcCreator\"><img src=\"fieldAdd.png\"/></a>&nbsp;<a class=\"removeDCField\" title=\"Remove this Creataor field.\" href=\"#dcCreator\"><img src=\"fieldRemove.png\"/></a></td></tr>";
										
								}else{
									
									$counter = 0; 	
								
									foreach ($dcCreator as $aDc) {
										if ($aDc=='x-default'){continue;}
										if (trim($aDc)==''){continue;}										
										$rowData .= "<tr class=\"dcCreatorRow\"><td>Creator</td><td><input type=\"text\" id=\"dcCreator$counter\" name=\"dcCreator$counter\" value=\"$aDc\" /><a class=\"addNewDCField\" title=\"Add another Creator field.\" href=\"#dcCreator\"><img src=\"fieldAdd.png\"/></a>&nbsp;<a class=\"removeDCField\" title=\"Remove this Creataor field.\" href=\"#dcCreator\"><img src=\"fieldRemove.png\"/></a></td></tr>";										
										$counter=$counter+1;
									}																			
								}
								
								echo $rowData;
								$rowData='';
							?>  
                            
                            <? if (count($dcSubject)==0)
								{
								
									$rowData = "<tr class=\"dcSubjectRow\"><td>Subject</td><td><input type=\"text\" id=\"dcSubject\" name=\"dcSubject\" /><a class=\"addNewDCField\" title=\"Add another Subject field.\" href=\"#dcSubject\"><img src=\"fieldAdd.png\"/></a>&nbsp;<a class=\"removeDCField\" title=\"Remove this Subject field.\" href=\"#dcSubject\"><img src=\"fieldRemove.png\"/></a></td></tr>";
										
										
										
								}else{
									
									$counter = 0; 									
									foreach ($dcSubject as $aDc) {
										if ($aDc=='x-default'){continue;}
										if (trim($aDc)==''){continue;}																				
										$rowData .= "<tr class=\"dcSubjectRow\"><td>Subject</td><td><input type=\"text\" id=\"dcSubject$counter\" name=\"dcSubject$counter\" value=\"$aDc\" /><a class=\"addNewDCField\" title=\"Add another Subject field.\" href=\"#dcSubject\"><img src=\"fieldAdd.png\"/></a>&nbsp;<a class=\"removeDCField\" title=\"Remove this Subject field.\" href=\"#dcSubject\"><img src=\"fieldRemove.png\"/></a></td></tr>";										
										$counter=$counter+1;
									}																			
								}
								
								echo $rowData;
								$rowData='';								
							?>                                                            

                            <? if (count($dcDescription)==0)
								{
								
									$rowData = "<tr class=\"dcDescriptionRow\"><td>Description</td><td><input type=\"text\" id=\"dcDescription\" name=\"dcDescription\" /><a class=\"addNewDCField\" title=\"Add another Description field.\" href=\"#dcDescription\"><img src=\"fieldAdd.png\"/></a>&nbsp;<a class=\"removeDCField\" title=\"Remove this Description field.\" href=\"#dcDescription\"><img src=\"fieldRemove.png\"/></a></td></tr>";
										
								}else{
									
									$counter = 0; 									
									foreach ($dcDescription as $aDc) {
										if ($aDc=='x-default'){continue;}
										if (trim($aDc)==''){continue;}																				
										$rowData .= "<tr class=\"dcDescriptionRow\"><td>Description</td><td><input type=\"text\" id=\"dcDescription$counter\" name=\"dcDescription$counter\" value=\"$aDc\" /><a class=\"addNewDCField\" title=\"Add another Description field.\" href=\"#dcDescription\"><img src=\"fieldAdd.png\"/></a>&nbsp;<a class=\"removeDCField\" title=\"Remove this Description field.\" href=\"#dcDescription\"><img src=\"fieldRemove.png\"/></a></td></tr>";										
										$counter=$counter+1;
									}																			
								}
								
								echo $rowData;
								$rowData='';								
							?>                                
                            

                            <? if (count($dcPublisher)==0)
								{
								
									$rowData = "<tr class=\"dcPublisherRow\"><td>Publisher</td><td><input type=\"text\" id=\"dcPublisher\" name=\"dcPublisher\" /><a class=\"addNewDCField\" title=\"Add another Publisher field.\" href=\"#dcPublisher\"><img src=\"fieldAdd.png\"/></a>&nbsp;<a class=\"removeDCField\" title=\"Remove this Publisher field.\" href=\"#dcPublisher\"><img src=\"fieldRemove.png\"/></a></td></tr>";
										
								}else{
									
									$counter = 0; 									
									foreach ($dcPublisher as $aDc) {
										if ($aDc=='x-default'){continue;}
										if (trim($aDc)==''){continue;}																				
										$rowData .= "<tr class=\"dcPublisherRow\"><td>Publisher</td><td><input type=\"text\" id=\"dcPublisher$counter\" name=\"dcPublisher$counter\" value=\"$aDc\" /><a class=\"addNewDCField\" title=\"Add another Publisher field.\" href=\"#dcPublisher\"><img src=\"fieldAdd.png\"/></a>&nbsp;<a class=\"removeDCField\" title=\"Remove this Publisher field.\" href=\"#dcPublisher\"><img src=\"fieldRemove.png\"/></a></td></tr>";										
										$counter=$counter+1;
									}																			
								}
								
								echo $rowData;
								$rowData='';								
							?> 
                            
                            <? if (count($dcContributor)==0)
								{
								
									$rowData = "<tr class=\"dcContributorRow\"><td>Contributor</td><td><input type=\"text\" id=\"dcContributor\" name=\"dcContributor\" /><a class=\"addNewDCField\" title=\"Add another Contributor field.\" href=\"#dcContributor\"><img src=\"fieldAdd.png\"/></a>&nbsp;<a class=\"removeDCField\" title=\"Remove this Contributor field.\" href=\"#dcContributor\"><img src=\"fieldRemove.png\"/></a></td></tr>";
										
								}else{
									
									$counter = 0; 									
									foreach ($dcContributor as $aDc) {
										if ($aDc=='x-default'){continue;}
										if (trim($aDc)==''){continue;}																				
										$rowData .= "<tr class=\"dcContributorRow\"><td>Contributor</td><td><input type=\"text\" id=\"dcContributor$counter\" name=\"dcContributor$counter\" value=\"$aDc\" /><a class=\"addNewDCField\" title=\"Add another Contributor field.\" href=\"#dcContributor\"><img src=\"fieldAdd.png\"/></a>&nbsp;<a class=\"removeDCField\" title=\"Remove this Contributor field.\" href=\"#dcContributor\"><img src=\"fieldRemove.png\"/></a></td></tr>";										
										$counter=$counter+1;
									}																			
								}
								
								echo $rowData;
								$rowData='';								
							?>        
                            

                            <? if (count($dcType)==0)
								{
								
									$rowData = "<tr class=\"dcTypeRow\"><td>Type</td><td><input type=\"text\" id=\"dcType\" name=\"dcType\" /><a class=\"addNewDCField\" title=\"Add another Type field.\" href=\"#dcType\"><img src=\"fieldAdd.png\"/></a>&nbsp;<a class=\"removeDCField\" title=\"Remove this Type field.\" href=\"#dcType\"><img src=\"fieldRemove.png\"/></a></td></tr>";
										
								}else{
									
									$counter = 0; 									
									foreach ($dcType as $aDc) {
										if ($aDc=='x-default'){continue;}
										if (trim($aDc)==''){continue;}																				
										$rowData .= "<tr class=\"dcTypeRow\"><td>Type</td><td><input type=\"text\" id=\"dcType$counter\" name=\"dcType$counter\" value=\"$aDc\" /><a class=\"addNewDCField\" title=\"Add another Type field.\" href=\"#dcType\"><img src=\"fieldAdd.png\"/></a>&nbsp;<a class=\"removeDCField\" title=\"Remove this Type field.\" href=\"#dcType\"><img src=\"fieldRemove.png\"/></a></td></tr>";										
										$counter=$counter+1;
									}																			
								}
								
								echo $rowData;
								$rowData='';								
							?>     
                            <? if (count($dcDate)==0)
								{
								
									$rowData = "<tr class=\"dcDateRow\"><td>Date</td><td><input type=\"text\" id=\"dcDate\" name=\"dcDate\" /><a class=\"addNewDCField\" title=\"Add another Date field.\" href=\"#dcDate\"><img src=\"fieldAdd.png\"/></a>&nbsp;<a class=\"removeDCField\" title=\"Remove this Date field.\" href=\"#dcDate\"><img src=\"fieldRemove.png\"/></a></td></tr>";
										
								}else{
									
									$counter = 0; 									
									foreach ($dcDate as $aDc) {
										if ($aDc=='x-default'){continue;}
										if (trim($aDc)==''){continue;}																				
										$rowData .= "<tr class=\"dcDateRow\"><td>Date</td><td><input type=\"text\" id=\"dcDate$counter\" name=\"dcDate$counter\" value=\"$aDc\" /><a class=\"addNewDCField\" title=\"Add another Date field.\" href=\"#dcDate\"><img src=\"fieldAdd.png\"/></a>&nbsp;<a class=\"removeDCField\" title=\"Remove this Date field.\" href=\"#dcDate\"><img src=\"fieldRemove.png\"/></a></td></tr>";										
										$counter=$counter+1;
									}																			
								}
								
								echo $rowData;
								$rowData='';								
							?>    
                                                            
                            <? if (count($dcFormat)==0)
								{
								
									$rowData = "<tr class=\"dcFormatRow\"><td>Format</td><td><input type=\"text\" id=\"dcFormat\" name=\"dcFormat\" /><a class=\"addNewDCField\" title=\"Add another Format field.\" href=\"#dcFormat\"><img src=\"fieldAdd.png\"/></a>&nbsp;<a class=\"removeDCField\" title=\"Remove this Format field.\" href=\"#dcFormat\"><img src=\"fieldRemove.png\"/></a></td></tr>";
										
								}else{
									
									$counter = 0; 									
									foreach ($dcFormat as $aDc) {
										if ($aDc=='x-default'){continue;}
										if (trim($aDc)==''){continue;}																				
										$rowData .= "<tr class=\"dcFormatRow\"><td>Format</td><td><input type=\"text\" id=\"dcFormat$counter\" name=\"dcFormat$counter\" value=\"$aDc\" /><a class=\"addNewDCField\" title=\"Add another Format field.\" href=\"#dcFormat\"><img src=\"fieldAdd.png\"/></a>&nbsp;<a class=\"removeDCField\" title=\"Remove this Format field.\" href=\"#dcFormat\"><img src=\"fieldRemove.png\"/></a></td></tr>";										
										$counter=$counter+1;
									}																			
								}
								
								echo $rowData;
								$rowData='';								
							?>                                                                                                        
                            
                            <? if (count($dcIdentifier)==0)
								{
								
									$rowData = "<tr class=\"dcIdentifierRow\"><td>Identifier</td><td><input type=\"text\" id=\"dcIdentifier\" name=\"dcIdentifier\" /><a class=\"addNewDCField\" title=\"Add another Identifier field.\" href=\"#dcIdentifier\"><img src=\"fieldAdd.png\"/></a>&nbsp;<a class=\"removeDCField\" title=\"Remove this Identifier field.\" href=\"#dcIdentifier\"><img src=\"fieldRemove.png\"/></a></td></tr>";
										
								}else{
									
									$counter = 0; 									
									foreach ($dcIdentifier as $aDc) {
										if ($aDc=='x-default'){continue;}
										if (trim($aDc)==''){continue;}																				
										$rowData .= "<tr class=\"dcIdentifierRow\"><td>Identifier</td><td><input type=\"text\" id=\"dcIdentifier$counter\" name=\"dcIdentifier$counter\" value=\"$aDc\" /><a class=\"addNewDCField\" title=\"Add another Identifier field.\" href=\"#dcIdentifier\"><img src=\"fieldAdd.png\"/></a>&nbsp;<a class=\"removeDCField\" title=\"Remove this Identifier field.\" href=\"#dcIdentifier\"><img src=\"fieldRemove.png\"/></a></td></tr>";										
										$counter=$counter+1;
									}																			
								}
								
								echo $rowData;
								$rowData='';								
							?>           
                            <? if (count($dcSource)==0)
								{
								
									$rowData = "<tr class=\"dcSourceRow\"><td>Source</td><td><input type=\"text\" id=\"dcSource\" name=\"dcSource\" /><a class=\"addNewDCField\" title=\"Add another Source field.\" href=\"#dcSource\"><img src=\"fieldAdd.png\"/></a>&nbsp;<a class=\"removeDCField\" title=\"Remove this Source field.\" href=\"#dcSource\"><img src=\"fieldRemove.png\"/></a></td></tr>";
										
								}else{
									
									$counter = 0; 									
									foreach ($dcSource as $aDc) {
										if ($aDc=='x-default'){continue;}
										if (trim($aDc)==''){continue;}																				
										$rowData .= "<tr class=\"dcSourceRow\"><td>Source</td><td><input type=\"text\" id=\"dcSource$counter\" name=\"dcSource$counter\" value=\"$aDc\" /><a class=\"addNewDCField\" title=\"Add another Source field.\" href=\"#dcSource\"><img src=\"fieldAdd.png\"/></a>&nbsp;<a class=\"removeDCField\" title=\"Remove this Source field.\" href=\"#dcSource\"><img src=\"fieldRemove.png\"/></a></td></tr>";										
										$counter=$counter+1;
									}																			
								}
								
								echo $rowData;
								$rowData='';								
							?>        
                            <? if (count($dcLanguage)==0)
								{
								
									$rowData = "<tr class=\"dcLanguageRow\"><td>Language</td><td><input type=\"text\" id=\"dcLanguage\" name=\"dcLanguage\" /><a class=\"addNewDCField\" title=\"Add another Language field.\" href=\"#dcLanguage\"><img src=\"fieldAdd.png\"/></a>&nbsp;<a class=\"removeDCField\" title=\"Remove this Language field.\" href=\"#dcLanguage\"><img src=\"fieldRemove.png\"/></a></td></tr>";
										
								}else{
									
									$counter = 0; 									
									foreach ($dcLanguage as $aDc) {
										if ($aDc=='x-default'){continue;}
										if (trim($aDc)==''){continue;}																				
										$rowData .= "<tr class=\"dcLanguageRow\"><td>Language</td><td><input type=\"text\" id=\"dcLanguage$counter\" name=\"dcLanguage$counter\" value=\"$aDc\" /><a class=\"addNewDCField\" title=\"Add another Language field.\" href=\"#dcLanguage\"><img src=\"fieldAdd.png\"/></a>&nbsp;<a class=\"removeDCField\" title=\"Remove this Language field.\" href=\"#dcLanguage\"><img src=\"fieldRemove.png\"/></a></td></tr>";										
										$counter=$counter+1;
									}																			
								}
								
								echo $rowData;
								$rowData='';								
							?>                                                                           
                            
                            <? if (count($dcRelation)==0)
								{
								
									$rowData = "<tr class=\"dcRelationRow\"><td>Relation</td><td><input type=\"text\" id=\"dcRelation\" name=\"dcRelation\" /><a class=\"addNewDCField\" title=\"Add another Relation field.\" href=\"#dcRelation\"><img src=\"fieldAdd.png\"/></a>&nbsp;<a class=\"removeDCField\" title=\"Remove this Relation field.\" href=\"#dcRelation\"><img src=\"fieldRemove.png\"/></a></td></tr>";
										
								}else{
									
									$counter = 0; 									
									foreach ($dcRelation as $aDc) {
										if ($aDc=='x-default'){continue;}
										if (trim($aDc)==''){continue;}																				
										$rowData .= "<tr class=\"dcRelationRow\"><td>Relation</td><td><input type=\"text\" id=\"dcRelation$counter\" name=\"dcRelation$counter\" value=\"$aDc\" /><a class=\"addNewDCField\" title=\"Add another Relation field.\" href=\"#dcRelation\"><img src=\"fieldAdd.png\"/></a>&nbsp;<a class=\"removeDCField\" title=\"Remove this Relation field.\" href=\"#dcRelation\"><img src=\"fieldRemove.png\"/></a></td></tr>";										
										$counter=$counter+1;
									}																			
								}
								
								echo $rowData;
								$rowData='';								
							?>          
                            
                            <? if (count($dcCoverage)==0)
								{
								
									$rowData = "<tr class=\"dcCoverageRow\"><td>Coverage</td><td><input type=\"text\" id=\"dcCoverage\" name=\"dcCoverage\" /><a class=\"addNewDCField\" title=\"Add another Coverage field.\" href=\"#dcCoverage\"><img src=\"fieldAdd.png\"/></a>&nbsp;<a class=\"removeDCField\" title=\"Remove this Coverage field.\" href=\"#dcCoverage\"><img src=\"fieldRemove.png\"/></a></td></tr>";
										
								}else{
									
									$counter = 0; 									
									foreach ($dcCoverage as $aDc) {
										if ($aDc=='x-default'){continue;}
										if (trim($aDc)==''){continue;}																				
										$rowData .= "<tr class=\"dcCoverageRow\"><td>Coverage</td><td><input type=\"text\" id=\"dcCoverage$counter\" name=\"dcCoverage$counter\" value=\"$aDc\" /><a class=\"addNewDCField\" title=\"Add another Coverage field.\" href=\"#dcCoverage\"><img src=\"fieldAdd.png\"/></a>&nbsp;<a class=\"removeDCField\" title=\"Remove this Coverage field.\" href=\"#dcCoverage\"><img src=\"fieldRemove.png\"/></a></td></tr>";										
										$counter=$counter+1;
									}																			
								}
								
								echo $rowData;
								$rowData='';								
							?>                               
                            
                         <? if (count($dcRights)==0)
								{
								
									$rowData = "<tr class=\"dcRightsRow\"><td>Rights</td><td><input type=\"text\" id=\"dcRights\" name=\"dcRights\" /><a class=\"addNewDCField\" title=\"Add another Rights field.\" href=\"#dcRights\"><img src=\"fieldAdd.png\"/></a>&nbsp;<a class=\"removeDCField\" title=\"Remove this Rights field.\" href=\"#dcRights\"><img src=\"fieldRemove.png\"/></a></td></tr>";
										
								}else{
									
									$counter = 0; 									
									foreach ($dcRights as $aDc) {
										if ($aDc=='x-default'){continue;}
										if (trim($aDc)==''){continue;}																				
										$rowData .= "<tr class=\"dcRightsRow\"><td>Rights</td><td><input type=\"text\" id=\"dcRights$counter\" name=\"dcRights$counter\" value=\"$aDc\" /><a class=\"addNewDCField\" title=\"Add another Rights field.\" href=\"#dcRights\"><img src=\"fieldAdd.png\"/></a>&nbsp;<a class=\"removeDCField\" title=\"Remove this Rights field.\" href=\"#dcRights\"><img src=\"fieldRemove.png\"/></a></td></tr>";										
										$counter=$counter+1;
									}																			
								}
								
								echo $rowData;
								$rowData='';								
							?>                             
                            
                            

                            </table>
                            <br  style="clear:both;"/>

                            <div style="float:right; margin-right:46px;"><input type="submit" value="Embed Data" /> <input type="button" id="neverMindButton" value="Never mind" /></div>
                        
                        
                        
                        	
                        </form>
                    
                    
                    
                    
                    </div>
                    
                    
                    
                    <br style="clear:both" />

                    <br style="clear:both" />
                    
                    <?
					
									
						 
						
						$a = $b = $c = $o = "";
						$gpsLat='';
						$gpsLng='';
						$oldnameSpace = '';
						$nameSpacesFound=array();
						
						$iterator = new SXMPIterator(&$xmpmeta );	
						while($iterator->Next(&$a, &$b, &$c, &$o) == TRUE){

							
							
							if (trim($c)==''){continue;}
							if (trim($c)=='x-default'){continue;}							
							
							
							
							//make the data pretty
							$fieldName = ucwords(substr($b,strpos($b,':')+1));
							$nameSpaceProper = ucwords(substr($a,0,strpos($a,':')));
							

								

						   
						  if ($oldnameSpace!=$a){
							
							if ($oldnameSpace!=''){echo "</table>";}
							
							
							
							
							
							if (!in_array($a,$nameSpacesFound)){
								
								$counter = 0;
								$useIndex = -1;
								
								foreach ($nameSpaces as $aSpace) {
									if ($aSpace==$a){
										$useIndex = $counter;	
									}
									$counter=$counter+1;
								}				
								
								
								
								$nameSpacesTitles[$useIndex] = str_replace("<br />",' ',$nameSpacesTitles[$useIndex]);

								if ($nameSpacesTitles[$useIndex]=='Dublin Core'){
									$editLink='<a style="color:#333; font-size:16px" href="#" id="linkEditDC">[&nbsp;Edit This Data&nbsp;]</a>';	
								}else{
									$editLink='';									
								}	
								
								if ($useIndex==-1){
								
					
									
								?>
                                
                                <br /><br />
                                
                                
                                
                                
                                <div class="headerTitle"><img src="logos_unkown.png" title="<?=$nameSpaceProper?>"><? echo $nameSpaceProper . '(' . $a . ')';?></div> 
                                <table class="dataTable" id="NSTable<?=$useIndex?>">
                                
                                
                                <?					
									
								}else{
								
								?>	
                                
                                <br /><br />
                                <div class="headerTitle"><img src="<?=$nameSpacesLogos[$useIndex]?>" title="<?=$nameSpacesTitles[$useIndex]?>"><span><?=$nameSpacesTitles[$useIndex]?>&nbsp;&nbsp;<?=$editLink?></span></div>
                                <table class="dataTable" id="NSTable<?=$useIndex?>">
                                
                                
                                <?									
									
								}
								
								
								array_push($nameSpacesFound, $a);
								$oldnameSpace=$a;
								
								
								
							}		  
							  
						  }  
 
						  
						  //output the fields
						  
						  $gpsText='';
						  
						  if (strpos(strtolower($fieldName),'latitude')!==false){
							  
							  if (strpos(strtolower($c),',')!==false){
								  
								  
								 
								 list($deg, $min, $sec) = split(',',$c,3);
								 
								$deg = str_ireplace('n','',$deg);
								$min = str_ireplace('n','',$min);
								$sec = str_ireplace('n','',$sec);																
								 
								 $gpsLat="N " . $deg . "° $min.$sec";
								 
								 if ($gpsLat!=''&&$gpsLng!=''){
									 
									 $url = urlencode("$gpsLat $gpsLng");
									 $gpsText="<a href=\"http://maps.google.com/maps?q=$url\">View GPS Location on Google Maps</a>";
								 }
								  
								  
							  }
							  
							  
						  }
						  if (strpos(strtolower($fieldName),'longitude')!==false){
							  
							  if (strpos(strtolower($c),',')!==false){
								  
								 list($deg, $min, $sec) = split(",", $c);		
								$deg = str_ireplace('w','',$deg);
								$min = str_ireplace('w','',$min);
								$sec = str_ireplace('w','',$sec);
																	 						 
								 $gpsLng="W " . $deg . "° $min.$sec";
								 
								 if ($gpsLat!=''&&$gpsLng!=''){
									 
									 $url = urlencode("$gpsLat $gpsLng");
									 $gpsText="<a href=\"http://maps.google.com/maps?q=$url\">View GPS Location on Google Maps</a>";
								 }
								  
								  
							  }
							  
							  
						  }						  
						  
						  
						  echo "<tr><td class=\"tableFieldName\">$fieldName</td><td class=\"tableData\">$c</td></tr>";
						  
						  if ($gpsText!=''){
							  
							  echo "<tr><td class=\"tableFieldName\">GPS Location</td><td class=\"tableData\">$gpsText</td></tr>";
							  
							  
						  }
						  
						  
						  
						  
						  
						}					
					
					 
					 	if ($oldnameSpace!=''){echo "</table>";}
					
					?>
                    
                    
                            
                </div>
            
      
            
            
            
            
            
            <? } ?>
		
        
        
        <? }elseif (isset($_REQUEST['omeka'])){	 ?>
        
        	<style type="text/css">
            
            	h1{font-size:28px;}
				
            	ul{font-size:16px;}
				li{margin-left:30px; list-style:disc; padding:2px;}
			
				#actionBox{
					
					
					border-style:solid;
					border-width:2px;
					border-color:#7A6A53;
					background-color:#7A6A53;
					color:#FFF;
					-webkit-border-radius: 6px; -moz-border-radius: 6px; border-radius: 6px;
					padding:10px;
					width:412px;
					max-width:415px;
					padding-right:0px;
					
				}
            
            </style>
        
        
        	<h1>Embedded Data Awareness in Digital Archives</h1><br /><br />

        
        	<div style="width:54%; float:left;">
                <h1>What:</h1><br />
    
                <ul>
                    <li>Implements <a href="http://www.adobe.com/products/xmp/">Adobe XMP</a> embedded metadata in the <a href="http://omeka.org/">Omeka</a> digital archive system.</li>
                    <li>When an image is added to the archive if it contains an embedded Dublin Core record it will automatically load that information into the Omeka database.</li>
                    <li>When the Omeka record is changed the embedded metadata is updated in the original file as well as all of its derivatives  (thumbnails, etc).</li>
                    <li>The embedded data reflect what is in the system and vice versa.</li>
               
                </ul>
                <br /><br />
    
    
                <h1>Why:</h1><br />
                <ul>
                    <li>To demonstrate the advantage of having and maintaining descriptive embedded metadata in the digital asset.</li>
                    <li>The images become their own metadata repository.</li>
                    <li>Reduces data input and errors. Provides interoperability.</li>
                    <li>Contributes to the growing semantic nature of the Internet by allowing digital assets to be self-describing.</li>
                </ul>
                <br /><br />

                
                <h1>How:</h1><br />
                <ul>
                    <li>Relies on <a href="http://xmpphptoolkit.sourceforge.net/">XMP PHP Toolkit</a> to interact with XMP data.</li>
                    <li>Utilizes Omeka's plugin system extend its functionality.</li>
                </ul>
                
                
                <br /><br />

                
                <h1>Files:</h1><br />
                <ul>
                	<li>This is a very early plugin, it likely has many bugs and is intended as a demonstration.</li>
                    <li>You *MUST* have <a href="http://xmpphptoolkit.sourceforge.net/">XMP PHP Toolkit</a> installed on the host of the Omeka installation for the plugin to work.</li>
                    <li><a href="http://www.embedmydata.com/EmbeddedData.zip">Download plugin.</a></li>
                </ul>
                
                                
                <br />

                   
			</div>            
            
            
           	<div style="width:45%; float:right;">
            	<div id="actionBox">
                
                	<a style="color:#FFF; font-size:16px; text-decoration:underline;" href="http://www.embedmydata.com/omeka/admin/">Visit Online Demo</a>  -- For instructions view the presentation below.

                
                </div>
                
                <div style="text-align:center;">
             <div style="width:425px;" id="__ss_9132803"><strong style="display:block;margin:12px 0 4px"><a href="http://www.slideshare.net/thisismattmiller/embedded-data-awareness-in-digital-archives-demo" title="Embedded data awareness in digital archives demo">Embedded data awareness in digital archives demo</a></strong><object id="__sse9132803" width="425" height="355"><param name="movie" value="http://static.slidesharecdn.com/swf/ssplayer2.swf?doc=embeddeddataawarenessindigitalarchivesdemo-110904235930-phpapp01&stripped_title=embedded-data-awareness-in-digital-archives-demo&userName=thisismattmiller" /><param name="allowFullScreen" value="true"/><param name="allowScriptAccess" value="always"/><embed name="__sse9132803" src="http://static.slidesharecdn.com/swf/ssplayer2.swf?doc=embeddeddataawarenessindigitalarchivesdemo-110904235930-phpapp01&stripped_title=embedded-data-awareness-in-digital-archives-demo&userName=thisismattmiller" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="425" height="355"></embed></object><div style="padding:5px 0 12px">View more <a href="http://www.slideshare.net/">presentations</a> from <a href="http://www.slideshare.net/thisismattmiller">thisismattmiller</a>.</div></div>
                     </div>  
            
            
            </div>
        
        	<br style="clear:both" />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />        


        
        <? }else{ ?>    
        
        
        
        	<div id="actionBoxFrontPage">NEW!<br /><br />Embedded Data Awareness in a Digital Archive<br /><br /><a href="/?omeka" style="color:#FFF; font-size:16px; text-decoration:underline;"> Online Demonstration</a></div>
    
            <div class="titleHeader"><img src="step1.png" /></div>
        
        
            <div id="uploadPhotoBox">
            
                <div id="upload"></div>
            
            </div>
            
			<div class="titleHeader"><img src="step2.png" style="float:left;" />
            
           	 <div id="urlHolder"><div id="urlTextHolder"><input type="text" id="urlTextBox" value="Enter full URL to an image or PDF here" /></div><div id="okayGo"></div></div>
            
            </div><br />

            
			<br style="clear:both;" /><br /><br /><br /><br />


            <div class="titleHeader">
            
            <img src="step3.png" style="float:left;" /><br style="clear:both;" /><br /><br />




            
            	<div style="margin:auto; text-align:center;">
                
                	<div style="float:left;  margin:10px;"><a href="?analyze=jpg&idTag=<?=genRandomString()?>&url=http://embedmydata.com/example1.jpg"><img src="example1.jpg" style="height:200px;" /><br /></a>Dublin Core &amp; VRA Core <br />example created by <br /><a href="http://metadatadeluxe.pbworks.com">Embedded Metadata Working Group</a></div>
                	<div style="float:left;  margin:10px;"><a href="?analyze=jpg&idTag=<?=genRandomString()?>&url=http://embedmydata.com/example2.jpg"><img src="example2.jpg" style="height:200px;" /><br /></a>Dublin Core &amp; VRA Core <br />example created by <br /><a href="http://metadatadeluxe.pbworks.com">Embedded Metadata Working Group</a></div>                    
                	<div style="float:left;  margin:10px;"><a href="?analyze=jpg&idTag=<?=genRandomString()?>&url=http://embedmydata.com/example3.jpg"><img src="example3.jpg" style="height:200px;" /><br /></a>ArtStor Core<br />example created by <br /><a href="http://metadatadeluxe.pbworks.com">Embedded Metadata Working Group</a></div>                    
                	<div style="float:left;  margin:10px;"><a href="?analyze=jpg&idTag=<?=genRandomString()?>&url=http://embedmydata.com/example4.jpg"><img src="example4.jpg" style="height:200px;" /><br /></a>Device EXIF Data<br /></div>                                        
                    
                </div>
            
            </div>
            <br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />

		<? } ?>    
    
    
    
    
    
    </div>


	
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-10371295-4']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>