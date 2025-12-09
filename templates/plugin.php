<?php 
  require_once BB_DIR_PATH . 'templates/store.php';
?>

<div id="bb-dashboard-post" class="bb-dashboard-section">
    <h4 class="bb-section-title">
       Plugin Audit
    </h4>
    <div class="bb-desh-card-wrap">
        <div class="bb-desh-card__single">
            <span class="bb-desh-card__title">Total</span>
            <span class="bb-desh-card__count">
              <?php echo $total_plugin ?>
            </span>
        </div>

        <div class="bb-desh-card__single">
            <span class="bb-desh-card__title">Active</span>
            <span class="bb-desh-card__count">
               <?php echo $activate_plugin ?>
            </span>
        </div>

        <div class="bb-desh-card__single">
            <span class="bb-desh-card__title">Inactive</span>
            <span class="bb-desh-card__count">
              <?php echo $inactive_plugin ?>
            </span>
        </div>

        <div class="bb-desh-card__single">
            <span class="bb-desh-card__title">Abandoned</span>
            <span class="bb-desh-card__count">
                <?php echo $abandoned_plugin ?>
            </span>
        </div>
    </div>

    <div class="ba-dashboard__content__section__data plugin_table">
    <table>
        <thead>
            <tr>
                <th>Plugin Name</th>
            </tr>
        </thead>

        <tbody>
           <?php foreach( $all_plugin_info as $plugin ) { ?>
                <tr>
                    <td><?php echo $plugin[ 'name' ]; ?> 
                      <span class="plugin-badge <?php echo $plugin['is_active'] ? 'active' : 'inactive' ?>">active</span>
                    </td>
                </tr>
           <?php } ?>
        </tbody>
    </table>
</div>

</div>
