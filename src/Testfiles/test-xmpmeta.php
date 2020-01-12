<?php  

SXMPFiles::Initialize();
$xmpfiles = new SXMPFiles();
$xmpmeta = new SXMPMeta();

$xmpfiles->OpenFile('Image1.jpg');
$xmpfiles->GetXMP( $xmpmeta );

echo "Photoshop original source : ".$xmpmeta->GetProperty(SXMPMeta::kXMP_NS_Photoshop, "Source" )."\n";
$xmpmeta->SetProperty(SXMPMeta::kXMP_NS_Photoshop, "Source", "XMP PHP Toolkit by Mathias VITALIS", 0);
echo "Photoshop modified source : ".$xmpmeta->GetProperty(SXMPMeta::kXMP_NS_Photoshop, "Source" )."\n";

//sort the data model of the XMP object into a canonical order
$xmpmeta->Sort();

//Serialize and show the full xmp header
$buffer = $xmpmeta->SerializeToBuffer(0,0);
print_r($buffer);

//Can we put the modified XMP to the file ?
if ($xmpfiles->CanPutXMP( $xmpmeta)){
  
  // We put the modified XMP object to the file
  echo "\nPutting XMP to the file...\n";
  $xmpfiles->PutXMP($xmpmeta);
}

echo "Close the file.\n";
$xmpfiles->CloseFile();



