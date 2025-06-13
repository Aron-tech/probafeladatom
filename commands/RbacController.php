<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();

        $manageGroups = $auth->createPermission('ManageGroups');
        $manageGroups->description = 'Csoportok kezelése';
        $auth->add($manageGroups);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $manageGroups);

        $student = $auth->createRole('student');
        $auth->add($student);

        $auth->assign($admin, 1); // Admin felhasználó
        $auth->assign($student, 2); // Student felhasználó

        echo "RBAC sikeresen inicializálva!\n";
    }
}
