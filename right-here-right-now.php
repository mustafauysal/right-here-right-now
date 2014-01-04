<?php
/*
Plugin Name: Right Here Right Now
Plugin URI: http://wordpress.org/plugins/right-here-right-now
Description: Replace wordpress right now widget with right-here-right-now plugin.
Version: 1.1.1
Author: Mustafa UYSAL
Author URI: http://uysalmustafa.com
License:GPLv2 or later
Network: True
*/

// if you want to use right now widget set it false
$remove_right_now = true;

/** Hooks **/
add_action('admin_enqueue_scripts', 'rhrn_charts_js');
add_action('admin_head', 'rhrn_legacy_chart');
add_action('wp_dashboard_setup', 'rhrn_dashboard_widget');
add_action('in_admin_footer', 'rhrn_draw_chart');




if ($remove_right_now) {
    add_action('wp_dashboard_setup', 'rhrn_remove_dashboard_right_now');
}

function rhrn_remove_dashboard_right_now() {
    global $wp_meta_boxes;
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
}

/**
 * Load Chart js
 * @link http://www.chartjs.org/ Easy, object oriented client side graphs for designers and developers
 */
function rhrn_charts_js() {
    wp_register_script('chartjs', plugins_url('/js/Chart.min.js', __FILE__));
    wp_enqueue_script('chartjs');
}

/**
 * Js hack for older browsers
 */
function rhrn_legacy_chart() {
    echo '<!--[if lte IE 8]> <script src="' . plugins_url("/js/excanvas.js", __FILE__) . '"></script><![endif]-->';
}

    
function rhrn_dashboard_widget() {
    /**
     * Check user capability,
     */
    if (current_user_can('edit_pages')) {
        wp_add_dashboard_widget('right_here_right_now', __('Right Now'), 'right_here_right_now');
    }
}

function right_here_right_now() {
	echo '<table><tr><td><div id="post-stats">
	<div id="chartbg" style="border-radius:100%;background-color:#242628;height:84px;width:84px;position:absolute;margin-left:48px;margin-top:48px;border:#fff 3px solid;text-align:center;">
	<br/>
	<a href="edit.php?post_status=publish"><span class="item"  style="color:#9fbb58;font-size:12px;line-height:14px;">' . wp_count_posts()->publish . '</span> <span style="color:white;vertical-align:text-bottom;font-size:12px;">' . __( 'Published' ) . '</span></a><br/>
	<a href="edit.php?post_status=draft"><span class="item"  style="color:#f9e15d;font-size:12px;line-height:14px;">' . wp_count_posts()->draft . '</span> <span style="color:white;vertical-align:text-bottom;font-size:12px;">' . __( 'Draft' ) . '</span></a><br/>
	<a href="edit.php?post_status=trash"><span class="item"  style="color:#e25440;font-size:12px;line-height:14px;">' . wp_count_posts()->trash . '</span> <span style="color:white;vertical-align:text-bottom;font-size:12px;">' . __( 'Trash' ) . '</span></a>
	</div>
	<canvas id="canvas-post" height="185"  width="185"></canvas><br/>
	</div></td>';


	echo '<td><div id="comment-stats" >
	<div id="chartbg" style="border-radius:100%;background-color:#242628;height:84px;width:84px;position:absolute;margin-left:48px;margin-top:48px;border:#fff 3px solid;text-align:center;">
	<br/>
	<a href="edit-comments.php?comment_status=approved"><span class="item"  style="color:#9fbb58;font-size:12px;line-height:14px;">' . wp_count_comments()->approved . '</span> <span style="color:white;vertical-align:text-bottom;font-size:12px;">' . __( 'Approved' ) . '</span></a><br/>
	<a href="edit-comments.php?comment_status=moderated"><span class="item"  style="color:#f9e15d;font-size:12px;line-height:14px;">' . wp_count_comments()->moderated . '</span> <span style="color:white;vertical-align:text-bottom;font-size:12px;">' . __( 'Pending' ) . '</span></a><br/>
	<a href="edit-comments.php?comment_status=spam"><span class="item"  style="color:#e25440;font-size:12px;line-height:14px;">' . wp_count_comments()->spam . '</span> <span style="color:white;vertical-align:text-bottom;font-size:12px;">' . __( 'Spam' ) . '</span></a>
	</div>
	<canvas id="canvas-comment" height="185"  width="185" ></canvas>
	</div></td></tr></table>';
}


function rhrn_draw_chart() {
    ?>
        <script type="text/javascript">
            
        var options  = {
            //Boolean - Whether we should show a stroke on each segment
            segmentShowStroke : true,
                
            //String - The colour of each segment stroke
            segmentStrokeColor : "#fff",
                
            //Number - The width of each segment stroke
            segmentStrokeWidth : 2,
                
            //The percentage of the chart that we cut out of the middle.
            percentageInnerCutout : 50,
                
            //Boolean - Whether we should animate the chart	
            animation : true,
                
            //Number - Amount of animation steps
            animationSteps : 100,
                
            //String - Animation easing effect
            animationEasing : "easeOutBounce",
                
            //Boolean - Whether we animate the rotation of the Doughnut
            animateRotate : true,
                
            //Boolean - Whether we animate scaling the Doughnut from the centre
            animateScale : false,
                
            //Function - Will fire on animation completion.
            onAnimationComplete : null
        }
    	
        var postData = [
            {
                value: <?php echo wp_count_posts()->publish; ?>,
                color:"#9EC149"
            },
            {
                value : <?php echo wp_count_posts()->draft; ?>,
                color : "#F9E15D"
            },
            {
                value : <?php echo wp_count_posts()->trash; ?>,
                color : "#EB5700"
            },
                
                
        ];
            
            
            
        var contentChart = new Chart(document.getElementById("canvas-post").getContext("2d")).Doughnut(postData,options).ctx.fillRect(0,0,150,75);
    	
    	
    </script>
    <script type="text/javascript">
                
        var commentData = [
            {
                value: <?php echo wp_count_comments()->approved; ?>,
                color:"#9EC149"
            },
            {
                value : <?php echo wp_count_comments()->moderated; ?>,
                color : "#F9E15D"
            },
            {
                value : <?php echo wp_count_comments()->spam; ?>,
                color : "#EB5700"
            },
                    
                    
        ];
                
        var discussionChart = new Chart(document.getElementById("canvas-comment").getContext("2d")).Doughnut(commentData,options);
                
                
    </script>

<?php
 
}
	
