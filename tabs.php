<!--tabs-->
<div class=flex id=tabs>
	<button tab=statement class=active>Statement</button>
	<button tab=implement >Implementation</button>
	<script>
		//add listeners
		(function(){
			var btns=document.querySelectorAll('#tabs button[tab]');
			for(var i=0;i<btns.length;i++){
				btns[i].onclick=function(){activateTab(this.getAttribute('tab'))};
			}
		})();
		function activateTab(tab){
			//all invisible
			var btns=document.querySelectorAll('#tabs button[tab]');
			for(var i=0;i<btns.length;i++){
				btns[i].classList.remove('active');
				var id=btns[i].getAttribute('tab');
				document.getElementById(id).classList.add('invisible');
			}
			//visible
			//button.tab == div.id
			document.querySelector('#tabs button[tab='+tab+']').classList.add('active');
			document.getElementById(tab).classList.remove('invisible');
		}
	</script>
	<style>
		#tabs {
			margin-left:0.5em;
		}
		#tabs button {
			display:block;
			padding:0.5em;
			background:#fafafa;
			border:1px solid #ccc;
			border-bottom:none;
			box-shadow: 0 0 4px 2px rgba(0,0,0,.3) inset;
		}
		#tabs button.active {
			background:white;
			box-shadow:none;
		}
	</style>
</div>
