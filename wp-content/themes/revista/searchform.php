<?php
  $placeholder = (is_search() || is_page('buscador')) ? 'Ingresa el término de búsqueda o el autor aquí' : 'Buscar';
?>

<form action="<?php echo home_url(); ?>" method="GET" class="Form Form--search">
  <div class="input-group">
    <input type="text" name="s" id="s" class="form-control" placeholder="<?php echo $placeholder; ?>">
    <span class="input-group-btn">
      <button class="btn btn-default" type="button"><span class="Form-icon"></span></button>
    </span>
  </div><!-- /input-group -->
</form><!-- end Form--search -->
