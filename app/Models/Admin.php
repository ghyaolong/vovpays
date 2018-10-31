<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $fillable = ['username', 'email', 'phone', 'verify', 'status'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 获得此管理员的角色。
     */
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }

    /**
     * 获取菜单
     * @return array
     */
    public function getMenu(int $id) : array
    {
        // 拥有权限的菜单
        $hasMenu = $this->leftJoin('admin_role', 'admins.id', '=', 'admin_role.admin_id')
            ->leftJoin('roles', 'admin_role.role_id', '=', 'roles.id')
            ->leftJoin('role_rule', 'roles.id', '=', 'role_rule.role_id')
            ->leftJoin('rules', 'role_rule.rule_id', '=', 'rules.id')
            ->where([
                ['admins.id', '=', $id],
                ['rules.is_check', '=', 1],
                ['rules.is_show', '=', 1]
            ])
            ->whereIn('rules.level', [1, 2])
            ->select('rules.title', 'rules.icon', 'rules.uri', 'rules.id', 'rules.pid', 'rules.sort')
            ->distinct('rules.id')
            ->get()->toArray();

        // 不需要验证的菜单
        $suMenu = Rule::where([
            ['is_check', '=', 0],
            ['is_show', '=', 1]
        ])->whereIn('level', [1, 2])
            ->select('rules.title', 'rules.icon', 'rules.uri', 'rules.id', 'rules.pid', 'rules.sort')
            ->distinct('rules.id')
            ->get()->toArray();

        $menu = $this->mergeMenu($hasMenu, $suMenu);
        unset($hasMenu);
        unset($suMenu);
        $menu = $this->makeMenu($menu);
        return $menu;
    }

    /**
     * 合并菜单并去重排序
     * @param $menu1
     * @param $menu2
     * @return array
     */
    public function mergeMenu(array $menu1, array $menu2) : array
    {
        $arr1 = array_column($menu1, 'id');
        foreach ($menu2 as $key => $row) {
            if (in_array($row['id'], $arr1)) {
                unset($menu2[$key]);
            }
        }
        $mergeArr = array_merge($menu1, $menu2);
        unset($menu1);
        unset($menu2);
        usort($mergeArr, function ($a, $b) {
            if ($a['sort'] == $b['sort']) {
                return 0;
            }
            return ($a['sort'] > $b['sort']) ? -1 : 1;
        });
        return $mergeArr;

    }

    /**
     * 组装菜单数据
     * @param $rules
     * @param int $pid
     * @return array
     */
    public function makeMenu(array $rules, int $pid = 0) : array
    {
        $menu = [];
        foreach ($rules as $k => $v){
            if ($v['pid'] == $pid) {
                $v['spread'] = false;
                unset($rules[$k]);
                $v['children'] = $this->makeMenu($rules, $v['id']);
                $menu[] = $v;
            }
        }
        return $menu;
    }
}
