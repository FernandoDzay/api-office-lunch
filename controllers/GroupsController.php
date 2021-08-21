<?php

    namespace App\Controllers;

    use App\core\base\Controller;
    use App\core\Application;
    use App\core\http\Response;
    use App\models\UsersGroup;

    class GroupsController extends Controller {


        public function actionSetusergroup() {
            $user_id = $_REQUEST['user_id'];
            $group_id = $_REQUEST['group_id'];

            $user_group = new UsersGroup([$user_id, $group_id, 'DEFAULT', 'DEFAULT']);

            $user_group->save();
        }

        public function actionUpdateusergroup() {
            $user_group_obj = new UsersGroup();
            $user_group_obj->updateUserGroup($_REQUEST['user_id'], $_REQUEST['group_id']);
        }

        public function actionActivateuserstatus() {
            $user_group_obj = new UsersGroup();
            $user_group_obj->activateUserStatus($_REQUEST['user_id']);
        }

        public function actionDesactivateuserstatus() {
            $user_group_obj = new UsersGroup();
            $user_group_obj->desActivateUserStatus($_REQUEST['user_id']);
        }

        public function actionGetgroups() {
            $groups = Application::$db->query("SELECT * FROM groups");
            echo json_encode($groups);
        }

        public function actionUserhasgroup() {
            $user_id = $_REQUEST['user_id'];
            $group = Application::$db->row("SELECT * FROM users_group where user_id=$user_id");
            if(empty($group)) {
                echo json_encode(['status' => '0']);
            }
            else {
                echo json_encode(['status' => '1']);
            }
        }

        public function actionGroupsdata() {
            $users_groups_tables_sql = "SELECT user_id, group_id, username FROM users_group ug INNER JOIN users u ON u.id=ug.user_id ORDER BY group_id, username";
            $users_without_group_table_sql =  "SELECT id AS user_id, username FROM users WHERE id NOT IN (SELECT user_id FROM users_group ug INNER JOIN users u ON u.id=ug.user_id)";
            $groups_sql = "SELECT group_id, start_time, end_time FROM users_group ug INNER JOIN groups g ON ug.group_id=g.id GROUP BY group_id";
            
            $users_groups_tables = Application::$db->query($users_groups_tables_sql);
            $users_without_group_table = Application::$db->query($users_without_group_table_sql);
            $groups = Application::$db->query($groups_sql);

            $data = [
                'users_groups_tables' => $users_groups_tables,
                'users_without_group_table' => $users_without_group_table,
                'groups' => $groups
            ];

            echo json_encode($data);

        }

        public function actionGetlunchhour() {

            $user_id = $_REQUEST['user_id'];

            $query = 
            "
                SELECT start_time, end_time
                FROM groups g INNER JOIN users_group ug ON g.id = ug.group_id
                WHERE user_id = :user_id
            ";

            $lunch_hour = Application::$db->row($query, ['user_id' => $user_id]);

            if($lunch_hour == false) {
                echo 'false';
                return;
            }
            echo json_encode($lunch_hour);
        }

        public function actionRemoveusergroup() {
            $user_group_obj = new UsersGroup();
            $user_group_obj->removeUserGroup($_REQUEST['user_id']);
        }



        public function actionChangegroupsorder() {

        }

    }





?>