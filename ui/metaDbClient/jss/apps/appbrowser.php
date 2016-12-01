<?php
        //à

        require_once($_SERVER['DOCUMENT_ROOT'].'/admin/utils/appslib/Appscrapper.php');
        $_REQUEST['header']='';
        $_REQUEST['footer']='';

        $Appscrapper = new Appscrapper();
        $appURL = $_REQUEST['url'];
//        $appURL="https://itunes.apple.com/es/app/el-pais-para-ipad/id402167240?mt=8";
        //$appURL = "https://play.google.com/store/apps/details?id=jp.naver.line.android&feature=top-free#?t=W251bGwsMSwxLDIwNSwianAubmF2ZXIubGluZS5hbmRyb2lkIl0.";
        

        if(!empty($appURL)):
                 if(strpos($appURL,'itunes.apple')):                          
                         $appdata = $Appscrapper->loaditunesData($appURL);
                         $type='itunes';
                 elseif(strpos($appURL,'play.google')):                         
                           $appdata = $Appscrapper->loadgoogleplayData($appURL);
                           $type='play';
                 endif;
         endif;

       
        
         if(!empty($appdata)):

             if($type=='itunes'):
                     $appdata =json_decode($appdata);
                     echo '<div class="thumbnail">
                              <img alt="300x200"  style="width: 240px; margin-bottom: 10px;" src="'.$appdata->artworkUrl512.'">
                              <div class="caption">
                                <h3>'.$appdata->trackName.'</h3>
                                <p>'.substr($appdata->description,0,200).'...</p>
                              </div>
                            </div>';

             elseif($type=='play'):

                 $appdata =json_decode($appdata);              
                echo '<div class="thumbnail">
                              <img alt="300x200"  style="width: 124px; margin-bottom: 10px;" src="'.$appdata->General[0]->banner_icon.'">
                              <div class="caption">
                                <h3>'.$appdata->General[0]->app_title.'</h3>
                                <p>'.substr($appdata->General[0]->text_plain_app_description,0,200).'...</p>
                              </div>
                            </div>';
             endif;

         endif;       