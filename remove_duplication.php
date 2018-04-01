<?php
    /**
     * @author Webfairy MediaT CMS - www.Webfairy.net
     */
    include dirname(__FILE__).'/lib/engine.php';
        $Webfairy = new Webfairy();
            $Webfairy->start();
            
            
            
   $duplication = $Webfairy->db->posts()
        ->select('`hash`')
        ->group('`hash`','count( id ) > 1')
        ->order('`id` DESC');            

    foreach ($duplication as $item) {
        $i = 1;
        foreach ($Mubashier->db->posts('hash',$item['hash']) as $id => $row) {
            if($i <> 1){
                $Webfairy->delete_post($id);
                echo "{$row['title']}'<br />";
            }
            $i++;	
        }            

    }             