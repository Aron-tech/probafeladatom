<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Group model
 *
 * @property int $id
 * @property string $name
 * @property int|null $parent_id
 * @property bool $is_deleted
 */
class Group extends ActiveRecord
{
    /**
     *
     * @param bool $onlyRoot
     * @return array
     */
    public static function getHierarchy(bool $onlyRoot = false): array
    {
        $query = self::find()
            ->where(['is_deleted' => 0])
            ->asArray()
            ->all();

        $items = [];
        foreach ($query as $row) {
            $items[$row['id']] = $row + ['children' => []];
        }

        $tree = [];
        foreach ($items as $id => &$node) {
            if ($node['parent_id'] && isset($items[$node['parent_id']])) {
                $items[$node['parent_id']]['children'][] = &$node;
            } else {
                $tree[] = &$node;
            }
        }

        if ($onlyRoot) {
            return array_map(function ($group) {
                unset($group['children']);
                return $group;
            }, $tree);
        }
        return $tree;
    }
}
