<?php

use User\Model\UserModel;
use Base\Filter\UserFilter;

use User\Model\SchoolModel as UserSchoolModel;
use User\Model\SubjectModel;
use User\Model\WorkTypeModel;
use User\Model\RoleModel;
use Base\Filter\RoleFilter;

use User\Model\UserRoleModel;
use Base\Filter\UserRoleFilter;

use School\Model\SchoolModel;
use School\Model\SchoolSortModel;

//以下为注册表单对象的内容
use User\Form\UserForm;
use User\Form\RoleForm;
use School\Form\SchoolForm;

return array(
		
		'factories' => array(
					
				//以下为向系统中注册表单对象
				'Information\User\UserForm' =>  function($sm) {
				
					return new UserForm();
				},
				
				'Information\Role\RoleForm' =>  function($sm) {
				
					return new RoleForm();
				},
				
				'Information\School\SchoolForm' =>  function($sm) {
				
					return new SchoolForm();
				}
				
		),
		
    
);
