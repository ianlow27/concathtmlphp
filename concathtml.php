<?php
$usage = "
  Usage: php $argv[0] [--help]\n
Version: 0.0.1-241030
  About: This PHP script concatenates all HTML pages within a directory into a single HTML file.
 Author: Ian Low | Date: 2024-10-29 | Copyright (c) 2024, Ian Low | Usage Rights: MIT License
";
if(isset($argv[1])){
  if(substr($argv[1],0,3)=="--h"){
    echo $usage;
  }
  return;
}

$currdir = getcwd();
echo "Current working directory is ". $currdir. "\n";

$dir = new DirectoryIterator($currdir); 

$allcontents="";
foreach ($dir as $fileinfo) {
  if(substr($fileinfo->getfilename(),-5,5)==".html"){ 
    if($fileinfo->getfilename()=="concathtmlphp.html") continue;
    $file = $fileinfo->getfilename();
    echo "processing $file...\n";
    $acontents = 
      explode("%%%___%%%___%%%",
        preg_replace("/<body/", "%%%___%%%___%%%<body",
          preg_replace("/<\/body>/", "</body>%%%___%%%___%%%",
            file_get_contents($file)
          )
        )
      );
    $allcontents .= 
      preg_replace("/<body/","\n<div", 
        preg_replace("/<\/body>/","</div>\n", 
          $acontents[1]
        )
      );
  }
}
file_put_contents("concathtmlphp.html", 
  "<!DOCTYPE html>\n<html>\n<body>\n". $allcontents.
  "\n</body>\n</html>" )

?>
