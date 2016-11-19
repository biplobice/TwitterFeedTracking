<?php
	echo $this->Html->script('Chart');
?>

<div class="phrases index large-9 medium-8 columns content">
	<div>
		<h4>Phrases you're tracking</h4>
		<?= implode (", ", $phrases); ?>
	</div>
	
		
<?php foreach ($phrases as $key => $phrase): ?>
	<div style="padding: 20px;">
		<h3> Mentions of "<?= $phrase ?>" over last 60 minutes</h3>
	<canvas id="<?= $key ?>" height="300" width="500"></canvas>
	<script>
		var chartData = {
		    labels: <?= json_encode($data[$phrase]['labels']); ?>,
		    datasets: [
		        {
		            fillColor: "#79D1CF",
		            strokeColor: "#79D1CF",
		            data: <?= json_encode($data[$phrase]['counts']); ?>
		        }
		    ]
		};
		
		var ctx = document.getElementById("<?= $key ?>").getContext("2d");
		var myBar = new Chart(ctx).Bar(chartData, {
		    showTooltips: false,
		    onAnimationComplete: function () {
		
		        var ctx = this.chart.ctx;
		        ctx.font = this.scale.font;
		        ctx.fillStyle = this.scale.textColor
		        ctx.textAlign = "center";
		        ctx.textBaseline = "bottom";
		
		        this.datasets.forEach(function (dataset) {
		            dataset.bars.forEach(function (bar) {
		                ctx.fillText(bar.value, bar.x, bar.y - 5);
		            });
		        })
		    }
		});				
	</script>
	</div>
<?php endforeach; ?>
</div>