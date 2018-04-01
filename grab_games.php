<?php
    /**
     * @author Webfairy MediaT CMS - www.Webfairy.net
     */
     
    set_time_limit(300);


function scandir_through($dir)
{
    $items = glob($dir . '/*');

    for ($i = 0; $i < count($items); $i++) {
        if (is_dir($items[$i])) {
            $add = glob($items[$i] . '/*');
            $items = array_merge($items, $add);
        }
    }

    return $items;
}     
     
     
    include dirname(__FILE__).'/lib/engine.php';
        $Webfairy = new Webfairy();
            $Webfairy->start();


    $url = 'http://www.gamepacksfree.com/board_games.html';
    
    
    $Webfairy->loadClass('dom','tools');
    
    $html = file_get_html($url);


    foreach ($html->find('ul[id="list"]/li') as $tag) {
        $href = $tag->find('a',2)->href;
        $title = $tag->find('a',0)->plaintext;
        
        if(strpos( $href,'.zip') !== false){
            $hash = md5($title);
            
            if(!$Webfairy->db->posts('hash',$hash)->fetch()){
            
            $fname = dirname(__FILE__) . '/g/'.basename($href);
            $fp = fopen ($fname, 'w+');

            $ch = curl_init('http://www.gamepacksfree.com/'.$href);
        
            curl_setopt_array($ch, array(
            CURLOPT_URL            => 'http://www.gamepacksfree.com/'.$href,
            CURLOPT_BINARYTRANSFER => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FILE           => $fp,
            CURLOPT_TIMEOUT        => 50,
            CURLOPT_USERAGENT      => 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)'
            ));
        
        $results = curl_exec($ch);
        if(curl_exec($ch) === false)
         {
          echo 'Curl error: ' . curl_error($ch);
         }	            
            
            
            $to = dirname(__FILE__).'/x/'.$title;
            
            if(!is_dir($to)){
                mkdir($to, 0777, true);
            }
            

                $zip = new ZipArchive;
                if ($zip->open($fname) === TRUE) {
                    $zip->extractTo($to);
                    $zip->close();
                }                   
            
            
          $img = $file = '';
          
          $imgs = array();
          
          $scandir_through = scandir_through($to);
          
            foreach ($scandir_through as $filepath) {
                $xt = end(explode('.',basename($filepath)));
            	if($xt == 'swf'){
            	   $file = $filepath;
            	}
                if(strpos( $filepath,'x1') !== false){
                    $xx = explode('x',basename($filepath));
                    $imgs[$xx[0]] = $filepath;
                }
            }          
          
          $maxkey = max(array_keys($imgs));
          
          $img = $imgs[$maxkey];

          copy($file,dirname(__FILE__).'/uploads/'.basename($file));
          
          
          
          
          $img_db = $Webfairy->grabImage($img,true,true,array('title' => $title));
          
           $file_db = $Webfairy->db->files()->insert(
           array(
            'file_real_name' => basename($file),
            'file_clean_name' => basename($file),
            'file_physical_name' => basename($file),
            'file_size' => filesize($file),
            'file_mime_type' => 'application/x-shockwave-flash',
            'file_extension' => 'swf',
            'file_time' => time(),
           )
           ); 
           
               $Webfairy->db->posts()->insert(
                array(
                    'hash' => $hash,
                    'name' => $Webfairy->post_name_gen($title),
                    'type' => 3,
                    'file_id' => $file_db['id'],
                    'thumb_id' => $img_db['id'],
                    'cat_id' => 2,
                    'title' => $title,
                )
               );  
           
           
          
          

           
            }
        }
        sleep(1);

    }




