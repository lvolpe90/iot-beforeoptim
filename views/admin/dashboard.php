<!-- Qui ci vanno i file del dashboard -->


<h3>Dashboard</h3>

<p>Di seguito sono mostrate le rilevazioni delle ultime 24 ore </p>

<div class='col-md-6'>
<?php foreach ($grafici as $impianto=>$grafico): ?>
<div class='col-md-12'>
    <h4><?php echo $impianto; ?></h4>
    <canvas id="grafico<?php echo md5($impianto) ?>" style="width:600px" height="100"></canvas>
</div>
<?php endforeach; ?>
</div>

<div class='col-md-6'>
    <h3>Elenco eccezioni ultime 24h</h3>
    <table class="table table-responsive">
        <tr>
        
            <th>Impianto</th>
            <th>Sensore</th>
            <th>Data e ora</th>
            <th>Note</th>
        </tr>
        <?php foreach ($eccezioni as $ecc): ?>
            <tr>
                <td><?php echo $ecc->impianto ?></td>
                <td><?php echo $ecc->sensore ?></td>
                <td><?php echo $ecc->dataora ?></td>
                <td><?php echo $ecc->note ?></td>
            </tr>

        <?php endforeach; ?>
    </table>
</div>


<script>
    Chart.defaults.global.legend = {
  enabled: true, display: true
};
    
    Array.prototype.getRandom= function(cut){
        var i= Math.floor(Math.random()*this.length);
        if(cut && i in this){
            return this.splice(i, 1)[0];
        }
        return this[i];
    }
    
var colors= ['aqua', 'black', 'blue', 'fuchsia', 'gray', 'green', 
'lime', 'maroon', 'navy', 'olive', 'orange', 'purple', 'red', 
'silver', 'teal', 'white', 'yellow'];
    
    function getHexColor(colorStr) {
        var a = document.createElement('div');
        a.style.color = colorStr;
        var colors = window.getComputedStyle( document.body.appendChild(a) ).color.match(/\d+/g).map(function(a){ return parseInt(a,10); });
        document.body.removeChild(a);
        return (colors.length >= 3) ? '#' + (((1 << 24) + (colors[0] << 16) + (colors[1] << 8) + colors[2]).toString(16).substr(1)) : false;
    }
    
    
    <?php foreach ($grafici as $impianto=>$grafico):  $id = md5($impianto); ?>
 
        var ctx<?php echo $id; ?> = document.getElementById('grafico<?php echo $id; ?>').getContext("2d");
        var myChart<?php echo $id; ?> = new Chart(ctx<?php echo $id; ?>, {

        });
    
        var clr<?php echo $id; ?> = colors.getRandom();
        <?php foreach ($grafico as $idSensore=>$serieGrafico){
    
            echo 'var ascisse'.$id.' = '. json_encode($serieGrafico->ascisse).'; ';  

        }  ?>
            var data<?php echo $id; ?> = {
                labels: ascisse<?php echo $id ?>,
                datasets: [
                    
                    <?php foreach ($grafico as $idSensore=>$serieGrafico) : ?>
                         {
                            label: '<?php echo $serieGrafico->tipoGrafico ?>',
                            data: <?php echo json_encode($serieGrafico->ordinate) ?>,
                            borderWidth: 10,
                            strokeColor: 'rgba(60,141,188,0.8)'
                            
                        }            
                    <?php if (end($grafico)!=$serieGrafico) echo ', '; endforeach; ?>
                    

                
                ]
            };
                
        $(window).resize( function () {
          
        });
        myChart<?php echo $id; ?>.Line(data<?php echo $id; ?>, {
          responsive: true,
          maintainAspectRatio: false,
          datasetFill : false,
          scaleGridLineWidth : 0,
            
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:false
                        }
                    }]
                },
                legend: { display: true, position:'top',labels: {useLineStyle: true } }
            }
          
        });
    
    <?php endforeach; ?>
    

    


</script>