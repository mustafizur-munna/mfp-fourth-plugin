<div class="wrap">
    <h1 class="wp-heading-inline"> MFP Fourth Posts</h1>



<form method="get">
    <div class="tablenav top">
        <div class="alignleft actions">
            <label class="screen-reader-text" for="cat">Filter by category</label>
            <?php
                $selected_cat = isset( $_GET["mfp-cat"] ) ? $_GET["mfp-cat"] : '-1';
            ?>
            <select name="mfp-cat" id="cat" class="postform">
                
                <option value="-1" <?php selected(-1, $selected_cat); ?>>All Categories</option>
                <?php
                    $cats = get_categories();
                    foreach ( $cats as $cat ) :
                ?>
                <option class="level-0" value="<?php echo $cat->term_id; ?>" <?php selected($cat->term_id, $selected_cat); ?> ><?php echo $cat->name; ?></option>
                <?php
                    endforeach;
                ?>
            </select>
            <?php
                $selected_user = isset($_GET["mfp-user"]) ? $_GET["mfp-user"] : -1 ;
            ?>
            <select name="mfp-user" id="user" class="postform">
                <option value="-1" <?php selected(-1, $selected_user); ?> >All Users</option>
                <?php
                    $users = get_users();
                    foreach ( $users as $user ) :

                ?>
                <option value="<?php echo $user->data->ID; ?>" <?php selected($user->data->ID, $selected_user); ?> ><?php echo $user->data->display_name; ?></option>
                <?php
                    endforeach;
                ?>
            </select>
            <input type="hidden" name="page" value="mfp">
            <input type="submit" name="filter_action" id="post-query-submit" class="button" value="Filter">
        </div>
    </div>
</form>

<table class="wp-list-table widefat fixed striped table-view-list posts">
    <thead>
        <tr>
            <th>Image</th>
            <th>Title</th>
            <th>Author</th>
            <th>Categories</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $post_args = array(
                "post_type"=> "post",
            );
            if( isset($_GET["mfp-cat"]) && $_GET["mfp-cat"] != -1 ){
                $post_args["tax_query"] = array(
                    array(
                        "taxonomy"=> "category",
                        "field"=> "term_id",
                        "terms"=> $_GET["mfp-cat"],
                    ),
                );
            } elseif (isset($_GET["mfp-user"]) && $_GET["mfp-user"] != -1){
                $post_args= array(
                    "author"=> $_GET["mfp-user"],
                );
            }
            $posts_query = new WP_Query($post_args);

            if( $posts_query->have_posts() ) :
    
            $posts = $posts_query->posts;

            foreach ( $posts as $post ) :
                $cat_query = get_the_category($post->ID);
                $cats = wp_list_pluck($cat_query, 'name');
                $author = get_user_by('id', $post->post_author);
                $date_time = $post->post_date;
                $date_time_explode = explode(' ', $date_time);
                $final_date_time = implode(' at ', $date_time_explode);
            
        ?>
            <tr>
                <td><?php echo get_the_post_thumbnail( $post->ID, array( '500', '60' ) ); ?></td>
                <td><?php echo $post->post_title; ?></td>
                <td><?php echo $author->display_name; ?></td>
                <td><?php echo implode(', ', $cats); ?></td>
                <td><?php echo $final_date_time; ?></td>
            </tr>
        <?php
            endforeach;
            else :
                echo "<tr><td>No posts found!</td></tr>";
            endif
        ?>

    </tbody>
</table>


</div>