<?php 
  require_once BB_DIR_PATH . 'templates/store.php';
?>

<div id="bb-dashboard-post" class="bb-dashboard-section">
  <h4 class="bb-section-title">
    Environment & Configuration Snapshot
  </h4>

  <p>
    Get a full snapshot of your server and WordPress setup—PHP version,
    memory limits, upload size, and more. Useful for finding
    misconfigurations that affect performance or plugin compatibility.
  </p>

  <div class="ba-dashboard__content__section__data">

    <!-- TAB NAV -->
    <ul class="ba-dashboard__tab__list">
      <li class="ba-dashboard__tab__item active" data-tab="php">PHP</li>
      <li class="ba-dashboard__tab__item" data-tab="server">Server</li>
      <li class="ba-dashboard__tab__item" data-tab="wordpress">WordPress</li>
      <li class="ba-dashboard__tab__item" data-tab="database">Database</li>
    </ul>

    <!-- TAB CONTENT -->
    <div class="ba-dashboard__tab__content">

      <!-- PHP TAB -->
      <div class="ba-dashboard__tab__panel active" id="php">
        <div class="ba-dashboard__list">
          <div class="ba-item"><span class="ba-title">PHP Version</span><span class="ba-value"><?php echo $php_version ?></span></div>
          <div class="ba-item"><span class="ba-title">SAPI</span><span class="ba-value"><?php echo $php_sapi  ?></span></div>
          <div class="ba-item"><span class="ba-title">User</span><span class="ba-value"><?php echo $php_user ?></span></div>
          <div class="ba-item"><span class="ba-title">Max Execution Time</span><span class="ba-value"><?php echo $max_execution_time ?></span></div>
          <div class="ba-item"><span class="ba-title">Memory Limit</span><span class="ba-value"><?php echo $memory_limit ?></span></div>
          <div class="ba-item"><span class="ba-title">Upload Max Filesize</span><span class="ba-value"><?php echo $upload_max_filesize ?></span></div>
          <div class="ba-item"><span class="ba-title">Post Max Size</span><span class="ba-value"><?php echo $post_max_size ?></span></div>
          <div class="ba-item"><span class="ba-title">Display Errors</span><span class="ba-value"><?php echo $display_errors ?></span></div>
          <div class="ba-item"><span class="ba-title">Log Errors</span><span class="ba-value"><?php echo $log_errors ?></span></div>
          <div class="ba-item"><span class="ba-title">extensions</span>
            <span class="ba-value">
             <?php foreach( $php_extensions as $extension ){
                  echo ' '. $extension . ',';
             } ?>
            </span>
          </div>
          <div class="ba-item"><span class="ba-title">Error Reporting</span><span class="ba-value"><?php echo $php_error_reporting ?></span></div>
        </div>
      </div>

      <!-- SERVER TAB -->
      <div class="ba-dashboard__tab__panel" id="server">
        <div class="ba-dashboard__list">
          <div class="ba-item"><span class="ba-title">Server Software</span><span class="ba-value"><?php echo $server_software ?></span></div>
          <div class="ba-item"><span class="ba-title">Operating System</span><span class="ba-value"><?php echo $server_address ?></span></div>
          <div class="ba-item"><span class="ba-title">Server IP</span><span class="ba-value"><?php echo $server_os ?></span></div>
          <div class="ba-item"><span class="ba-title">Hostname</span><span class="ba-value"><?php echo $server_host ?></span></div>
          <div class="ba-item"><span class="ba-title">HTTP Protocol</span><span class="ba-value"><?php echo $server_arch ?></span></div>
        </div>
      </div>

      <!-- WORDPRESS TAB -->
      <div class="ba-dashboard__tab__panel" id="wordpress">
        <div class="ba-dashboard__list">
          <div class="ba-item"><span class="ba-title">WordPress Version</span><span class="ba-value"><?php echo $wp_version ; ?></span></div>
          <div class="ba-item"><span class="ba-title">WP_DEBUG</span><span class="ba-value"><?php echo $wp_debug ? 'true' : 'false'; ?></span></div>
          <div class="ba-item"><span class="ba-title">WP_DEBUG DISPLAY</span><span class="ba-value"><?php echo $wp_debug_display ? 'true' : 'false' ; ?></span></div>
          <div class="ba-item"><span class="ba-title">WP_DEBUG LOG</span><span class="ba-value"><?php echo $wp_debug_log ? 'true' : 'false' ; ?></span></div>
          <div class="ba-item"><span class="ba-title">SCRIPT DEBUG</span><span class="ba-value"><?php echo $script_debug ? 'true' : 'false' ; ?></span></div>
          <div class="ba-item"><span class="ba-title">WP CACHE</span><span class="ba-value"><?php echo $wp_cache ? 'true' : 'false' ; ?></span></div>
          <div class="ba-item"><span class="ba-title">CONCATENATE SCRIPTS</span><span class="ba-value"><?php echo $concatenate_scripts ? $concatenate_scripts : 'null' ; ?></span></div>
          <div class="ba-item"><span class="ba-title">COMPRESS SCRIPTS</span><span class="ba-value"><?php echo $compress_scripts ? $compress_scripts : 'null' ; ?></span></div>
          <div class="ba-item"><span class="ba-title">COMPRESS CSS</span><span class="ba-value"><?php echo $compress_css ? $compress_css : 'null' ; ?></span></div>
          <div class="ba-item"><span class="ba-title">Environment Type</span><span class="ba-value"><?php echo $environment_type; ?></span></div>
          <div class="ba-item"><span class="ba-title">Development Mode</span><span class="ba-value"><?php echo $development_mode ? $development_mode : 'null' ; ?></span></div>
        </div>
      </div>

      <!-- DATABASE TAB -->
      <div class="ba-dashboard__tab__panel" id="database">
        <div class="ba-dashboard__list">
          <div class="ba-item"><span class="ba-title">Database Name</span><span class="ba-value"><?php echo  $database_name ?></span></div>
          <div class="ba-item"><span class="ba-title">database user</span><span class="ba-value"><?php echo  $database_user ?></span></div>
          <div class="ba-item"><span class="ba-title">Database Host</span><span class="ba-value"><?php echo  $database_host ?></span></div>
          <div class="ba-item"><span class="ba-title">server version</span><span class="ba-value"><?php echo $server_version ?></span></div>
        </div>
      </div>

    </div>
  </div>
</div>


