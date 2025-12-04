<?php 
  require_once BB_DIR_PATH . 'templates/store.php';
?>

<div id="bb-dashboard-post" class="bb-dashboard-section">
    <h4 class="bb-section-title">
        Database Overview
    </h4>
    <div class="bb-desh-card-wrap">
        <div class="bb-desh-card__single">
            <span class="bb-desh-card__title">DB Size</span>
            <span class="bb-desh-card__count">
               <?php echo $db_size; ?>
            </span>
        </div>

        <div class="bb-desh-card__single">
            <span class="bb-desh-card__title">Tables</span>
            <span class="bb-desh-card__count">
              <?php echo $db_tables; ?>
            </span>
        </div>

        <div class="bb-desh-card__single">
            <span class="bb-desh-card__title">Options</span>
            <span class="bb-desh-card__count">
              <?php echo $db_option; ?>
            </span>
        </div>

        <div class="bb-desh-card__single">
            <span class="bb-desh-card__title">Transients</span>
            <span class="bb-desh-card__count">
               <?php echo $db_transist; ?>
            </span>
        </div>
    </div>
   <!--- table start from here ---->
</div>
