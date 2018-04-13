<h3>Richiesta Report</h3>

<p>Inserisci l'intervallo di data e ora </p>

<div class="col-md-12">


    <form method="POST" class="col-md-6" action="<?php echo base_url('RichiestaReport'); ?>">

        <label for="range">Data inizio e fine: </label>
        <input id="range" type="text" name="range" class="form-control">

        <input type="hidden" name="dataDa" id="dataDa">
        <input type="hidden" name="dataA" id="dataA">
        <input class="btn btn-primary" type="submit" value="Richiedi report">
        <input class="btn btn-default" type="reset" value="Reset date">
    </form>

</div>



<div class="col-md-6">
    <h4>Lista Rilevazioni</h4>
    <table class='table table-responsive'>
        
        <tr>
            <th>Sensore</th>
            <th>Impianto</th>
            <th>Data e ora</th>
            <th>Valore</th>
            <th>Note</th>
        </tr>
        
        <?php foreach ($rilevazioni as $rilevazione): ?>
        
            <tr>
                <td><?php echo $rilevazione->sensore ; ?></td>
                <td><?php echo $rilevazione->impianto ; ?></td>
                <td><?php echo $rilevazione->dataOra ; ?></td>
                <td><?php echo $rilevazione->valore ; ?></td>
                <td><?php echo $rilevazione->note ; ?></td>
            </tr>
        <?php endforeach; ?>
    
    </table>
</div>

<div class="col-md-6">
    <h4>Lista Eccezioni</h4>
    <table class='table table-responsive'>
        
        <tr>
            <th>Sensore</th>
            <th>Impianto</th>
            <th>Data e ora</th>
            <th>Note</th>
        </tr>
        
        <?php foreach ($eccezioni as $eccezione): ?>
        
            <tr>
                <td><?php echo $eccezione->sensore ; ?></td>
                <td><?php echo $eccezione->impianto ; ?></td>
                <td><?php echo $eccezione->dataora ; ?></td>
                <td><?php echo $eccezione->note ; ?></td>
            </tr>
        <?php endforeach; ?>
    
    </table>
</div>

<script>


$(function() {
    moment.locale('it');
    var start = moment().subtract(1, 'days');
    var end = moment();

    function cb(start, end) {
        $('#dataDa').val(start.format('YYYY-MM-DD')+' 00:00:00');
        $('#dataA').val(end.format('YYYY-MM-DD')+' 23:59:59');
    }

    $('#range').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Oggi': [moment(), moment()],
           'Ieri': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Ultimi 7 giorni': [moment().subtract(6, 'days'), moment()],
           'Ultimi 30 giorni': [moment().subtract(29, 'days'), moment()],
           'Questo mese': [moment().startOf('month'), moment().endOf('month')],
           'Ultimo mese': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);
    
});

</script>