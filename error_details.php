<!DOCTYPE html>
<html>
 <head>
    <meta charset="utf-8">
    <?php ini_set('date.timezone','Asia/Shanghai'); ?>
    <h1 align="center">error_details<h1>
    <button class="click" type="button" onclick="error_logs()">error_logs</button>
    <button class="click" type="button" onclick="error_details()">error_details</button>
    <button class="click" type="button" onclick="prev_page()">上一页</button>
    <button class="click" type="button" onclick="next_page()">下一页</button>
    <style type="text/css">
    body{
        background: #f5f5f5;
    }
    .table {
        display: table;
    }
    .row {
        display: table-row;
    }
    .row div {
        display: table-cell;
        min-width: 70px;
        height: 50px;
        text-align: center;
        vertical-align: middle;
        padding: 5px 10px;
        border: 1px solid #D0D0D0;
    }
    .content {
        font-size: 15px;
        font-weight: normal;
    }
    .click {
        background-color: orange;
        width: 150px;
        height: 40px;
        font-size: 15px;
        color: white;
    }

    </style>
 </head>
 <body>
    <div class="table">
        <div class="row">
            <div>id</div>
            <div>logid</div>
            <div>errortype</div>
            <div>errorurl</div>
            <div>errorcode</div>
            <div>errordesc</div>
            <div>networkenvi</div>
            <div>time</div>
        </div>
        <?php 
            $pageSize = 20;
            $id = $_GET['id'];
            $page = $_GET['page'];
            if(trim($page) == '') {
                $page = 0;
            }

            $pageData = query($id, $page, $pageSize);
            function query($id, $page, $pageSize) {
                $con = mysql_connect("127.0.0.1","root","haojia2901");
                mysql_select_db("nh_logs", $con);
                mysql_query("SET NAMES UTF8");
                $head = $page * $pageSize;
                if(trim($id) != ''){
                    $result = mysql_query("SELECT id, logid, errortype, errorurl, errorcode, errordesc, networkenvi, time FROM error_details WHERE logid=$id ORDER BY time DESC LIMIT $head,$pageSize");
                }  else {
                    $result = mysql_query("SELECT id, logid, errortype, errorurl, errorcode, errordesc, networkenvi, time FROM error_details ORDER BY time DESC LIMIT $head,$pageSize");
                }
                mysql_close($con);
                $data = array();
                while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
                    $data[] = $row;
                }
                return $data;
            }
        ?>
        <?php foreach ($pageData as $value): ?>
        <div class="row">
            <?php foreach ($value as $key => $val): ?>
                    <div class="content">
                        <?php if($key == 'time') {
                            $val = date('Y-m-d H:i:s', $val);
                        }
                        echo $val; 
                        ?>
                    </div>
            <?php endforeach; ?>
        </div>
        <?php endforeach ?>
    </div>
    
        <script language="javascript" type="text/javascript">
            
            function error_logs() {
                window.location.href="http://log.analysis.shoujikanbing.com:2501/log/logError/error_logs.php"; 
            }
            function error_details() {
                window.location.href="http://log.analysis.shoujikanbing.com:2501/log/logError/error_details.php"; 
            }
            function next_page() {
                <?php
                $page = $_GET['page'];
                if(trim($page) != ''){
                    if(count($pageData) == $pageSize){
                        $page = $page + 1;
                    }
                }else {
                    if(count($pageData) == $pageSize){
                        $page = 1;
                    }
                }
                ?>
                window.location.href="http://log.analysis.shoujikanbing.com:2501/log/logError/error_details.php?id=<?php echo $id; ?>&page=<?php echo $page; ?>"; 
            }
            function prev_page() {
                <?php
                $page = $_GET['page'];
                if(trim($page) != ''){
                    if($page != 0) {
                    $page = $page - 1;
                    } 
                }else {
                    $page = 0;
                }
                ?>
                window.location.href="http://log.analysis.shoujikanbing.com:2501/log/logError/error_details.php?id=<?php echo $id; ?>&page=<?php echo $page; ?>"; 
            }
            
        </script>
</body>
</html>
