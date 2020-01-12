<?php

SXMPFiles::Initialize();

$xmpfiles = new SXMPFiles();
$xmpmeta = new SXMPMeta();

$xmpfiles2 = new SXMPFiles();
$xmpmeta2 = new SXMPMeta();


$xmpfiles->OpenFile('AMOMA_10312309978.jpg');
$xmpfiles->GetXMP( $xmpmeta );

$xmpfiles2->OpenFile('Image2.jpg');
$xmpfiles2->GetXMP( $xmpmeta2 );

//$exif_data = exif_read_data( '/var/www/thisismattmiller.com/web/Testfiles/Image1.jpg' );
//echo '<pre>';
//print_r($exif_data);
//echo '</pre>';


echo "</br>PREFIX : ";
echo SXMPMeta::GetNamespacePrefix(SXMPMeta::kXMP_NS_EXIF);

echo "</br>NAMESPACE : ";
echo SXMPMeta::GetNamespaceURI(SXMPMeta::GetNamespacePrefix(SXMPMeta::kXMP_NS_EXIF));

echo "</br>SET PROPERTY PDF/Producer : ";
echo $xmpmeta->SetProperty(SXMPMeta::kXMP_NS_PDF, "Producer", "Mathias")?"OK":"NOT OK";

echo "</br>SET PROPERTY PHOTOSHOP/Source: ";
echo $xmpmeta->SetProperty(SXMPMeta::kXMP_NS_Photoshop, "Source", "XMP PHP Toolkit by SilverHand", 0)?"OK":"NOT OK";

echo "</br>GET PROPERTY PHOTOSHOP/Source: ";
echo $xmpmeta->GetProperty(SXMPMeta::kXMP_NS_Photoshop, "Source");

echo "</br>GET PROPERTY XMP/ModifyDate: ";
echo $xmpmeta->GetProperty_Date(SXMPMeta::kXMP_NS_XMP,"ModifyDate");

echo "</br>SET PROPERTY XMP/DateTimeDigitized: ";
echo $xmpmeta->SetProperty_Date(SXMPMeta::kXMP_NS_EXIF, "DateTimeDigitized", date('c') )?"OK":"NOT OK";

echo "</br>SET PROPERTY DC/Title, French: ";
echo $xmpmeta->SetLocalizedText(SXMPMeta::kXMP_NS_DC, "description", '', "fr-FR", "Une description française" )?"OK":"NOT OK";


echo "</br>COUNT ARRAY ITEMS FROM DC/Title : ";
echo $xmpmeta->CountArrayItems(SXMPMeta::kXMP_NS_DC, "title");

$buffer = $xmpmeta->SerializeToBuffer(0,0);

echo "</br>SERIALIZE XMPMeta : ";
echo ($buffer);




echo "</br>MergeFromJPEG  ( Merge xmpmeta1 with xmpmeta2 ) : ";

$buffer = $xmpmeta->SerializeToBuffer(0,0);
SXMPUtils::MergeFromJPEG(&$xmpmeta, $xmpmeta2);

$buffer = $xmpmeta->SerializeToBuffer(0,0);
print_r($buffer);


echo "</br>Catenate Array Items  TIFF/BitsPerSample : ";
echo SXMPUtils::CatenateArrayItems($xmpmeta, SXMPMeta::kXMP_NS_TIFF, "BitsPerSample");

SXMPUtils::SeparateArrayItems($xmpmeta, "http://ns.adobe.com/tiff/1.0/", "BitsPerSample", "1; 2; 3; 8; 16");



echo "</br>CAN PUT XMP INTO FILE ? : ";
echo $xmpfiles->CanPutXMP( $xmpmeta)?"YES":"NO";

//echo "</br>PUT XMP INTO FILE : ";
//echo $xmpfiles->PutXMP($xmpmeta)?"OK";"ERROR";

$xmpfiles->CloseFile();
$xmpfiles2->CloseFile();

echo "</br>";
