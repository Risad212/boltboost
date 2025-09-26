<?php 
  require_once BB_DIR_PATH . 'templates/store.php';
?>

<div id="bb-dashboard-post" class="bb-dashboard-section">
    <h4 class="bb-section-title">
        Post Type &amp; Metadata Overview
    </h4>
    <p class="bb-section-disc">
        See how many posts, pages, and custom content types your site has—plus how much metadata is attached.
        <br>
        Quickly spot unused or bloated content types that may be slowing things down.
    </p>
    <div class="bb-desh-card-wrap">
        <div class="bb-desh-card__single">
            <span class="bb-desh-card__title">Post Types</span>
            <span class="bb-desh-card__count">
                <?php echo $post_types_count ?>
            </span>
        </div>

        <div class="bb-desh-card__single">
            <span class="bb-desh-card__title">Total Items</span>
            <span class="bb-desh-card__count">
                <?php echo $total_post  ?>
            </span>
        </div>

        <div class="bb-desh-card__single">
            <span class="bb-desh-card__title">Total Meta</span>
            <span class="bb-desh-card__count">
                <?php echo $post_meta_total ?>
            </span>
        </div>

        <div class="bb-desh-card__single">
            <span class="bb-desh-card__title">Revisions</span>
            <span class="bb-desh-card__count">
                <?php echo $revisions  ?>
            </span>
        </div>
    </div>

    <div class="bb-dashboard-data">
        <table class="bb-dashboard__table">
            <thead>
                <tr>
                    <th>Post Type</th>
                    <th>Total Items</th>
                    <th>Total Meta</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Page</td>
                    <td>
                        <span class="bb-data-wrapper">
                            <span class="bb-data-count"><?php echo $pages ?></span>
                            <span class="bb-data-progress-wrapper">
                                <span class="bb-data-progress" style="width: <?php echo $page_percentage ?>%;"></span>
                            </span>
                        </span>
                    </td>
                    <td>
                        <span class="bb-data-wrapper">
                            <span class="bb-data-count"><?php echo $pages_meta?></span>
                            <span class="bb-data-progress-wrapper">
                                <span class="bb-data-progress" style="width: <?php echo $page_meta_pg ?>%;"></span>
                            </span>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>Post</td>
                    <td>
                        <span class="bb-data-wrapper">
                            <span class="bb-data-count"><?php echo $posts?></span>
                            <span class="bb-data-progress-wrapper">
                                <span class="bb-data-progress" style="width: <?php echo $post_percentage ?>%;"></span>
                            </span>
                        </span>
                    </td>
                    <td>
                        <span class="bb-data-wrapper">
                            <span class="bb-data-count"><?php echo $posts_meta ?></span>
                            <span class="bb-data-progress-wrapper">
                                <span class="bb-data-progress" style="width: <?php echo $post_meta_pg  ?>%;"></span>
                            </span>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>Wp_navigation</td>
                    <td>
                        <span class="bb-data-wrapper">
                            <span class="bb-data-count"><?php echo $navigation ?></span>
                            <span class="bb-data-progress-wrapper">
                                <span class="bb-data-progress" style="width: <?php echo $navigation_percentage ?>%;"></span>
                            </span>
                        </span>
                    </td>
                    <td>
                        <span class="bb-data-wrapper">
                            <span class="bb-data-count"><?php echo $navigation_meta ?></span>
                            <span class="bb-data-progress-wrapper">
                                <span class="bb-data-progress" style="width: <?php echo $navigation_meta_pg ?>%;"></span>
                            </span>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>Elementor_library</td>
                    <td>
                        <span class="bb-data-wrapper">
                            <span class="bb-data-count"><?php echo $E_Library?></span>
                            <span class="bb-data-progress-wrapper">
                                <span class="bb-data-progress" style="width: <?php echo $E_Library_percentage ?>%;"></span>
                            </span>
                        </span>
                    </td>
                    <td>
                        <span class="bb-data-wrapper">
                            <span class="bb-data-count"><?php echo $E_Library_meta  ?></span>
                            <span class="bb-data-progress-wrapper">
                                <span class="bb-data-progress" style="width: <?php echo  $E_Library_meta_pg  ?>%;"></span>
                            </span>
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
