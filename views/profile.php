<div class="col-md-6 col-lg-4 col-sm-12">
    

    
    <div class="box box-widget widget-user">
        <!-- Add the bg color to the header using any of the bg-* classes -->
        <div class="widget-user-header bg-aqua-active">
          <h3 class="widget-user-username"><?php echo $user["name"] ?></h3>
          <h5 class="widget-user-desc"><?php echo $user["role"] ?></h5>
        </div>
        <div class="widget-user-image">
          <img class="img-circle" src="<?php echo $user["image"] ?>" alt="User Avatar">
        </div>
        <div class="box-footer">
          <div class="row">
            <div class="col-sm-6 border-right">
                <div class="description-block">
                    <h5 class="description-header">Nome completo</h5>
                    <span class="description-text"><?php echo $user["fullname"] ?></span>
                </div>
            </div> 
            <div class="col-sm-6">
                <div class="description-block">
                    <h5 class="description-header">Data iscrizione</h5>
                    <span class="description-text"><?php echo date("d/m/Y") ?></span>
                </div>
            </div>               
              
          </div>
            
          <!-- /.row -->
        </div>
    </div>
    
    
</div>
