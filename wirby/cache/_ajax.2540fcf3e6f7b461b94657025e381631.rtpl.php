<?php if(!class_exists('raintpl')){exit;}?><div class="tab-pane" id="start"><?php $tpl = new RainTPL;$tpl->assign( $this->var );$tpl->draw( "start" );?></div>
<div class="tab-pane" id="offer"><?php $tpl = new RainTPL;$tpl->assign( $this->var );$tpl->draw( "offer" );?></div>
<div class="tab-pane" id="order"><?php $tpl = new RainTPL;$tpl->assign( $this->var );$tpl->draw( "order" );?></div>
<div class="tab-pane" id="about"><?php $tpl = new RainTPL;$tpl->assign( $this->var );$tpl->draw( "about" );?></div>
<div class="tab-pane" id="where"><?php $tpl = new RainTPL;$tpl->assign( $this->var );$tpl->draw( "where" );?></div>
