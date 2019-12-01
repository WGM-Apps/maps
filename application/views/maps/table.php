<aside class="scrollmenu">
    <table class="table table-hover table-striped table-bordered table-sm">
        <thead class="bg-light">
            <tr>
                <th>Fullname</th>
                <th>NIK</th>
                <th>Divisi</th>
                <th>Jabatan</th>
                <th>User ID</th>
                <th>User ID Induk</th>
                <th>Username</th>
                <th>Password</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($user as $r): ?>
            <tr>
                <td><?php echo $r->nama ?></td>
                <td><?php echo $r->nik ?></td>
                <td><?php echo $r->divisi_id ?></td>
                <td><?php echo $r->jabatan ?></td>
                <td><?php echo $r->user_id ?></td>
                <td><?php echo $r->user_id_induk ?></td>
                <td><?php echo $r->user ?></td>
                <td><?php echo $r->password ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</aside>

<ul class="table-responsive pagination">
<?php
    if($page == 1) {
        echo "
            <li class='page-item disabled'>
                <a class='page-link' href='javascript:void(0)'>
                    First
                </a>
            </li>
            <li class='page-item disabled'>
                <a class='page-link' href='javascript:void(0)'>
                    &laquo;
                </a>
            </li>
        ";
    }else {
        $link_prev = ($page > 1)? $page - 1 : 1;
        echo "
            <li class='page-item'>
                <a class='page-link' href='javascript:void(0)' onclick='data_id_paging(this)' data-id='1'>
                    First
                </a>
            </li>
            <li class='page-item'>
                <a class='page-link' href='javascript:void(0)' onclick='data_id_paging(this)' data-id='$link_prev'>
                    &laquo;
                </a>
            </li>
        ";
    }

    for($i=$start_number; $i<=$end_number; $i++):
        $link_active = ($page == $i) ? ' class="page-item active"' : '';
        echo "
            <li $link_active>
                <a class='page-link' href='javascript:void(0)' onclick='data_id_paging(this)' data-id='$i'>
                    $i
                </a>
            </li>
        ";
    endfor;

    if($page == $pages){
        echo "
            <li class='page-item disabled'>
                <a class='page-link' href='javascript:void(0)'>
                    &raquo;
                </a>
            </li>
            <li class='page-item disabled'>
                <a class='page-link' href='javascript:void(0)'>
                    Last
                </a>
            </li>
        ";
    }else{
        $link_next = ($page < $pages)? $page + 1 : $pages;
        echo "
            <li class='page-item'>
                <a class='page-link' href='javascript:void(0)' onclick='data_id_paging(this)' data-id='$link_next'>
                    &raquo;
                </a>
            </li>
            <li class='page-item'>
                <a class='page-link' href='javascript:void(0)' onclick='data_id_paging(this)' data-id='$pages'>
                    Last
                </a>
            </li>
        ";
    }
?>
</ul>