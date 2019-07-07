<?php
global $wpdb;

function getUrl($wsId, $filter)
{
    $base_url = "/wp-admin/edit.php";
    $url_query = "?";

    $url_query .= "post_type=workshop&";
    $url_query .= "page=ms_events_registrations&";

    if ($wsId != null) {
        $url_query .= "workshop_id=" . $wsId . "&";
    }

    if ($filter != null) {
        $url_query .= "workshop_filter=" . $filter . "&";
    }

    return $base_url . $url_query;
}


$users = get_users();
$devices = get_posts(array(
    'post_type'         => 'devices',
    'posts_per_page'    =>  -1,
    'tax_query' => array(
        array(
            'taxonomy' => 'locations',
            'field'    => 'slug',
            'terms'    => 'makerspace',
        ),
    )
));

// print_r ($devices);

$licenses_sql       = "SELECT * FROM makerspace_device_license_device_user";
$licenses_result    = $wpdb->get_results($licenses_sql);

$table_arr = [];

foreach ($users as $u) {
    $table_arr[$u->ID] = [];
    $table_arr[$u->ID][0] = $u->display_name;
}

foreach ($licenses_result as $l) {
    $table_arr[$l->makerspace_dldu_user_id][$l->makerspace_dldu_device_id] = true;
}



?>

<?php if ($_GET["debug"] == true): ?>
<div>
    <pre> <?php print_r($table_arr); ?></pre>
</div>
<?php endif; ?>


<div class="makerspace-device-licenses">


    <table id="table-device-license" class="display compact" style="width:100%">
        <thead>
            <tr>
                <th class="first-col">User</th>
                <?php foreach ($devices as $device) : ?>
                    <th style="white-space: nowrap; padding: 5px 10px;"><?php echo $device->post_title ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($table_arr as $u) : ?>
                <tr>
                    <td class="first-col"><?php echo $u[0]; ?></td>

                    <?php foreach ($devices as $device) : ?>
                        <td class="">
                            <div class="d-flex justify-content-center">
                                <?php if ($u[$device->ID]) : ?>
                                    <span class="ms-dl-led-green"></span>
                                <?php else : ?>
                                    <span class="ms-dl-led-red"></span>
                                <?php endif; ?>
                            </div>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>

</div>


<script>
    $(document).ready(function() {
        $('#table-device-license').DataTable({
            "scrollX": true
        });
    });
</script>