<?php
echo '	<div class="container" style="height:121px;">
		<div class="menu">
			<ul>
				<li class="current">积分兑换</li>
			</ul>
		</div>
            
		<div class="content">
		<ul>
			<li>
				<div class="info">
					<dl class="dhleft">
							<dd ';echo $this->iff($this->scoretype=='current','class="current img01"');echo '><a class="cai" href="/index.php/score/goods/current/all">正在活动</a></dd>
							<dd ';echo $this->iff($this->scoretype=='old','class="current img01"');echo '><a class="cai" href="/index.php/score/goods/old/all">往期活动</a></dd>
							<dd ';echo $this->iff($this->scoretype=='me','class="current img01"');echo '><a class="cai"  href="/index.php/score/goods/me/current">我参与的活动</a></dd>
					</dl>
				</div>
			</li>
		</ul>
		</div>
	</div>
';
?>