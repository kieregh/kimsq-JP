<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
    <div class="container">
        <div class="drawer-inner">
            <?php if($my['uid']):?>
            <ul class="nav navbar-nav navbar-form">
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown"><img src="<?php echo $g['s']?>/_var/avatar/<?php echo $my['photo']?$my['photo']:'0.gif'?>" width="35" height="35" class="img-circle">
						<?php echo $my[$_HS['nametype']]?>
						<b class="caret"></b>
					</a>
                    <ul class="dropdown-menu">
						<li><a href="#."><span class="glyphicon glyphicon-lock"></span> <?php echo _LANG('s2001','xlayout')?></a></li>
						<li><a href="#."><span class="glyphicon glyphicon-user"></span> <?php echo _LANG('s2002','xlayout')?></a></li>
						<li class="divider"></li>
						<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;a=logout"><span class="glyphicon glyphicon-log-out"></span> <?php echo _LANG('s2003','xlayout')?></a></li>
                    </ul>
                </li>
            </ul>
			<?php if($d['layout']['header_notify']=='true'):?>
            <div class="navbar-form">
                <a class="btn btn-default navbar-btn btn-block rb-notifications-modal" role="button" data-toggle="modal" data-target="#modal_window">
					<i class="fa fa-bell-o fa-lg fa-fw"></i> <?php echo _LANG('s2004','xlayout')?> 
					<span id="rb-notification-badge" class="badge"><?php echo $my['num_notice']?></span>
				</a> 
            </div>
			<?php endif?>
            <?php elseif($d['layout']['header_login']=='true'):?>
            <div class="navbar-form">
                <a href="#" class="btn btn-default btn-block navbar-btn rb-modal-login" role="button" data-toggle="modal" data-target="#modal_window"><i class="fa fa-sign-in fa-lg"></i> <?php echo _LANG('s2005','xlayout')?></a>
            </div>
            <?php endif?>

            <ul class="nav navbar-nav navbar-form">
                <li><a href="<?php echo RW(0)?>" class="rb-sidebar-close"><i class="fa fa-home fa-lg"></i> Home</a></li>
				<?php getWidget('default/mk-menu-default',array('smenu'=>'0','limit'=>'2','dropdown'=>'1','dispfmenu'=>'1','mobile'=>'1'))?>
            </ul>

            <?php if($my['admin']):?>
            <a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=admin&amp;module=dashboard&amp;front=mobile.shortcut" class="btn btn-default btn-block navbar-btn rb-sidebar-close">
				<i class="fa fa-user fa-lg"></i> <?php echo _LANG('s2006','xlayout')?>
			</a>
            <?php endif?>
            <button type="button" class="btn btn-primary btn-block navbar-btn rb-sidebar-close"><i class="fa fa-times"></i> <?php echo _LANG('s2007','xlayout')?></button>
        </div>
    </div>
</nav> 

