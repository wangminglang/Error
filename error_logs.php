<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <?php ini_set('date.timezone','Asia/Shanghai'); ?>
    <h1 align="center">error_logs<h1>
    <button class="click" type="button" onclick="error_details()">error_details</button>
    <style type="text/css">
    body{
        background: #f5f5f5;
    }
    #table {
        border: 2px solid #D0D0D0;

    }
    .content {
        font-weight: normal;
        font-size: 15px;
    }
    .row td {
        min-width: 50px;
        height: 50px;
        text-align: center;
        vertical-align: middle;
        padding: 5px 10px;
        border: 1px solid #D0D0D0;
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
    <table id="table">
        <tr class="row">
            <td>id</td>
            <td>appid</td>
            <td>channel</td>
            <td>deviceid</td>
            <td>time</td>
            <td>sessionid</td>
            <td>clientversion</td>
            <td>devicemodel</td>
            <td>deviceosversion</td>
            <td>carrieroperator</td>
            <td>networkmode</td>
            <td>deviceimei</td>
            <td>devicemac</td>
        </tr>
        <?php 
            $con = mysql_connect("127.0.0.1","root","haojia2901");
            mysql_select_db("nh_logs", $con);
            mysql_query("SET NAMES UTF8");
            $pageSize = 20; 
            $page = $_GET['page'];
            if(trim($page) == ''){
                $page = 1;
            }
            $head = ($page - 1) * $pageSize;
            $result = mysql_query("SELECT * FROM error_logs ORDER BY time DESC LIMIT $head,$pageSize");
            $resultNum = mysql_query("SELECT * FROM error_logs");
            $data = array();
            $rowsNum = mysql_num_rows($resultNum);
            while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
                $data[] = $row;
            }
            mysql_close($con);
        ?>
        <tbody id="tableBody">
        <?php foreach ($data as $value): ?>
            <tr class="row">
            <?php foreach ($value as $key => $val): ?>
                    <td class="content">
                        <?php if($key == 'time') {
                        $val = date('Y-m-d H:i:s', $val);
                            echo $val; 
                        }elseif ($key == 'id') {
                        ?>
                        <a href="http://log.analysis.shoujikanbing.com:2501/log/logError/error_details.php?id=<?php echo $val ?>"><?php echo $val; ?></a>
                        <?php }else {
                            echo $val; 
                        }
                        ?>
                    </td>
            <?php endforeach; ?>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
    <span id="spanFirst">首页</span> <span id="spanPre">上一页</span> <span id="spanNext">下一页</span> <span id="spanLast">尾页</span> 第<span id="spanPageNum">0</span>页/共<span id="spanTotalPage">0</span>页     
</body>
</html>
<script language="javascript" type="text/javascript">

    var totalPage = document.getElementById("spanTotalPage");
    var pageNum = document.getElementById("spanPageNum");
    var spanPre = document.getElementById("spanPre");   
    var spanNext = document.getElementById("spanNext");   
    var spanFirst = document.getElementById("spanFirst");   
    var spanLast = document.getElementById("spanLast"); 
    var numberRowsInTable = <?php echo "$rowsNum"; ?>;
    var pageSize = <?php echo "$pageSize"; ?>;
    var page = <?php echo "$page"; ?>   

    totalPage.innerHTML = pageCount();
    pageNum.innerHTML = page;
    if (numberRowsInTable > (page * pageSize)) {
        nextLink();
        lastLink();
    }
    if (page > 1) {
        preLink();
        firstLink();
    };

    //下一页
    function next() {
        page++;
        showPage();
        window.location.href = "http://log.analysis.shoujikanbing.com:2501/log/logError/error_logs.php?page=" + page;
    }

    //上一页
    function pre() {
        page--;
        showPage();
        window.location.href = "http://log.analysis.shoujikanbing.com:2501/log/logError/error_logs.php?page=" + page;
    }

    //首页
    function first() {
        page = 1;
        showPage();
        window.location.href = "http://log.analysis.shoujikanbing.com:2501/log/logError/error_logs.php?page=" + page;
    }

    //尾页
    function last() {
        page = pageCount();
        showPage();
        window.location.href = "http://log.analysis.shoujikanbing.com:2501/log/logError/error_logs.php?page=" + page;
    }


    function showPage() {
        pageNum.innerHTML = page;
    }
   

    function pageCount() {
        var count = 0;
        if (numberRowsInTable % pageSize !== 0) {count = 1;}
        return parseInt(numberRowsInTable/pageSize) + count;
    }

    function error_details(){
        window.location.href = "http://log.analysis.shoujikanbing.com:2501/log/logError/error_details.php";
    }

    //显示链接
    function preLink() {spanPre.innerHTML = "<a href='javascript:pre();'>上一页</a>";}
    function preText() {spanPre.innerHTML = "上一页";}
    function nextLink() {spanNext.innerHTML = "<a href='javascript:next();'>下一页</a>";}
    function nextText() {spanNext.innerHTML = "下一页";}
    function firstLink() {spanFirst.innerHTML = "<a href='javascript:first();'>首页</a>";}
    function firstText() {spanFirst.innerHTML = "首页";}
    function lastLink() {spanLast.innerHTML = "<a href='javascript:last();'>尾页</a>";}
    function lastText() {spanLast.innerHTML = "尾页";}

</script>

