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
              <?php echo $db_total_tables; ?>
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
    <div class="ba-dashboard__content__section__data">
    <table>
        <thead>
            <tr>
                <th>Table Name</th>
                <th>Rows</th>
                <th>Data Size</th>
                <th>Index Size</th>
                <th>Total Size</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach( $db_core_tables as $table ) { ?>
               <tr>
                 <td><?php echo $table['table_name'] ?></td>
                 <td><?php echo $table['row_count'] ?></td>
                 <td><?php echo $table['data_size_formatted'] ?></td>
                 <td><?php echo $table['index_size_formatted'] ?></td>
                 <td><?php echo $table['total_size_formatted'] ?></td>
              </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</div>
