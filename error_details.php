<!DOCTYPE html>
<html>
 <head>
    <meta charset="utf-8">
    <?php ini_set('date.timezone','Asia/Shanghai'); ?>
    <h1 align="center">error_details<h1>
    <button class="click" type="button" onclick="error_logs()">error_logs</button>
    <button class="click" type="button" onclick="error_details()">error_details</button>
    <style type="text/css">
    body{
        background: #f5f5f5;
    }
    #table {
        border: 2px solid #D0D0D0;
    }
   
    .row td {
        min-width: 50px;
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
     <table id="table">
         <tr class="row">
            <td>id</td>
            <td>logid</td>
            <td>errortype</td>
            <td>errorurl</td>
            <td>errorcode</td>
            <td>errordesc</td>
            <td>networkenvi</td>
            <td>time</td>
        </tr>
        <?php 
            $id = $_GET['id'];
            $pageData = query($id);
            function query($id) {
                $con = mysql_connect("127.0.0.1","root","haojia2901");
                mysql_select_db("nh_logs", $con);
                mysql_query("SET NAMES UTF8");
                if(trim($id) != ''){
                    $result = mysql_query("SELECT id, logid, errortype, errorurl, errorcode, errordesc, networkenvi, time FROM error_details WHERE logid=$id ORDER BY time DESC");
                }  else {
                    $result = mysql_query("SELECT id, logid, errortype, errorurl, errorcode, errordesc, networkenvi, time FROM error_details ORDER BY time DESC");
                }
                mysql_close($con);
                $data = array();
                while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
                    $data[] = $row;
                }
                return $data;
            }
        ?>
        <tbody id="tableBody">
        <?php foreach ($pageData as $value): ?>
        <tr class="row">
            <?php foreach ($value as $key => $val): ?>
                    <td class="content">
                        <?php if($key == 'time') {
                            $val = date('Y-m-d H:i:s', $val);
                        }
                        echo $val; 
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
            
            function error_logs() {
                window.location.href="http://log.analysis.shoujikanbing.com:2501/log/logError/error_logs.php"; 
            }
            function error_details() {
                window.location.href="http://log.analysis.shoujikanbing.com:2501/log/logError/error_details.php"; 
            }
            
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

