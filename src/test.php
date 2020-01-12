<?php





		$img = '/var/www/embedmydata.com/web/Testfiles/VRAexample012.jpg';
				
		SXMPFiles::Initialize();
		
		$xmpfiles = new SXMPFiles();
		$xmpmeta = new SXMPMeta();		
		$xmpfiles->OpenFile($img);
		$xmpfiles->GetXMP( $xmpmeta );



		$field='description';
		
		
		if ($xmpmeta->GetProperty(SXMPMeta::kXMP_NS_DC,$field)==''){
		
			echo "thi dhist is arry";	
			
		}else{
			
			echo $xmpmeta->GetProperty(SXMPMeta::kXMP_NS_DC,$field);
			
		}


		echo ($xmpmeta->CountArrayItems(SXMPMeta::kXMP_NS_DC, 'subject'));
		//SXMPMeta::AppendArrayItem( string $schemaNS, string $ArrayName, long $arrayOption, int $ArrayItem, string $itemValue , long $itemOptions=0 )
		$xmpmeta->AppendArrayItem(SXMPMeta::kXMP_NS_DC, 'subject', 0, 'test',0);
		echo ($xmpmeta->CountArrayItems(SXMPMeta::kXMP_NS_DC, 'subject'));
		echo $xmpmeta->GetArrayItem(SXMPMeta::kXMP_NS_DC, 'subject', 23);
		//echo ($xmpmeta->CountArrayItems(SXMPMeta::kXMP_NS_DC, 'subject'));
		//echo "<br />";
		//echo $xmpmeta->GetArrayItem(SXMPMeta::kXMP_NS_DC, 'subject', 3);












?>