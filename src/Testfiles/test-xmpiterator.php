<?php  

SXMPFiles::Initialize();
$xmpfile = new SXMPFiles();
$xmpmeta = new SXMPMeta();

$xmpfile->OpenFile('VRAexample012.jpg');
$xmpfile->GetXMP( $xmpmeta );

//sort the data model of the XMP object into a canonical order
$xmpmeta->Sort();

$a = $b = $c = $o = "";

$iterator = new SXMPIterator(&$xmpmeta );

//Scan whole values, except the exif namespace

while($iterator->Next(&$a, &$b, &$c, &$o) == TRUE){
  
  //if (strcmp($a, SXMPMeta::kXMP_NS_EXIF)==0) {
  //  printf("Skipping %s ... </br>",SXMPMeta::kXMP_NS_EXIF);
  //  $iterator->Skip(SXMPIterator::kXMP_IterSkipSubtree );
  //} else {
      printf("%s | %s | %s | %x </br>", $a, $b, $c, $o);    
  //}
}
  

$xmpfile->CloseFile();
