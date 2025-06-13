<?php

namespace app\commands;

use yii\console\Controller;
use app\models\Group;
use app\models\User;
use Yii;

class SeedController extends Controller
{
    public function actionGroups()
    {
        Yii::$app->db->createCommand()->truncateTable(Group::tableName())->execute();

        $g1 = new Group(['name' => 'Matematika']); $g1->save();
        $g2 = new Group(['name' => 'Informatika']); $g2->save();
        $g3 = new Group(['name' => 'Fizika']); $g3->save();

        $g4 = new Group(['name' => 'Webfejlesztés', 'parent_id' => $g2->id]); $g4->save();
        $g5 = new Group(['name' => 'Adatbázisok', 'parent_id' => $g2->id]); $g5->save();
        $g6 = new Group(['name' => 'Mechanika', 'parent_id' => $g3->id]); $g6->save();

        (new Group(['name' => 'Angol']))->save();
        (new Group(['name' => 'Testnevelés']))->save();
        (new Group(['name' => 'Biológia']))->save();

        (new Group(['name' => 'Törölt csoport', 'is_deleted' => true]))->save();

        echo "Groups seeded successfully.\n";
    }

    public function actionUser()
    {
        // Tábla ürítése
        Yii::$app->db->createCommand()->truncateTable(User::tableName())->execute();

        // Admin felhasználó létrehozása
        $admin = new User([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('admin123'),
            'status' => 10,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        
        if ($admin->save()) {
            echo "Admin user created successfully.\n";
        } else {
            echo "Error creating admin user:\n";
            print_r($admin->errors);
            return 1;
        }

        $user = new User([
            'username' => 'user',
            'email' => 'user@example.com',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('user123'),
            'status' => 10,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        
        if ($user->save()) {
            echo "Regular user created successfully.\n";
        } else {
            echo "Error creating regular user:\n";
            print_r($user->errors);
            return 1;
        }

        return 0;
    }
}
