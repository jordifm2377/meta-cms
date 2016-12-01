<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />

    <script type="text/javascript" src="<?php echo APP_BASE?>/jss/utils.js"></script>
    <link rel="stylesheet" href="<?php echo APP_BASE?>/csss/editora.css" type="text/css" />
    <!-- compliance patch for microsoft browsers -->
    <!--[if lt IE 7]><script src="/jss/ie7/ie7-standard-p.js" type="text/javascript"></script><![endif]-->
    <!--[if lt IE 7]><link rel="stylesheet" type="text/css" href="/csss/ie6.css" media="screen"/><![endif]-->
    <!--[if lte IE 7]><link rel="stylesheet" type="text/css" href="/csss/ie.css" media="screen"/><![endif]-->

    <link rel="shortcut icon" href="/images/favicon.ico"/>
    <script type="text/javascript">
        <!--
        function sf(){document.Form_login.p_username.focus();}
        // -->
    </script>
    <title>Editora 4.2 - Login - <?php echo $title ?></title>
</head>
<body onLoad="sf()">

    <!-- HEADER -->
    <div id="header">
        <!-- BOTTOM -->
    	<div class="head_bottom head_login">
        	<div class="wrapper">
            	<h1><?php echo getMessage('site_login_title') ?> <strong><?php echo $title ?></strong></h1>
            </div>
        </div>
        <!-- /end BOTTOM -->
    </div>
    <!-- /end HEADER -->

    <!-- CONTENT -->
    <div id="content">

    	<!-- CAIXA LOGIN -->
        <div class="login wrap" id="editora_container">

            <!-- FORMULARI -->
        	<form method="post" action="<?php echo APP_BASE;?>/login" name="Form_login" class="form">
            	<fieldset>
                    <legend><?php echo getMessage('site_login_session') ?></legend>
                    <span class="split"></span>
                    <div>
                        <input type="hidden" name="p_action" value="login"/>
                        <p>
                            <label for="p_username"><?php echo getMessage('login_label_username');?>:</label>
                            <input type="text" name="p_username" size="10" id="p_username" />
                        </p>
                        <p>
                            <label for="p_password"><?php echo getMessage('login_label_password');?>:</label>
                            <input type="password" name="p_password" size="10" id="p_password" />
                        </p>
                        <p>
                            <label for="u_lang"><?php echo getMessage('login_label_language');?>:</label>
                            <select name="u_lang" onChange="javascript:changeLang(this.options[this.selectedIndex].value)" id="u_lang">
                                 <option value="">&nbsp;</option>
                                    <?php foreach ($array_langs as $menu_lang) {
										echo '<option '.selectedTrue($lg, $menu_lang).' value="'.$menu_lang.'">'.getMessage('language_choose_'.$menu_lang).'</option>';
                                    } ?>
                            </select>
                        </p>
                        <p class="btn"><input type="submit" value="<?php echo getMessage('login_label_submit');?>" title="<?php echo getMessage('login_label_submit');?>" /></p>
                    </div>
                </fieldset>
            </form>
            <!-- /end FORMULARI -->

            <!-- MISSATGE FORMULARI -->
           <?php  if($message!=""){ ?>
            <div id="editora_login" class="message">
            	<span class="arrow"></span>
            	<div class="linea_login_msg">
                	<span class="ico" title="Atenció!">Atenció!</span><p><?php echo $message ?></p>
                        <?php if(!strstr("MSIE 6", $_SERVER["HTTP_USER_AGENT"])===false) {
                                echo '<div class="pre_ie6">
                                        <div class="ie6">
                                                <img title="Alert" alt="alert" src="/admin/images/alert2.gif" />
                                                <p>'.getMessage('msie6').'</p>
                                        </div>
                                </div>';
                        }
                        ?>
                </div>
            </div>
            <!-- MISSATGE FORMULARI -->
             <?php  } ?>

        </div>
    	<!-- /end CAIXA LOGIN -->

    </div>
    <!-- /end CONTENT -->
    <!-- FOOTER -->
    <div id="footer">
    	<div class="wrapper">
        	<h2><a href="/" title="Omatech">Omatech</a></h2>
            <ul>
            	<li><a href="http://www.omatech.com" title="www.omatech.com">www.omatech.com</a></li>
            	<li><a href="mailto:info@omatech.com" title="info@omatech.com">info@omatech.com</a></li>
            	<li><span>93 219 77 63</span></li>
            </ul>
        </div>
    </div>
    <!-- /end FOOTER -->
</body>

</html>