<?php
	require_once('functions.php');
	session_start();
	if(isset($_SESSION['valid_user']))
	{
	?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8"/>
		<title>GroupMessager</title>
		<link rel="stylesheet" type="text/css" href="style.css" />
		
		<script src="http://lib.sinaapp.com/js/jquery/1.9.1/jquery-1.9.1.min.js"></script>
		
		<link rel="stylesheet" href="EDT/datatable.css" type="text/css" />
		<script type="text/javascript" src="EDT/easy.datatable.min.js"></script>
		<script type="text/javascript" src="local.js"></script>
	</head>
	<body>
		<div id="header"><!--上-->
			<div>
				<p>你好, <?php echo $_SESSION['valid_user'];?>&nbsp;&nbsp;&nbsp;
					<a href="Logout.php">登 出</a>
				</p>
			</div>
			<h1>商务短信平台</h1>
		</div>
		<div id="MainPanel">
			<div>
				<div id="sidebar"><!--中左-->
					<ul>
						<li><a href="#" id="TextMessage">短信发送</a></li>
						<li><a href="#" id="Record">发送记录</a></li>
						<li><a href="#" id="AM">余额查询</a></li>
						<li><a href="#" id="Password">修改密码</a></li>
						<li><a href="#">注册账户</a></li>
						<li><a href="#">短信设置</a></li>
						<li><a href="#">账户充值</a></li>
						<li><a href="Logout.php">用户退出</a></li>
					</ul>
				
				</div>
				<div id="content"><!--中右-->
					<div id="TextMessagePanel">
						<div>
							<div><!--ROW-->
								<div><!--cell 1-->
									<div><!--subtable 1-->
										<div>
											<p>
												手动添加号码：
											</p>
											<div>
												<form>
													<input type="text" id="telnum"/>
													<input id="addBtn" type="button" value="添加"></input>
												</form>
											</div>
										</div>
										<div>
											<p>
												文件导入号码：
											</p>
											<div>
												<form id="telForm" action="importTelNum.php" method="post" enctype="multipart/form-data">
													<input type="hidden" name="MAX_FILE_SIZE" value="10000000"/>
													<input id="file" name="FileName"  type="file"  size="10" value=""/>
													<input type="button" id="importBtn"  value="导入"/>
													<input type="button" id="clearBtn"  value="清空"/>
													<img src="loading.gif" id="loading1" class="hidden"/>
												</form>
											</div>
										</div>
										<div>
											<p>
												号码列表：
											</p>
											<div>
												<form action="LoadTelJson.php" name="myform">
													<div style="height: 100%;overflow:auto;width: 300px;"  class="dataTableScrollDiv">
														<table class="datatable easydatatable" id="telTable" width="100%" align="center">
															<tr>
																<!-- datatableIndex,datatableCount -->
																<th width="100">电话号码</th>
															</tr>
															<!-- Data Show Row-->

															<tr style="display: none;">
																<td align="center">{Telno}</td>
															</tr>
														</table>
													</div>
													<div class="panelBar" style="width: 300px;height:30px;text-align:center;" size="5,10,30,50" row="10" pagetheme="no" align="center">
														<label>共{maxPage}页</label>								
														<input type="button" value="<<" onclick="DataTable.go('telTable',1)"/>
														<input type="button" value="<" onclick="DataTable.go('telTable', '{pageNo - 1}')"/>
														<input type="button" value=">" onclick="DataTable.go('telTable', '{pageNo - 1 + 2}')"/>
														<input type="button" value=">>" onclick="DataTable.go('telTable', '{maxPage}')"/>
														<span class="pagego"><input type="text" class="gototxt" name="pageNo" style="width: 42px; text-align:center" /></span>
														<span class="pagegoto"name="pagegoto">&gt;&gt;</span>'
													</div>
												</form>
											</div>
										</div>
										<div>
											<p>
												已导入号码数：
											</p>
											<div>
												<em id="telCount">0</em>
											</div>
										</div>
									</div>
								</div>
									
								<div><!--cell 2-->
									<div><!--subtable 2-->
										<div>
											<p>
												定时发送：
											</p>
											<div>
												<!--<input type="text" id="datepicker"></input>-->
												<input type="datetime-local"/>
											</div>
										</div>
										<div>
											<p>
												发送内容：
											</p>
											<div>
												<form id="messageForm" action="Ensure.php" method="post">
													<textarea class="form_textarea" type="text" name="message" id="message"></textarea>
													<br/>
													<p>注意: 已经输入  <span id="charNum">0</span> 个字符，不可超过70个字符</p>
													<input type="button" id="sendBtn" value="发送"/>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="EnsurePanel">
						<table>
							<tr><td>共发短信：</td><td><em id="telCount1"></em>  条</td></tr>
							<tr><td>可发短信：</td><td><em id="available"></em>  条</td></tr>
							<tr><td>余额：</td><td><em id="account"></em>  元</td></tr>
							<tr><td>发送内容：</td><td><textarea id="message1" readonly="readonly"></textarea></td></tr>
						</table>
						<div>
							<input type="button" id="cancelBtn" value="取消发送"/>
							<input type="button" id="continueBtn" value="继续发送"/>
							<img src="loading.gif" id="loading" class="hidden"/>
						</div>
					</div>
					<div id="RecordPanel">
						<form action="LoadRecordJson.php" name="myform">
							<div style="height:100%;overflow:auto;width: 100%;"  class="dataTableScrollDiv">
								<table class="datatable easydatatable" id="recordTable" width="100%" align="center">
									<tr><th style="width:600px">发送内容</th><th>发送数量</th><th>发送时间</th><th>发送状态</th><th>操作</th></tr>
									<!-- Data Show Row-->
						
									<tr style="display: none;">
										<td align="center"><p align="left">{Content}</p></td>
										<td align="center">{Number}</td>
										<td align="center">{Time}</td>
										<td align="center">成功</td>
										<td align="center"><a href="#" id="s{ID}" onclick="showRecord(this)">查看</a> <a href="#" id="d{ID}" onclick="deleteRecord(this)">删除</a></td>
									</tr>
								</table>
							</div>
							<div class="panelBar" style="width: 100%;text-align:center" size="5,10,30,50" row="15" pagetheme="no">
								<label>共{maxPage}页</label>								
								<input type="button" value="<<" onclick="DataTable.go('recordTable',1)"/>
								<input type="button" value="<" onclick="DataTable.go('recordTable', '{pageNo - 1}')"/>
								<input type="button" value=">" onclick="DataTable.go('recordTable', '{pageNo - 1 + 2}')"/>
								<input type="button" value=">>" onclick="DataTable.go('recordTable', '{maxPage}')"/>
								<span class="pagego"><input type="text" class="gototxt" name="pageNo" style="width: 42px; text-align:center" /></span>
							</div>
						</form>
					</div>
					<div id="DRPanel">
						<table>
							<tr><td>发送时间： </td><td><em id="rectime"></em></td></tr>
							<tr><td>发送内容： </td><td><textarea id="recmsg" readonly="readonly"></textarea></td></tr>
						</table>
					
						<form id="drForm" action="LoadDRJson.php" name="myform">
							<div style="height: 100%;width: 480px;"  class="dataTableScrollDiv" align="center">
								<table class="datatable easydatatable" id="drTable" width="100%" align="center">
									<tr>
										<!-- datatableIndex,datatableCount -->
										<th width="80">电话号码</th>
										<th width="100">发送状态</th>
									</tr>
									<!-- Data Show Row-->
						
									<tr style="display: none;">
										<td align="center">{Tel}</td>
										<td align="center">成功</td>
									</tr>
								</table>
							</div>
							<div class="panelBar" style="width: 480px; text-align:center" size="5,10,30,50" row="10" pagetheme="no">
								<label>共{maxPage}页</label>								
								<input type="button" value="<<" onclick="DataTable.go('drTable',1)"/>
								<input type="button" value="<" onclick="DataTable.go('drTable', '{pageNo - 1}')"/>
								<input type="button" value=">" onclick="DataTable.go('drTable', '{pageNo - 1 + 2}')"/>
								<input type="button" value=">>" onclick="DataTable.go('drTable', '{maxPage}')"/>
								<span class="pagego"><input type="text" class="gototxt" name="pageNo" style="width: 42px; text-align:center" /></span>
							</div>
						</form>
					</div>
					<div id="AMPanel">
						<table>
							<tr><td>已发短信：</td><td><em id="amount"></em>  条</td></tr>
							<tr><td>可发短信：</td><td><em id="account1"></em>  条</td></tr>
						</table>
					</div>
					<div id="PasswordPanel">
						<table>
							<tr><td>用户名：</td><td><p><?php echo $_SESSION['valid_user'];?></p></td></tr>
							<tr><td>原密码：</td><td><input type="password" id="origpsw"/></td></tr>
							<tr><td>新密码：</td><td><input type="password" id="newpsw"/></tr>
						</table>
						<input type="button" id="cpwBtn" value="提交"/>
					</div>
				</div>
			</div><!-- end of right content-->
		</div>
	</body>
</html>
<?php 
														
	//draw_sidebar();
	//draw_footer();

	}
	else 
	{
		echo '<script>alert("请登录")</script>';
		JumpTo("index.php");	
	}
?>