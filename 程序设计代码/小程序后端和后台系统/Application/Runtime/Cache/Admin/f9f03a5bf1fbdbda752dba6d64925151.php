<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>Table</title>
		<link rel="stylesheet" href="/tsg/Public/Admin1/plugins/layui/css/layui.css" media="all" />
		<link rel="stylesheet" href="/tsg/Public/Admin1/css/global.css" media="all">
		<link rel="stylesheet" type="text/css" href="http://www.jq22.com/jquery/font-awesome.4.6.0.css">
		<link rel="stylesheet" href="/tsg/Public/Admin1/css/table.css" />
	</head>

	<body>
		<div class="admin-main">

			<blockquote class="layui-elem-quote">
				<!-- <a href="form.html" class="layui-btn layui-btn-small" id="add">
					<i class="layui-icon">&#xe608;</i> 添加信息
				</a> -->
				<!-- <a href="#" class="layui-btn layui-btn-small" id="import">
					<i class="layui-icon">&#xe608;</i> 导入信息
				</a>
				<a href="#" class="layui-btn layui-btn-small">
					<i class="fa fa-shopping-cart" aria-hidden="true"></i> 导出信息
				</a> -->
				<form  action="">
					<input style="width: 300px;" type="text" name="sousuo" lay-verify="title" autocomplete="off" placeholder="请输入搜索内容" class="layui-input">
					<a style="position: absolute;left: 350px;top: 34px" href="javascript:;" class="layui-btn layui-btn-small" id="search">
						<i class="layui-icon">&#xe615;</i> 搜索
					</a>
				</form>
				
			</blockquote>
			<fieldset class="layui-elem-field">
				<legend>用户列表</legend>
				<div class="layui-field-box">
					<table class="site-table table-hover">
						<thead>
							<tr>
								<th><input type="checkbox" id="selected-all"></th>
								<th>ID</th>
								<th>学号</th>
								<th>姓名</th>
								<th>性别</th>
								<th>学院</th>
								<th>班级</th>
								<th>手机号码</th>
								<th>积分</th>
								<th>注册时间</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
						<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><tr>	
								<td><input type="checkbox"></td>
								<td class="id"><?php echo ($vol["id"]); ?></td>
								<td class="studyid"><?php echo ($vol["studyid"]); ?></td>
								<td class="name"><?php echo ($vol["name"]); ?></td>
								<td class="sex"><?php if($vol["sex"] == 1): ?><span>男</span>
                                <?php else: ?><span>女</span><?php endif; ?></td>
								<td class="unit"><?php echo ($vol["unit"]); ?></td>
								<td class="class"><?php echo ($vol["major"]); echo ($vol["class"]); ?></td>
								<td class="phoone"><?php echo ($vol["phone"]); ?></td>
								<td class="integral"><?php echo ($vol["integral"]); ?></td>
								<td class="addtime"><?php echo (date('Y-m-d H:i:s',$vol["addtime"])); ?></td>
								<td style="width: 120px;padding: 2px">
									<button style="color: white;background-color:rgb(55, 55, 56);" class="layui-btn layui-btn-primary layui-btn-mini">
										拉黑
									</button>
									<a type="button" class="layui-btn layui-btn-small" href="/tsg/index.php/Admin/User/edit/id/<?php echo ($vol["id"]); ?>">
										<i class="layui-icon">
											
										</i>
									</a>
									<a type="button" class="layui-btn layui-btn-small" href="/tsg/index.php/Admin/User/del/id/<?php echo ($vol["id"]); ?>" > 
										<i class="layui-icon">
											
										</i>
									</a>
								</td>
							
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>

				</div>
			</fieldset>
			<div class="admin-table-page">
				<div id="page" class="page">
				<?php echo ($show); ?>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="/tsg/Public/Admin1/plugins/layui/layui.js"></script>
		<script>
			layui.config({
				base: 'plugins/layui/modules/'
			});

			layui.use(['icheck', 'laypage','layer'], function() {
				var $ = layui.jquery,
					laypage = layui.laypage,
					layer = parent.layer === undefined ? layui.layer : parent.layer;
				$('input').iCheck({
					checkboxClass: 'icheckbox_flat-green'
				});

				//page
				laypage({
					cont: 'page',
					pages: 25 //总页数
						,
					groups: 5 //连续显示分页数
						,
					jump: function(obj, first) {
						//得到了当前页，用于向服务端请求对应数据
						var curr = obj.curr;
						if(!first) {
							//layer.msg('第 '+ obj.curr +' 页');
						}
					}
				});

				$('#search').on('click', function() {
					parent.layer.alert('你点击了搜索按钮')
				});

				$('#add').on('click', function() {
					$.get('temp/edit-form.html', null, function(form) {
						layer.open({
							type: 1,
							title: '添加表单',
							content: form,
							btn: ['保存', '取消'],
							area: ['600px', '400px'],
							maxmin: true,
							yes: function(index) {
								console.log(index);
							},
							full: function(elem) {
								var win = window.top === window.self ? window : parent.window;
								$(win).on('resize', function() {
									var $this = $(this);
									elem.width($this.width()).height($this.height()).css({
										top: 0,
										left: 0
									});
									elem.children('div.layui-layer-content').height($this.height() - 95);
								});
							}
						});
					});
				});

				$('#import').on('click', function() {
					var that = this;
					var index = layer.tips('只想提示地精准些', that,{tips: [1, 'white']});
					$('#layui-layer'+index).children('div.layui-layer-content').css('color','#000000');
				});

				$('.site-table tbody tr').on('click', function(event) {
					var $this = $(this);
					var $input = $this.children('td').eq(0).find('input');
					$input.on('ifChecked', function(e) {
						$this.css('background-color', '#EEEEEE');
					});
					$input.on('ifUnchecked', function(e) {
						$this.removeAttr('style');
					});
					$input.iCheck('toggle');
				}).find('input').each(function() {
					var $this = $(this);
					$this.on('ifChecked', function(e) {
						$this.parents('tr').css('background-color', '#EEEEEE');
					});
					$this.on('ifUnchecked', function(e) {
						$this.parents('tr').removeAttr('style');
					});
				});
				$('#selected-all').on('ifChanged', function(event) {
					var $input = $('.site-table tbody tr td').find('input');
					$input.iCheck(event.currentTarget.checked ? 'check' : 'uncheck');
				});
			});
		</script>
	</body>
</html>