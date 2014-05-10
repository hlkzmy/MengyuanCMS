<?php

namespace Etah\Mvc\Controller;

use Zend\Paginator\Paginator;
use Zend\InputFilter\FileInput;
use Zend\InputFilter\InputFilter;
use Zend\Validator\File\Size;
use Zend\Validator\File\Extension;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Where;
use Zend\Form\Annotation\Object;
//加载一些其他的项目
use Etah\Mvc\Controller\RegistController;
use Etah\Mvc\Factory\ServiceLocator\ServiceLocatorFactory;
//加载注册对象
use Etah\Mvc\Factory\Regist\MemberVariable as RegistMemberVariable;
//加载形成页面的对象
use Etah\Mvc\Factory\Page\Create as CreatePage;
use Etah\Mvc\Factory\Page\Update as UpdatePage;
use Etah\Mvc\Factory\Page\Read as ReadPage;
use Etah\Mvc\Factory\Page\Delete as DeletePage;
use Etah\Mvc\Factory\Page\Append as AppendPage;
use Etah\Mvc\Factory\Page\Lookup as LookupPage;
use Etah\Mvc\Factory\Page\view as ViewPage;
//加载响应对象
use Etah\Mvc\Factory\Response\CheckCreate as CheckCreate;
use Etah\Mvc\Factory\Response\CheckUpdate as CheckUpdate;
use Etah\Mvc\Factory\Response\CheckDelete as CheckDelete;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService as AuthenticationService;
use Zend\Authentication\Adapter\DbTable as dbTableAuthAdapter;
use Zend\Authentication\Result as Result;
use Zend\View\Model\ViewModel;
use Zend\Session\Container as Session;
use Zend\Mvc\MvcEvent;
use Zend\Filter\File\Rename;
use Zend\File\Transfer\Adapter\Http;

class BaseController extends AbstractActionController {

    protected $serviceManager = null;

    //声明服务管理者对象

    function __construct() {

        $this->serviceManager = ServiceLocatorFactory::getInstance();
        //对服务管理者对象进行赋值
    }

    /**
     * 向控制器中的成员变量注册数据表模型
     * @param object $serviceManager
     * @param string $applicationName
     * @param string $folderName
     * @param string $ModelName
     */
    final protected function registDatabaseModel($serviceManager, $applicationName, $folderName, $modelName) {

        $modelName = lcfirst($modelName);

        if (!isset($this->{$modelName})) {
            $this->{$modelName} = RegistMemberVariable::getDatabaseModel($serviceManager, $applicationName, $folderName, $modelName);
        }
    }

    /**
     * 向控制器中的成员变量注册表单对象
     * @param object $serviceManager
     * @param string $applicationName
     * @param string $folderName
     * @param string $FormName
     */
    final protected function registForm($serviceManager, $applicationName, $folderName, $formName) {

        $formName = lcfirst($formName);

        if (!isset($this->{$formName})) {
            $this->{$formName} = RegistMemberVariable::getForm($serviceManager, $applicationName, $folderName, $formName);
        }
    }
    
    /**
     * 向控制器中的成员变量注册表单对象
     * @param object $serviceManager
     * @param string $FilterName
     */
    final protected function registFilter($serviceManager, $filterName) {

        $filterName = lcfirst($filterName);

        if (!isset($this->{$filterName})) {
            $this->{$filterName} = RegistMemberVariable::getFilter($serviceManager, $filterName);
        }
    }

    /**
     * 返回登录用户的相关信息
     */
    protected function getLoginUser() {
        if (!isset($this->loginUser)) {
            $auth = new AuthenticationService();
            $this->loginUser = $auth->getIdentity();
        }
        return $this->loginUser;
    }

    /**
     * 返回当前登录用户id
     */
    public function getLoginUserId() {
        $user = $this->getLoginUser();

        return $user->id;
    }

    /**
     * 动态的从网站后台中获取数据库记录
     * 主要用于在显示无限分类列表页面的时候，点击“加号”按钮时从后台拉取数据，然后出现加号的子节点列表
     * 接受一个id作为参数，然后返回一个视图对象
     * @param  int $id
     * @return ViewModel
     */
    public function appendAction() {

        $mvcEvent = $this->getEvent();
        //得到Mvc事件对象

        $appendPage = new appendPage();

        $appendPage->setBaseController($this)
                ->setServiceManager($this->serviceManager)
                ->setMvcEvent($mvcEvent)
                ->setUrl($this->url());

        $viewModel = $appendPage->getViewModel();

        return $viewModel;
    }

//function ajaxGetUnlimitedRowListAction() end

    public function getRouteAdditionalParameters($routeMatch) {

        $params = $routeMatch->getParams();

        unset($params['__NAMESPACE__']);
        unset($params['controller']);
        unset($params['action']);
        unset($params['__CONTROLLER__']);

        return $params;
    }

//function  getRouteAdditionalParameters() end

    public function createAction() {

        $mvcEvent = $this->getEvent();
        //得到Mvc事件对象

        $createPage = new CreatePage();

        $createPage->setBaseController($this)
                ->setServiceManager($this->serviceManager)
                ->setMvcEvent($mvcEvent)
                ->setUrl($this->url());

        $viewModel = $createPage->getViewModel();

        return $viewModel;
    }

//function createAction() end

    public function updateAction() {

        $mvcEvent = $this->getEvent();
        //得到Mvc事件对象

        $updatePage = new UpdatePage();

        $updatePage->setBaseController($this)
                ->setServiceManager($this->serviceManager)
                ->setMvcEvent($mvcEvent)
                ->setUrl($this->url());

        $viewModel = $updatePage->getViewModel();

        return $viewModel;
    }

    public function lookupAction() {

        $mvcEvent = $this->getEvent();
        //得到Mvc事件对象

        $lookupPage = new LookupPage();

        $lookupPage->setBaseController($this)
                ->setServiceManager($this->serviceManager)
                ->setMvcEvent($mvcEvent)
                ->setUrl($this->url());

        $viewModel = $lookupPage->getViewModel();

        return $viewModel;
    }

//function lookupAction() end

    public function readAction() {


        $mvcEvent = $this->getEvent();
        //得到Mvc事件对象

        $readPage = new ReadPage();

        $readPage->setBaseController($this)
                ->setServiceManager($this->serviceManager)
                ->setMvcEvent($mvcEvent)
                ->setUrl($this->url());

        $viewModel = $readPage->getViewModel();
        $viewModel->setTerminal(true);
        return $viewModel;
    }

//function readAction() end

    public function viewAction() {

        $mvcEvent = $this->getEvent();
        //得到Mvc事件对象

        $viewPage = new viewPage();

        $viewPage->setBaseController($this)
                ->setServiceManager($this->serviceManager)
                ->setMvcEvent($mvcEvent)
                ->setUrl($this->url());

        $viewModel = $viewPage->getViewModel();


        return $viewModel;
    }

    public function getChildrenCount($row) {

        return ($row['right_number'] - $row['left_number'] - 1 ) / 2;
    }

//function getChildrenCount() end

    public function getStatusString($row) {

        if ($row['status'] == 'Y') {
            return '已启用';
        } else if ($row['status'] == 'N') {
            return '已禁用';
        } else {
            return '';
        }
    }

//function getStatusString() end

    public function getSortType($row) {

        if ($row['right_number'] - $row['left_number'] > 1) {
            return '大分类';
        } else if ($row['right_number'] - $row['left_number'] == 1) {
            return '栏目';
        } else {
            return '';
        }
    }

//function getSortType() end

    public function getDisplayString($row) {

        if ($row['display'] == 'Y') {
            return '显示状态';
        } else if ($row['display'] == 'N') {
            return '隐藏状态';
        } else {
            return '';
        }
    }

//function getDisplayString() end

    final public function ajaxReturn($statusCode,$message,$data=null,$callbackType=NULL,$navTabId=null) {
    		
    	$return = array();
    		
    	$return['statusCode'] = $statusCode;
    		
    	$return['message']  = $message;
    		
    	if($data!==null){
    		$return['data'] = $data;
    	}
    	
    	if($callbackType!==null){
    		$return['callbackType'] = $callbackType;
    	}
    	
    	if($navTabId!==null){
    		$return['navTabId'] = $navTabId;
    	}
    		
    	exit ( json_encode ( $return ) );
    		
    }//function dwzAjaxReturn() end

//function dwzAjaxReturn() end

    /**
     * 从路由中取得命名空间、控制器，然后组成唯一的键值
     * @param MvcEvent $event
     * @return string  $key
     */
    private function getUniqueKey($event) {

        $routeMatchParam = $event->getRouteMatch()->getParams();

        $module = strtolower(substr($routeMatchParam['__NAMESPACE__'], 0, strpos($routeMatchParam['__NAMESPACE__'], '\\')));
        //得到模块的名称

        $controller = $routeMatchParam['__CONTROLLER__'];
        //得到控制器的名称

        $key = strtolower($module . "." . $controller);

        return $key;
    }

//function getUniqueKey() end

    public function formatValueOptions($valueOptions, $field, $defaultValue = true) {

        $result = array();

        if ($defaultValue) {
            $result = array('0' => '请选择');
        }
        foreach ($valueOptions as $option) {

            $temp = array();

            $key = $option[$field[0]];

            $value = $option[$field[1]];

            $result[$key] = $value;
        }

        return $result;
    }

//function formatValueOptions() end
    /**
     *
     * 本控制器的目的是公用所有向数据库插入数据的函数 ， checkUseradd
     *
     */

    public function checkCreateAction() {

        $mvcEvent = $this->getEvent();
        //得到Mvc事件对象

        $checkCreate = new CheckCreate();

        $checkCreate->setBaseController($this)
                ->setServiceManager($this->serviceManager)
                ->setMvcEvent($mvcEvent);

        $checkCreate->response();
    }

    /**
     * 本函数用于公用编辑函数
     */
    public function checkUpdateAction() {
        $mvcEvent = $this->getEvent();
        //得到Mvc事件对象

        $checkUpdate = new CheckUpdate();

        $checkUpdate->setBaseController($this)
                ->setServiceManager($this->serviceManager)
                ->setMvcEvent($mvcEvent);

        $checkUpdate->response();
    }

    /**
     * 本控制器的目的是公用所有类似的删除函数，例如 checkUserDelete
     */
    public function deleteAction() {
        $mvcEvent = $this->getEvent();

        $checkDelete = new CheckDelete();

        $checkDelete->setBaseController($this)
                ->setServiceManager($this->serviceManager)
                ->setMvcEvent($mvcEvent);
        $checkDelete->response();
    }

    /**
     * 用户ajax上传视频验证
     */
    public function AjaxDouploadVideoAction() {

        $uploadRs = $this->douploadVideo();
        exit(json_encode($uploadRs));
    }

    /**
     * 私有函数用于视频文件的上传
     * @return string|multitype:
     */
    private function douploadVideo() {

        //得到服务管理者对象

        $MvcEvent = $this->getEvent();
        //得到Mvc事件对象

        $config = $this->serviceManager->get('config');
        //得到整个项目合并之后的配置数组

        $UniqueKey = $this->getUniqueKey($MvcEvent) . '.checkcreate';
        //通过Mvc事件对象形成 “模块.控制器.方法”的键值，用来查找对应的配置

        if (!isset($config['checkcreate'][$UniqueKey])) {
            die('未获取到' . $UniqueKey . '相关的列表配置，请联系网站管理人员！');
        }

        $checkCreateConfig = $config['checkcreate'][$UniqueKey];


        $request = $this->getRequest();

        $files = $request->getFiles();

        $post = $request->getPost()->toArray();

        $upload = new Http();
        $rename = new Rename('file');

        foreach ($files as $key => $onefile) {

            $temp_name = com_create_guid();

            $options = array(
                'source' => $onefile['tmp_name'],
                'target' => TEMP_DISK_PATH . $temp_name,
                'overwrite' => true,
            );

            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $onefile['tmp_name']);
            finfo_close($finfo);


            $rename->addFile($options);
            $uploadInfo['upload_flag'] = $temp_name;
            $uploadInfo['size'] = $onefile['size'];
        }

        $upload->addFilter($rename);

        if ($upload->receive()) {
            $uploadInfo['status'] = true;
            $uploadInfo['info'] = '视频上传成功，请继续填写相关信息';
            return($uploadInfo);
        } else {

            $uploadInfo['status'] = false;
            $uploadInfo['info'] = json_encode($upload->getErrors());

            return($uploadInfo);
        }
    }

    /**
     * 从路由中格式化routeMatch的信息，然后返回命名空间、控制器、方法
     */
    protected function getFormatRouteParameter($mvcEvent) {

        $routeMatch = $mvcEvent->getRouteMatch();

        $controller = $routeMatch->getParam('controller');

        $controllerArray = explode('\\', $controller);

        $namespace = strtolower($controllerArray[0]);

        $controller = strtolower($controllerArray[2]);

        $action = strtolower($routeMatch->getParam('action'));

        $result = array();
        $result['namespace'] = $namespace;
        $result['controller'] = $controller;
        $result['action'] = $action;

        return $result;
    }

//function getRouteParameter() end
}

//function BaseController() end
