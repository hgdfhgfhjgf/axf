<?php
//命名空间
namespace Admin\Controller;
//引入父类
use Think\Controller;
//声明类并且继承父类
class IndexController extends Controller{
	public function index(){
		$this->display();
	}
	public function main(){
		$this->display();
	}
}