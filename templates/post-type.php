<?php 
  require_once BB_DIR_PATH . '/includes/PostType.php';
  $get_post_types = new Post_Type();
  $get_details    = $get_post_types->get_all_details();
  
  // assign the all value in varable for view
  $post_types_count = count($get_details['registered']);
  $total_post       = $get_details['total_posts'];
  $post_meta_total  = $get_details['post_meta_total'];
  $revisions        = $get_details['revisions'];


  echo '<pre>';
   print_r($get_details);
  echo '<pre>';
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
                            <span class="bb-data-count">2</span>
                            <span class="bb-data-progress-wrapper">
                                <span class="bb-data-progress" style="width: 40%;"></span>
                            </span>
                        </span>
                    </td>
                    <td>
                        <span class="bb-data-wrapper">
                            <span class="bb-data-count">2</span>
                            <span class="bb-data-progress-wrapper">
                                <span class="bb-data-progress" style="width: 50%;"></span>
                            </span>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>Post</td>
                    <td>
                        <span class="bb-data-wrapper">
                            <span class="bb-data-count">1</span>
                            <span class="bb-data-progress-wrapper">
                                <span class="bb-data-progress" style="width: 20%;"></span>
                            </span>
                        </span>
                    </td>
                    <td>
                        <span class="bb-data-wrapper">
                            <span class="bb-data-count">0</span>
                            <span class="bb-data-progress-wrapper">
                                <span class="bb-data-progress" style="width: 0%;"></span>
                            </span>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>Wp_navigation</td>
                    <td>
                        <span class="bb-data-wrapper">
                            <span class="bb-data-count">1</span>
                            <span class="bb-data-progress-wrapper">
                                <span class="bb-data-progress" style="width: 20%;"></span>
                            </span>
                        </span>
                    </td>
                    <td>
                        <span class="bb-data-wrapper">
                            <span class="bb-data-count">0</span>
                            <span class="bb-data-progress-wrapper">
                                <span class="bb-data-progress" style="width: 0%;"></span>
                            </span>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>Elementor_library</td>
                    <td>
                        <span class="bb-data-wrapper">
                            <span class="bb-data-count">1</span>
                            <span class="bb-data-progress-wrapper">
                                <span class="bb-data-progress" style="width: 20%;"></span>
                            </span>
                        </span>
                    </td>
                    <td>
                        <span class="bb-data-wrapper">
                            <span class="bb-data-count">0</span>
                            <span class="bb-data-progress-wrapper">
                                <span class="bb-data-progress" style="width: 0%;"></span>
                            </span>
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
