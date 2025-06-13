<?php

/** @var yii\web\View $this */
/** @var app\models\Group[] $groups */

use yii\helpers\Html;
use yii\jui\Draggable;

$this->title = 'My Yii Application';

$canManageGroups = Yii::$app->user->can('ManageGroups');

if ($canManageGroups):
    $groups = app\models\Group::getHierarchy();
?>

<div class="site-index">
    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Csoportok</h1>
    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-lg-12">
                <h2>Group Hierarchy</h2>
                <div id="draggable-container">
                    <div id="group-hierarchy">
                    <?php foreach ($groups as $group): ?>
                        <?php Draggable::begin([
                            'options' => [
                                'id' => 'group-' . $group['id'],
                                'class' => 'group-container',
                            ],
                            'clientOptions' => [
                                'containment' => '#draggable-container',
                            ],
                        ]); ?>
                            <div class="group-name"><?= Html::encode($group['name']) ?></div>
                        <?php Draggable::end(); ?>
                        <?php if (!empty($group['children'])): ?>
                            <div class="group-children">
                                <?php foreach ($group['children'] as $child): ?>
                                    <?php Draggable::begin([
                                        'options' => [
                                            'id' => 'child-' . $child['id'],
                                            'class' => 'group-container',
                                        ],
                                        'clientOptions' => [
                                            'containment' => '#draggable-container',
                                        ],
                                    ]); ?>
                                        <div class="group-name"><?= Html::encode($child['name']) ?></div>
                                    <?php Draggable::end(); ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
