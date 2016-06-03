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
            $result = mysql_query("SELECT * FROM error_logs ORDER BY time DESC");
            $data = array();
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
    var theTable = document.getElementById("tableBody");
    var totalPage = document.getElementById("spanTotalPage");   
    var pageNum = document.getElementById("spanPageNum");
    var spanPre = document.getElementById("spanPre");   
    var spanNext = document.getElementById("spanNext");   
    var spanFirst = document.getElementById("spanFirst");   
    var spanLast = document.getElementById("spanLast");   
    var numberRowsInTable = theTable.rows.length;   
    var pageSize = 20;   
    var page = 1;   
    
    function error_details() {
         window.location.href="http://log.analysis.shoujikanbing.com:2501/log/logError/error_details.php"; 
    }
    
    //下一页
    function next() {
	hideTable();
	currentRow = page * pageSize;
	maxRow = currentRow + pageSize;
	if (maxRow > numberRowsInTable) {
		maxRow = numberRowsInTable;
	}
	for (var i = currentRow; i < maxRow; i++) {
		theTable.rows[i].style.display = '';
	}
	page++;
	if (maxRow === numberRowsInTable){nextText(); lastText();}
	showPage();
	firstLink();
	preLink();
}
    //上一页
    function pre() {
	hideTable();
	page--;
	currentRow = page * pageSize;
	maxRow = currentRow - pageSize;
	if(currentRow > numberRowsInTable) {currentRow = numberRowsInTable;}
	for (var i = maxRow; i < currentRow; i++) {
		theTable.rows[i].style.display = '';
	}
	if (maxRow === 0) {firstText(); preText();}
	showPage();
	lastLink();
	nextLink();
}
    //首页
    function first() {
	hideTable();
	page = 1;
	for (var i = 0; i < pageSize; i++) {
		theTable.rows[i].style.display = '';
	}
	showPage();
	preText();
	nextLink();
	lastLink();
}
    //尾页
    function last() {
	hideTable();
	page = pageCount();
	currentRow = (page - 1) * pageSize;
	for (var i = currentRow; i < numberRowsInTable; i++) {
		theTable.rows[i].style.display = '';
	}
	showPage();
	nextText();
	firstLink();
	preLink();
    }

    function hideTable() {
	for (var i = 0; i < numberRowsInTable; i++) {
		theTable.rows[i].style.display = 'none';
	}
    }
    function showPage() {
	pageNum.innerHTML = page;
    }
    function pageCount() {
	var count = 0;
	if (numberRowsInTable % pageSize !== 0) {count = 1;}
	return parseInt(numberRowsInTable/pageSize) + count;
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

    function hide() {
	for (var i = pageSize; i < numberRowsInTable; i++) {
		theTable.rows[i].style.display = 'none';
	}
	pageNum.innerHTML = '1';
	totalPage.innerHTML = pageCount();
        if (numberRowsInTable > pageSize) {
	nextLink();
	lastLink();
	}
    }
    hide();  
</script>

